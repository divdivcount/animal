<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LikeModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database('default');
    }

    // 사용자가 해당 게시글에 좋아요를 눌렀는지 확인
    public function is_liked($post_id, $user_id) {
        $this->db->where('post_id', $post_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('board_likes');

        return $query->num_rows() > 0;  // 좋아요가 있다면 true 반환
    }

    // 게시글 좋아요
    public function like_post($post_id, $user_id) {
        // 이미 좋아요가 있으면 추가하지 않음
        $this->db->where('post_id', $post_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('board_likes');

        if ($query->num_rows() == 0) {
            $data = [
                'post_id' => $post_id,
                'user_id' => $user_id,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('board_likes', $data);
        }
    }

    // 댓글 좋아요
    public function like_comment($comment_id, $user_id) {
        $data = ['comment_id' => $comment_id, 'user_id' => $user_id];
        if (!$this->exists_comment_like($comment_id, $user_id)) {
            return $this->db->insert('comment_likes', $data);
        }
        return false;  // 이미 좋아요를 눌렀으면 추가하지 않음
    }

    // 좋아요 취소
    public function unlike_post($post_id, $user_id) {
        $this->db->where('post_id', $post_id);
        $this->db->where('user_id', $user_id);
        $this->db->delete('board_likes'); // 삭제
    }

    // 게시글 좋아요 여부 확인
    public function exists_post_like($post_id, $user_id) {
        $this->db->where('post_id', $post_id);
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('post_likes') > 0;
    }

    // 댓글 좋아요 여부 확인
    public function exists_comment_like($comment_id, $user_id) {
        $this->db->where('comment_id', $comment_id);
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('comment_likes') > 0;
    }

    // 게시글 좋아요 카운트
    public function get_post_likes_count($post_id) {
        $this->db->where('post_id', $post_id);
        return $this->db->count_all_results('post_likes');
    }

    // 댓글 좋아요 카운트
    public function get_comment_likes_count($comment_id) {
        $this->db->where('comment_id', $comment_id);
        return $this->db->count_all_results('comment_likes');
    }
}
