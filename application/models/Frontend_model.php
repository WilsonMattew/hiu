<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	function get_slider_classes(){
		$this->db->where('status', 'active');
		$this->db->where('is_slider', 1);
		$this->db->order_by('class_id', 'desc');
		$this->db->limit(10);
		return $this->db->get('classes');
	}

	function get_featured_classes(){
		$this->db->where('status', 'active');
		$this->db->where('is_featured', 1);
		$this->db->order_by('class_id', 'desc');
		$this->db->limit(20);

		$this->db->from('classes');
	    $this->db->join('category', 'category.category_id = classes.category_id');
	    return $this->db->get();
	}

	function get_recommended_classes(){
		$this->db->where('status', 'active');
		$this->db->where('is_recommended', 1);
		$this->db->order_by('class_id', 'desc');
		$this->db->limit(20);
		
		$this->db->from('classes');
	    $this->db->join('category', 'category.category_id = classes.category_id');
	    return $this->db->get();
	}

	function get_classes($param1 = "", $limit = "", $offset = ""){
		if(isset($_GET['search']) && $_GET['search'] != ""){
			$this->db->like('class_title', $_GET['search']);
			$this->db->or_like('short_description', $_GET['search']);
			$this->db->or_like('description', $_GET['search']);
			$this->db->or_like('level', $_GET['search']);
		}

		if(isset($_GET['recommended']) && $_GET['recommended'] != ""){
			$this->db->where('is_recommended', 1);
		}

		if(isset($_GET['featured']) && $_GET['featured'] != ""){
			$this->db->where('is_featured', 1);
		}

		//If exitst numeric data, then this parameter for pagination or category title
		if($param1 != "" && !is_numeric($param1)){
			$category_id = $this->db->get_where('category', array('slugify' => $param1))->row('category_id');
			$this->db->where('category_id', $category_id);
		}
		//For filter
			if(isset($_GET['pricing']) && $_GET['pricing'] == 'free'){
				$this->db->where('is_free', 1);
			}elseif(isset($_GET['pricing']) && $_GET['pricing'] == 'premium'){
				$this->db->where('is_free !=', 1);
			}

			if(isset($_GET['duration_range']) && $_GET['duration_range'] == 'less30'){
				$count_seconds = 30*60;
				$this->db->where('total_duration <=', $count_seconds);
			}elseif(isset($_GET['duration_range']) && $_GET['duration_range'] == '31to60'){
				$first_range = 31*60;
				$second_range = 60*60;
				$this->db->where('total_duration >=', $first_range);
				$this->db->where('total_duration <=', $second_range);
			}elseif(isset($_GET['duration_range']) && $_GET['duration_range'] == 'greater60'){
				$count_seconds = 60*60;
				$this->db->where('total_duration >', $count_seconds);
			}
		//End filter

		if($limit != "" || $offset != ""){
			$this->db->limit($limit, $offset);
		}

		$this->db->where('status', 'active');
		return $this->db->get('classes');
	}

	function get_classes_with_skills($skill_slug = "", $limit = "", $offset = ""){
		$skill_id = $this->db->get_where('skills', array('slugify' => $skill_slug))->row('skill_id');

		//For filter
			if(isset($_GET['pricing']) && $_GET['pricing'] == 'free'){
				$this->db->where('is_free', 1);
			}elseif(isset($_GET['pricing']) && $_GET['pricing'] == 'premium'){
				$this->db->where('is_free !=', 1);
			}

			if(isset($_GET['duration_range']) && $_GET['duration_range'] == 'less30'){
				$count_seconds = 30*60;
				$this->db->where('total_duration <=', $count_seconds);
			}elseif(isset($_GET['duration_range']) && $_GET['duration_range'] == '31to60'){
				$first_range = 31*60;
				$second_range = 60*60;
				$this->db->where('total_duration >=', $first_range);
				$this->db->where('total_duration <=', $second_range);
			}elseif(isset($_GET['duration_range']) && $_GET['duration_range'] == 'greater60'){
				$count_seconds = 60*60;
				$this->db->where('total_duration >', $count_seconds);
			}
		//End filter

		$this->db->order_by('classes.class_id', 'DESC');
		$this->db->where('skill_id', $skill_id);
		$this->db->where('status', 'active');

		if($limit != "" || $offset != ""){
			$this->db->limit($limit, $offset);
		}

		$this->db->from('skill_threades');
	    $this->db->join('classes', 'classes.class_id = skill_threades.class_id');
		return $this->db->get();
	}

	function user_registration($verification_code = ""){
		$data['first_name'] = htmlspecialchars($this->input->post('first_name'));
		$data['last_name'] = htmlspecialchars($this->input->post('last_name'));
		$data['email'] = htmlspecialchars($this->input->post('email'));
		$data['password'] = sha1($this->input->post('password'));
		if(get_settings('email_verification')){
			$data['is_verified'] = 0;
			$data['verification_code'] = $verification_code;
		}else{
			$data['is_verified'] = 1;
		}
		$data['status'] = 0;
		$data['date_added'] = time();
		$data['role'] = 'student';
		$data['social'] = '{"facebook":"","twitter":"","linkedin":"","website":""}';
		$this->db->insert('user', $data);
		return $this->db->insert_id();
	}

	function saved_class_by_class_id($class_id = ""){
		$user_id = $this->session->userdata('user_id');
		$this->db->where('user_id', $user_id);
		$this->db->where('class_id', $class_id);
		return $this->db->get('bookmark');
	}

	function bookmark($type = "", $class_id = ""){
		$user_id = $this->session->userdata('user_id');
		$is_saved = $this->saved_class_by_class_id($class_id)->num_rows();
		if($type == 'remove' && $is_saved > 0){
			$this->db->where('user_id', $user_id);
			$this->db->where('class_id', $class_id);
			$this->db->delete('bookmark');
			return get_phrase('this_class_has_been_removed');
		}else{
			$data['user_id'] = $user_id;
			$data['class_id'] = $class_id;
			$data['date_added'] = time();
			$this->db->insert('bookmark', $data);
			return get_phrase('this_class_has_been_saved');
		}
	}


	function get_total_watched_student($class_id = ""){
		$this->db->where('class_id', $class_id);
		$this->db->where('progress_percent >', 0);
		return $this->db->get('watch_histories')->num_rows();
	}

	function get_active_packages($package_id = ""){
		if($package_id > 0){
			$this->db->where('package_id', $package_id);
		}
		$this->db->where('status', 1);
		return $this->db->get('package');
	}

	function add_subscription($user_id = "", $package_id = "", $paid_amount = "", $payment_method = "", $payment_key = ""){
		$expire_date = 0;

		$package = $this->frontend_model->get_active_packages($package_id)->row_array();
		if($package['package_type'] == 'monthly'){
			$expire_month = date('m')+1;
			$expire_date = strtotime(date('d-'.$expire_month.'-Y H:i:s')) + (86400*get_settings('free_subscription_days'));
		}elseif($package['package_type'] == 'yearly'){
			$expire_year = date('Y')+1;
			$expire_date = strtotime(date('d-m-'.$expire_year.' H:i:s')) + (86400*get_settings('free_subscription_days'));
		}elseif($package['package_type'] == 'days'){
			$expire_date = strtotime(date('d-m-Y H:i:s')) + (86400*$package['days']) + (86400*get_settings('free_subscription_days'));
		}

		$data['user_id'] = $user_id;
		$data['package_id'] = $package_id;
		$data['paid_amount'] = $paid_amount;
		$data['payment_method'] = $payment_method;
		$data['payment_key'] = $payment_key;
		$data['date_added'] = time();
		$data['expire_date'] = $expire_date;
		$data['free_days'] = get_settings('free_subscription_days');
		$this->db->insert('payment', $data);
	}

	function get_following_by_user_id($follower_user_id = ""){
		$this->db->where('follower_user_id', $follower_user_id);
		return $this->db->get('followers');
	}

	function get_followers_by_user_id($user_id = ""){
		$this->db->where('user_id', $user_id);
		return $this->db->get('followers');
	}

	function get_followers_by_follower_id($user_id = "",  $follower_user_id = ""){
		if($follower_user_id == ""){
			$follower_user_id = $this->session->userdata('user_id');
		}
		$this->db->where('user_id', $user_id);
		$this->db->where('follower_user_id', $follower_user_id);
		return $this->db->get('followers');
	}
	
	function follow($user_id ="", $follower_user_id = ""){
		$this->db->where('user_id', $user_id);
		$this->db->where('follower_user_id', $follower_user_id);
		$query = $this->db->get('followers');

		if($query->num_rows() > 0){
			$this->db->where('user_id', $user_id);
			$this->db->where('follower_user_id', $follower_user_id);
			$this->db->delete('followers');
			return array('status' => "success", 'message'=> 'unfollow');
		}else{
			$this->db->insert('followers', array('user_id' => $user_id, 'follower_user_id' => $follower_user_id));
			return array('status' => "success", 'message'=> 'followed');
		}
	}

	function get_class_duration($class_id = ""){
		return $this->db->select_sum('duration')->where('class_id', $class_id)->get('lessons')->row('duration');
	}

	function get_lessons($lesson_id = ""){
		$this->db->where('lesson_id', $lesson_id);
		return $this->db->get('lessons');
	}

	function get_active_lessons_by_class_id($class_id = ""){
		$this->db->where('lesson_status', 1);
		$this->db->where('class_id', $class_id);
		return $this->db->get('lessons');
	}


	// function load_lesson_video(){
	// 	$class_id = htmlspecialchars($this->input->post('class_id'));
	// 	$lesson_id = htmlspecialchars($this->input->post('lesson_id'));
	// }

	// function get_last_viewed_lesson($class_id = "", $user_id = ""){
	// 	$this->db->where('class_id', $class_id);
	// 	$this->db->where('user_id', $user_id);
	// 	$this->db->where('last_viewed', 1);
	// 	$lesson_id = $this->db->get('watch_history')->row('lesson_id');

	// 	$this->db->where('lesson_id', $lesson_id);
	// 	return $this->db->get('lessons');
	// }

	function get_watch_histories($class_id = "", $user_id = ""){
		if($user_id == ""){
			$user_id = $this->session->userdata('user_id');
		}
		$this->db->where('user_id', $user_id);
		$this->db->where('class_id', $class_id);
		return $this->db->get('watch_histories');
	}

	function get_watch_histories_by_user($user_id = ""){
		if($user_id == ""> 0){
			$user_id = $this->session->userdata('user_id');
		}
		$this->db->where('in_history', 1);
		$this->db->where('user_id', $user_id);
		$this->db->order_by('date', 'desc');
		return $this->db->get('watch_histories');
	}

	// function is_last_viewed($class_id = "", $lesson_id = ""){

	// 	$user_id = $this->session->userdata('user_id');
	// 	if($user_id):
	// 		$watch_history = $this->db->get_where('watch_history', array('class_id' => $class_id, 'lesson_id' => $lesson_id, 'user_id' => $user_id));
	// 		if($watch_history->num_rows() > 0){
	// 			$this->db->where('watch_history_id', $watch_history->row('watch_history_id'));
	// 			$this->db->update('watch_history', array('last_viewed' => 1));
	// 		}else{
	// 			$data['class_id'] = $class_id;
	// 			$data['class_owner_id'] = $this->db->get_where('classes', array('class_id' => $class_id))->row('user_id');
	// 			$data['lesson_id'] = $lesson_id;
	// 			$data['user_id'] = $user_id;
	// 			$data['last_viewed'] = 1;
	// 			$data['current_duration'] = 0;
	// 			$data['is_done'] = 0;
	// 			$this->db->insert('watch_history', $data);
	// 		}
	// 	endif;

	// }

	function update_watch_history($class_id = "", $lesson_id = "", $seconds = "", $is_done = ""){
		$user_id = $this->session->userdata('user_id');

		$history = $this->frontend_model->get_watch_histories($class_id, $user_id);

		if($history->num_rows() > 0){
			$history = $history->row_array();

			$durations = json_decode($history['lesson_current_duration'], 1);

			if($is_done == 1){
				$lesson_done = json_decode($history['lesson_done'], 1);
				$lesson_done[$lesson_id] = 1;
				$data['lesson_done'] = json_encode($lesson_done);

				//calculate total progress as percentage
				$number_of_lessons = $this->get_active_lessons_by_class_id($class_id)->num_rows();
				$num_of_completed_lessons = count($lesson_done);
				$data['progress_percent'] = (100/$number_of_lessons) * $num_of_completed_lessons;

				$durations[$lesson_id] = 0;
				$data['lesson_current_duration'] = json_encode($durations);
			}else{
				$durations[$lesson_id] = round($seconds);
				$data['lesson_current_duration'] = json_encode($durations);
			}


			$data['playing_lesson'] = $lesson_id;
			$data['in_history'] = 1;
			$data['date'] = time();
			$this->db->where('user_id', $user_id);
			$this->db->where('class_id', $class_id);
			$this->db->update('watch_histories', $data);
		}else{
			$data['class_id'] = $class_id;
			$data['user_id'] = $user_id;
			$data['playing_lesson'] = $lesson_id;
			$data['in_history'] = 1;
			$data['lesson_done'] = '[]';
			$data['lesson_current_duration'] = json_encode(array($lesson_id => round($seconds)));
			$data['date'] = time();
			$this->db->insert('watch_histories', $data);
		}

	}



	function get_class_projects($class_id = "", $user_id = ""){
		if($class_id != ""){
			$this->db->where('class_id', $class_id);
		}

		if($user_id != ""){
			$this->db->where('user_id', $user_id);
		}
		return $this->db->get('projects');
	}

	function get_related_skills($class_id = ""){
		$this->db->where('class_id', $class_id);
		$this->db->from('skill_threades');
	    $this->db->join('skills', 'skills.skill_id = skill_threades.skill_id');
	    return $this->db->get();
	}

	function best_suited_level($class_id = "", $return_count = ""){
		//0=all, 1=beginner, 2=intermediate, 3=advanced
		$all = $this->db->where('class_id', $class_id)->where('level', 'all')->get('reviews')->num_rows();
		$beginner = $this->db->where('class_id', $class_id)->where('level', 'beginner')->get('reviews')->num_rows();
		$intermediate = $this->db->where('class_id', $class_id)->where('level', 'intermediate')->get('reviews')->num_rows();
		$advanced = $this->db->where('class_id', $class_id)->where('level', 'advanced')->get('reviews')->num_rows();
		if($advanced > $beginner && $advanced > $intermediate && $advanced > $all){
			$best_suited_level = 'advanced';
		}elseif($intermediate > $all && $intermediate > $beginner && $intermediate > $advanced){
			$best_suited_level = 'intermediate';
		}elseif($beginner > $all && $beginner > $intermediate && $beginner > $advanced){
			$best_suited_level = 'beginner';
		}else{
			$best_suited_level = 'all';
		}


		$total_reviews = $all + $beginner + $intermediate + $advanced;
		if($total_reviews < 5){
			$best_suited_level = $this->crud_model->get_classes($class_id)->row('level');
		}


		if($return_count != ""){
			return array('best_suited_level' => $best_suited_level, 'total_reviews' => $total_reviews);
		}else{
			return $best_suited_level;
		}
	}

	function get_reviews($review_id = ""){
		if($review_id > 0){
			$this->db->where('review_id', $review_id);
		}
		return $this->db->get('reviews');
	}

	function get_reviews_user_and_class($class_id = "", $user_id = ""){
		if($user_id == ""){
			$user_id = $this->session->userdata('user_id');
		}
		$this->db->where('user_id', $user_id);
		$this->db->where('class_id', $class_id);

		$this->db->from('reviews');
	    $this->db->join('review_tags', 'review_tags.review_tag_id = reviews.review_tag_id');
		return $this->db->get();
	}

	function get_review_tags($review_tag_id = ""){
		if($review_tag_id > 0){
			$this->db->where('review_tag_id', $review_tag_id);
		}
		return $this->db->get('review_tags');
	}

	function get_reviews_by_class_id($class_id = ""){
		$this->db->order_by('review_id', 'desc');
		$this->db->where('class_id', $class_id);

		$this->db->from('reviews');
	    $this->db->join('user', 'user.user_id = reviews.user_id');
		return $this->db->get();
	}

	function get_expectations_met($class_id = ""){
		$arr = array();

		$this->db->where('expectation', 0);
		$this->db->where('class_id', $class_id);
		$not_really = $this->db->get('reviews')->num_rows();

		$this->db->where('expectation', 1);
		$this->db->where('class_id', $class_id);
		$somewhat = $this->db->get('reviews')->num_rows();

		$this->db->where('expectation', 2);
		$this->db->where('class_id', $class_id);
		$yes = $this->db->get('reviews')->num_rows();

		$this->db->where('expectation', 3);
		$this->db->where('class_id', $class_id);
		$exceeded = $this->db->get('reviews')->num_rows();

		$total_reviews = $not_really + $somewhat + $yes + $exceeded;
		if($total_reviews > 0){
			$arr['not_really'] = round((100/$total_reviews)*$not_really);
			$arr['somewhat'] = round((100/$total_reviews)*$somewhat);
			$arr['yes'] = round((100/$total_reviews)*$yes);
			$arr['exceeded'] = round((100/$total_reviews)*$exceeded);
		}else{
			$arr['not_really'] = 0;
			$arr['somewhat'] = 0;
			$arr['yes'] = 0;
			$arr['exceeded'] = 0;
		}
		return $arr;
	}

	function get_discussion($discussion_id = ""){
		$this->db->where('discussion_id', $discussion_id);
		$this->db->from('discussions');
	    $this->db->join('user', 'user.user_id = discussions.user_id');
		return $this->db->get();
	}

	function get_discussions_by_class_id($class_id = ""){
		$this->db->order_by('discussion_id', 'desc');
		$this->db->where('class_id', $class_id);
		$this->db->where('parent_id', 0);

		$this->db->from('discussions');
	    $this->db->join('user', 'user.user_id = discussions.user_id');
		return $this->db->get();
	}

	function get_child_discussions($discussion_id = ""){
		$this->db->order_by('discussion_id', 'desc');
		$this->db->where('parent_id', $discussion_id);

		$this->db->from('discussions');
	    $this->db->join('user', 'user.user_id = discussions.user_id');
		return $this->db->get();
	}

	function add_discussion($user_id = "", $parent_id = ""){
		$data['description'] = $this->input->post('discussion');
		$data['class_id'] = $this->input->post('class_id');
		$data['user_id'] = $user_id;
		$data['parent_id'] = $parent_id;
		$data['added_date'] = time();
		$this->db->insert('discussions', $data);
	}

	function add_review($user_id = "", $class_id = ""){
		$data['user_id'] = $user_id;
		$data['class_id'] = $class_id;
		$data['review_tag_id'] = $this->input->post('review_tag_id');
		$data['expectation'] = $this->input->post('expectation');
		$data['level'] = $this->input->post('level');
		$data['comment'] = $this->input->post('comment');
		$data['added_date'] = time();

		$this->db->insert('reviews', $data);
	}

	function update_review($review_id = ""){
		$data['review_tag_id'] = $this->input->post('review_tag_id');
		$data['expectation'] = $this->input->post('expectation');
		$data['level'] = $this->input->post('level');
		$data['comment'] = $this->input->post('comment');
		$data['updated_date'] = time();

		$this->db->where('review_id', $review_id);
		$this->db->update('reviews', $data);
	}

	function get_saved_classes($user_id = ""){
		$this->db->where('user_id', $user_id);
		return $this->db->get('bookmark');
	}

	// function enrol_class($user_id = "", $class_id = ""){
	// 	if(login_type()){
	// 		$query = $this->db->get_where('watch_history_classes', array('class_id' => $class_id, 'user_id' => $user_id));
	// 		if($query->num_rows() > 0){
	// 			$data['updated_time'] = time();
	// 			$data['status'] = 1;
	// 			$this->db->where('user_id', $user_id);
	// 			$this->db->where('class_id', $class_id);
	// 			$this->db->update('watch_history_classes', $data);
	// 		}else{
	// 			$data['class_id'] = $class_id;
	// 			$data['user_id'] = $user_id;
	// 			$data['updated_time'] = time();
	// 			$data['status'] = 1;
	// 			$this->db->insert('watch_history_classes', $data);
	// 		}
	// 	}
	// }

	// function watch_history_classes($user_id = ""){
	// 	if($user_id == ''){
	// 		$user_id = $this->session->userdata('user_id');
	// 	}
	// 	$this->db->order_by('updated_time', 'desc');
	// 	$this->db->where('watch_history_classes.user_id', $user_id);
	// 	$this->db->where('watch_history_classes.status', 1);

	// 	$this->db->from('watch_history_classes');
	//     $this->db->join('classes', 'classes.class_id = watch_history_classes.class_id');
	// 	return $this->db->get();
	// }

	function get_related_skills_by_class_ids($class_ids = array()){
		$this->db->select('slugify');
		$this->db->select('skill_title');
		$this->db->distinct('skill_id');
		$this->db->where_in('class_id', $class_ids);
		$this->db->from('skill_threades');
	    $this->db->join('skills', 'skills.skill_id = skill_threades.skill_id');
		return $this->db->get();
	}

	function number_of_followers($user_id = ""){
		$this->db->where('user_id', $user_id);
		return $this->db->get('followers')->num_rows();
	}

	function number_of_following($user_id = ""){
		$this->db->where('follower_user_id', $user_id);
		return $this->db->get('followers')->num_rows();
	}

	function get_classes_by_user_id($user_id = "", $limit= "", $offset = "0"){
		$this->db->where('user_id', $user_id);

		if($limit){
			$this->db->limit($limit, $offset);
		}
		$this->db->where('status', 'active');
		return $this->db->get('classes');
	}

	function get_top_categories(){
		$query = $this->db
		    ->select("category_id, count(*) AS class_number",false)
		    ->from ("classes")
		    ->group_by("category_id")
		    ->order_by("class_number","DESC")
		    ->where('status', 'active')
		    ->limit(10)
		    ->get();
		return $query->result_array();
	}

	function get_top_skills(){
		$query = $this->db
		    ->select("skill_id, count(*) AS class_number",false)
		    ->from ("skill_threades")
		    ->group_by("skill_id")
		    ->order_by("class_number","DESC")
		    ->where('is_active_class', 1)
		    ->limit(10)
		    ->get();
		return $query->result_array();
	}

	function profile_update($user_id = ""){
		$data['first_name'] = htmlspecialchars($this->input->post('first_name'));
		$data['last_name'] = htmlspecialchars($this->input->post('last_name'));
		$data['surname'] = htmlspecialchars($this->input->post('surname'));
		$data['phone'] = htmlspecialchars($this->input->post('phone'));
		$data['address'] = htmlspecialchars($this->input->post('address'));
		$data['about'] = htmlspecialchars($this->input->post('about'));

		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);
	}

	function upload_profile_image($user_id = ""){
		$data['photo'] = $user_id.rand(1000, 9999).'.png';
		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);

		move_uploaded_file($_FILES['user_image']['tmp_name'], 'uploads/user_images/'.$data['photo']);

		resizeImage('uploads/user_images/'.$data['photo'], 'uploads/user_images/optimized/', 100);
	}

	function social_link_update($user_id = ""){
		$links['facebook'] = htmlspecialchars($this->input->post('facebook'));
		$links['linkedin'] = htmlspecialchars($this->input->post('linkedin'));
		$links['twitter'] = htmlspecialchars($this->input->post('twitter'));
		$links['website'] = htmlspecialchars($this->input->post('website'));

		$data['social'] = json_encode($links);
		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);
	}

	function change_password($user_id = ""){
		$current_password = sha1($this->input->post('current_password'));
		$new_password = sha1($this->input->post('new_password'));
		$confirm_password = sha1($this->input->post('confirm_password'));
		
		$this->db->where('user_id', $user_id);
		$this->db->where('password', $current_password);
		$query = $this->db->get('user');
		if($query->num_rows() > 0){
			if($new_password == $confirm_password){
				$this->db->where('user_id', $user_id);
				$this->db->update('user', array('password' => $new_password));
				$this->session->set_flashdata('success',get_phrase('password_changed_successfully'));
			}else{
				$this->session->set_flashdata('error',get_phrase('confirm_password_does_not_match'));
			}
		}else{
			$this->session->set_flashdata('error',get_phrase('current_password_does_not_match'));
		}
	}

	function get_payments($user_id = ""){
		$this->db->order_by('payment_id', 'desc');
		$this->db->where('user_id', $user_id);

		$this->db->from('payment');
	    $this->db->join('package', 'package.package_id = payment.package_id');
		return $this->db->get();
	}

	function get_payments_by_payment_id($payment_id = ""){
		$this->db->where('payment_id', $payment_id);
		$this->db->from('payment');
	    $this->db->join('package', 'package.package_id = payment.package_id');
		return $this->db->get()->row_array();
	}














}