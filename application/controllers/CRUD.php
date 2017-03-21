<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CRUD extends CI_Controller {
    
    
    public function create() {
		
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title','Recepto pavadinimo','required|trim|xss_clean|max_length[100]');
        $this->form_validation->set_rules('user','El.pašto','required|trim|xss_clean|max_length[100]');
        $this->form_validation->set_rules('type','Recepto tipo','required|xss_clean|trim|max_length[10]');
        $this->form_validation->set_rules('description','Recepto aprašymo','required|trim|xss_clean|max_length[10000]');

        $this->form_validation->set_message('required', '%s laukelis yra privalomas');
        $this->form_validation->set_message('max_length', '%s maximalus simbolių skaičius yra %s');

        if($this->form_validation->run()){
            $data = array(
                'title' => $this->input->post('title'),
                'type' => $this->input->post('type'),
                'description' => $this->input->post('description'),
                'publish' => 0,
                'user' => $this->input->post('user'),
            );
            $this->CRUD_model->add_review($data);
            $data['reg']= "Jūsų pasiūlymas išsiūstas";
            $data['user_email']= $this->session->userdata('email');
            $this->load->view("header");
            $this->load->view("pasiulytiRecepta",$data);
            $this->load->view("footer");
        }
        else{
            $data['uperr']= validation_errors();
            $data['user_email']= $this->session->userdata('email');
            $this->load->view("header");
            $this->load->view("pasiulytiRecepta",$data);
            $this->load->view("footer");
        }
        
	}
    
    public function delete() {
        $this->CRUD_model->delete_row();
        redirect('index.php/vartotojas/adminasAnketa');
    }
    public function update(){

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','El. pašto laukelis','required|trim|xss_clean');
        $this->form_validation->set_rules('password','Slaptažodžio','required|md5|trim');
        $this->form_validation->set_rules('cpassword','Pakartotino slaptažodžio','required|md5|trim|matches[password]');

        $this->form_validation->set_message('required', '%s laukelis yra privalomas');
        $this->form_validation->set_message("matches", 'Slaptažodžiai nesutampa');

        if($this->form_validation->run()){
            $senas = $this->input->post('email');
            $naujas = array('password' => $this->input->post("password") );
            $this->CRUD_model->update_record($senas,$naujas);
            $data['reg']= "Jūsų duomenys atnaujinti sėkmingai";
            $this->load->view("header");
            $this->load->view("anketa",$data);
            $this->load->view("footer");
        }
        else{
            $data['uperr']= validation_errors();
            $this->load->view("header");
            $this->load->view("anketa",$data);
            $this->load->view("footer");
        }
    }
    
    public function deleteReview() {
        $this->CRUD_model->delete_review();
        redirect('index.php/vartotojas/adminasAnketa');
    }

    public function updateReview() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title','Recepto pavadinimo','required|trim|xss_clean|max_length[100]');
        $this->form_validation->set_rules('user','El.pašto','required|trim|xss_clean|max_length[100]');
        $this->form_validation->set_rules('id','ID','required|trim|xss_clean|max_length[9]');
        $this->form_validation->set_rules('admin','Administratoriaus vardo','required|trim|xss_clean|max_length[30]');
        $this->form_validation->set_rules('type','Recepto tipo','required|xss_clean|trim|max_length[10]');
        $this->form_validation->set_rules('description','Recepto aprašymo','required|trim|xss_clean|max_length[10000]');

        $this->form_validation->set_message('required', '%s laukelis yra privalomas');
        $this->form_validation->set_message('max_length', '%s maximalus simbolių skaičius yra %s');

        
        if($this->form_validation->run()){
            $id = $this->input->post('id');
            
            $data = array(
                'title' => $this->input->post('title'),
                'type' => $this->input->post('type'),
                'description' => $this->input->post('description'),
                'publish' => 1,
                'user' => $this->input->post('user'),
                'admin' => "admin",
            );
            $this->CRUD_model->update_review($id,$data);
            $data['reg']= "Receptas išsaugotas ir viešinamas";
        }
        else{
            $data['aderr']=validation_errors();
        }
        if($query=$this->CRUD_model->get_records()){
            $data['records']=$query;
        }
        if($query=$this->CRUD_model->get_reviews()){
            $data['recipe']=$query;
        }
        redirect('index.php/vartotojas/adminasAnketa', 'refresh');
        
    }
} 