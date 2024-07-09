<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* CodeIgniter
*
* An open source application development framework for PHP 5.1.6 or newer
*
* @package		CodeIgniter
* @author		ExpressionEngine Dev Team
* @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
* @license		http://codeigniter.com/user_guide/license.html
* @link		http://codeigniter.com
* @since		Version 1.0
* @filesource
*/

if (! function_exists('remove_js')) {
    function remove_js($description = '') {
        return preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $description);
    }
}

if (! function_exists('user_login')) {
    function login_type($user_role = '') {
        $CI =&  get_instance();
        $CI->load->database();

        if ($CI->session->userdata('user_role') === $user_role && $user_role != '') {
            return true;
        }elseif($CI->session->userdata('login_type') === true && $user_role === ''){
            return true;
        }else{
            return false;
        }
    }
}

if (! function_exists('check_duplicate_email')) {
    function exist_email($email = "") {
        $CI =&  get_instance();
        $CI->load->database();
        if($CI->session->userdata('login_type') != true){
            $query = $CI->db->get_where('user', array('email' => $email));
        }else{
            //check for profile update (like user email)
            $CI->db->where('user_id !=', $CI->session->userdata('user_id'));
            $CI->db->where('email', $email);
            $query = $CI->db->get('user');
        }
        if($query->num_rows() > 0){
            if($query->row('status') == 1){
                return 'true';
            }else{
                return 'unverified';
            }
        }else{
            return false;
        }
    }
}

if (! function_exists('get_settings')) {
    function get_settings($type = '') {
        $CI	=&	get_instance();
        $CI->load->database();

        $CI->db->where('type', $type);
        $result = $CI->db->get('settings')->row('description');
        return $result;
    }
}

if (! function_exists('get_frontend_settings')) {
    function get_frontend_settings($type = '') {
        $CI =&  get_instance();
        $CI->load->database();

        $CI->db->where('type', $type);
        $result = $CI->db->get('frontend_settings')->row('description');
        return $result;
    }
}

if (! function_exists('translated_date')) {
    function translated_date($strtotime = "", $format = ""){
        if($format == ""){
            return date('d', $strtotime).'-'.get_phrase(date('M', $strtotime)).'-'.date('Y', $strtotime);
        }elseif($format == 1){
            return get_phrase(date('D', $strtotime)).', '.date('d', $strtotime).'-'.get_phrase(date('M', $strtotime)).'-'.date('Y', $strtotime);
        }
    }
}

if (! function_exists('resizeImage')) {
    function resizeImage($filelocation = "", $target_path = "", $width = "", $height = "") {
        $CI =&  get_instance();
        $CI->load->database();
        
        if($width == ""){
            $width = 200;
        }

        if($height == ""){
            $maintain_ratio = TRUE;
        }else{
            $maintain_ratio = FALSE;
        }

        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $filelocation,
            'new_image' => $target_path,
            'maintain_ratio' => $maintain_ratio,
            'create_thumb' => TRUE,
            'thumb_marker' => '',
            'width' => $width,
            'height' => $height
        );
        $CI->load->library('image_lib', $config_manip);

        if ($CI->image_lib->resize()) {
            return true;
        }else{
            $CI->image_lib->display_errors();
            return false;
        }
        $CI->image_lib->clear();
   }
}

if (! function_exists('get_user_image')) {
    function get_user_image($user_id = "") {
        $CI =&  get_instance();
        $CI->load->database();

        if($user_id){
            $photo = $CI->crud_model->get_users($user_id)->row('photo');
            $user_image = 'uploads/user_images/optimized/'.$photo;
        }else{
            $user_id = $CI->session->userdata('user_id');
            $photo = $CI->crud_model->get_users($user_id)->row('photo');
            $user_image = 'uploads/user_images/optimized/'.$photo;
        }
        if(is_file($user_image) && file_exists($user_image)){
            return base_url($user_image);
        }else{
            return base_url('uploads/user_images/thumbnail.png');
        }
    }
}

if (! function_exists('get_logo')) {
    function get_logo($type = '') {
        $logo = 'uploads/system_images/logo/'.get_frontend_settings($type);
        if(is_file($logo) && file_exists($logo)){
            return base_url($logo);
        }else{
            return base_url('uploads/system_images/logo/thumbnail.png');
        }
    }
}

if (! function_exists('get_category_thumbnail')) {
    function get_category_thumbnail($image_name = '', $optimized = '') {
        if(!$optimized == '') $optimized = $optimized.'/';
        $thumbnails = 'uploads/category_thumbnails/'.$optimized.$image_name;
        if(is_file($thumbnails) && file_exists($thumbnails)){
            return base_url($thumbnails);
        }else{
            return base_url('uploads/category_thumbnails/thumbnail.png');
        }
    }
}

if (! function_exists('get_class_thumbnail')) {
    function get_class_thumbnail($image_name = '', $optimized = '') {
        if(!$optimized == '') $optimized = $optimized.'/';
        $thumbnails = 'uploads/classes/thumbnail/'.$optimized.$image_name;
        if(is_file($thumbnails) && file_exists($thumbnails)){
            return base_url($thumbnails);
        }else{
            return base_url('uploads/classes/thumbnail/thumbnail.png');
        }
    }
}

if (! function_exists('get_class_banner')) {
    function get_class_banner($image_name = '', $optimized = '') {
        if(!$optimized == '') $optimized = $optimized.'/';
        $banner = 'uploads/classes/banner/'.$optimized.$image_name;
        if(is_file($banner) && file_exists($banner)){
            return base_url($banner);
        }else{
            $directory = 'uploads/classes/banner/';
            $banner = 'uploads/classes/banner/'.$image_name;
            if(is_file($banner) && file_exists($banner)){
                resizeImage($banner, $directory.'optimized/', 1300);
                return base_url($directory.'optimized/'.$image_name);
            }else{
                return base_url('uploads/classes/banner/thumbnail.png');
            }
        }
    }
}

if (! function_exists('get_random_code')) {
    function get_random_code($length = "") {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}

if (! function_exists('get_time_ago')) {
    function get_time_ago( $time ) {
        $time_difference = time() - $time;

        if( $time_difference < 1 ) { return 'less than 1 second ago'; }
        $condition = array( 12 * 30 * 24 * 60 * 60 =>  get_phrase('year'),
                    30 * 24 * 60 * 60       =>  get_phrase('month'),
                    24 * 60 * 60            =>  get_phrase('day'),
                    60 * 60                 =>  get_phrase('hour'),
                    60                      =>  get_phrase('minute'),
                    1                       =>  get_phrase('second')
        );

        foreach( $condition as $secs => $str )
        {
            $d = $time_difference / $secs;

            if( $d >= 1 )
            {
                $t = round( $d );
                return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) .' '. get_phrase('ago');
            }
        }
    }
}

if (! function_exists('currency')) {
    function currency($price = 0) {
        $CI	=&	get_instance();
        $CI->load->database();
        $CI->db->where('type', 'system_currency');
        $currency_code = $CI->db->get('settings')->row('description');

        $CI->db->where('code', $currency_code);
        $symbol = $CI->db->get('currency')->row('symbol');

        $CI->db->where('type', 'currency_position');
        $position = $CI->db->get('settings')->row('description');

        if ($position == 'right') {
            return $price.$symbol;
        }elseif ($position == 'right-space') {
            return $price.' '.$symbol;
        }elseif ($position == 'left') {
            return $symbol.$price;
        }elseif ($position == 'left-space') {
            return $symbol.' '.$price;
        }
    }
}

if (! function_exists('system_currency')) {
    function system_currency($type = "") {
        $CI	=&	get_instance();
        $CI->load->database();
        $CI->db->where('type', 'system_currency');
        $currency_code = $CI->db->get('settings')->row('description');

        $CI->db->where('code', $currency_code);
        $symbol = $CI->db->get('currency')->row('symbol');
        if ($type == "") {
            return $symbol;
        }else {
            return $currency_code;
        }

    }
}

if ( ! function_exists('slugify'))
{
    function slugify($text) {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        if (empty($text))
        return 'n-a';
        return $text;
    }
}

if ( ! function_exists('ellipsis'))
{
    // Checks if a video is youtube, vimeo or any other
    function ellipsis($long_string, $max_character = 30) {
        $short_string = strlen($long_string) > $max_character ? substr($long_string, 0, $max_character)."..." : $long_string;
        return $short_string;
    }
}


if ( ! function_exists('trimmer'))
{
    function trimmer($text) {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
        return 'n-a';
        return $text;
    }
}

if ( ! function_exists('duration_format'))
{
    function duration_format($total_seconds = "") {
        $seconds = $total_seconds%60;
        $total_minutes = $total_seconds/60;
        $minutes = $total_minutes%60;
        $hours = $total_minutes/60;

        return array('h' => intval($hours), 'm' => intval($minutes), 's' => intval($seconds));
    }
}

if ( ! function_exists('subscription'))
{
    function subscription_status($user_id = "") {
        $CI =&  get_instance();
        $CI->load->database();
        $current_date = time();
        if($user_id == ""){
            $user_id = $CI->session->userdata('user_id');
        }
        $CI->db->limit(1);
        $CI->db->order_by('payment_id', 'desc');
        $CI->db->where('user_id', $user_id);
        $payment = $CI->db->get('payment');

        if($user_id && $payment->num_rows() > 0 || login_type('admin')){
            if($current_date <= $payment->row('expire_date') || login_type('admin')){
                $status = true;
            }else{
                $status = false;
            }
        }else{
            $status = false;
        }
        return $status;
    }
}
