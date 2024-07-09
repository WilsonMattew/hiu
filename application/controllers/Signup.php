<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set(get_settings('timezone'));
		$this->load->library('session');
		if(login_type('admin')){
			redirect(site_url('admin'), 'refresh');
		}elseif(login_type()){
			redirect(site_url('home'), 'refresh');
		}
	}

	public function index() {
		$page_data['page_title'] = 'sign_up';
		$page_data['page_name'] = 'sign_up';
		$this->load->view('frontend/index', $page_data);
	}

	public function modal_view() {
		$this->load->view('frontend/modal_view');
	}

	function register(){
		$email = htmlspecialchars($this->input->post('email'));
		$verification_code = rand(100000, 999999);
		$exist_email = exist_email($email);
		if(!$exist_email){
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				$this->frontend_model->user_registration($verification_code);
				if (get_settings('email_verification')) {

		            $this->session->set_flashdata('success', get_phrase('your_registration_has_been_successfully_done').'. '.get_phrase('please_check_your_mail_inbox_to_verify_your_email_address'));
		            $this->email_model->send_email_verification_mail($email, $verification_code);
		            $this->session->set_userdata('verify_email', $email);
					redirect(site_url('signup/email_verification'), 'refresh');
		        }else {
		            $this->session->set_flashdata('success', get_phrase('your_registration_has_been_successfully_done'));
					redirect(site_url('signin'), 'refresh');
		        }

		    }else{
		    	$this->session->set_flashdata('error', get_phrase('invalid_email_address'));
				redirect(site_url('signup'), 'refresh');
		    }
		}elseif($exist_email === 'unverified'){
			$this->session->set_userdata('verify_email', $email);
		    $this->email_model->send_email_verification_mail($email, $verification_code);
			$this->session->set_flashdata('error', get_phrase('you_have_already_registered').'. '.get_phrase('please_verify_your_email_address'));
			redirect(site_url('signup/email_verification'), 'refresh');
			
		}else{
			$this->session->set_flashdata('error', get_phrase('you_have_already_registered'));
			redirect(site_url('signin'), 'refresh');
		}
	}

	public function email_verification(){
		if(!$this->session->userdata('verify_email')){
			$this->session->set_flashdata('error', get_phrase('plese_sign_up_again_to_verify_it'));
			redirect(site_url('signup'), 'refresh');
		}

		$email = $this->session->userdata('verify_email');

		$verification_code = htmlspecialchars($this->input->post('verification_code'));
		if(isset($verification_code) && !empty($verification_code)){

			$this->db->where('email', $email);
			$this->db->where('verification_code', $verification_code);
			$this->db->where('is_verified', 0);
			$this->db->where('status', 0);
			$this->db->update('user', array('status' => 1, 'is_verified' => 1));

			$this->session->set_flashdata('success', get_phrase('your_email_address_has_been_successfully_verified'));
			redirect(site_url('signin'), 'refresh');
		}
		
		$page_data['page_title'] = 'email_verification';
		$page_data['page_name'] = 'email_verification';
		$this->load->view('frontend/index', $page_data);
	}

	function resend_verification_mail(){
		$email = $this->session->userdata('verify_email');
		if($email){
			$this->db->where('email', $email);
			$this->db->where('is_verified', 0);
			$this->db->where('status', 0);
			$query = $this->db->get('user');
			if($query->num_rows() > 0){
				$this->email_model->send_email_verification_mail($email, $query->row('verification_code'));
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 2;
		}
	}




}