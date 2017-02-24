<?php

class Model_users extends CI_Model {

	public function is_admin() {

		$this->db->where('vardas',$this->input->post('vardas'));
		$this->db->where('slaptazodis',md5($this->input->post('slaptazodis')));

		$query= $this->db->get('admin');

		if($query->num_rows()==1){
			return true;
		}
		else {return false;}

	}
	public function can_log_in() {

		$this->db->where('email',$this->input->post('email'));
		$this->db->where('password',md5($this->input->post('password')));

		$query= $this->db->get('users');

		if($query->num_rows()==1){
			return true;
		}
		else {return false;}

	}

	public function add_user() {

		$data = array(
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password'),
		);

		$query = $this->db->insert('users',$data);

		if($query){return true;}
		else {return false;}
	}
}