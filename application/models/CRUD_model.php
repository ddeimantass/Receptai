<?php

class CRUD_model extends CI_Model {

	public function get_records($limit = 0, $offset = 0) {
        $this->db->limit($limit);
        $this->db->offset($offset);
		$query = $this->db->get("users");
		return $query->result();
	}
    public function count_records() {
        $this->db->order_by("id","desc");
		$query = $this->db->get("users");
		return count($query->result());
	}
	public function add_record($data) {

		$this->db->insert("users",$data);
		return;
	}
	public function update_record($senas,$naujas) {

		$this->db->where("email",$senas);
		$this->db->update("users", $naujas);
	}
	public function delete_row() {
		
		$this->db->where("id", $this->uri->segment(3));
		$this->db->delete("users");
	}
	public function get_reviews() {

		$query = $this->db->get("recipe");
		return $query->result();

	}
	public function add_review($data) {
        
		$this->db->insert("recipe",$data);
		return;
	}
	public function update_review($senas,$naujas) {
		
		$this->db->where("id",$senas);
		$this->db->update("recipe", $naujas);
	}
	public function delete_review() {
		
		$this->db->where("id", $this->uri->segment(3));
		$this->db->delete("recipe");
	}
}