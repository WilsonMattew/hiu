<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set(get_settings('timezone'));
		$this->load->library('session');
	}

	function index($class_title = "", $class_id = ""){
		$user_id = $this->session->userdata('user_id');
		if(isset($_POST['is_ajax_call']) && !empty($_POST['is_ajax_call'])){

		}else{
			// if(isset($_GET['lesson_id']) && !empty($_GET['lesson_id'])){
			// 	$lesson_id = $_GET['lesson_id'];
			// 	$lesson = $this->db->get_where('lessons', array('class_id' => $class_id, 'lesson_id' => $lesson_id));
			// 	if(subscription_status() || $lesson->row('is_free')){
			// 		$this->frontend_model->is_last_viewed($class_id, $lesson_id);
			// 	}
			// }
			
			// $this->frontend_model->enrol_class($user_id, $class_id);
			

			$page_data['class_details'] = $this->crud_model->get_classes($class_id)->row_array();
			$page_data['page_title'] = $page_data['class_details']['class_title'];
			if(login_type()){
				$page_data['page_name'] = 'logged_in_classes';
			}else{
				$page_data['page_name'] = 'logged_out_classes';
			}
			$this->load->view('frontend/index', $page_data);
		}
	}


	function update_watch_history($class_id = "", $lesson_id = "", $seconds = "", $is_done = ""){
		if(login_type()){
			$response = $this->frontend_model->update_watch_history($class_id, $lesson_id, $seconds, $is_done);
			echo $response;
		}
	}


	function class_details(){
		$user_id = $this->session->userdata('user_id');
		$class_id = htmlspecialchars($this->input->get('class_id'));
		$type = htmlspecialchars($this->input->get('type'));
		$page_data['class_details'] = $this->crud_model->get_classes($class_id)->row_array();
		

		if($type == 'reviews'){
			$page_data['reviews'] = $this->frontend_model->get_reviews_by_class_id($class_id);
			$this->load->view('frontend/class_reviews', $page_data);
		}elseif($type == 'discussions'){
			$page_data['discussions'] = $this->frontend_model->get_discussions_by_class_id($class_id);
			$this->load->view('frontend/class_discussions', $page_data);
		}else{
			$page_data['class_owner'] = $this->crud_model->get_users($page_data['class_details']['user_id'])->row_array();
			$page_data['is_following'] = $this->frontend_model->get_followers_by_follower_id($user_id)->num_rows();
			$this->load->view('frontend/class_about', $page_data);
		}
	}

	function delete_review(){
		$response = array();
		$review_id = $_GET['review_id'];
		$user_id = $this->session->userdata('user_id');
		$this->db->where('review_id', $review_id);
		$this->db->where('user_id', $user_id);
		$review = $this->db->get('reviews')->num_rows();
		if(login_type('admin') || $review > 0){
			$this->db->where('review_id', $review_id);
			$this->db->delete('reviews');
			$response['status'] = 'success';
			$response['message'] = get_phrase('review_deleted_successfully');
		}else{
			$response['status'] = 'error';
			$response['message'] = get_phrase('you_do_not_have_access_to_this_review');
		}
		echo json_encode($response);
	}

	function delete_discussion(){
		$response = array();
		$discussion_id = $_GET['discussion_id'];
		$user_id = $this->session->userdata('user_id');
		$this->db->where('discussion_id', $discussion_id);
		$this->db->where('user_id', $user_id);
		$discussions = $this->db->get('discussions')->num_rows();
		if(login_type('admin') || $discussions > 0){
			$this->db->where('discussion_id', $discussion_id);
			$this->db->delete('discussions');

			$this->db->where('parent_id', $discussion_id);
			$this->db->delete('discussions');
			$response['status'] = 'success';
			$response['message'] = get_phrase('discussion_deleted_successfully');
		}else{
			$response['status'] = 'error';
			$response['message'] = get_phrase('you_do_not_have_access_to_this_discussion');
		}
		echo json_encode($response);
	}

	function add_discussion(){
		if(login_type()){
			$description = $this->input->post('discussion');
			if(isset($description) && !empty($description)){
				$user_id = $this->session->userdata('user_id');
				$parent_id = $this->input->post('parent_id');
				$discussion_id = $this->frontend_model->add_discussion($user_id, $parent_id);

				$response['class_id'] = $this->input->post('class_id');
				$response['status'] = 'success';
				$response['message'] = get_phrase('post_successfully_published');
			}else{
				$response['status'] = 'error';
				$response['message'] = get_phrase('field_is_empty');
			}
		}else{
			$response['status'] = 'error';
			$response['message'] = get_phrase('please_login_first');
		}

		echo json_encode($response);
	}

	function add_review_form(){
		$page_data['class_details'] = $this->crud_model->get_classes($_GET['class_id'])->row_array();
		$this->load->view('frontend/add_review', $page_data);
	}

	function edit_review_form(){
		$page_data['class_details'] = $this->crud_model->get_classes($_GET['class_id'])->row_array();
		$this->load->view('frontend/edit_review', $page_data);
	}

	function add_review(){
		if(isset($_GET['class_id']) && !empty($_GET['class_id'])){
			$is_free = $this->crud_model->get_classes($_GET['class_id'])->row('is_free');
			if(subscription_status() || $is_free == 1){
				$user_id = $this->session->userdata('user_id');
				$this->frontend_model->add_review($user_id, $_GET['class_id']);
				$response['class_id'] = $_GET['class_id'];
				$response['status'] = 'success';
				$response['message'] = get_phrase('post_successfully_published');
			}else{
				$response['status'] = 'error';
				$response['message'] = get_phrase('please_purchase_a_subscription_to_add_a_review');
			}
		}else{
			$response['status'] = 'error';
			$response['message'] = get_phrase('select_all_required_fields');
		}
		echo json_encode($response);
	}

	function update_review(){
		if(subscription_status() && isset($_GET['review_id']) && !empty($_GET['review_id'])){
			$this->frontend_model->update_review($_GET['review_id']);
			$response['class_id'] = $_GET['class_id'];
			$response['status'] = 'success';
			$response['message'] = get_phrase('review_updated_successfully');
		}else{
			$response['status'] = 'error';
			$response['message'] = get_phrase('please_purchase_a_subscription_to_add_a_review');
		}
		echo json_encode($response);
	}

	function my_classes(){
		if(!login_type()){
			$this->session->set_flashdata('error',get_phrase('please_login_first'));
			redirect(site_url('signin'), 'refresh');
		}

		$page_data['page_title'] = 'my_classes';
		$page_data['page_name'] = 'my_classes';

		if(isset($_POST['is_ajax_call']) && !empty($_POST['is_ajax_call'])){
			if(isset($_GET['type']) && $_GET['type'] == 'watch_history'){
				$this->load->view('frontend/my_watch_history', $page_data);
			}else{
				$this->load->view('frontend/my_saved_classes', $page_data);
			}
		}else{
			$this->load->view('frontend/index', $page_data);
		}
	}

	function remove_watching_class(){
		$user_id = $this->session->userdata('user_id');
		$class_id = $_GET['class_id'];

		
		$this->db->where('user_id', $user_id);
		$this->db->where('class_id', $class_id);
		$query = $this->db->get('watch_histories');
		if($query->num_rows() > 0){
			$data['in_history'] = 0;
			$this->db->where('user_id', $user_id);
			$this->db->where('class_id', $class_id);
			$this->db->update('watch_histories', $data);

			$response['status'] = 'success';
			$response['message'] = get_phrase('removed_from_watch_history');
		}else{
			$response['status'] = 'error';
			$response['message'] = get_phrase('not_found');
		}
		echo json_encode($response);
	}















}