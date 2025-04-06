<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommentModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database('default');
    }
    // 댓글 목록 조회
    public function get_by_post($post_id) {
        return $this->db->get_where('comments', ['post_id' => $post_id])->result();
    }

    // 댓글 작성
    public function create($data) {
        return $this->db->insert('comments', $data);
    }

    // 댓글 삭제
    public function delete($id) {
        return $this->db->delete('comments', ['id' => $id]);
    }

    // 댓글 수정
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('comments', $data);
    }
}
