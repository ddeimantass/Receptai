<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vartotojas extends CI_Controller {
    
    public function administratorius() {
        $this->load->view("adminas");
    }
    public function adminasAnketa() {
        $this->load->model("recipe_model");
      
        $recipesPerPage = 2;
        $usersPerPage = 2;
        
        if (isset($_GET["u"])) {
            $current_users_page = filter_input(INPUT_GET,"u",FILTER_SANITIZE_NUMBER_INT);
        }
        if (isset($_GET["r"])) {
            $current_recipes_page = filter_input(INPUT_GET,"r",FILTER_SANITIZE_NUMBER_INT);
        }
        if (empty($current_users_page)) {
            $current_users_page = 1;
        }
        if (empty($current_recipes_page)) {
            $current_recipes_page = 1;
        }

        $total_users = $this->CRUD_model->count_records();
        $total_recipes = $this->recipe_model->count_recipes_admin();;
        
        $total_users_pages = ceil($total_users / $usersPerPage);
        $total_recipes_pages = ceil($total_recipes / $recipesPerPage);
        
        if ($current_users_page > $total_users_pages && $current_recipes_page > $total_recipes_pages) {
            header("location:?u=".$total_users_pages."&r=".$total_recipes_pages);
        }
        if ($current_users_page < 1 && $current_recipes_page < 1) {
            header("location:?u=1&r=1");
        }
        if ($current_recipes_page > $total_recipes_pages && $current_users_page < 1) {
            header("location:?u=1&r=".$total_recipes_pages);
        }
        if ($current_recipes_page < 1 && $current_users_page > $total_users_pages) {
            header("location:?r=1&u=".$total_users_pages);
        }
        
        $usersOffset = ($current_users_page - 1) * $usersPerPage;
        $recipesOffset = ($current_recipes_page - 1) * $recipesPerPage;
        
        $users = $this->CRUD_model->get_records($usersPerPage, $usersOffset);
        $recipes = $this->recipe_model->get_recipes_admin($recipesPerPage, $recipesOffset);
        $users = json_decode(json_encode($users), True);
        $recipes = json_decode(json_encode($recipes), True);
        
        $data = array(
            'users' => $users,
            'recipes' => $recipes,
            'total_users' => $total_users,
            'total_recipes' => $total_recipes,
            'total_users_pages' => $total_users_pages,
            'total_recipes_pages' => $total_recipes_pages,
            'current_users_page' => $current_users_page,            
            'current_recipes_page' => $current_recipes_page,            
        );
        
        if($query=$this->CRUD_model->get_records(1, 0)){
        }
        if($query=$this->recipe_model->get_recipes_admin(1, 0)){
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
