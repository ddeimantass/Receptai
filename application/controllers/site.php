<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {
    
    public function index() {
        
        $this->pagrindinis();
	}
    public function prisijungimas() {
        
   
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','El. pašto','required|trim|valid_email[users.email]|callback_validate_unique');
        
        $this->form_validation->set_message('required', '%s laukelis yra privalomas');
        $this->form_validation->set_message("valid_email", 'Neteisingai įvedėte el. pašto adresą slaptažodžio priminimui');
        
        if($this->form_validation->run()){

			$config = Array(
			    'protocol' => 'smtp',
			    'smtp_host' => 'smtp.gmail.com',
			    'smtp_port' => 587,
			    'smtp_user' => 'ddeimantass@gmail.com',
			    'smtp_pass' => '',
			    'mailtype'  => 'html', 
			    'charset'   => 'iso-8859-1',
			    'smtp_crypto' => 'tls'
			);
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");

	        $this->email->from('ddeimantass@gmail.com', 'Deimantas');
	        $this->email->to($this->input->post('email'));

	        $this->email->subject('Email test');
	        
	        $passwd = $this->generate_password_suggestion();
	        $senas = $this->input->post('email');
	        $naujas = array('password' => md5($passwd));
	        $this->CRUD_model->update_record($senas,$naujas);
	        
	        $this->email->message('Jūsų naujas slaptažodis: '. $passwd );

	        $data['reg']= "Norėdami išsiūsti laišką įrašykite savo SMTP Pašto duomenis site.php faile";
	        
	        if($this->email->send())
	            $data['reg']= "Naujas slaptažodis išsiūstas į jūsų el. paštą";
	        
	        //echo $this->email->print_debugger();
	        
	        $this->load->view("header");
	        $this->load->view("login", $data);
	        $this->load->view("footer");
        }
        else{
            $data['remerr']= validation_errors();
            $this->load->view("header");
            $this->load->view("login",$data);
            $this->load->view("footer");
        }

    }
    public function validate_unique($email){

        $this->load->model("model_users");
        if($this->model_users->email_exists($email))
            return true;
        else{
            $this->form_validation->set_message("validate_unique", 'Toks el. paštas neregistruotas');
            return false;
        }    
    }
    function generate_password_suggestion()
    {
        $chars = "abcdefghijklmnpqrstuvwxyzABCDEFGIHJKLMNPQRSTUVWXYZ123456789_";
        $suggestion = substr(str_shuffle($chars), 0, 12);
        return $suggestion;
    }
    public function detaliai() {
        if(isset($_GET['id']))
            $id = 0 + $_GET['id'];
        if( is_integer($id)){
            $recipe = $this->recipe_by_id($id);
            $recipe = json_decode(json_encode($recipe), True);
        }        
        if(!isset($recipe)){
            $this->pagrindinis();
        }
        else{
            
            $data = array(
                'recipe' => $recipe[0],
            );
            $this->load->view("header");
            $this->load->view("detaliai", $data);
            $this->load->view("footer");
        }
        

    }
    public function pagrindinis() {
        
        $search = null;
        $sort = "new";
        $recipesPerPage = 2;
        if (isset($_GET["s"])) {
            $search = filter_input(INPUT_GET,"s",FILTER_SANITIZE_STRING);
        }
        if (isset($_GET["pg"])) {
            $current_page = filter_input(INPUT_GET,"pg",FILTER_SANITIZE_NUMBER_INT);
        }
        if (isset($_GET["sort"])) {
            $input = filter_input(INPUT_GET,"sort",FILTER_SANITIZE_STRING);
            if(in_array($input, ["new", "a_z", "z_a"]))
                $sort = $input;
        }
        if (empty($current_page)) {
            $current_page = 1;
        }

        $total_items = $this->get_recipes_count($search);
        $total_pages = ceil($total_items / $recipesPerPage);

        if ($current_page > $total_pages && $total_pages != 0) {
            header("location:?pg=".$total_pages);
        }
        if ($current_page < 1) {
            header("location:?pg=1");
        }
        $offset = ($current_page - 1) * $recipesPerPage;
        if(empty($search))
            $recipes = $this->full_recipes_array($recipesPerPage, $offset, $sort);
        else
            $recipes = $this->search_recipes_array($search, $recipesPerPage, $offset, $sort);
        
        $data = array(
            'recipes' => $recipes,
            'total_items' => $total_items,
            'total_pages' => $total_pages,
            'current_page' => $current_page,
            'search' => $search,
            'sort' => $sort,
        );
        $this->load->view("header");
        $this->load->view("pagrindinis", $data);
        $this->load->view("footer");        
	}
    function recipe_by_id($id){
        $this->load->model("recipe_model");
        if($this->recipe_model->get_recipe_by_id($id))
            return $this->recipe_model->get_recipe_by_id($id);
        else
            return null;
    }
    function full_recipes_array($limit = null, $offset = 0, $sort) {
        $this->load->model("recipe_model");
        return $this->recipe_model->get_recipes($limit, $offset, $sort);
    }

    function search_recipes_array($search = null, $limit = null, $offset = 0, $sort) {
        $this->load->model("recipe_model");
        return $this->recipe_model->search_recipes($search, $limit, $offset, $sort);
    }

    function get_recipes_count($search = null) {
        $this->load->model("recipe_model");
        return $this->recipe_model->count_recipes($search);
    }
} 