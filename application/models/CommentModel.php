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
        return $this->db->get_where('board_comments', ['post_id' => $post_id])->result();
    }

    // 댓글 작성
    public function create($data) {
        return $this->db->insert('board_comments', $data);
    }

    // 댓글 삭제
    public function delete($id) {
        return $this->db->delete('board_comments', ['id' => $id]);
    }

    // 댓글 수정
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('board_comments', $data);
    }

    public function get_comments_by_post($post_id) {
        // 댓글 목록을 가져오면서 작성자의 닉네임도 포함
        $this->db->select('board_comments.*, users.nickname');  // 'comments' -> 'board_comments'로 테이블 이름 수정
        $this->db->from('board_comments');  // 'comments' -> 'board_comments'로 테이블 이름 수정
        $this->db->join('users', 'users.id = board_comments.author_id');  // 'user_id' -> 'author_id'로 수정
        $this->db->where('board_comments.post_id', $post_id);  // 'comments.post_id' -> 'board_comments.post_id'로 수정
        $this->db->order_by('board_comments.created_at', 'ASC');  // 댓글 작성 날짜 순으로 정렬
    
        $query = $this->db->get();
        return $query->result();  // 댓글 목록 반환
    }
    
}
