<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feed extends CI_Controller {
     
    public function __construct() {

        parent::__construct();
        $this->load->model('posts_model', 'posts');
    }
     
    public function index(){

        $data['feed_name'] = 'Rubinas.lt';
        $data['encoding'] = 'utf-8';
        $data['feed_url'] = 'http://localhost:8888/CodeIgniter/index.php/feed';
        $data['page_description'] = 'What my site is about comes here';
        $data['page_language'] = 'en-en';
        $data['creator_email'] = 'mail@me.com';
        $data['posts'] = $this->posts->getPosts(10);    
        header("Content-type: text/xml; charset=utf-8");
         
        $this->load->view('rss', $data);
    }
     
}