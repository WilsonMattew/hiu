<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set(get_settings('timezone'));
		$this->load->library('session');
		if(!login_type('teacher')){
			redirect(site_url('signin'), 'refresh');
		}
	}

	function index(){
		$page_data['popular_classes'] = $this->crud_model->popular_classes(10);
		$page_data['page_title'] = get_phrase('dashboard');
		$page_data['page_name'] = 'dashboard';
		$this->load->view('backend/index', $page_data);
	}

	function dashboard(){
		$page_data['popular_classes'] = $this->crud_model->popular_classes(10);
		$page_data['page_title'] = get_phrase('dashboard');
		$page_data['page_name'] = 'dashboard';
		$this->load->view('backend/index', $page_data);
	}

	function classes(){
		$page_data['page_title'] = get_phrase('classes');
		$page_data['page_name'] = 'classes';
		$this->load->view('backend/index', $page_data);
	}


public function classes_server_side_data() {
	$user_id = $this->session->userdata('user_id');
	//mentioned all with colum of table that is Views > backend > admin or user
	$columns = array(0 => 'class_id', 1 => 'class_title', 2 => 'title', 3 => 'class_id', 4 => 'status', 5 => 'class_id');

	$limit = htmlspecialchars($this->input->post('length'));
    $start = htmlspecialchars($this->input->post('start'));

    $column_index = $columns[$this->input->post('order')[0]['column']];

    $dir = $this->input->post('order')[0]['dir'];

    $totalData = $this->crud_model->get_classes_by_user_id($user_id)->num_rows();
        
    $totalFiltered = $totalData;
    $search = $this->input->post('search')['value'];

    if(empty($search)) {
    	$classes = $this->db->select('*')
        	->where('user_id', $user_id)
        	->limit($limit,$start)
        	->order_by($column_index,$dir)
	        ->from('classes')
	        ->join('category', 'category.category_id = classes.category_id')
	        ->get()->result_array();
    } else {
    	$classes = $this->db->select('*')
        	->where('user_id',$user_id)
        	->like('class_title',$search)
        	->or_like('title',$search)
        	->or_like('status',$search)
        	->limit($limit,$start)
        	->order_by($column_index,$dir)
	        ->from('classes')
	        ->join('category', 'category.category_id = classes.category_id')
	        ->get()->result_array();

        $totalFiltered = $this->db->like('class_title',$search)
        	->where('user_id',$user_id)
            ->or_like('title',$search)
            ->or_like('status',$search)
            ->from('classes')
    		->join('category', 'category.category_id = classes.category_id')
    		->get()->num_rows();
    }

    $data = array();
    if(!empty($classes)) {
        foreach ($classes as $key => $class) {
        	$user_details = $this->crud_model->get_users($class['user_id'])->row_array();
        	if($class['is_featured'] && $class['is_recommended']):
        		$title =
        		'<strong>
                    <a href="'.site_url("teacher/manage_class/".$class["class_id"]).'">
                    	'.$class["class_title"].'<i class="entypo-star text-11px text-danger" data-toggle="tooltip" data-placement="top" title="'.get_phrase("featured_class").'"></i>

                    	<i class="fa fa-hand-holding-heart" data-toggle="tooltip" data-placement="top" title="'.get_phrase("recommended_class").'"></i>
                    </a>
                </strong>
				<br>
				<small>'.$user_details["first_name"].' '.$user_details["last_name"]."<br/>".date("D, d-M-Y", $class["date_added"]).'
				</small>';
        	elseif($class['is_featured']):
            	$title =
        		'<strong>
                    <a href="'.site_url("teacher/manage_class/".$class["class_id"]).'">
                    	'.$class["class_title"].'<i class="entypo-star text-11px text-danger" data-toggle="tooltip" data-placement="top" title="'.get_phrase("featured_class").'"></i>
                    </a>
                </strong>
				<br>
				<small>'.$user_details["first_name"].' '.$user_details["last_name"]."<br/>".date("D, d-M-Y", $class["date_added"]).'
				</small>';
			elseif($class['is_recommended']):
            	$title =
        		'<strong>
                    <a href="'.site_url("teacher/manage_class/".$class["class_id"]).'">
                    	'.$class["class_title"].'
                    	<i class="fa fa-hand-holding-heart" data-toggle="tooltip" data-placement="top" title="'.get_phrase("recommended_class").'"></i>
                    </a>
                </strong>
				<br>
				<small>'.$user_details["first_name"].' '.$user_details["last_name"]."<br/>".date("D, d-M-Y", $class["date_added"]).'
				</small>';
			else:
				$title =
        		'<strong>
                    <a href="'.site_url("teacher/manage_class/".$class["class_id"]).'">
                    	'.$class["class_title"].
                    '</a>
                </strong>
				<br>
				<small>'.$user_details["first_name"].' '.$user_details["last_name"]."<br/>".date("D, d-M-Y", $class["date_added"]).'
				</small>';
			endif;

			$category = '<span class="badge badge-secondary">'.$class['title'].'</span>';

			$number_of_lesson = $this->crud_model->get_lessons_by_class_id($class['class_id'])->num_rows();
			$total_duration = duration_format($class['total_duration']);
			$lessons = $number_of_lesson.' '.get_phrase('lessons').'<br>';
			$lessons .= $total_duration['h'].'h '.$total_duration['m'].'m '.$total_duration['s'].'s';
			
			if ($class['status'] == 'active'):
				$status =
               '<span class="badge bg-success">'.get_phrase($class['status']).'</span>';
            elseif($class['status'] == 'pending'):
              	$status =
                '<span class="badge bg-danger">'.get_phrase($class['status']).'</span>';
            else:
              	$status =
                '<span class="badge">'.get_phrase($class['status']).'</span>';
            endif;

            $droupdown_btn_with_view_btn = '<div class="btn-group">
							<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
							'.get_phrase("action").' <span class="caret"></span>
							</button>
                      			<ul class="dropdown-menu dropdown-blue dropdown-menu-right" role="menu"><li><a href="'.site_url('classes/'.$class['slugify'].'/'.$class['class_id']).'" target="_blank">'.get_phrase("view_in_frontend").'</a></li>';

            $edit_btn = '<li><a href="'.site_url('teacher/manage_class/'.$class['class_id']).'">'.get_phrase('manage_class').'</a></li>';


      		if ($class['status'] == 'active'):
            	$status_changing_btn = '<li><a href="javascript:;" onclick="confirm_modal(&apos;'.site_url("teacher/change_status/inactive/".$class["class_id"]).'&apos;, '.'&apos;generic_confirmation&apos;'.');">'.get_phrase("mark_as_inactive").'</a></li>';
            elseif($class['status'] == 'pending'):
            	$status_changing_btn = '<li><a href="javascript:;" onclick="showAjaxModal(&apos;'.site_url("teacher/class_approval_mail_form/".$class["class_id"]).'&apos;, '.'&apos;'.$class['class_title'].'&apos;'.');">'.get_phrase("send_a_approval_request").'</a></li>';
            else:
            	$status_changing_btn = '<li><a href="javascript:;" onclick="confirm_modal(&apos;'.site_url("teacher/change_status/active/".$class["class_id"]).'&apos;, '.'&apos;generic_confirmation&apos;'.');">'.get_phrase("mark_as_active").'</a></li>';
            endif;


            $droupdown_closed_with_delete_btn = '<li class="divider"></li>
                        <li><a href="javascript:;" onclick="confirm_modal(&apos;'.site_url("teacher/class_delete/".$class["class_id"]).'&apos;)">'.get_phrase("delete").'</a>
                        </li>
                      </ul>
                    </div>';
            $action = $droupdown_btn_with_view_btn.$edit_btn.$status_changing_btn.$droupdown_closed_with_delete_btn;

            $nestedData['key'] = ++$key;
            $nestedData['title'] = $title;
            $nestedData['category'] = $category;
            $nestedData['total_lesson'] = $lessons;
            $nestedData['status'] = $status;
            $nestedData['action'] = $action.'<script>$("a, i").tooltip();</script>';
            $data[] = $nestedData;
        }
    }

    $json_data = array(
        "draw"            => intval($this->input->post('draw')),  
        "recordsTotal"    => intval($totalData),  
        "recordsFiltered" => intval($totalFiltered), 
        "data"            => $data
	);
        
    echo json_encode($json_data);
}

function add_class($param1 = ""){
	if($param1 == 'added' && isset($_POST['class_title'])){
		echo $this->crud_model->add_class();
		die();
	}
	$page_data['page_title'] = get_phrase('add_class');
	$page_data['page_name'] = 'add_class';
	$this->load->view('backend/index', $page_data);
}

function change_status($status = "", $class_id = ""){
	$current_status = $this->crud_model->get_classes($class_id)->row('status');
	if($status == 'inactive'){
		$is_active = 0;
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->where('class_id', $class_id);
		$this->db->update('classes', array('status' => $status));

		$this->db->where('class_id', $class_id);
		$this->db->update('skill_threades', array('is_active_class' => $is_active));
	}elseif($status == 'active' && $current_status == 'inactive'){
		$is_active = 1;

		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->where('class_id', $class_id);
		$this->db->update('classes', array('status' => $status));

		$this->db->where('class_id', $class_id);
		$this->db->update('skill_threades', array('is_active_class' => $is_active));
	}

	$this->session->set_flashdata('success', get_phrase('status_changed_successfully'));
	redirect(site_url('teacher/classes'), 'refresh');
}

function class_delete($class_id = ""){
	$user_id = $this->session->userdata('user_id');
	$this->crud_model->class_delete($class_id, $user_id);

	$this->session->set_flashdata('success', get_phrase('class_deleted_successfully'));
	redirect(site_url('teacher/classes'), 'refresh');
}

function manage_class($class_id = ""){
	$page_data['class_details'] = $this->crud_model->get_classes($class_id)->row_array();
	$page_data['lessons'] = $this->crud_model->get_lessons_by_class_id($class_id);

	$page_data['page_title'] = get_phrase('manage_class_information');
	$page_data['page_name'] = 'manage_class';
	$this->load->view('backend/index', $page_data);
}

function load_class_info($type = "", $class_id){
	$page_data['class_details'] = $this->crud_model->get_classes($class_id)->row_array();
	$page_data['lessons'] = $this->crud_model->get_lessons_by_class_id($class_id);

	if($type == 'lessons'){
		$this->load->view('backend/teacher/lessons', $page_data);
	}else{
		$this->load->view('backend/teacher/lessons', $page_data);
	}
}

function update_class($class_id = ""){
	$user_id = $this->session->userdata('user_id');
	echo $this->crud_model->update_class($class_id, $user_id);
}

function get_video_duration_by_type($lesson_type = ""){
	if($lesson_type == ''){
		$lesson_type = $this->input->post('lesson_type');
	}
	$video_url = $this->input->post('video_url');

	if($lesson_type == 'video_file' || $lesson_type == 'html5_video_url'){
		$response = $this->video_model->get_html5_video_info($video_url);
		print_r($response);
	}elseif($lesson_type == 'youtube' || $lesson_type == 'vimeo'){
		$response = $this->video_model->getVideoDetails($video_url);
		echo $response['duration'];
	}
}


function lesson_add($param1 = "", $class_id = ""){
	$user_id = $this->session->userdata('user_id');
	if($param1 == 'added'){
		echo $this->crud_model->lesson_add($class_id, $user_id);
		die();
	}

	$page_data['class_id'] = $param1;
	$this->load->view('backend/teacher/lesson_add', $page_data);
}

function lesson_edit($param1 = "", $param2 = "", $param3 = ""){
	$user_id = $this->session->userdata('user_id');
	if($param1 == 'updated'){
		//param2=lesson_id, param3=class_id
		echo $this->crud_model->lesson_update($param2, $param3);
		die();
	}

	//param1=lesson_id, param2=class_id
	$page_data['class_id'] = $param1;
	$page_data['lesson'] = $this->crud_model->get_lessons($param2)->row_array();
	$this->load->view('backend/teacher/lesson_edit', $page_data);
}

function lesson_delete($class_id = "", $lesson_id = ""){
	$this->crud_model->lesson_delete($class_id, $lesson_id);
	$this->session->set_flashdata('success', get_phrase('lesson_deleted_successfully'));
	redirect(site_url('teacher/manage_class/'.$class_id), 'refresh');
}

function sort_lesson(){
	$class_id = htmlspecialchars($this->input->post('class_id'));
	$lesson_id = htmlspecialchars($this->input->post('lesson_id'));
	$new_sort_position = htmlspecialchars($this->input->post('sort_position'));

	echo $this->crud_model->sort_lesson($class_id, $lesson_id, $new_sort_position);
}

function class_approval_request($type = "", $notification_id = ""){
	if($type == 'view_message'){
		$this->db->where('notification_id', $notification_id);
		$notification = $this->db->get('website_notification')->row_array();
		$message = json_decode($notification['details']);
		echo $message->message;
		die();
	}elseif($type == 'delete'){
		$this->db->where('notification_id', $notification_id);
		$this->db->delete('website_notification');
		$this->session->set_flashdata('success', get_phrase('request_has_been_deleted'));
		redirect(site_url('teacher/class_approval_request'), 'refresh');
	}

	$user_id = $this->session->userdata('user_id');
	$this->crud_model->notification_mark_as_read('class_approval_request', $user_id);
	$page_data['all_requests'] = $this->crud_model->get_notification_by_type('class_approval_request', $user_id);
	$page_data['page_title'] = get_phrase('approval_request');
	$page_data['page_name'] = 'class_approval_request';
	$this->load->view('backend/index', $page_data);
}

function class_approval($class_id = ""){
	$data['type'] = 'class_approval_request';
	$data['mail_from'] = $this->session->userdata('user_id');
	$data['mail_to'] = 'admin';
	$data['status'] = 0;
	$data['date_added'] = time();

	$details['class_id'] = $class_id;
	$details['message'] = htmlspecialchars($_POST['message']);
	$data['details'] = json_encode($details);

	$this->db->insert('website_notification', $data);

	$this->session->set_flashdata('success', get_phrase('the_request_has_been_sent').'. '.get_phrase('please_wait,_class_will_be_reviewed_and_you_will_be_notified_after_ending_the_review'));
	redirect(site_url('teacher/classes'), 'refresh');
}


function class_approval_mail_form($class_id = ""){
	$page_data['class_id'] = $class_id;
	$this->load->view('backend/teacher/class_approval_mail_form', $page_data);
}

function profile($param1 = ""){
	$user_id = $this->session->userdata('user_id');
	if($param1 == 'updated'){
		$this->crud_model->profile_updated($user_id);
		$this->session->set_flashdata('success', get_phrase('profile_updated_successfully'));
		redirect(site_url('teacher/profile'), 'refresh');
	}
	$page_data['user_info'] = $this->crud_model->get_users($user_id)->row_array();
	$page_data['page_title'] = get_phrase('profile');
	$page_data['page_name'] = 'profile';
	$this->load->view('backend/index', $page_data);
}

function change_password($param1 = ""){
	$user_id = $this->session->userdata('user_id');
	if($param1 == 'updated'){
		$this->crud_model->change_password($user_id);
		redirect(site_url('teacher/change_password'), 'refresh');
	}
	$page_data['page_title'] = get_phrase('change_password');
	$page_data['page_name'] = 'change_password';
	$this->load->view('backend/index', $page_data);
}












}