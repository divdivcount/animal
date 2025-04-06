<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BoardCategoryModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database('default');
    }

    // 카테고리 전체 목록 조회
    public function get_all() {
        $this->db->order_by('sort_order', 'ASC');  // DB 객체를 사용하여 쿼리 실행
        return $this->db->get('board_categories')->result();
    }

    // 카테고리 생성
    public function create($data) {
        return $this->db->insert('board_categories', $data);
    }

    // 카테고리 정보 조회
    public function get_by_id($id) {
        return $this->db->get_where('board_categories', ['id' => $id])->row();
    }

    // 카테고리 삭제
    public function delete($id) {
        return $this->db->delete('board_categories', ['id' => $id]);
    }
}
