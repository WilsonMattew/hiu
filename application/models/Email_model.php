<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	public function send_email_verification_mail($email = "", $verification_code = "") {
		$query = $this->db->get_where('user' , array('email' => $email));
		if($query->num_rows() > 0) {
			$row = $query->row_array();
			$msg = get_settings('email_verification_mail');
			$msg = str_replace('[user_name]',$row['first_name'],$msg);
			$msg = str_replace('[verification_code]',$verification_code,$msg);

			$email_data['subject'] = get_phrase("email_verification");
			$email_data['from'] = get_settings('system_email');
			$email_data['to'] = $email;
			$email_data['message'] = $msg;
			$this->send_smtp_mail($email_data['message'], $email_data['subject'], $email_data['to'], $email_data['from']);
			return true;
		}else {
			return false;
		}
	}

	function send_forgot_password_mail($new_password = '' , $email = '') {
		$query = $this->db->get_where('user' , array('email' => $email, 'status' => 1, 'is_verified' => 1));
		if($query->num_rows() > 0) {
			$row = $query->row_array();
			$msg = get_settings('forgot_password_mail');
			$msg = str_replace('[user_name]',$row['first_name'],$msg);
			$msg = str_replace('[new_password]',$new_password,$msg);

			$email_data['subject'] = get_phrase("password_reset_request");
			$email_data['from'] = get_settings('system_email');
			$email_data['to'] = $email;
			$email_data['message'] = $msg;
			$this->send_smtp_mail($email_data['message'], $email_data['subject'], $email_data['to'], $email_data['from']);
			return true;
		}else {
			return false;
		}
	}

	function send_account_access($email = "", $pass = ""){
		$query = $this->db->get_where('user' , array('email' => $email, 'status' => 1, 'is_verified' => 1));
		if($query->num_rows() > 0) {
			$row = $query->row_array();
			$msg = get_settings('account_access_mail');
			$msg = str_replace('[user_name]',$row['first_name'],$msg);
			$msg = str_replace('[email]',$email,$msg);
			$msg = str_replace('[password]',$pass,$msg);

			$email_data['subject'] = get_phrase("new_account_access");
			$email_data['from'] = get_settings('system_email');
			$email_data['to'] = $email;
			$email_data['message'] = $msg;
			$this->send_smtp_mail($email_data['message'], $email_data['subject'], $email_data['to'], $email_data['from']);
			return true;
		}else {
			return false;
		}
	}

	function send_class_approval_mail($user_id = ""){
		$query = $this->db->get_where('user' , array('user_id' => $user_id));
		if($query->num_rows() > 0) {
			$row = $query->row_array();
			$msg = $_POST['message'];

			$email_data['subject'] = get_phrase("class_approval_request");
			$email_data['from'] = get_settings('system_email');
			$email_data['to'] = $row['email'];
			$email_data['message'] = $msg;
			$this->send_smtp_mail($email_data['message'], $email_data['subject'], $email_data['to'], $email_data['from']);
			return true;
		}else {
			return false;
		}
	}

	public function send_smtp_mail($msg=NULL, $sub=NULL, $to=NULL, $from=NULL) {
		//Load email library
		$this->load->library('email');
		if($from == NULL)
		$from=$this->db->get_where('settings' , array('type' => 'system_email'))->row('value');

		//SMTP & mail configuration
		$config = array(
			'protocol'  => get_settings('protocol'),
			'smtp_host' => get_settings('smtp_host'),
			'smtp_port' => get_settings('smtp_port'),
			'smtp_user' => get_settings('smtp_user'),
			'smtp_pass' => get_settings('smtp_pass'),
			'mailtype'  => 'html',
			'charset'   => 'utf-8'
		);
		$this->email->set_header('MIME-Version', 1.0);
		$this->email->set_header('Content-type', 'text/html');
		$this->email->set_header('charset', 'UTF-8');
		
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		$this->email->to($to);
		$this->email->from($from, get_settings('system_title'));
		$this->email->subject($sub);
		$this->email->message($msg);

		//Send email
		$this->email->send();
	}
}
