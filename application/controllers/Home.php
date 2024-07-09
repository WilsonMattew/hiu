<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set(get_settings('timezone'));
		$this->load->library('session');
	}

	function page_not_found(){
		$page_data['page_name'] = 'page_not_found';
		$page_data['page_title'] = 'page_not_found';
		$this->load->view('frontend/page_not_found', $page_data);
	}

	function index(){
		$page_data['page_name'] = 'home';
		$page_data['page_title'] = 'home';
		$this->load->view('frontend/index', $page_data);
	}

	function about_us(){
		$page_data['page_title'] = 'about_us';
		$page_data['page_name'] = 'about_us';
		$this->load->view('frontend/index', $page_data);
	}

	function privacy_policy(){
		$page_data['page_title'] = 'privacy_policy';
		$page_data['page_name'] = 'privacy_policy';
		$this->load->view('frontend/index', $page_data);
	}

	function terms_and_condition(){
		$page_data['page_title'] = 'terms_and_condition';
		$page_data['page_name'] = 'terms_and_condition';
		$this->load->view('frontend/index', $page_data);
	}

	function faq(){
		$page_data['page_title'] = 'faq';
		$page_data['page_name'] = 'faq';
		$this->load->view('frontend/index', $page_data);
	}

	function bookmark(){
		$response = array();
		$type = htmlspecialchars($this->input->get('type'));
		$class_id = htmlspecialchars($this->input->get('class_id'));
		$user_id = $this->session->userdata('user_id');
		if(login_type()){
			$message = $this->frontend_model->bookmark($type, $class_id);

			if($message){
				$response['status'] = 'success';
				$response['message'] = $message;
			}else{
				$response['status'] = 'error';
				$response['message'] = get_phrase('something_is_wrong');
			}
		}else{
			$response['status'] = 'error';
			$response['message'] = get_phrase('please_sign_in_first');
		}

		echo json_encode($response);
	}

	function follow($user_id = ""){
		if(login_type()){
			$follower_user_id = $this->session->userdata('user_id');

			if($user_id != $follower_user_id){
				$response = $this->frontend_model->follow($user_id, $follower_user_id);
				echo json_encode($response);
			}else{
				echo json_encode(array('status' => "error", 'message'=> get_phrase("sorry,_it_looks_like_it's_you").'. '.get_phrase("so,_you_can_follow_other_users")));
			}
			
		}else{
			echo json_encode(array('status' => "error", 'message'=> get_phrase('please_sign_in_first')));
		}
	}

	function share_on(){
		if(isset($_GET['class_id']) && $_GET['class_id'] != ""){
			$page_data['class_details'] = $this->crud_model->get_classes($_GET['class_id'])->row_array();
			$this->load->view('frontend/share_on', $page_data);
		}
	}











}