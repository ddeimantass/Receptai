<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {
    
    public function index() {
		
        $this->pagrindinis();
        
	}
    
    public function pagrindinis() {
		
        $this->load->view("header");
        $this->load->view("pagrindinis");
        $this->load->view("footer");
        
	}
    public function prisijungimas() {
        
        $this->load->view("header");
        $this->load->view("login");
        $this->load->view("footer");

    }   
} 