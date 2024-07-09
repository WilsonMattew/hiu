<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_model extends CI_Model
{
	// constructor
	function __construct()
	{
		parent::__construct();
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	function signup_post(){

		$response = array();

		$data['first_name'] = htmlspecialchars($_POST['first_name']);
		$data['last_name'] = htmlspecialchars($_POST['last_name']);
		$data['email'] = htmlspecialchars($_POST['email']);
		$data['password'] = sha1($_POST['password']);
		$verification_code = rand(100000, 999999);
		$exist_email = exist_email($data['email']);
		if(!$exist_email){
			if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
				$this->frontend_model->user_registration($verification_code);
				if (get_settings('email_verification')) {

		            $credentials = array('email' => $_POST['email'], 'status' => 0);
	    			$query = $this->db->get_where('user', $credentials);
	    			$this->email_model->send_email_verification_mail($data['email'], $query->row('verification_code'));
                    $response['message'] = get_phrase('please_check_your_inbox_to_verify_your_email_address');
                    $response['email_verification'] = get_settings('email_verification');
		        }else {
		            $response['message'] = get_phrase('registration_successful');
			        $response['email_verification'] = get_settings('email_verification');
			        $response['status'] = 200;
			        $response['validity'] = true;
		        }

		    }else{
		    	$response['message'] = get_phrase('invalid_email_address');
            	$response['email_verification'] = get_settings('email_verification');
		        $response['status'] = 403;
		        $response['validity'] = false;
		    }
		}elseif($exist_email === 'unverified'){
			$credentials = array('email' => $_POST['email'], 'status' => 0);
			$query = $this->db->get_where('user', $credentials);
			$this->email_model->send_email_verification_mail($data['email'], $query->row('verification_code'));
            $response['message'] = get_phrase('you_have_already_signed_up').'. '.get_phrase('please_check_your_inbox_to_verify_your_email_address');
            $response['email_verification'] = get_settings('email_verification');
			
		}else{
			$response['message'] = get_phrase('you_have_already_registered');
        	$response['email_verification'] = get_settings('email_verification');
	        $response['status'] = 403;
	        $response['validity'] = false;
		}
		return $response;
	}

	// Email verify
	public function verify_email_address_post(){
	    $response = array();
	    $credentials = array('email' => $_POST['email'], 'verification_code' => $_POST['verification_code'], 'status' => 0);
	    $query = $this->db->get_where('user', $credentials);
	    if($query->num_rows() > 0){
	      $this->db->where('user_id', $query->row('user_id'));
	      $this->db->update('user', array('status' => 1, 'is_verified' => 1));

	      $response['message'] = get_phrase('email_verification_successfully');
	      $response['status'] = 200;
	      $response['validity'] = true;
	    }else{
	      $response['message'] = get_phrase('verification_code_not_matched');
	      $response['status'] = 403;
	      $response['validity'] = false;
	    }

	    return $response;
  	}

  	// Resend Verification Code
	public function resend_verification_code_post(){
	    $response = array();
	    $check['email'] = $_POST['email'];
	    $credentials = array('email' => $_POST['email'], 'status' => 0);
	    $query = $this->db->get_where('user', $credentials);
	    if($query->num_rows() > 0) {
	    	$this->email_model->send_email_verification_mail($check['email'], $query->row('verification_code'));
	    	$response['message'] = get_phrase('please_check_your_inbox_to_verify_your_email_address');
	      	$response['status'] = 200;
	      	$response['validity'] = true;
	    } else{
	    	$response['message'] = get_phrase('verification_code_not_send');
	    	$response['status'] = 403;
	    	$response['validity'] = false;
	    }

	    return $response;
  	}

  	// Login mechanism
	public function login_post()
	{
		$userdata = array();
		$credential = array('email' => $_POST['email'], 'password' => sha1($_POST['password']), 'status' => 1);
		$query = $this->db->get_where('user', $credential);
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$userdata['user_id'] = $row['user_id'];
			$userdata['first_name'] = $row['first_name'];
			$userdata['last_name'] = $row['last_name'];
			$userdata['email'] = $row['email'];
			$userdata['role'] = $row['role'];
			$userdata['validity'] = 1;
		} else {
			$userdata['validity'] = 0;
		}
		return $userdata;
	}

	// Forget Password
	public function forget_password_post(){
	    $response = array();
	    $email = $this->input->post('email');
	    $new_password = rand(10000, 99999);
	    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			if($this->email_model->send_forgot_password_mail($new_password, $email) == true){
				$response['message'] = get_phrase('your_password_has_been_changed').'. '.get_phrase('please_check_the_email_for_your_new_password');
		      	$response['status'] = 200;
		      	$response['validity'] = true;
			}else{
				$response['message'] = get_phrase('user_not_found');
		    	$response['status'] = 403;
		    	$response['validity'] = false;
			}
		}else{
			$response['message'] = get_phrase('invalid_email_address');
	    	$response['status'] = 403;
	    	$response['validity'] = false;
		}

	    return $response;
  	}

  	// Reset Password
  	public function update_password_post($user_id = "")
	{
		$response = array();
		if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
			$user_details = $this->crud_model->get_users($user_id)->row_array();
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password');
			$confirm_password = $this->input->post('confirm_password');
			if ($user_details['password'] == sha1($current_password) && $new_password == $confirm_password) {
				$data['password'] = sha1($new_password);
				$this->db->where('user_id', $user_id);
				$this->db->update('user', $data);
				$response['status'] = 'success';
			} else {
				$response['status'] = 'failed';
			}
		} else {
			$response['status'] = 'failed';
		}

		return $response;
	}

	function categories_get(){
		$all_categories = array();
		$categories = $this->crud_model->get_parent_categories()->result_array();

        foreach($categories as $key => $category):
			$sub_categories = $this->crud_model->get_sub_categories($category['category_id'])->result_array();
        	$all_categories[$key]['parent'] = $category;
        	$all_categories[$key]['sub'] = $sub_categories;
		endforeach;
		$response['categories'] = $all_categories;
		$response['base_url'] = base_url();
		return $response;
	}

	function home_get(){
		$response = array();
		$slider_class_list = array();
		$featured_class_list = array();
		$recommended_class_list = array();

		$slider_classes = $this->frontend_model->get_slider_classes()->result_array();
		foreach($slider_classes as $key => $slider_class):
			$slider_class['student_number'] = $this->frontend_model->get_total_watched_student($slider_class['class_id']);

			$slider_class_list[$key] = $slider_class;
		endforeach;

		$featured_classes = $this->frontend_model->get_featured_classes()->result_array();
		foreach($featured_classes as $key => $featured_class):
			$featured_class['student_number'] = $this->frontend_model->get_total_watched_student($featured_class['class_id']);
			$user_details = $this->crud_model->get_users($featured_class['user_id'])->row_array();
			$featured_class['teacher_name'] = $user_details['first_name'].' '.$user_details['last_name'];

			$featured_class_list[$key] = $featured_class;
		endforeach;

		$recommended_classes = $this->frontend_model->get_recommended_classes()->result_array();
		foreach($recommended_classes as $key => $recommended_class):
			$recommended_class['student_number'] = $this->frontend_model->get_total_watched_student($recommended_class['class_id']);

			$user_details = $this->crud_model->get_users($recommended_class['user_id'])->row_array();
			$featured_class['teacher_name'] = $user_details['first_name'].' '.$user_details['last_name'];

			$recommended_class_list[$key] = $recommended_class;
		endforeach;

		$response['slider_classes'] = $slider_class_list;
		$response['featured_classes'] = $featured_class_list;
		$response['recommended_classes'] = $recommended_class_list;

		$response['base_url'] = base_url();
		return $response;
	}

	function class_details_get($class_id = "", $student_id = ""){
		$response = array();
		$response['class'] = $this->crud_model->get_classes($class_id)->row_array();

		if($student_id > 0){
			$response['following'] = $this->frontend_model->get_followers_by_follower_id($response['class']['user_id'], $student_id)->num_rows();
			$watch_history = $this->frontend_model->get_watch_histories($class_id, $student_id);
			$response['play_lesson'] = $this->frontend_model->get_lessons($watch_history->row('playing_lesson'))->row_array();
		}else{
			$response['following'] = 0;
			$response['play_lesson'] = 0;
		}
		$response['all_lessons'] = $this->frontend_model->get_active_lessons_by_class_id($class_id)->result_array();

		$response['class_owner'] = $this->crud_model->get_users($response['class']['user_id'])->row_array();

		$response['students'] = $this->frontend_model->get_total_watched_student($class_id);
		$response['student_recommended_level'] = $this->frontend_model->best_suited_level($class_id, 'count');
		$response['base_url'] = base_url();

		return $response;

	}


	function browse_classes_get($param1 = "", $param2 = ""){
		if(isset($_GET['search']) && $_GET['search'] != ""){
			$this->db->like('class_title', $_GET['search']);
			$this->db->or_like('short_description', $_GET['search']);
			$this->db->or_like('description', $_GET['search']);
			$this->db->or_like('level', $_GET['search']);
		}

		if(isset($_GET['recommended']) && $_GET['recommended'] != ""){
			$this->db->where('is_recommended', 1);
		}

		if(isset($_GET['featured']) && $_GET['featured'] != ""){
			$this->db->where('is_featured', 1);
		}

		//If exitst numeric data, then this parameter for pagination or category title
		if($param1 != "" && !is_numeric($param1)){
			$sub_categories = array();
			$category_id = $this->db->get_where('category', array('slugify' => $param1))->row('category_id');
			foreach($this->crud_model->get_sub_categories($category_id)->result_array() as $sub_category):
				array_push($sub_categories, $sub_category['category_id']);
			endforeach;
			$this->db->where_in('category_id', $sub_categories);
		}


		//For filter
			if(isset($_GET['pricing']) && $_GET['pricing'] == 'free'){
				$this->db->where('is_free', 1);
			}elseif(isset($_GET['pricing']) && $_GET['pricing'] == 'premium'){
				$this->db->where('is_free !=', 1);
			}

			if(isset($_GET['duration_range']) && $_GET['duration_range'] == 'less30'){
				$count_seconds = 30*60;
				$this->db->where('total_duration <=', $count_seconds);
			}elseif(isset($_GET['duration_range']) && $_GET['duration_range'] == '31to60'){
				$first_range = 31*60;
				$second_range = 60*60;
				$this->db->where('total_duration >=', $first_range);
				$this->db->where('total_duration <=', $second_range);
			}elseif(isset($_GET['duration_range']) && $_GET['duration_range'] == 'greater60'){
				$count_seconds = 60*60;
				$this->db->where('total_duration >', $count_seconds);
			}
		//End filter

		//uri segment not working here may some reason, so the param1 use for uri segment
		if($param1 != "" && is_numeric($param1)){
			$offset = $param1;
		}else{
			$offset = $param2;
		}
		if($offset != ""){
			$this->db->limit(15, $offset);
		}

		$this->db->where('status', 'active');
		return $this->db->get('classes')->result_array();
	}























}