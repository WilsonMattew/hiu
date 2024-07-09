<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Membership extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set(get_settings('timezone'));
		$this->load->library('session');
	}

	function index($class_title = ""){
		$page_data['packages'] = $this->frontend_model->get_active_packages();;
		$page_data['page_title'] = 'checkout_membership';
		$page_data['page_name'] = 'membership';
		$this->load->view('frontend/index', $page_data);
	}

	function checkout(){
		if(!login_type()){
			$this->session->set_flashdata('error', get_phrase('please_sign_in_first'));
			redirect(site_url('signin'), 'refresh');
		}
		$payment_method = htmlspecialchars($this->input->get('payment_method'));
		$package_id = htmlspecialchars($this->input->get('package_id'));
		$user_id = $this->session->userdata('user_id');

		$page_data['user_details'] = $this->crud_model->get_users($user_id)->row_array();
		$page_data['package'] = $this->frontend_model->get_active_packages($package_id)->row_array();

		if($payment_method == 'paypal'){
			$this->load->view('payment/paypal/paypal_checkout', $page_data);
		}elseif($payment_method == 'stripe'){
			$this->load->view('payment/stripe/stripe_checkout', $page_data);
		}else{
			$this->session->set_flashdata('error', get_phrase('please_select_a_payment_method'));
			redirect(site_url('membership'), 'refresh');
		}
	}

	function payment_success($payment_method = "", $package_id = "", $paid_amount = "", $param4 = "", $param5 = "", $param6 = "", $param7 = ""){
		$user_id = $this->session->userdata('user_id');
	    $package = $this->frontend_model->get_active_packages($package_id)->row_array();
		$response = false;
		$payment_key = false;





		//check payment validity
	    if($payment_method == 'paypal'){
			$response_arr = $this->payment_model->paypal_payment($param4, $param5, $param6);

			if($response_arr['payment_status'] != true){
				$this->session->set_flashdata('error', get_phrase('payment_failed'));
				redirect(site_url(), 'refresh');
			}

			if($package['price'] != $response_arr['paid_amount']){
				$this->session->set_flashdata('error', get_phrase('the_amount_does_not_match_with_this_package'));
				redirect(site_url(), 'refresh');
			}

		    $payment_key = json_encode(array('payment_id' => $param4, 'payment_token' => $param5, 'payer_id' => $param6));
			$response = $response_arr['payment_status'];


		}elseif($payment_method == 'stripe'){
			$response_arr = $this->payment_model->stripe_payment($param4);

			if($response_arr['payment_status'] != 'succeeded'){
				$this->session->set_flashdata('error', get_phrase('payment_failed'));
				redirect(site_url(), 'refresh');
			}

			if($response_arr['paid_amount'] != $paid_amount){
				$this->session->set_flashdata('error', get_phrase('the_amount_does_not_match_with_this_package'));
				redirect(site_url(), 'refresh');
			}

			$payment_key = $param4;
			$response = $response_arr['response'];

		}




		if($response == true){
			$this->frontend_model->add_subscription($user_id, $package_id, $paid_amount, $payment_method, $payment_key);
			$this->session->set_flashdata('success', get_phrase('subscription_purchased_successfully'));
			redirect(site_url(), 'refresh');
		}else{
			$this->session->set_flashdata('error', get_phrase('payment_failed'));
			redirect(site_url(), 'refresh');
		}
	}


















}