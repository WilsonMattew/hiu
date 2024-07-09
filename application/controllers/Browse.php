<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Browse extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set(get_settings('timezone'));
		$this->load->library('session');
	}

	function index($param1="", $param2 = ""){
		//uri segment not working here may some reason, so the param1 use for uri segment
		if($param1 != "" && is_numeric($param1)){
			$offset = $param1;
		}else{
			$page_data['category_slugify'] = $param1;
			$offset = $param2;
		}			


		//Start before pagination, this is for count row
			//check with skill or not for join query
			if(isset($_GET['skill']) && $_GET['skill'] != ""){
				$total_rows = $this->frontend_model->get_classes_with_skills($_GET['skill'])->num_rows();
			}else{
				$total_rows = $this->frontend_model->get_classes($param1)->num_rows();
		    }
		//End before pagination, this is for count row

	    $config = array();
	    $config = get_pagination($total_rows, 9);

        //If exitst numeric data, then this parameter for pagination or category title
        if($param1 != "" && !is_numeric($param1)){
        	$config['base_url']  = site_url('browse/'.$param1);
        }else{
        	$config['base_url']  = site_url('browse');
        }
        $this->pagination->initialize($config);


	    //Start after pegination, here get data per page  
	        //check with skill or not for join query
			if(isset($_GET['skill']) && $_GET['skill'] != ""){
				$classes = $this->frontend_model->get_classes_with_skills($_GET['skill'], $config['per_page'], $offset);
			}else{
				$classes = $this->frontend_model->get_classes($param1, $config['per_page'], $offset);
		    }
		//End after pegination, here get data per page  


		$page_data['classes'] = $classes;
		$page_data['total_result'] = $total_rows;
		$page_data['page_title'] = 'browse_classes';
		$page_data['page_name'] = 'browse_classes';

		if(isset($_POST['is_ajax_call']) && $_POST['is_ajax_call'] != ""){
			$this->load->view('frontend/browse_classes_list', $page_data);
		}else{
			$this->load->view('frontend/index', $page_data);
		}
	}

















}