<?php
class PetModel extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function create($data) {
    return $this->db->insert('pets', $data);
  }

  public function get_all_by_user($user_id) {
    return $this->db->where('user_id', $user_id)
                    ->order_by('created_at', 'DESC')
                    ->get('pets')
                    ->result();
  }

  public function get_by_id($id) {
    return $this->db->get_where('pets', ['id' => $id])->row();
  }
}
