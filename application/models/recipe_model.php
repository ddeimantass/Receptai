<?php

class Recipe_model extends CI_Model {
    
    public function count_recipes($search) {
        $this->db->where("publish", 1);
        $this->db->like("title", $search);
		$query = $this->db->get("recipe");
		return count($query->result());
	}
    public function search_recipes($search, $limit, $offset) {
        
        $this->db->where("publish", 1);
        $this->db->like("title", $search);
        $this->db->limit($limit);
        $this->db->offset($offset);
        $query = $this->db->get("recipe");
		return $query->result();
	}
    public function get_recipes($limit, $offset) {
        $this->db->limit($limit);
        $this->db->offset($offset);
        $this->db->where("publish", 1);
		$query = $this->db->get("recipe");
		return $query->result();
	}
    public function get_recipes_admin($limit, $offset) {
        $this->db->order_by("id","desc");
        $this->db->limit($limit);
        $this->db->offset($offset);
		$query = $this->db->get("recipe");
		return $query->result();
	}
    public function count_recipes_admin() {
		$query = $this->db->get("recipe");
		return count($query->result());
	}
    public function get_recipe_by_id($id) {
        $this->db->where("publish", 1);
        $this->db->where("id",$id);
		$query = $this->db->get("recipe");
		return $query->result();
	}
    
    
}