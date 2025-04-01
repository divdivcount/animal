<?php
class UserModel extends CI_Model {

  public function __construct()
  {
      parent::__construct();
      $this->load->database('default');
  }

  public function get_by_email($email) {
    return $this->db->get_where('users', ['email' => $email])->row();
  }
}
