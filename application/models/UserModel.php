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

  public function create($data) {
    return $this->db->insert('users', $data);
  }

  public function exists_by_email($email) {
      return $this->db->where('email', $email)->count_all_results('users') > 0;
  }

  public function get_by_nickname($nickname) {
      return $this->db->get_where('users', ['nickname' => $nickname])->row();
  }


}
