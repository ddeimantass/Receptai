<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vartotojas extends CI_Controller {
    
     public function administratorius() {
        $this->load->view("adminas");
    }
    public function adminasAnketa() {
        
        $data=array();
        if($query=$this->CRUD_model->get_records()){

            $data['records']=$query;
        }
        if($query=$this->CRUD_model->get_reviews()){

            $data['recipe']=$query;
        }
        if (isset($aderr)){
            $data['aderr']=$query;
        }
        
        $this->load->view("adminasAnketa",$data);
    }
    public function anketa() {

        if($this->session->userdata('is_logged_in')){

            $this->load->view("header");
            $this->load->view("anketa");
            $this->load->view("footer");
        }
        else{
            redirect('index.php/vartotojas/pranesimas');
        }
    }
    public function pranesimas() {
        
        $this->load->view("header");
        $this->load->view("pranesimas");
        $this->load->view("footer");

    }
    public function pasiulytiRecepta() {

        if($this->session->userdata('is_logged_in')){
            $data['user_email']= $this->session->userdata('email');
            $this->load->view("header");
            $this->load->view("pasiulytiRecepta", $data);
            $this->load->view("footer");
        }
        else{
            redirect('index.php/vartotojas/prisijunk');
        }
    }
    public function prisijunk() {
        
        $data=array();
        if($query=$this->CRUD_model->get_reviews()){

            $data['records']=$query;
        }
        $this->load->view("header");
        $this->load->view("prisijunk",$data);
        $this->load->view("footer");

    }
    public function prisijungti() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','El. pašto','required|trim|xss_clean|callback_validate_credentials');
        $this->form_validation->set_rules('password','Slaptažodžio','required|md5|trim');

        $this->form_validation->set_message('required', '%s laukelis yra privalomas');

        if($this->form_validation->run()){

            $data = array(
                'email' => $this->input->post('email'),
                'is_logged_in'=>1 
            );
            $this->session->set_userdata($data);

            redirect('index.php/vartotojas/anketa');

        }
        else{
            $data['prierr']= validation_errors();
            $this->load->view("header");
            $this->load->view("login",$data);
            $this->load->view("footer");
        }

    }
    public function adminasPrisijungti() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('vardas','Vardo','required|trim|max_length[20]|xss_clean|callback_validate_creds');
        $this->form_validation->set_rules('slaptazodis','Slaptažodžio','required|md5');

        $this->form_validation->set_message('required', '%s laukelis yra privalomas');
        $this->form_validation->set_message('max_length', '%s maximalus simbolių skaičius yra %s');

        if($this->form_validation->run()){

            $data = array(
                'vardas' => $this->input->post('vardas'),
                'is_logged_in'=>1 
            );
            $this->session->set_userdata($data);

            redirect('index.php/vartotojas/adminasAnketa');

        }
        else{
            $data['prierr']= validation_errors();
            $this->load->view("adminas",$data);
        }
    }
    public function validate_credentials(){

        $this->load->model("model_users");

        if( $this->model_users->can_log_in()){
            return true;
        }
        else{
             $this->form_validation->set_message("validate_credentials", 'Neteisingas el. paštas arba slaptažodis.');
             return false;
        }
    }
    public function validate_creds(){

        $this->load->model("model_users");

        if( $this->model_users->is_admin()){
            return true;
        }
        else{
             $this->form_validation->set_message("validate_creds", 'Neteisingas Vardas arba slaptažodis.');
             return false;
        }
    }
    public function atsijungti(){

        $this->session->sess_destroy();
        redirect('index.php/vartotojas/prisijungti');
    }
    public function registruotis() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','El. pašto','required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password','Slaptažodžio','required|md5|trim');
        $this->form_validation->set_rules('cpassword','Pakartotino slaptažodžio','required|md5|trim|matches[password]');

        $this->form_validation->set_message('required', '%s laukelis yra privalomas');
        $this->form_validation->set_message("is_unique", 'Vartotojas tokiu el. pašto adresu jau egzistuoja');
        $this->form_validation->set_message("valid_email", 'Neteisingai įvedėte el. pašto adresą');
        $this->form_validation->set_message("matches", 'Slaptažodžiai nesutampa');

        if($this->form_validation->run()){
            $this->load->model('model_users');
            $this->model_users->add_user();
            $data['reg']= "Jūsų registracija sėkminga, galite prisijungti";
            $this->load->view("header");
            $this->load->view("login",$data);
            $this->load->view("footer");
        }
        else{
            $data['regerr']= validation_errors();
            $this->load->view("header");
            $this->load->view("login",$data);
            $this->load->view("footer");
        }

    }
}
