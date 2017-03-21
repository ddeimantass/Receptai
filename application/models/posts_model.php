<?php

class Posts_model extends CI_Model {

	public function getPosts($limit=NULL) {

		return $this->db->get('posts', $limit);
	}
}