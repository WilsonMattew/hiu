<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set(get_settings('timezone'));
		$this->load->library('session');
		if(!login_type('admin')){
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

/*=====================================================> Category start <=====================================================*/
	function add_category(){
		$page_data['page_title'] = get_phrase('add_category');
		$page_data['page_name'] = 'add_category';
		$this->load->view('backend/index', $page_data);
	}

	function add_sub_category($parent_category_id = ""){
		$page_data['parent_category'] = $this->crud_model->get_categories($parent_category_id)->row_array();
		$this->load->view('backend/admin/add_sub_category', $page_data);
	}

	function edit_category($category_id = ""){
		$page_data['category'] = $this->crud_model->get_categories($category_id)->row_array();
		$page_data['page_title'] = get_phrase('edit_category');
		$page_data['page_name'] = 'edit_category';
		$this->load->view('backend/index', $page_data);
	}

	function edit_sub_category($category_id = ""){
		$page_data['sub_category'] = $this->crud_model->get_categories($category_id)->row_array();
		$this->load->view('backend/admin/edit_sub_category', $page_data);
	}

	function categories($param1 = "", $param2 = ""){
		if($param1 == "add"){
			$this->crud_model->add_category();
			redirect(site_url('admin/categories'), 'refresh');
		}elseif($param1 == "update"){
			$this->crud_model->update_category($param2);
			redirect(site_url('admin/categories'), 'refresh');
		}elseif($param1 == "delete"){
			$this->crud_model->delete_category($param2);
			$this->session->set_flashdata('success', get_phrase('category_deleted_successfully'));
			redirect(site_url('admin/categories'), 'refresh');
		}
		$page_data['parent_categories'] = $this->crud_model->get_parent_categories();
		$page_data['page_title'] = get_phrase('categories');
		$page_data['page_name'] = 'categories';
		$this->load->view('backend/index', $page_data);
	}
/*=====================================================> Category end <=====================================================*/

function classes(){
	$page_data['page_title'] = get_phrase('classes');
	$page_data['page_name'] = 'classes';
	$this->load->view('backend/index', $page_data);
}


public function classes_server_side_data() {
	//mentioned all with colum of table that is Views > backend > admin or user
	$columns = array(0 => 'class_id', 1 => 'class_title', 2 => 'title', 3 => 'class_id', 4 => 'status', 5 => 'class_id');

	$limit = htmlspecialchars($this->input->post('length'));
    $start = htmlspecialchars($this->input->post('start'));

    $column_index = $columns[$this->input->post('order')[0]['column']];

    $dir = $this->input->post('order')[0]['dir'];

    $totalData = $this->crud_model->get_classes()->num_rows();
        
    $totalFiltered = $totalData; 
    $search = $this->input->post('search')['value'];

    if(empty($search)) {
    	$classes = $this->db->select('*')
        	->limit($limit,$start)
        	->order_by($column_index,$dir)
	        ->from('classes')
	        ->join('category', 'category.category_id = classes.category_id')
	        ->get()->result_array();
    } else {
    	$classes = $this->db->select('*')
        	->like('class_title',$search)
        	->or_like('title',$search)
        	->or_like('status',$search)
        	->limit($limit,$start)
        	->order_by($column_index,$dir)
	        ->from('classes')
	        ->join('category', 'category.category_id = classes.category_id')
	        ->get()->result_array();

        $totalFiltered = $this->db->like('class_title',$search)
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
                    <a href="'.site_url("admin/manage_class/".$class["class_id"]).'">
                    	'.$class["class_title"].'<i class="entypo-star text-11px text-danger" data-toggle="tooltip" data-placement="top" title="'.get_phrase("featured_class").'"></i>

                    	<i class="fa fa-hand-holding-heart" data-toggle="tooltip" data-placement="top" title="'.get_phrase("recommended_class").'"></i>
                    </a>
                </strong>
				<br>
				<small><a target="_blank" href="'.site_url("user/profile/".$user_details["user_id"]).'">'.$user_details["first_name"].' '.$user_details["last_name"]."<br/>".date("D, d-M-Y", $class["date_added"]).'</a>
				</small>';
        	elseif($class['is_featured']):
            	$title =
        		'<strong>
                    <a href="'.site_url("admin/manage_class/".$class["class_id"]).'">
                    	'.$class["class_title"].'<i class="entypo-star text-11px text-danger" data-toggle="tooltip" data-placement="top" title="'.get_phrase("featured_class").'"></i>
                    </a>
                </strong>
				<br>
				<small><a target="_blank" href="'.site_url("user/profile/".$user_details["user_id"]).'">'.$user_details["first_name"].' '.$user_details["last_name"]."<br/>".date("D, d-M-Y", $class["date_added"]).'</a>
				</small>';
			elseif($class['is_recommended']):
            	$title =
        		'<strong>
                    <a href="'.site_url("admin/manage_class/".$class["class_id"]).'">
                    	'.$class["class_title"].'
                    	<i class="fa fa-hand-holding-heart" data-toggle="tooltip" data-placement="top" title="'.get_phrase("recommended_class").'"></i>
                    </a>
                </strong>
				<br>
				<small><a target="_blank" href="'.site_url("user/profile/".$user_details["user_id"]).'">'.$user_details["first_name"].' '.$user_details["last_name"]."<br/>".date("D, d-M-Y", $class["date_added"]).'</a>
				</small>';
			else:
				$title =
        		'<strong>
                    <a href="'.site_url("admin/manage_class/".$class["class_id"]).'">
                    	'.$class["class_title"].
                    '</a>
                </strong>
				<br>
				<small><a target="_blank" href="'.site_url("user/profile/".$user_details["user_id"]).'">'.$user_details["first_name"].' '.$user_details["last_name"]."<br/>".date("D, d-M-Y", $class["date_added"]).'</a>
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
                      			<ul class="dropdown-menu dropdown-blue dropdown-menu-right" role="menu"><li><a href="'.site_url('classes/'.slugify($class['class_title']).'/'.$class['class_id']).'" target="_blank">'.get_phrase("view_in_frontend").'</a></li>';

            $edit_btn = '<li><a href="'.site_url('admin/manage_class/'.$class['class_id']).'">'.get_phrase('manage_class').'</a></li>';


      		if ($class['status'] == 'active'):
            	$status_changing_btn = '<li><a href="javascript:;" onclick="confirm_modal(&apos;'.site_url("admin/change_status/inactive/".$class["class_id"]).'&apos;, '.'&apos;generic_confirmation&apos;'.');">'.get_phrase("mark_as_inactive").'</a></li>';
            	$status_changing_btn .= '<li><a href="javascript:;" onclick="confirm_modal(&apos;'.site_url("admin/change_status/pending/".$class["class_id"]).'&apos;, '.'&apos;generic_confirmation&apos;'.');">'.get_phrase("mark_as_pending_for_review").'</a></li>';
            elseif($class['status'] == 'pending'):
            	$status_changing_btn = '<li><a href="javascript:;" onclick="confirm_modal(&apos;'.site_url("admin/change_status/active/".$class["class_id"]).'&apos;, '.'&apos;generic_confirmation&apos;'.');">'.get_phrase("mark_as_active").'</a></li>';
            else:
            	$status_changing_btn = '<li><a href="javascript:;" onclick="confirm_modal(&apos;'.site_url("admin/change_status/active/".$class["class_id"]).'&apos;, '.'&apos;generic_confirmation&apos;'.');">'.get_phrase("mark_as_active").'</a></li>';
            endif;


            $droupdown_closed_with_delete_btn = '<li class="divider"></li>
                        <li><a href="javascript:;" onclick="confirm_modal(&apos;'.site_url("admin/class_delete/".$class["class_id"]).'&apos;)">'.get_phrase("delete").'</a>
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
	$this->db->where('class_id', $class_id);
	$this->db->update('classes', array('status' => $status));

	if($status == 'active'){
		$is_active = 1;
	}else{
		$is_active = 0;
	}

	$this->db->where('class_id', $class_id);
	$this->db->update('skill_threades', array('is_active_class' => $is_active));

	$this->session->set_flashdata('success', get_phrase('status_changed_successfully'));
	redirect(site_url('admin/classes'), 'refresh');
}

function class_delete($class_id = ""){
	$this->crud_model->class_delete($class_id);

	$this->session->set_flashdata('success', get_phrase('class_deleted_successfully'));
	redirect(site_url('admin/classes'), 'refresh');
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
		$this->load->view('backend/admin/lessons', $page_data);
	}else{
		$this->load->view('backend/admin/lessons', $page_data);
	}
}

function update_class($class_id = ""){
	echo $this->crud_model->update_class($class_id);
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
	$this->load->view('backend/admin/lesson_add', $page_data);
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
	$this->load->view('backend/admin/lesson_edit', $page_data);
}

function lesson_delete($class_id = "", $lesson_id = ""){
	$this->crud_model->lesson_delete($class_id, $lesson_id);
	$this->session->set_flashdata('success', get_phrase('lesson_deleted_successfully'));
	redirect(site_url('admin/manage_class/'.$class_id), 'refresh');
}

function sort_lesson(){
	$class_id = htmlspecialchars($this->input->post('class_id'));
	$lesson_id = htmlspecialchars($this->input->post('lesson_id'));
	$new_sort_position = htmlspecialchars($this->input->post('sort_position'));

	echo $this->crud_model->sort_lesson($class_id, $lesson_id, $new_sort_position);
}

function class_approval_request(){
	$this->crud_model->notification_mark_as_read('class_approval_request', 'admin');
	$page_data['all_requests'] = $this->crud_model->get_notification_by_type('class_approval_request', 'admin');
	$page_data['page_title'] = get_phrase('approval_request');
	$page_data['page_name'] = 'class_approval_request';
	$this->load->view('backend/index', $page_data);
}

function class_approval($type = "", $notification_id = ""){
	$this->db->where('notification_id', $notification_id);
	$notification = $this->db->get('website_notification')->row_array();

	$message = json_decode($notification['details']);

	if($type == 'view_message'){
		echo $message->message;
		die();
	}elseif($type == 'delete'){
		$this->db->where('notification_id', $notification_id);
		$this->db->delete('website_notification');
		$this->session->set_flashdata('success', get_phrase('request_has_been_deleted'));
		redirect(site_url('admin/class_approval_request'), 'refresh');
	}elseif($type == 'approved'){
		$this->crud_model->change_class_status($type, $message->class_id);
	}

	// $data['type'] = 'class_approval_request';
	// $data['mail_from'] = $this->session->userdata('user_id');
	// $data['mail_to'] = $notification['mail_from'];
	// $data['status'] = 0;
	// $data['date_added'] = time();

	// $details['class_id'] = $message->class_id;
	// $details['message'] = htmlspecialchars($_POST['message']);
	// $data['details'] = json_encode($details);

	// $this->db->insert('website_notification', $data);

	$this->email_model->send_class_approval_mail($notification['mail_from']);

	$this->db->where('notification_id', $notification_id);
	$this->db->delete('website_notification');

	if($type == 'approved'){
		$this->session->set_flashdata('success', get_phrase('this_request_has_been_approved'));
	}else{
		$this->session->set_flashdata('success', get_phrase('this_request_has_been_rejected'));
	}
	redirect(site_url('admin/class_approval_request/'), 'refresh');
}

function class_approval_mail_form($type = "", $notification_id = ""){
	$this->db->where('notification_id', $notification_id);
	$notification = $this->db->get('website_notification')->row_array();
	$page_data['type'] = $type;
	$page_data['notification'] = $notification;
	$this->load->view('backend/admin/class_approval_mail_form', $page_data);
}

function skills($param1 = "", $param2 = ""){
	if($param1 == 'added'){
		$data['skill_title'] = htmlspecialchars($this->input->post('skill_name'));
		$data['slugify'] = slugify($data['skill_title']);
		$this->db->insert('skills', $data);
		$this->session->set_flashdata('success', get_phrase('skill_added_successfully'));
		redirect(site_url('admin/skills'), 'refresh');
	}

	if($param1 == 'updated'){
		$data['skill_title'] = htmlspecialchars($this->input->post('skill_name'));
		$data['slugify'] = slugify($data['skill_title']);
		$this->db->where('skill_id', $param2);
		$this->db->update('skills', $data);
		$this->session->set_flashdata('success', get_phrase('skill_updated_successfully'));
		redirect(site_url('admin/skills'), 'refresh');
	}

	if($param1 == 'delete'){
		$this->db->where('skill_id', $param2);
		$this->db->delete('skill_threades');

		$this->db->where('skill_id', $param2);
		$this->db->delete('skills');

		$this->session->set_flashdata('success', get_phrase('skill_deleted_successfully'));
		redirect(site_url('admin/skills'), 'refresh');
	}

	$page_data['skills'] = $this->crud_model->get_skills();
	$page_data['page_title'] = get_phrase('class_skills');
	$page_data['page_name'] = 'skills';
	$this->load->view('backend/index', $page_data);
}

function skill_add(){
	$this->load->view('backend/admin/skill_add');
}

function skill_edit($skill_id = ""){
	$page_data['skill'] = $this->crud_model->get_skills($skill_id)->row_array();
	$this->load->view('backend/admin/skill_edit', $page_data);
}



////Teacher
	function teachers($param1 = "", $param2 = ""){
	if($param1 == 'added'){
		$response = $this->crud_model->teacher_add();
		if($response == true){
			redirect(site_url('admin/teachers'), 'refresh');
		}else{
			redirect(site_url('admin/teacher_add'), 'refresh');
		}
	}

	if($param1 == 'updated'){
		$response = $this->crud_model->teacher_update($param2);
		if($response == true){
			redirect(site_url('admin/teachers'), 'refresh');
		}else{
			redirect(site_url('admin/teacher_edit/'.$param2), 'refresh');
		}
	}

	if($param1 == 'delete'){
		$this->crud_model->teacher_delete($param2);

		$this->session->set_flashdata('success', get_phrase('all_data_for_this_user_has_been_deleted'));
		redirect(site_url('admin/teachers'), 'refresh');
	}

	$page_data['teachers'] = $this->crud_model->get_teachers();
	$page_data['page_title'] = get_phrase('all_teachers');
	$page_data['page_name'] = 'teachers';
	$this->load->view('backend/index', $page_data);
}

function teacher_status($status = "", $user_id = ""){
	if($status == 'active'){
		$data['status'] = 1;
	}else{
		$data['status'] = 0;
	}
	$this->db->where('user_id', $user_id);
	$this->db->update('user', $data);
	$this->session->set_flashdata('success', get_phrase('user_status_updated_successfully'));
	redirect(site_url('admin/teachers'), 'refresh');
}

function teacher_add(){
	$page_data['page_title'] = get_phrase('add_teacher');
	$page_data['page_name'] = 'teacher_add';
	$this->load->view('backend/index', $page_data);
}

function teacher_edit($user_id = ""){
	$page_data['teacher'] = $this->crud_model->get_teachers($user_id)->row_array();
	$page_data['page_title'] = get_phrase('edit_teacher');
	$page_data['page_name'] = 'teacher_edit';
	$this->load->view('backend/index', $page_data);
}
///End Teacher



////Student
	function students($param1 = "", $param2 = ""){
	if($param1 == 'added'){
		$response = $this->crud_model->student_add();
		if($response == true){
			redirect(site_url('admin/students'), 'refresh');
		}else{
			redirect(site_url('admin/student_add'), 'refresh');
		}
	}

	if($param1 == 'updated'){
		$response = $this->crud_model->student_update($param2);
		if($response == true){
			redirect(site_url('admin/students'), 'refresh');
		}else{
			redirect(site_url('admin/student_edit/'.$param2), 'refresh');
		}
	}

	if($param1 == 'delete'){
		$this->crud_model->student_delete($param2);

		$this->session->set_flashdata('success', get_phrase('all_data_for_this_user_has_been_deleted'));
		redirect(site_url('admin/students'), 'refresh');
	}

	$page_data['students'] = $this->crud_model->get_students();
	$page_data['page_title'] = get_phrase('all_students');
	$page_data['page_name'] = 'students';
	$this->load->view('backend/index', $page_data);
}

function student_status($status = "", $user_id = ""){
	if($status == 'active'){
		$data['status'] = 1;
	}else{
		$data['status'] = 0;
	}
	$this->db->where('user_id', $user_id);
	$this->db->update('user', $data);
	$this->session->set_flashdata('success', get_phrase('user_status_updated_successfully'));
	redirect(site_url('admin/students'), 'refresh');
}

function student_add(){
	$page_data['page_title'] = get_phrase('add_student');
	$page_data['page_name'] = 'student_add';
	$this->load->view('backend/index', $page_data);
}

function student_edit($user_id = ""){
	$page_data['student'] = $this->crud_model->get_students($user_id)->row_array();
	$page_data['page_title'] = get_phrase('edit_student');
	$page_data['page_name'] = 'student_edit';
	$this->load->view('backend/index', $page_data);
}
///End Student


function purchase_history(){
	if(isset($_GET['date_range']) && !empty($_GET['date_range'])){
		$date_range = explode(' - ', $_GET['date_range']);
		$timestamp_start = strtotime($date_range[0]);
		$timestamp_end = strtotime($date_range[1]);
	}else{
		$month = date('m');
		$year = date('y');
		$total_days_of_this_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
		$timestamp_start = strtotime(date('01 M Y'));
		$timestamp_end = strtotime(date($total_days_of_this_month." M Y"));
	}

	$page_data['payments'] = $this->crud_model->get_payments_by_date_range($timestamp_start, $timestamp_end);
	$page_data['timestamp_start'] = $timestamp_start;
	$page_data['timestamp_end'] = $timestamp_end;
	$page_data['page_title'] = get_phrase('purchase_history');
	$page_data['page_name'] = 'purchase_history';
	$this->load->view('backend/index', $page_data);
}

function invoice($payment_id = ""){
	$page_data['payment'] = $this->crud_model->get_payments($payment_id)->row_array();
	$page_data['page_title'] = get_phrase('invoice');
	$page_data['page_name'] = 'invoice';
	$this->load->view('backend/index', $page_data);
}

function packages(){
	$page_data['packages'] = $this->crud_model->get_packages();
	$page_data['page_title'] = get_phrase('packages');
	$page_data['page_name'] = 'packages';
	$this->load->view('backend/index', $page_data);
}

function package_edit($param1 = "", $param2 = ""){
	if($param1 == 'updated'){
		$this->crud_model->package_update($param2);
		redirect(site_url('admin/packages'), 'refresh');
	}
	$page_data['package'] = $this->crud_model->get_packages($param1)->row_array();
	$this->load->view('backend/admin/package_edit', $page_data);
}

function package_status($status = "", $package_id = ""){
	if($status == 'active'){
		$data['status'] = 1;
	}else{
		$data['status'] = 0;
	}
	$this->db->where('package_id', $package_id);
	$this->db->update('package', $data);
	$this->session->set_flashdata('success', get_phrase('package_status_updated_successfully'));
	redirect(site_url('admin/packages'), 'refresh');
}

function system_settings($param1 = ""){
	if($param1 == 'updated'):
		$this->crud_model->system_settings();
		$this->session->set_flashdata('success', get_phrase('system_settings_updated_successfully'));
		redirect(site_url('admin/system_settings'), 'refresh');
	endif;
	$page_data['page_title'] = get_phrase('system_settings');
	$page_data['page_name'] = 'system_settings';
	$this->load->view('backend/index', $page_data);
}

function website_settings($type = "", $param1 = ""){
	if($param1 == 'updated'):
		$this->crud_model->website_settings($type);
		redirect(site_url('admin/website_settings/'.$type), 'refresh');
	endif;

	if($type == "")
		$type = 'basic';

	$page_data['page_title'] = get_phrase('website_settings');
	$page_data['page_name'] = 'website_settings';
	$page_data['type'] = $type;
	$this->load->view('backend/index', $page_data);
}

public function payment_settings($param1 = ""){
    if ($param1 == 'system_currency') {
        $this->crud_model->update_system_currency();
        redirect(site_url('admin/payment_settings'), 'refresh');
    }
    if ($param1 == 'paypal_settings') {
        $this->crud_model->update_paypal_settings();
        redirect(site_url('admin/payment_settings'), 'refresh');
    }
    if ($param1 == 'stripe_settings') {
        $this->crud_model->update_stripe_settings();
        redirect(site_url('admin/payment_settings'), 'refresh');
    }

    $page_data['currencies'] = $this->crud_model->get_currencies();
    $page_data['page_name'] = 'payment_settings';
    $page_data['page_title'] = get_phrase('payment_settings');
    $this->load->view('backend/index', $page_data);
}

public function manage_language($param1 = '', $param2 = '', $param3 = ''){
    if ($param1 == 'add_language') {
        $response = $this->crud_model->add_new_language();
        if($response == 'done'){
        	$this->session->set_flashdata('success', get_phrase('language_added_successfully'));
        }else{
        	$this->session->set_flashdata('error', get_phrase('this_language_allready_exist'));
        }
        redirect(site_url('admin/manage_language'), 'refresh');
    }

    if ($param1 == 'edit_phrase') {
        $page_data['edit_phrase_language'] = $param2;
        $this->db->where('name', strtolower($param2));
		$all_phrases = $this->db->get('language')->result_array();
        $page_data['language_phrases'] = $all_phrases;
    }

    if ($param1 == 'delete_language') {
        $this->crud_model->delete_language($param2);
        $this->session->set_flashdata('success', get_phrase('language_deleted_successfully'));
        redirect(site_url('admin/manage_language'), 'refresh');
    }

    $page_data['page_name'] = 'manage_language';
    $page_data['page_title'] = get_phrase('multi_language_settings');
    $this->load->view('backend/index', $page_data);
}

function update_phrase_with_ajax(){
	$language = strtolower($this->input->post('language'));
	$phrase = strtolower($this->input->post('phrase'));
	$data['translated'] = htmlspecialchars($this->input->post('updated_phrase'));


	$this->db->where('name', $language);
	$this->db->where('phrase', $phrase);
	$this->db->update('language', $data);
}

public function smtp_settings($param1 = ""){
    if ($param1 == 'updated') {
        $this->crud_model->update_smtp_settings();
        $this->session->set_flashdata('success', get_phrase('smtp_settings_updated_successfully'));
        redirect(site_url('admin/smtp_settings'), 'refresh');
    }

    $page_data['page_name'] = 'smtp_settings';
    $page_data['page_title'] = get_phrase('smtp_settings');
    $this->load->view('backend/index', $page_data);
}

public function email_template($param1 = ""){
    if ($param1 == 'updated') {
        $this->crud_model->update_email_template();
        $response['status'] = 'success';
        $response['message'] = get_phrase('email_template_updated_successfully');
    }else{
    	$response['status'] = 'error';
        $response['message'] = get_phrase('enter_valid_url');
    }

    echo json_encode($response);
}


function profile($param1 = ""){
	$user_id = $this->session->userdata('user_id');
	if($param1 == 'updated'){
		$this->crud_model->profile_updated($user_id);
		$this->session->set_flashdata('success', get_phrase('profile_updated_successfully'));
		redirect(site_url('admin/profile'), 'refresh');
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
		redirect(site_url('admin/change_password'), 'refresh');
	}
	$page_data['page_title'] = get_phrase('change_password');
	$page_data['page_name'] = 'change_password';
	$this->load->view('backend/index', $page_data);
}

function about(){
	$page_data['application_details'] = $this->crud_model->get_application_details();
	$page_data['page_title'] = get_phrase('about_this_product');
	$page_data['page_name'] = 'about';
	$this->load->view('backend/index', $page_data);
}
















}