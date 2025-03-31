<?php
class User_model extends CI_Model {

  public function get_by_email($email) {
    return $this->db->get_where('users', ['email' => $email])->row();
  }
}
