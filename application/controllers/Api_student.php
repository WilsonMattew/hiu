<?php
require APPPATH . '/libraries/TokenHandler.php';
//include Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';

class Api_student extends REST_Controller {

	protected $token;
	public function __construct() 
	{
		parent::__construct();
		$this->load->database();
		// creating object of TokenHandler class at first
		$this->tokenHandler = new TokenHandler();
		header('Content-Type: application/json');
	}

	public function token_data_get($auth_token)
	{
		//$received_Token = $this->input->request_headers('Authorization');
		if (isset($auth_token)) {
		  try
		  {

		    $jwtData = $this->tokenHandler->DecodeToken($auth_token);
		    return json_encode($jwtData);
		  }
		  catch (Exception $e)
		  {
		    echo 'catch';
		    http_response_code('401');
		    echo json_encode(array( "status" => false, "message" => $e->getMessage()));
		    exit;
		  }
		}else{
		  echo json_encode(array( "status" => false, "message" => "Invalid Token"));
		}
	}

	// Signup Api
	public function signup_post() {
		$response = array();
		$response = $this->api_model->signup_post();
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	// Verify Email Api
	public function verify_email_address_post(){
		$response = array();
		$response = $this->api_model->verify_email_address_post();
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	// Resend Verification Code Api
	public function resend_verification_code_post(){
		$response = array();
		$response = $this->api_model->resend_verification_code_post();
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	// Login Api
	public function login_post() {
		$userdata = $this->api_model->login_post();
		if ($userdata['validity'] == 1) {
		  $userdata['token'] = $this->tokenHandler->GenerateToken($userdata);
		}
		return $this->set_response($userdata, REST_Controller::HTTP_OK);
	}

	// Forget Password Api
	public function forget_password_post(){
		$response = array();
		$response = $this->api_model->forget_password_post();
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	// password reset
	public function update_password_post() {
		$response = array();
		if (isset($_POST['auth_token']) && !empty($_POST['auth_token'])) {
		  $auth_token = $_POST['auth_token'];
		  $logged_in_user_details = json_decode($this->token_data_get($auth_token), true);
		  if ($logged_in_user_details['user_id'] > 0) {
		    $response = $this->api_model->update_password_post($logged_in_user_details['user_id']);
		  }
		}else{
		  $response['status'] = 'failed';
		}
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}



	function subscription_status_get(){
		$response = array();
		if (isset($_GET['auth_token']) && !empty($_GET['auth_token'])) {
			$user_details = json_decode($this->token_data_get($auth_token), true);
			$response['subscription_status'] = subscription_status($user_details['user_id']);
		}
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	function categories_get(){
		$response = array();
		$response = $this->api_model->categories_get();
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	function home_get(){
		$response = array();
		$response = $this->api_model->home_get();
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	function class_details_get(){
		$response = array();
		$class_id = $_GET['class_id'];
		if (isset($_GET['auth_token']) && !empty($_GET['auth_token'])) {
			$user_details = json_decode($this->token_data_get($_GET['auth_token']), true);
			$response = $this->api_model->class_details_get($class_id, $user_details['user_id']);
		}else{
			$response = $this->api_model->class_details_get($class_id);
		}
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	function browse_classes_get($param1 = "", $param2 = ""){
		$response = array();
		$response = $this->api_model->browse_classes_get($param1, $param2);
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}




























}