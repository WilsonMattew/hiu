<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set(get_settings('timezone'));
		$this->load->library('session');
	}

	public function index() {
		if(login_type('admin')){
			redirect(site_url('admin'), 'refresh');
		}elseif(login_type()){
			redirect(site_url('home'), 'refresh');
		}
		$page_data['page_title'] = 'sign_in';
		$page_data['page_name'] = 'sign_in';
		$this->load->view('frontend/index', $page_data);
	}

	public function check_validity(){
		$email = htmlspecialchars($this->input->post('email'));
        $password = $this->input->post('password');
        $credential = array('email' => $email, 'password' => sha1($password), 'status' => 1, 'is_verified' => 1);

        // Checking login credential for admin
        $query = $this->db->get_where('user', $credential);

        if ($query->num_rows() > 0) {
        	$this->session->set_userdata('user_id', $query->row('user_id'));
            $this->session->set_userdata('user_role', $query->row('role'));
            $this->session->set_userdata('login_type', true);
            $this->session->set_userdata('user_name', $query->row('first_name').' '.$query->row('last_name'));
            $this->session->set_userdata('user_image', $query->row('photo'));
            $this->session->set_flashdata('success', get_phrase('signed_in_successfully'));
            if ($query->row('role') == 'admin') {
                redirect(site_url('admin/dashboard'), 'refresh');
            }elseif ($query->row('role') == 'student') {
                redirect(site_url('home'), 'refresh');
            }elseif($query->row('role') == 'teacher'){
            	redirect(site_url('teacher/dashboard'), 'refresh');
            }
        }else {
            $this->session->set_flashdata('error',get_phrase('invalid_login_credentials'));
            redirect(site_url('signin'), 'refresh');
        }
	}

	public function forgot_password() {
		if(login_type('admin')){
			redirect(site_url('admin'), 'refresh');
		}elseif(login_type()){
			redirect(site_url('home'), 'refresh');
		}
		$page_data['page_title'] = 'forgot_password';
		$page_data['page_name'] = 'forgot_password';
		$this->load->view('frontend/index', $page_data);
	}

	public function send_forgot_password_mail(){
		if(login_type('admin')){
			redirect(site_url('admin'), 'refresh');
		}elseif(login_type()){
			redirect(site_url('home'), 'refresh');
		}
		$new_password = rand(10000, 99999);
		$email = $this->input->post('email');
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			if($this->email_model->send_forgot_password_mail($new_password, $email) == true){
				$this->session->set_flashdata('success', get_phrase('your_password_has_been_changed').'. '.get_phrase('please_check_the_email_for_your_new_password'));
				redirect(site_url('signin'), 'refresh');
			}else{
				$this->session->set_flashdata('error', get_phrase('user_not_found'));
				redirect(site_url('signin/forgot_password'), 'refresh');
			}
		}else{
			$this->session->set_flashdata('error', get_phrase('invalid_email_address'));
			redirect(site_url('signin/forgot_password'), 'refresh');
		}
	}

	public function sign_out(){
		$this->session->sess_destroy();
		redirect(site_url('signin'), 'refresh');
	}
}
