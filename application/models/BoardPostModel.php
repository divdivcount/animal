<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BoardPostModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database('default');
    }

    // 게시글 전체 목록 조회
    public function get_all($category_id = null) {
        if ($category_id) {
            $this->db->join('board_post_categories', 'board_posts.id = board_post_categories.post_id');
            $this->db->where('board_post_categories.category_id', $category_id);
        }
        return $this->db->get('board_posts')->result();
    }

    // 게시글 작성
    public function create($data) {
        $this->db->insert('board_posts', $data);
        return $this->db->insert_id();
    }

    // 게시글 상세 조회
    public function get_by_id($id) {
        return $this->db->get_where('board_posts', ['id' => $id])->row();
    }

    // 게시글 수정
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('board_posts', $data);
    }

    // 게시글 삭제
    public function delete($id) {
        return $this->db->delete('board_posts', ['id' => $id]);
    }

    // 게시글과 카테고리 관계 설정
    public function assign_category($post_id, $category_id) {
        $this->db->insert('board_post_categories', ['post_id' => $post_id, 'category_id' => $category_id]);
    }
}
