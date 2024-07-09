<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set(get_settings('timezone'));
		$this->load->library('session');
	}

	function profile($user_id = ""){
		if($user_id == ""){
			redirect(site_url(), 'refresh');
		}
		$user_details = $this->crud_model->get_users($user_id)->row_array();
		$page_data['user_details'] = $user_details;
		$page_data['page_title'] = $user_details['first_name'].' '.$user_details['last_name'];
		$page_data['page_name'] = 'profile';
		$this->load->view('frontend/index', $page_data);
	}


	function account($type = "", $param2 = ""){
		if(!login_type()){
			$this->session->set_flashdata('error',get_phrase('you_do_not_have_access_to_this_account'));
			redirect(site_url(), 'refresh');
		}

		$user_id = $this->session->userdata('user_id');
		
		$user_details = $this->crud_model->get_users($user_id)->row_array();
		$page_data['user_details'] = $user_details;
		$page_data['type'] = $type;

		if($type == 'invoice'){
			$page_data['payment_id'] = $param2;
			$page_data['page_title'] = 'invoice';
		}else{
			$page_data['page_title'] = 'account_settings';
		}
		
		$page_data['page_name'] = 'profile_details';
		$this->load->view('frontend/index', $page_data);
	}

	function profile_update(){
		if(!login_type()){
			$this->session->set_flashdata('error',get_phrase('please_login_first'));
			redirect(site_url('signin'), 'refresh');
		}

		$user_id = $this->session->userdata('user_id');
		$this->frontend_model->profile_update($user_id);
		$this->session->set_flashdata('success',get_phrase('profile_updated_successfully'));
	}

	function upload_profile_image(){
		if(!login_type()){
			$this->session->set_flashdata('error',get_phrase('please_login_first'));
			redirect(site_url('signin'), 'refresh');
		}

		$user_id = $this->session->userdata('user_id');
		$this->frontend_model->upload_profile_image($user_id);

		$this->session->set_flashdata('success',get_phrase('profile_photo_updated_successfully'));
	}

	function social_link_update(){
		if(!login_type()){
			$this->session->set_flashdata('error',get_phrase('please_login_first'));
			redirect(site_url('signin'), 'refresh');
		}

		$user_id = $this->session->userdata('user_id');
		$this->frontend_model->social_link_update($user_id);
		$this->session->set_flashdata('success',get_phrase('social_links_updated_successfully'));
	}

	function change_password(){
		if(!login_type()){
			$this->session->set_flashdata('error',get_phrase('please_login_first'));
			redirect(site_url('signin'), 'refresh');
		}

		$user_id = $this->session->userdata('user_id');
		$this->frontend_model->change_password($user_id);
	}


	function followers(){
		$user_id = $_GET['user_id'];
		$page_data['followers'] = $this->frontend_model->get_followers_by_user_id($user_id);
		$this->load->view('frontend/followers.php', $page_data);
	}

	function following(){
		$user_id = $_GET['user_id'];
		$page_data['following'] = $this->frontend_model->get_following_by_user_id($user_id);
		$this->load->view('frontend/following.php', $page_data);
	}









}