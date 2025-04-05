<?php
class JournalModel extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function create($data) {
    return $this->db->insert('journal_entries', $data);
  }

  public function get_all_by_user($user_id) {
    return $this->db->where('user_id', $user_id)
                    ->order_by('created_at', 'DESC')
                    ->get('journal_entries')
                    ->result();
  }

  public function get_by_id($id)
  {
      return $this->db->where('id', $id)->get('journal_entries')->row();
  }

  public function update($id, $data)
  {
      $this->db->where('id', $id);
      return $this->db->update('journal_entries', $data);
  }
  
  public function delete($id)
  {
      return $this->db->delete('journal_entries', ['id' => $id]);
  }
}
