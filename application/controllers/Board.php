<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'core/Secure_Controller.php');

class Board extends Secure_Controller {

    protected $require_login = true;

    public function __construct() {
        parent::__construct();
        $this->load->model(['BoardCategoryModel','BoardPostModel','CommentModel','LikeModel']);
    }

    // 게시글 목록 보기
    public function posts($category_id = null) {
        $posts = $this->BoardPostModel->get_all($category_id);  // 카테고리별 게시글 조회
        $this->load->view('user/common/header');
        $this->load->view('user/board/posts', ['posts' => $posts]);
        $this->load->view('user/common/footer');
    }

    // 게시글 상세보기
    public function view_post($post_id) {
        $post = $this->BoardPostModel->get_by_id($post_id);
        $this->load->view('user/common/header');
        $this->load->view('user/board/view_post', ['post' => $post]);
        $this->load->view('user/common/footer');
    }

    // 게시글 작성
    public function create_post() {
        // 게시판 카테고리 가져오기
        $categories = $this->BoardCategoryModel->get_all();
        $this->load->view('/user/common/header');
        $this->load->view('/user/board/create_post', ['categories' => $categories]);
        $this->load->view('/user/common/footer');
    }

    // 게시글 저장
    public function store_post() {
        $title = $this->input->post('title');
        $summary = $this->input->post('summary');
        $content = $this->input->post('content');
        $author_id = $this->session->userdata('user_id');
        // $slug = $this->slugify($title);

        $data = [
            'title' => $title,
            'summary' => $summary,
            'content' => $content,
            'author_id' => $author_id,
            'slug' => $slug
        ];

        // 게시글 저장
        $post_id = $this->BoardPostModel->create($data);

        // 게시글과 카테고리 관계 설정
        $categories = $this->input->post('categories');
        if ($categories) {
            foreach ($categories as $category_id) {
                $this->BoardPostModel->assign_category($post_id, $category_id);
            }
        }

        redirect('/board/posts');
    }

    // 댓글 작성
    public function add_comment($post_id) {
        $user_id = $this->session->userdata('user_id');
        $content = $this->input->post('content');

        if (!$user_id) {
            redirect('login');
        }

        $data = [
            'post_id' => $post_id,
            'user_id' => $user_id,
            'content' => $content
        ];

        $this->CommentModel->create($data);
        redirect('/board/view_post/' . $post_id);
    }

    // 게시글 좋아요
    public function like_post($post_id) {
        $user_id = $this->session->userdata('user_id');

        if (!$user_id) {
            redirect('login');
        }

        $this->LikeModel->like_post($post_id, $user_id);
        redirect('/board/view_post/' . $post_id);
    }
}
