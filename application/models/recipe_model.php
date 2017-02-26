<?php

class Recipe_model extends CI_Model {
    
    public function count_recipes($search = null) {
		$query = $this->db->get("recipe");
		return count($query->result());
	}
    public function search_recipes($search = null, $limit = null, $offset = null) {
        //		$this->db->where("id", $this->uri->segment(3));
        //		$this->db->where("id",$senas);
		$query = $this->db->get("recipe");
		return $query->result();
	}
    public function get_recipes($limit = null, $offset = null) {
		$query = $this->db->get("recipe");
		return $query->result();
	}
    public function get_recipe_by_id($id) {
        $this->db->where("id",$id);
		$query = $this->db->get("recipe");
		return $query->result();
	}
    
    
}