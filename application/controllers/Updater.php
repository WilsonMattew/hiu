<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 *  @author   : Creativeitem
 *  Checkout
 *  http://codecanyon.net/user/Creativeitem
 *  http://support.creativeitem.com
 */

class Updater extends CI_Controller{
    function __construct(){
        parent::__construct();
        date_default_timezone_set(get_settings('timezone'));
        $this->load->database();
        $this->load->library('session');

        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

        if($this->session->userdata('login_type') != true || $this->session->userdata('user_role') != 'admin'){
            redirect(site_url('login'), 'refresh');
        }

    }

    /***default functin, redirects to login page if no admin logged in yet***/
    public function index(){
        redirect(site_url('admin/dashboard'), 'refresh');
    }

    /***** UPDATE PRODUCT *****/

    function update($task = '', $purchase_code = '')
    {

        // Create update directory.
        $dir = 'update';
        if (!is_dir($dir))
            mkdir($dir, 0777, true);

        $zipped_file_name = $_FILES["updater_file"]["name"];
        $path = 'update/' . $zipped_file_name;

        if (class_exists('ZipArchive')) {
            move_uploaded_file($_FILES["updater_file"]["tmp_name"], $path);
            // Unzip uploaded update file and remove zip file.
            $zip = new ZipArchive;
            $res = $zip->open($path);
            $zip->extractTo('update');
            $zip->close();
            unlink($path);
        }else{
            $this->session->set_flashdata('error', get_phrase('your_server_is_unable_to_extract_the_zip_file').'. '.get_phrase('please_enable_the_zip_extension_on_your_server').', '.get_phrase('then_try_again'));
            redirect(site_url('admin/system_settings'), 'refresh');
        }

        $unzipped_file_name = substr($zipped_file_name, 0, -4);
        $str = file_get_contents('./update/' . $unzipped_file_name . '/update_config.json');
        $json = json_decode($str, true);

        if ($json['require_version'] != get_settings('version')){
            $this->session->set_flashdata('error', get_phrase('it_looks_like_you_are_skipping_a_version').'. '.get_phrase('please_update_version').' '.$json['require_version'].' '.get_phrase('first'));
            redirect(site_url('admin/system_settings'), 'refresh');
        }   
           
        // Run php modifications
        require './update/' . $unzipped_file_name . '/update_script.php';

        // Create new directories.
        if (!empty($json['directory'])) {
            foreach ($json['directory'] as $directory) {
                if (!is_dir($directory['name']))
                    mkdir($directory['name'], 0777, true);
            }
        }

        // Create/Replace new files.
        if (!empty($json['files'])) {
            foreach ($json['files'] as $file)
                copy($file['root_directory'], $file['update_directory']);
        }

        $this->session->set_flashdata('success', get_phrase('product_updated_successfully'));
        redirect(site_url('admin/system_settings'));
    }

}
