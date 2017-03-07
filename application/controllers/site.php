<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {
    
    public function index() {
        $this->pagrindinis();
	}
    public function prisijungimas() {
        $this->load->view("header");
        $this->load->view("login");
        $this->load->view("footer");

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
        $recipesPerPage = 2;
        if (isset($_GET["s"])) {
            
            $search = filter_input(INPUT_GET,"s",FILTER_SANITIZE_STRING);
        }
        if (isset($_GET["pg"])) {
            $current_page = filter_input(INPUT_GET,"pg",FILTER_SANITIZE_NUMBER_INT);
        }
        if (empty($current_page)) {
            $current_page = 1;
        }

        $total_items = $this->get_recipes_count($search);
        $total_pages = ceil($total_items / $recipesPerPage);

        if ($current_page > $total_pages) {
            header("location:?pg=".$total_pages);
        }
        if ($current_page < 1) {
            header("location:?pg=1");
        }
        $offset = ($current_page - 1) * $recipesPerPage;

        $recipes = $this->full_recipes_array($recipesPerPage, $offset);
        if(!empty($search)){
            $recipes = $this->search_recipes_array($search, $recipesPerPage, $offset);
        }
        $data = array(
            'recipes' => $recipes,
            'total_items' => $total_items,
            'total_pages' => $total_pages,
            'current_page' => $current_page,
            'search' => $search,
            
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
    function full_recipes_array($limit = null, $offset = 0) {
        $this->load->model("recipe_model");
        return $this->recipe_model->get_recipes($limit, $offset);
    }

    function search_recipes_array($search = null, $limit = null, $offset = 0) {
        $this->load->model("recipe_model");
        return $this->recipe_model->search_recipes($search, $limit, $offset);
    }

    function get_recipes_count($search = null) {
        $this->load->model("recipe_model");
        return $this->recipe_model->count_recipes($search);
    }
} 