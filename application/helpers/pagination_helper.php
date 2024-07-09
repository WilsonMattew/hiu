<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('pagintaion'))
{
    function get_pagination($total_rows, $per_page_item){
        $config['per_page']        = $per_page_item;
        $config['num_links']       = 2;
        $config['total_rows']      = $total_rows;
        $config['full_tag_open']   = '<ul class="pagination mb-0">';
        $config['full_tag_close']  = '</ul>';
        $config['prev_link']       = '<i class="bi bi-chevron-left"></i>';
        $config['prev_tag_open']   = '<li class="page-item page-link">';
        $config['prev_tag_close']  = '</li>';
        $config['next_link']       = '<i class="bi bi-chevron-right"></i>';
        $config['next_tag_open']   = '<li class="page-item page-link">';
        $config['next_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="page-item active"> <a href="javascript:;" class="page-link">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li class="page-item page-link">';
        $config['num_tag_close']   = '</li>';
        $config['first_tag_open']  = '<li class="page-item page-link">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open']   = '<li class="page-item page-link">';
        $config['last_tag_close']  = '</li>';
        $config['reuse_query_string'] = true;
        return $config;
    }
}
