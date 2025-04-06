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

  // 반려동물 수정
  public function update($id, $data) {
    return $this->db->where('id', $id)->update('pets', $data);
  }

  // 반려동물 삭제
  public function delete($id) {
    return $this->db->where('id', $id)->delete('pets');
  }
}
