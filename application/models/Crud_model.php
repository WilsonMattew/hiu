<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crud_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	function get_any_tables_data($table = "", $column = "", $value = "", $column2 = "", $value2 = "", $column3 = "", $value3 = ""){
		if($column != ""){
			$this->db->where($column, $value);
		}
		if($column2 != ""){
			$this->db->where($column2, $value2);
		}
		if($column3 != ""){
			$this->db->where($column3, $value3);
		}
		return $this->db->get($table);
	}

	function get_monthly_earn($month = ""){
		$year = date('Y');
		$start_date = strtotime('01-'.$month.'-'.$year);
		$last_day_of_this_month = date('t',$start_date);
		$end_date = strtotime($last_day_of_this_month.'-'.$month.'-'.$year);

		$this->db->select_sum('paid_amount');
		$this->db->where('date_added >=', $start_date);
		$this->db->where('date_added <=', $end_date);
		$total_amount_of_this_month = $this->db->get('payment')->row('paid_amount');
		return floatval($total_amount_of_this_month);
	}

	function popular_classes($limit = 10){
		$query = $this->db
		    ->select("class_id, count(*) AS student_number", false)
		    ->from ("watch_histories")
		    ->group_by("class_id")
		    ->order_by("student_number","DESC")
		    ->limit($limit)
		    ->get();
		return $query->result_array();
	}

	public function get_users($user_id = ""){
		if($user_id > 0){
			$this->db->where('user_id', $user_id);
		}
		return $this->db->get('user');
	}

/*=====================================================> Category start <=====================================================*/
	function get_categories($id = ""){
		if($id > 0){
			$this->db->where('category_id', $id);
		}
		$this->db->order_by('title', 'asc');
		return $this->db->get('category');
	}

	function get_categories_by_title($title = ""){
		$title = slugify($title);
		if(!empty($title)){
			$this->db->where('slugify', $title);
		}
		return $this->db->get('category');
	}

	function get_sub_categories($parent_id = ""){
		if($parent_id > 0){
			$this->db->where('parent_id', $parent_id);
		}
		$this->db->order_by('title', 'asc');
		return $this->db->get('category');
	}

	function get_parent_categories(){
		$this->db->where('parent_id', "");
		$this->db->order_by('title', 'asc');
		return $this->db->get('category');
	}

	


	function add_category(){
		$data['title'] = htmlspecialchars($this->input->post('title'));
		$data['slugify'] = slugify($data['title']);
		$data['icon_class'] = htmlspecialchars($this->input->post('icon_class'));
		if(isset($_POST['parent_id'])){
			$data['parent_id'] = htmlspecialchars($this->input->post('parent_id'));
			$data['category_type'] = 'sub';
		}else{
			$data['parent_id'] = 0;
			$data['category_type'] = 'parent';
		}
		
		$category = $this->get_categories_by_title($data['title']);
		if(!is_numeric($data['slugify']) && $category->num_rows() <= 0 ){
			if(isset($_FILES['thumbnail']['name']) && $_FILES['thumbnail']['name'] != ""){
				$data['thumbnail'] = md5(rand(10000, 99999)).'.jpg';
				move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'uploads/category_thumbnails/'.$data['thumbnail']);
				resizeImage('uploads/category_thumbnails/'.$data['thumbnail'], 'uploads/category_thumbnails/optimized/', 350);
			}else{
				$data['thumbnail'] = "";
			}
			$this->db->insert('category', $data);
			return true;
		}else{
			if(is_numeric($data['slugify'])){
				$this->session->set_flashdata('success', get_phrase('the_category_cannot_be_numeric'));
			}else{
				$this->session->set_flashdata('error', get_phrase('this_category_already_exists'));
			}
		}
	}

	function update_category($category_id = ""){
		$data['icon_class'] = htmlspecialchars($this->input->post('icon_class'));
		$data['title'] = htmlspecialchars($this->input->post('title'));
		$data['slugify'] = slugify($data['title']);
		
		$category = $this->get_categories_by_title($data['title']);
		if($category->num_rows() <= 0 || $category->row('category_id') == $category_id){
			$is_correct = 1;
		}else{
			$is_correct = 0;
		}
		if(!is_numeric($data['slugify']) && $is_correct == 1){
			if(isset($_FILES['thumbnail']['name']) && $_FILES['thumbnail']['name'] != ""){
				$data['thumbnail'] = md5(rand(10000, 99999)).'.jpg';
				move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'uploads/category_thumbnails/'.$data['thumbnail']);
				resizeImage('uploads/category_thumbnails/'.$data['thumbnail'], 'uploads/category_thumbnails/optimized/', 350);

				$thumbnail_name = $this->get_categories($category_id)->row('thumbnail');
				if(is_file('uploads/category_thumbnails/'.$thumbnail_name) && file_exists('uploads/category_thumbnails/'.$thumbnail_name)){
					unlink('uploads/category_thumbnails/'.$thumbnail_name);			
					unlink('uploads/category_thumbnails/optimized/'.$thumbnail_name);
				}
				
			}
			$this->db->where('category_id', $category_id);
			$this->db->update('category', $data);
		}else{
			if(is_numeric($data['slugify'])){
				$this->session->set_flashdata('success', get_phrase('the_category_cannot_be_numeric'));
			}else{
				$this->session->set_flashdata('error', get_phrase('this_category_already_exists'));
			}
		}
	}

	function delete_category($category_id = ""){
		$sub_categories = $this->get_sub_categories($category_id);
		
		if($sub_categories->num_rows() > 0){
			foreach($sub_categories->result_array() as $sub_category){
				$thumbnail_name = $this->get_categories($category_id)->row('thumbnail');
				if(is_file('uploads/category_thumbnails/'.$thumbnail_name) && file_exists('uploads/category_thumbnails/'.$thumbnail_name)){
					unlink('uploads/category_thumbnails/'.$thumbnail_name);
					unlink('uploads/category_thumbnails/optimized/'.$thumbnail_name);
				}
				$this->db->where('category_id', $sub_category['category_id']);
				$this->db->delete('category');
			}
		}
		
		$thumbnail_name = $this->get_categories($category_id)->row('thumbnail');
		if(is_file('uploads/category_thumbnails/'.$thumbnail_name) && file_exists('uploads/category_thumbnails/'.$thumbnail_name)){
			unlink('uploads/category_thumbnails/'.$thumbnail_name);
			unlink('uploads/category_thumbnails/optimized'.$thumbnail_name);
		}
		$this->db->where('category_id', $category_id);
		$this->db->delete('category');
	}
/*=====================================================> Category end <=====================================================*/

	public function get_classes($class_id = ""){
		if($class_id > 0){
			$this->db->where('class_id', $class_id);
		}
		return $this->db->get('classes');
	}

	public function get_classes_by_user_id($user_id = ""){
		if($user_id > 0){
			$this->db->where('user_id', $user_id);
		}
		return $this->db->get('classes');
	}

	function get_class_duration($class_id = ""){
		return $this->db->select_sum('duration')->where('class_id', $class_id)->get('lessons')->row('duration');
	}


	public function get_courses_with_category($column = "", $value = '', $column2 = "", $value2 = ''){
	    if($column != ""){
			$this->db->where($column, $value);
		}
		if($column2 != ""){
			$this->db->where($column2, $value2);
		}

	    $this->db->from('classes');
	    $this->db->join('category', 'category.category_id = classes.category_id');
	    return $this->db->get();
	}

	function get_packages($package_id = ""){
		if($package_id > 0){
			$this->db->where('package_id', $package_id);
		}
		return $this->db->get('package');
	}

	function class_delete($class_id = "", $user_id = ""){
		if($user_id > 0){
			$this->db->where('user_id', $user_id);
		}
		$this->db->where('class_id', $class_id);
		$query = $this->db->get('classes');
		if($query->num_rows() > 0){
			$query = $query->row_array();

			$dir = 'uploads/classes/';
			if(is_file($dir.'thumbnail/'.$query['class_thumbnail']) && file_exists($dir.'thumbnail/'.$query['class_thumbnail'])){
				unlink($dir.'thumbnail/'.$query['class_thumbnail']);
				unlink($dir.'thumbnail/optimized/'.$query['class_thumbnail']);
			}

			if(is_file($dir.'banner/'.$query['banner']) && file_exists($dir.'banner/'.$query['banner'])){
				unlink($dir.'banner/'.$query['banner']);
				unlink($dir.'banner/optimized/'.$query['banner']);
			}

			$this->db->where('class_id', $class_id);
			$this->db->delete('classes');

			$this->db->where('class_id', $class_id);
			$this->db->delete('discussions');

			$this->db->where('class_id', $class_id);
			$this->db->delete('lessons');

			$this->db->where('class_id', $class_id);
			$this->db->delete('projects');

			$this->db->where('class_id', $class_id);
			$this->db->delete('reviews');

			$this->db->where('class_id', $class_id);
			$this->db->delete('skill_threades');

			$this->db->where('class_id', $class_id);
			$this->db->delete('watch_histories');
		}
	}

	function add_class(){
		$data['class_title'] = htmlspecialchars($this->input->post('class_title'));
		if(empty($data['class_title'])){
			$response['status'] = 'error';
			$response['message'] = get_phrase('enter_the_class_title');
			return json_encode($response);
		}

		$data['category_id'] = htmlspecialchars($this->input->post('category'));
		if(empty($data['category_id'])){
			$response['status'] = 'error';
			$response['message'] = get_phrase('please_select_a_category');
			return json_encode($response);
		}

		$data['level'] = htmlspecialchars($this->input->post('level'));
		if(empty($data['level'])){
			$response['status'] = 'error';
			$response['message'] = get_phrase('please_select_a_level');
			return json_encode($response);
		}

		$data['is_free'] = htmlspecialchars($this->input->post('is_free'));
		$data['is_featured'] = htmlspecialchars($this->input->post('is_featured'));
		$data['is_recommended'] = htmlspecialchars($this->input->post('is_recommended'));
		$data['is_slider'] = htmlspecialchars($this->input->post('is_slider'));

		$data['short_description'] = htmlspecialchars($this->input->post('short_description'));
		$data['description'] = htmlspecialchars($this->input->post('long_description'));

		$data['user_id'] = $this->session->userdata('user_id');
		$data['date_added'] = time();

		if($this->session->userdata('user_role') == 'admin'){
			$data['status'] = 'active';
		}else{
			$data['status'] = 'pending';
		}


		$data['class_thumbnail'] = md5(rand(10000, 99999)).'.png';
		$data['banner'] = md5(rand(10000, 99999)).'.png';

		
		$this->db->insert('classes', $data);
		$class_id = $this->db->insert_id();

		$skill_ids = $this->input->post('skills');
		foreach($skill_ids as $skill_id){
			$skill_data['skill_id'] = htmlspecialchars($skill_id);
			$skill_data['class_id'] = $class_id;

			if($this->session->userdata('user_role') == 'admin'){
				$skill_data['is_active_class'] = 1;
			}else{
				$skill_data['is_active_class'] = 0;
			}
			$this->db->insert('skill_threades', $skill_data);
		}

		if(!empty($_FILES['class_thumbnail']['name'])){
			$thumbnail_up_directory = 'uploads/classes/thumbnail/';
			move_uploaded_file($_FILES['class_thumbnail']['tmp_name'], $thumbnail_up_directory.$data['class_thumbnail']);
			resizeImage($thumbnail_up_directory.$data['class_thumbnail'], $thumbnail_up_directory.'optimized/', 520);
		}

		if(!empty($_FILES['banner']['name'])){
			$banner_up_directory = 'uploads/classes/banner/';
			move_uploaded_file($_FILES['banner']['tmp_name'], $banner_up_directory.$data['banner']);
		}

		$this->session->set_flashdata('success', get_phrase('class_added_successfully'));
		$response['status'] = 'success';
		$response['redirect'] = site_url($this->session->userdata('user_role').'/manage_class/'.$class_id);

		return json_encode($response);
	}

	function update_class($class_id = "", $user_id = ""){
		if($user_id > 0){
			$this->db->where('user_id', $user_id);
		}
		$this->db->where('class_id', $class_id);
		$query = $this->db->get('classes');
		if($query->num_rows() > 0)
		{
			$query = $query->row_array();


			$data['class_title'] = htmlspecialchars($this->input->post('class_title'));
			if(empty($data['class_title'])){
				$response['status'] = 'error';
				$response['message'] = get_phrase('enter_the_class_title');
				return json_encode($response);
				die();
			}

			$data['category_id'] = htmlspecialchars($this->input->post('category'));
			if(empty($data['category_id'])){
				$response['status'] = 'error';
				$response['message'] = get_phrase('please_select_a_category');
				return json_encode($response);
				die();
			}

			$data['level'] = htmlspecialchars($this->input->post('level'));
			if(empty($data['level'])){
				$response['status'] = 'error';
				$response['message'] = get_phrase('please_select_a_level');
				return json_encode($response);
				die();
			}

			$data['is_free'] = htmlspecialchars($this->input->post('is_free'));
			$data['is_featured'] = htmlspecialchars($this->input->post('is_featured'));
			$data['is_recommended'] = htmlspecialchars($this->input->post('is_recommended'));
			$data['is_slider'] = htmlspecialchars($this->input->post('is_slider'));

			$data['short_description'] = htmlspecialchars($this->input->post('short_description'));
			$data['description'] = htmlspecialchars($this->input->post('long_description'));

			$data['date_updated'] = time();

			$dir = 'uploads/classes/';
			if(!empty($_FILES['class_thumbnail']['name'])){
				$data['class_thumbnail'] = $class_id.md5(rand(10000, 99999)).'.png';

				$thumbnail_up_directory = 'uploads/classes/thumbnail/';
				move_uploaded_file($_FILES['class_thumbnail']['tmp_name'], $thumbnail_up_directory.$data['class_thumbnail']);
				resizeImage($thumbnail_up_directory.$data['class_thumbnail'], $thumbnail_up_directory.'optimized/', 520);

				if(is_file($dir.'thumbnail/'.$query['class_thumbnail']) && file_exists($dir.'thumbnail/'.$query['class_thumbnail'])){
					unlink($dir.'thumbnail/'.$query['class_thumbnail']);
					unlink($dir.'thumbnail/optimized/'.$query['class_thumbnail']);
				}
			}

			if(!empty($_FILES['banner']['name'])){
				$data['banner'] = $class_id.md5(rand(10000, 99999)).'.png';

				$banner_up_directory = 'uploads/classes/banner/';
				move_uploaded_file($_FILES['banner']['tmp_name'], $banner_up_directory.$data['banner']);

				if(is_file($dir.'banner/'.$query['banner']) && file_exists($dir.'banner/'.$query['banner'])){
					unlink($dir.'banner/'.$query['banner']);
					unlink($dir.'banner/optimized/'.$query['banner']);
				}
			}

			$this->db->where('class_id', $class_id);
			$this->db->update('classes', $data);


			//delecte previous skills
			$this->db->where('class_id', $class_id);
			$this->db->delete('skill_threades');

			//check status of this class for skils 
			if($query['status'] == 'active'){
				$is_active = 1;
			}else{
				$is_active = 0;
			}

			//insert all selected skills
			$skill_ids = $this->input->post('skills');
			foreach($skill_ids as $skill_id){
				$skill_data['skill_id'] = htmlspecialchars($skill_id);
				$skill_data['class_id'] = $class_id;
				$skill_data['is_active_class'] = $is_active;
				$this->db->insert('skill_threades', $skill_data);
			}

			$this->session->set_flashdata('success', get_phrase('class_added_successfully'));
			$response['status'] = 'success';
			$response['message'] = get_phrase('class_updated_successfully');
		}else{
			$response['status'] = 'error';
			$response['message'] = get_phrase('no_access');
		}
		return json_encode($response);
	}

	function get_lessons_by_class_id($class_id = ""){
		$this->db->order_by('sort', 'asc');
		$this->db->where('class_id', $class_id);
		return $this->db->get('lessons');
	}

	function get_lessons($lesson_id = ""){
		if($lesson_id != ""){
			$this->db->where('lesson_id', $lesson_id);
		}
		return $this->db->get('lessons');
	}

	function lesson_add($class_id = "", $user_id = ""){
		$data['user_id'] = $user_id;
		$data['class_id'] = $class_id;
		$data['lesson_title'] = htmlspecialchars($this->input->post('lesson_title'));
		$data['lesson_type'] = htmlspecialchars($this->input->post('lesson_type'));
		$data['is_free'] = htmlspecialchars($this->input->post('is_free_lesson'));
		$data['lesson_status'] = 1;

		if($data['lesson_type'] == 'video_file'){
			$path = $_FILES['video_file']['name'];
			if($path){
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$video_file = md5(rand(10000, 99999)).'.'.$ext;
				$data['lesson_src'] = base_url('uploads/classes/videos/'.$video_file);
				move_uploaded_file($_FILES['video_file']['tmp_name'], 'uploads/classes/videos/'.$video_file);
			}
		}else{
			$data['lesson_src'] = htmlspecialchars($this->input->post('video_url'));
		}

		$duration_arr = explode(':', $this->input->post('duration'));
		$minutes = $duration_arr[0] * 60;
		$seconds = ($minutes * 60) + ($duration_arr[1] * 60) + ($duration_arr[2]);
		$data['duration'] = $seconds;
		$data['date_added'] = time();


		$total_class_duration = $this->get_classes($class_id)->row('total_duration');
		$total_duration = $total_class_duration + $seconds;
		$this->db->where('class_id', $class_id);
		$this->db->update('classes', array('total_duration' => $total_duration));


		$this->db->insert('lessons', $data);

		$response['status'] = 'success';
		$response['message'] = get_phrase('lesson_uploaded_successfully');

		return json_encode($response);
	}

	function lesson_update($lesson_id = "", $class_id = ""){
		$data['lesson_title'] = htmlspecialchars($this->input->post('lesson_title'));
		$data['lesson_type'] = htmlspecialchars($this->input->post('lesson_type'));
		$data['is_free'] = htmlspecialchars($this->input->post('is_free_lesson'));

		if($data['lesson_type'] == 'video_file'){
			$path = $_FILES['video_file']['name'];
			if($path){
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$video_file = md5(rand(10000, 99999)).'.'.$ext;
				$data['lesson_src'] = base_url('uploads/classes/videos/'.$video_file);
				move_uploaded_file($_FILES['video_file']['tmp_name'], 'uploads/classes/videos/'.$video_file);
			}
		}else{
			$data['lesson_src'] = htmlspecialchars($this->input->post('video_url'));
		}

		//delete previous file
		$lesson_row = $this->get_lessons($lesson_id)->row_array();
		if($lesson_row['lesson_type'] == 'video_file'){
			$src = explode(base_url(), $lesson_row['lesson_src']);
			if(is_file($src[1]) && file_exists($src[1])){
				unlink($src[1]);
			}
		}

		$duration_arr = explode(':', $this->input->post('duration'));
		$minutes = $duration_arr[0] * 60;
		$seconds = ($minutes * 60) + ($duration_arr[1] * 60) + ($duration_arr[2]);
		$data['duration'] = $seconds;
		$data['date_updated'] = time();



		$total_class_duration = $this->get_classes($class_id)->row('total_duration');
		$total_duration = $total_class_duration + $seconds;
		$previous_duration = $this->get_lessons($lesson_id)->row('duration');
		$total_duration = $total_duration - $previous_duration;
		$this->db->where('class_id', $class_id);
		$this->db->update('classes', array('total_duration' => $total_duration));


		$this->db->where('lesson_id', $lesson_id);
		$this->db->update('lessons', $data);


		$response['status'] = 'success';
		$response['message'] = get_phrase('lesson_uploaded_successfully');

		return json_encode($response);
	}

	function lesson_delete($class_id = "", $lesson_id = ""){
		$class = $this->crud_model->get_classes($class_id)->row_array();
		$lesson = $this->crud_model->get_lessons($lesson_id)->row_array();

		$updated_duration = $class['total_duration'] - $lesson['duration'];
		$this->db->where('class_id', $class_id);
		$this->db->update('classes', array('total_duration' => $updated_duration));

		$src = explode(base_url(), $lesson['lesson_src']);
		if($lesson['lesson_type'] == 'video_file' && is_file($src[1]) && file_exists($src[1])){
			unlink($src[1]);
		}

		$this->db->where('lesson_id', $lesson_id);
		$this->db->where('class_id', $class_id);
		$this->db->delete('lessons');
	}

	function sort_lesson($class_id = "", $lesson_id = "", $new_sort_position = ""){
		$current_sort_position = $this->db->get_where('lessons', array('lesson_id' => $lesson_id))->row('sort');

		$this->db->where('sort', $new_sort_position);
		$this->db->where('class_id', $class_id);
		$this->db->update('lessons', array('sort' => $current_sort_position));

		$this->db->where('lesson_id', $lesson_id);
		$this->db->update('lessons', array('sort' => $new_sort_position));

		$response['status'] = 'success';
		$response['message'] = get_phrase('item_sorted_successfully');
		return json_encode($response);
	}



	function get_notification_by_type($type = "", $mail_to = "", $status = "", $limit = 10, $offset = 0){
		if($status != ""){
			$this->db->where('status', $status);
		}
		$this->db->where('type', $type);
		$this->db->where('mail_to', $mail_to);
		$this->db->limit($limit, $offset);
		return $this->db->get('website_notification');
	}

	function notification_mark_as_read($type = "", $mail_receiver = "", $notification_id = ""){
		if($type != "")
			$this->db->where('type', $type);

		if($mail_receiver != "")
			$this->db->where('mail_to', $mail_receiver);

		if($notification_id != "")
			$this->db->where('notification_id', $notification_id);

		$this->db->update('website_notification', array('status' => 1));
	}

	function change_class_status($type = "", $class_id){
		if($type == 'approved'){
			$data['status'] = 'active';

			$this->db->where('class_id', $class_id);
			$this->db->update('classes', $data);

			$this->db->where('class_id', $class_id);
			$this->db->update('skill_threades', array('is_active_class' => 1));
		}
	}




/*=====================================================> Skills start*/
	function get_skills($skill_id = ""){
		if($skill_id > 0){
			$this->db->where('skill_id', $skill_id);
		}
		return $this->db->get('skills');
	}

	function get_selected_skills($skill_id = "", $class_id = ""){
		$this->db->where('skill_id', $skill_id);
		$this->db->where('class_id', $class_id);
		return $this->db->get('skill_threades');
	}

/*=====================================================> Skills end*/


/*=====================================================> Teacher start*/
	function get_teachers($user_id = ""){
		if($user_id > 0){
			$this->db->where('user_id', $user_id);
		}
		$this->db->where('role', 'teacher');
		return $this->db->get('user');
	}

	function teacher_add(){
		$data['first_name'] = htmlspecialchars($this->input->post('first_name'));
		if(empty($data['first_name'])){
			$this->session->set_flashdata('error', get_phrase("first_name_can_not_be_empty"));
			return false;
		}

		$data['last_name'] = htmlspecialchars($this->input->post('last_name'));
		$data['surname'] = htmlspecialchars($this->input->post('surname'));

		$data['email'] = htmlspecialchars($this->input->post('email'));
		if(empty($data['email']) ){
			$this->session->set_flashdata('error', get_phrase("email_can_not_be_empty"));
			return false;
		}
		if(exist_email($data['email'])){
			$this->session->set_flashdata('error', get_phrase("this_email_already_exists").'. '.get_phrase("please_use_different_email"));
			return false;
		}

		$data['password'] = sha1($this->input->post('password'));
		if(empty($this->input->post('password'))){
			$this->session->set_flashdata('error', get_phrase("pssword_can_not_be_empty"));
			return false;
		}

		$data['phone'] = htmlspecialchars($this->input->post('phone'));
		$data['address'] = htmlspecialchars($this->input->post('address'));
		$data['about'] = htmlspecialchars($this->input->post('about'));

		$social['facebook'] = htmlspecialchars($this->input->post('facebook'));
		$social['twitter'] = htmlspecialchars($this->input->post('twitter'));
		$social['linkedin'] = htmlspecialchars($this->input->post('linkedin'));
		$social['website'] = htmlspecialchars($this->input->post('website'));

		$data['social'] = json_encode($social);

		$data['role'] = 'teacher';
		$data['photo'] = md5(rand(10000, 99999)).'.png';
		$data['date_added'] = time();
		$data['is_verified'] = 1;
		$data['status'] = 1;

		$this->db->insert('user', $data);

		if($_POST['account_access'] == 1){
			$this->email_model->send_account_access($data['email'], $this->input->post('password'));
		}

		if($_FILES['photo']['name']){
			move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/user_images/'.$data['photo']);
			resizeImage('uploads/user_images/'.$data['photo'], 'uploads/user_images/optimized/'.$data['photo'], 120);
		}

		$this->session->set_flashdata('success', get_phrase("user_added_successfully"));
		return true;
	}

	function teacher_update($user_id = ""){
		$data['first_name'] = htmlspecialchars($this->input->post('first_name'));
		if(empty($data['first_name'])){
			$this->session->set_flashdata('error', get_phrase("first_name_can_not_be_empty"));
			return false;
		}

		$data['last_name'] = htmlspecialchars($this->input->post('last_name'));
		$data['surname'] = htmlspecialchars($this->input->post('surname'));
		$data['phone'] = htmlspecialchars($this->input->post('phone'));
		$data['address'] = htmlspecialchars($this->input->post('address'));
		$data['about'] = htmlspecialchars($this->input->post('about'));

		$social['facebook'] = htmlspecialchars($this->input->post('facebook'));
		$social['twitter'] = htmlspecialchars($this->input->post('twitter'));
		$social['linkedin'] = htmlspecialchars($this->input->post('linkedin'));
		$social['website'] = htmlspecialchars($this->input->post('website'));

		$data['social'] = json_encode($social);

		if($_FILES['photo']['name']){
			$data['photo'] = md5(rand(10000, 99999)).'.png';
			move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/user_images/'.$data['photo']);
			resizeImage('uploads/user_images/'.$data['photo'], 'uploads/user_images/optimized/'.$data['photo'], 120);

			$previous_img = $this->get_users($user_id)->row('photo');
			if(is_file('uploads/user_images/'.$previous_img) && file_exists('uploads/user_images/'.$previous_img)){
				unlink('uploads/user_images/'.$previous_img);
				unlink('uploads/user_images/optimized/'.$previous_img);
			}
		}

		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);

		$this->session->set_flashdata('success', get_phrase("user_updated_successfully"));
		return true;
	}

	function teacher_delete($user_id = ""){
		$img = $this->get_users($user_id)->row('photo');
		if(is_file('uploads/user_images/'.$img) && file_exists('uploads/user_images/'.$img)){
			unlink('uploads/user_images/'.$img);
			unlink('uploads/user_images/optimized/'.$img);
		}

		$this->db->where('user_id', $user_id);
		$this->db->delete('watch_histories');

		$this->db->where('user_id', $user_id);
		$this->db->delete('reviews');

		$this->db->where('user_id', $user_id);
		$this->db->delete('projects');

		$this->db->where('user_id', $user_id);
		$this->db->delete('payment');

		$this->db->where('user_id', $user_id);
		$this->db->delete('lessons');

		$this->db->where('user_id', $user_id);
		$this->db->delete('bookmark');

		$this->db->where('user_id', $user_id);
		$this->db->or_where('follower_user_id', $user_id);
		$this->db->delete('followers');

		$this->db->where('user_id', $user_id);
		$this->db->from('classes');
	    $this->db->join('skill_threades', 'skill_threades.class_id = classes.class_id');
	    $this->db->join('reviews', 'reviews.class_id = classes.class_id');
	    $this->db->join('projects', 'projects.class_id = classes.class_id');
	    $this->db->join('discussions', 'discussions.class_id = classes.class_id');
	    $this->db->join('bookmark', 'bookmark.class_id = classes.class_id');
	    $this->db->delete();


		$this->db->where('user_id', $user_id);
		$this->db->delete('user');
	}
/*=====================================================> Teacher end*/




/*=====================================================> Student start*/
	function get_students($user_id = ""){
		if($user_id > 0){
			$this->db->where('user_id', $user_id);
		}
		$this->db->where('role', 'student');
		return $this->db->get('user');
	}

	function student_add(){
		$data['first_name'] = htmlspecialchars($this->input->post('first_name'));
		if(empty($data['first_name'])){
			$this->session->set_flashdata('error', get_phrase("first_name_can_not_be_empty"));
			return false;
		}

		$data['last_name'] = htmlspecialchars($this->input->post('last_name'));
		$data['surname'] = htmlspecialchars($this->input->post('surname'));

		$data['email'] = htmlspecialchars($this->input->post('email'));
		if(empty($data['email']) ){
			$this->session->set_flashdata('error', get_phrase("email_can_not_be_empty"));
			return false;
		}
		if(exist_email($data['email'])){
			$this->session->set_flashdata('error', get_phrase("this_email_already_exists").'. '.get_phrase("please_use_different_email"));
			return false;
		}

		$data['password'] = sha1($this->input->post('password'));
		if(empty($this->input->post('password'))){
			$this->session->set_flashdata('error', get_phrase("pssword_can_not_be_empty"));
			return false;
		}

		$data['phone'] = htmlspecialchars($this->input->post('phone'));
		$data['address'] = htmlspecialchars($this->input->post('address'));
		$data['about'] = htmlspecialchars($this->input->post('about'));

		$social['facebook'] = htmlspecialchars($this->input->post('facebook'));
		$social['twitter'] = htmlspecialchars($this->input->post('twitter'));
		$social['linkedin'] = htmlspecialchars($this->input->post('linkedin'));
		$social['website'] = htmlspecialchars($this->input->post('website'));

		$data['social'] = json_encode($social);

		$data['role'] = 'student';
		$data['photo'] = md5(rand(10000, 99999)).'.png';
		$data['date_added'] = time();
		$data['is_verified'] = 1;
		$data['status'] = 1;

		$this->db->insert('user', $data);

		if($_POST['account_access'] == 1){
			$this->email_model->send_account_access($data['email'], $this->input->post('password'));
		}

		if($_FILES['photo']['name']){
			move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/user_images/'.$data['photo']);
			resizeImage('uploads/user_images/'.$data['photo'], 'uploads/user_images/optimized/'.$data['photo'], 120);
		}

		$this->session->set_flashdata('success', get_phrase("user_added_successfully"));
		return true;
	}

	function student_update($user_id = ""){
		$data['first_name'] = htmlspecialchars($this->input->post('first_name'));
		if(empty($data['first_name'])){
			$this->session->set_flashdata('error', get_phrase("first_name_can_not_be_empty"));
			return false;
		}

		$data['last_name'] = htmlspecialchars($this->input->post('last_name'));
		$data['surname'] = htmlspecialchars($this->input->post('surname'));
		$data['phone'] = htmlspecialchars($this->input->post('phone'));
		$data['address'] = htmlspecialchars($this->input->post('address'));
		$data['about'] = htmlspecialchars($this->input->post('about'));

		$social['facebook'] = htmlspecialchars($this->input->post('facebook'));
		$social['twitter'] = htmlspecialchars($this->input->post('twitter'));
		$social['linkedin'] = htmlspecialchars($this->input->post('linkedin'));
		$social['website'] = htmlspecialchars($this->input->post('website'));

		$data['social'] = json_encode($social);

		if($_FILES['photo']['name']){
			$data['photo'] = md5(rand(10000, 99999)).'.png';
			move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/user_images/'.$data['photo']);
			resizeImage('uploads/user_images/'.$data['photo'], 'uploads/user_images/optimized/'.$data['photo'], 120);

			$previous_img = $this->get_users($user_id)->row('photo');
			if(is_file('uploads/user_images/'.$previous_img) && file_exists('uploads/user_images/'.$previous_img)){
				unlink('uploads/user_images/'.$previous_img);
				unlink('uploads/user_images/optimized/'.$previous_img);
			}
		}

		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);

		$this->session->set_flashdata('success', get_phrase("user_updated_successfully"));
		return true;
	}

	function student_delete($user_id = ""){
		$img = $this->get_users($user_id)->row('photo');
		if(is_file('uploads/user_images/'.$img) && file_exists('uploads/user_images/'.$img)){
			unlink('uploads/user_images/'.$img);
			unlink('uploads/user_images/optimized/'.$img);
		}


		$this->db->where('user_id', $user_id);
		$this->db->delete('watch_histories');

		$this->db->where('user_id', $user_id);
		$this->db->delete('reviews');

		$this->db->where('user_id', $user_id);
		$this->db->delete('projects');

		$this->db->where('user_id', $user_id);
		$this->db->delete('payment');

		$this->db->where('user_id', $user_id);
		$this->db->delete('bookmark');

		$this->db->where('user_id', $user_id);
		$this->db->or_where('follower_user_id', $user_id);
		$this->db->delete('followers');

		$this->db->where('user_id', $user_id);
		$this->db->delete('user');
	}
/*=====================================================> Student end*/




	function get_payments($payment_id = ""){
		if($payment_id > 0){
			$this->db->where('payment_id', $payment_id);
		}
		return $this->db->get('payment');
	}

	function get_payments_by_date_range($start = "", $end = ""){
		$this->db->where('date_added >=', $start);
		$this->db->where('date_added <=', $end);
		return $this->db->get('payment');
	}

	function check_google_client(){
		$name = $this->input->post('name');
		$uId = $this->input->post('uId');
		$uEmail = $this->input->post('uEmail');
		$uImage = $this->input->post('uImage');

		if(isset($name) && !empty($name) && isset($uId) && !empty($uId) && isset($uEmail) && !empty($uEmail) && isset($uImage) && !empty($uImage)){
			if(filter_var($uImage, FILTER_VALIDATE_URL)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function package_update($package_id = ""){
		$data['price'] = htmlspecialchars($this->input->post('price'));
		

		if(isset($_POST['price']) && !empty($_POST['price']) && is_numeric($data['price'])){
			if(isset($_POST['days']) && !empty($_POST['days']) && is_numeric($_POST['days'])){

				$data['days'] = htmlspecialchars($this->input->post('days'));

			}

			$this->db->where('package_id', $package_id);
			$this->db->update('package', $data);
			$this->session->set_flashdata('success', get_phrase('package_updated_successfully'));
		}else{
			$this->session->set_flashdata('error', get_phrase('please_enter_a_numeric_value_in_the_price_field'));
		}
	}

	function system_settings(){
		$data['description'] = htmlspecialchars($_POST['system_title']);
		$this->db->where('type', 'system_title');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['system_name']);
		$this->db->where('type', 'system_name');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['slogan']);
		$this->db->where('type', 'slogan');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['meta_keywords']);
		$this->db->where('type', 'meta_keywords');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['meta_description']);
		$this->db->where('type', 'meta_description');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['system_email']);
		$this->db->where('type', 'system_email');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['address']);
		$this->db->where('type', 'address');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['phone']);
		$this->db->where('type', 'phone');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['timezone']);
		$this->db->where('type', 'timezone');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['language']);
		$this->db->where('type', 'language');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['purchase_code']);
		$this->db->where('type', 'purchase_code');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['footer_text']);
		$this->db->where('type', 'footer_text');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['footer_link']);
		$this->db->where('type', 'footer_link');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['email_verification']);
		$this->db->where('type', 'email_verification');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['youtube_api_key']);
		$this->db->where('type', 'youtube_api_key');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['vimeo_api_key']);
		$this->db->where('type', 'vimeo_api_key');
		$this->db->update('settings', $data);

		$data['description'] = htmlspecialchars($_POST['free_subscription_days']);
		$this->db->where('type', 'free_subscription_days');
		$this->db->update('settings', $data);
	}


	function website_settings($type = ""){
		if($type == 'basic'){
			$data['description'] = htmlspecialchars($_POST['top_notification_status']);
			$this->db->where('type', 'top_notification_status');
			$this->db->update('frontend_settings', $data);

			$data['description'] = htmlspecialchars($_POST['top_notification']);
			$this->db->where('type', 'top_notification');
			$this->db->update('frontend_settings', $data);

			$data['description'] = htmlspecialchars($_POST['about_us']);
			$this->db->where('type', 'about_us');
			$this->db->update('frontend_settings', $data);

			$data['description'] = htmlspecialchars($_POST['privacy_policy']);
			$this->db->where('type', 'privacy_policy');
			$this->db->update('frontend_settings', $data);

			$data['description'] = htmlspecialchars($_POST['terms_and_condition']);
			$this->db->where('type', 'terms_and_condition');
			$this->db->update('frontend_settings', $data);

			$data['description'] = htmlspecialchars($_POST['faq']);
			$this->db->where('type', 'faq');
			$this->db->update('frontend_settings', $data);

			$this->session->set_flashdata('success', get_phrase('basic_information_updated_successfully'));		
		}elseif($type == 'website_logo'){

			if($_FILES['light_logo']['name']){
				$data['description'] = md5(rand(10000, 99999)).'.png';

				move_uploaded_file($_FILES['light_logo']['tmp_name'], 'uploads/system_images/logo/'.$data['description']);
				unlink('uploads/system_images/logo/'.get_frontend_settings('light_logo'));

				$this->db->where('type', 'light_logo');
				$this->db->update('frontend_settings', $data);
			}
			
			if($_FILES['dark_logo']['name']){
				$data['description'] = md5(rand(10000, 99999)).'.png';

				move_uploaded_file($_FILES['dark_logo']['tmp_name'], 'uploads/system_images/logo/'.$data['description']);
				unlink('uploads/system_images/logo/'.get_frontend_settings('dark_logo'));

				$this->db->where('type', 'dark_logo');
				$this->db->update('frontend_settings', $data);
			}

			if($_FILES['favicon']['name']){
				$data['description'] = md5(rand(10000, 99999)).'.png';

				move_uploaded_file($_FILES['favicon']['tmp_name'], 'uploads/system_images/logo/'.$data['description']);
				unlink('uploads/system_images/logo/'.get_frontend_settings('favicon'));

				$this->db->where('type', 'favicon');
				$this->db->update('frontend_settings', $data);
			}
			$this->session->set_flashdata('success', get_phrase('website_logo_updated_successfully'));
		}elseif($type == 'home_page_blogs'){
			$data_arr = array();
			foreach($_POST['title'] as $key => $title){
				$data['title'] = htmlspecialchars($_POST['title'][$key]);
				$data['description'] = htmlspecialchars($_POST['description'][$key]);
				if($_FILES['image']['name'][$key]){
					$data['image'] = md5(rand(100000, 999999)).'.png';
					move_uploaded_file($_FILES['image']['tmp_name'][$key], 'uploads/home_page_images/'.$data['image']);

					unlink('uploads/home_page_images/'.$_POST['previous_image'][$key]);
				}else{
					$data['image'] = htmlspecialchars($_POST['previous_image'][$key]);
				}

				array_push($data_arr, $data);
			}

			$data_json['description'] = json_encode($data_arr);
			$this->db->where('type', 'home_page_blogs');
			$this->db->update('frontend_settings', $data_json);
		}
	}

	public function update_smtp_settings(){
    	$data['description'] = htmlspecialchars($this->input->post('smtp_protocol'));
        $this->db->where('type', 'protocol');
        $this->db->update('settings', $data);

        $data['description'] = htmlspecialchars($this->input->post('smtp_host'));
        $this->db->where('type', 'smtp_host');
        $this->db->update('settings', $data);

        $data['description'] = htmlspecialchars($this->input->post('smtp_port'));
        $this->db->where('type', 'smtp_port');
        $this->db->update('settings', $data);

        $data['description'] = htmlspecialchars($this->input->post('smtp_user'));
        $this->db->where('type', 'smtp_user');
        $this->db->update('settings', $data);

        $data['description'] = htmlspecialchars($this->input->post('smtp_pass'));
        $this->db->where('type', 'smtp_pass');
        $this->db->update('settings', $data);
    }

    public function update_email_template(){
    	$data['description'] = remove_js($this->input->post('email_verification_mail'));
        $this->db->where('type', 'email_verification_mail');
        $this->db->update('settings', $data);

        $data['description'] = remove_js($this->input->post('forgot_password_mail'));
        $this->db->where('type', 'forgot_password_mail');
        $this->db->update('settings', $data);

        $data['description'] = remove_js($this->input->post('account_access_mail'));
        $this->db->where('type', 'account_access_mail');
        $this->db->update('settings', $data);
    }


    function profile_updated($user_id = ""){
		$data['first_name'] = htmlspecialchars($this->input->post('first_name'));
		$data['last_name'] = htmlspecialchars($this->input->post('last_name'));
		$data['surname'] = htmlspecialchars($this->input->post('surname'));
		$data['phone'] = htmlspecialchars($this->input->post('phone'));
		$data['address'] = htmlspecialchars($this->input->post('address'));
		$data['about'] = htmlspecialchars($this->input->post('about'));

		$social['facebook'] = htmlspecialchars($this->input->post('facebook'));
		$social['twitter'] = htmlspecialchars($this->input->post('twitter'));
		$social['linkedin'] = htmlspecialchars($this->input->post('linkedin'));
		$social['website'] = htmlspecialchars($this->input->post('website'));
		
		$data['social'] = json_encode($social);

		if(isset($_FILES['user_image']['name']) && $_FILES['user_image']['name'] != ""){
			$data['photo'] = md5(rand(10000, 99999)).'.jpg';
			move_uploaded_file($_FILES['user_image']['tmp_name'], 'uploads/user_images/'.$data['photo']);
			resizeImage('uploads/user_images/'.$data['photo'], 'uploads/user_images/optimized/', 120);

			$this->db->where('user_id', $user_id);
			$previous_img= $this->db->get('user')->row('photo');
			if(is_file('uploads/user_images/'.$previous_img) && file_exists('uploads/user_images/'.$previous_img)){
				unlink('uploads/user_images/'.$previous_img);
				unlink('uploads/user_images/optimized/'.$previous_img);
			}
		}

		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);
	}

	function change_password($user_id = ""){
		$current_password = sha1($this->input->post('current_password'));
		$new_password = $this->input->post('new_password');
		$confirm_password = $this->input->post('confirm_password');

		$this->db->where('user_id', $user_id);
		$this->db->where('password', $current_password);
		$query = $this->db->get('user');
		if($query->num_rows() > 0){
			if($new_password == $confirm_password){

				$data['password'] = sha1($new_password);
				$this->db->where('user_id', $user_id);
				$this->db->update('user', $data);

				$this->session->set_flashdata('success', get_phrase('password_has_been_changed'));
			}else{
				$this->session->set_flashdata('error', get_phrase('confirm_password_mismatched'));
			}
		}else{
			$this->session->set_flashdata('error', get_phrase('current_password_mismatched'));
		}
	}


	public function update_paypal_settings(){
        // update paypal keys
        $paypal_info = array();
        $paypal['active'] = $this->input->post('paypal_active');
        $paypal['mode'] = $this->input->post('paypal_mode');
        $paypal['sandbox_client_id'] = $this->input->post('sandbox_client_id');
        $paypal['sandbox_secret_key'] = $this->input->post('sandbox_secret_key');
        $paypal['production_client_id'] = $this->input->post('production_client_id');
        $paypal['production_secret_key'] = $this->input->post('production_secret_key');

        array_push($paypal_info, $paypal);

        $data['description']    =   json_encode($paypal_info);
        $this->db->where('type', 'paypal_keys');
        $this->db->update('settings', $data);

        $data['description'] = html_escape($this->input->post('paypal_currency'));
        $this->db->where('type', 'paypal_currency');
        $this->db->update('settings', $data);
    }

	public function update_stripe_settings(){
        // update stripe keys
        $stripe_info = array();

        $stripe['active'] = $this->input->post('stripe_active');
        $stripe['testmode'] = $this->input->post('testmode');
        $stripe['public_key'] = $this->input->post('public_key');
        $stripe['secret_key'] = $this->input->post('secret_key');
        $stripe['public_live_key'] = $this->input->post('public_live_key');
        $stripe['secret_live_key'] = $this->input->post('secret_live_key');

        array_push($stripe_info, $stripe);

        $data['description']    =   json_encode($stripe_info);
        $this->db->where('type', 'stripe_keys');
        $this->db->update('settings', $data);

        $data['description'] = htmlspecialchars($this->input->post('stripe_currency'));
        $this->db->where('type', 'stripe_currency');
        $this->db->update('settings', $data);
    }

    public function update_system_currency(){
        $data['description'] = htmlspecialchars($this->input->post('system_currency'));
        $this->db->where('type', 'system_currency');
        $this->db->update('settings', $data);

        $data['description'] = htmlspecialchars($this->input->post('currency_position'));
        $this->db->where('type', 'currency_position');
        $this->db->update('settings', $data);
    }

	function get_currencies(){
		return $this->db->get('currency')->result_array();
	}


	function add_new_language(){
		$new_language = strtolower(htmlspecialchars($this->input->post('language')));
		$already_exist = $this->db->get_where('language', array('name' => $new_language))->num_rows();
		if($already_exist <= 0){
			$this->db->where('name', get_settings('language'));
			$all_phrases = $this->db->get('language')->result_array();
			foreach($all_phrases as $phrase){
				$data['name'] = $new_language;
				$data['phrase'] = $phrase['phrase'];
				$data['translated'] = str_replace('_', ' ', $phrase['phrase']);
				$this->db->insert('language', $data);
			}
			return 'done';
		}else{
			return 'exist';
		}
	}

	function delete_language($language = ""){
		$this->db->where('name', $language);
		$this->db->delete('language');
	}


	function get_application_details()
    {
        $purchase_code = get_settings('purchase_code');
        $returnable_array = array(
            'purchase_code_status' => get_phrase('not_found'),
            'support_expiry_date'  => get_phrase('not_found'),
            'customer_name'        => get_phrase('not_found')
        );

        $personal_token = "gC0J1ZpY53kRpynNe4g2rWT5s4MW56Zg";
        $url = "https://api.envato.com/v3/market/author/sale?code=" . $purchase_code;
        $curl = curl_init($url);

        //setting the header for the rest of the api
        $bearer   = 'bearer ' . $personal_token;
        $header   = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
        $header[] = 'Authorization: ' . $bearer;

        $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:' . $purchase_code . '.json';
        $ch_verify = curl_init($verify_url . '?code=' . $purchase_code);

        curl_setopt($ch_verify, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch_verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch_verify, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_verify, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $cinit_verify_data = curl_exec($ch_verify);
        curl_close($ch_verify);

        $response = json_decode($cinit_verify_data, true);

        if (count($response['verify-purchase']) > 0) {

            //print_r($response);
            $item_name         = $response['verify-purchase']['item_name'];
            $purchase_time       = $response['verify-purchase']['created_at'];
            $customer         = $response['verify-purchase']['buyer'];
            $licence_type       = $response['verify-purchase']['licence'];
            $support_until      = $response['verify-purchase']['supported_until'];
            $customer         = $response['verify-purchase']['buyer'];

            $purchase_date      = date("d M, Y", strtotime($purchase_time));

            $todays_timestamp     = strtotime(date("d M, Y"));
            $support_expiry_timestamp = strtotime($support_until);

            $support_expiry_date  = date("d M, Y", $support_expiry_timestamp);

            if ($todays_timestamp > $support_expiry_timestamp)
                $support_status    = get_phrase('expired');
            else
                $support_status    = get_phrase('valid');

            $returnable_array = array(
                'purchase_code_status' => $support_status,
                'support_expiry_date'  => $support_expiry_date,
                'customer_name'        => $customer
            );
        } else {
            $returnable_array = array(
                'purchase_code_status' => 'invalid',
                'support_expiry_date'  => 'invalid',
                'customer_name'        => 'invalid'
            );
        }

        return $returnable_array;
    }











}
