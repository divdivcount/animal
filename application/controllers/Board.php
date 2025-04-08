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

    public function view_post($post_id) {
        // 게시글 조회
        $post = $this->BoardPostModel->get_by_id($post_id);
        
        // 게시글이 없으면 게시글 목록으로 리디렉션
        if (!$post) {
            redirect('board/posts'); // 게시글이 없으면 게시글 목록으로 리디렉션
        }
    
        // 게시글 작성자 정보 가져오기
        $author_id = $post->author_id;
        $this->load->model('UserModel'); // 사용자 정보 조회를 위한 UserModel 로드
        $author = $this->UserModel->get_by_id($author_id); // 작성자 정보 조회
    
        // 사용자가 해당 게시글에 좋아요를 눌렀는지 확인
        $user_id = $this->session->userdata('user_id');
        $this->load->model('LikeModel');
        $is_liked = $this->LikeModel->is_liked($post_id, $user_id);
        
        // 뷰로 데이터 전달
        $this->load->view('user/common/header');
        $this->load->view('user/board/view_post', [
            'post' => $post, 
            'is_liked' => $is_liked,
            'author' => $author // 작성자 정보 추가
        ]);
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

    // 게시글 좋아요
    public function like_post($post_id) {
        $user_id = $this->session->userdata('user_id');

        if (!$user_id) {
            redirect('login');
        }

        $this->LikeModel->like_post($post_id, $user_id);
        redirect('/board/view_post/' . $post_id);
    }

    // 게시글 좋아요 취소
    public function unlike_post($post_id) {
        $user_id = $this->session->userdata('user_id');

        if (!$user_id) {
            redirect('login');
        }

        // 좋아요 취소
        $this->LikeModel->unlike_post($post_id, $user_id);
        redirect('/board/view_post/' . $post_id);
    }

    public function load_comments($post_id) {
        // 게시글에 대한 댓글 목록을 가져옴
        $comments = $this->CommentModel->get_comments_by_post($post_id);
    
        // 댓글 데이터를 JSON 형태로 반환
        echo json_encode($comments);
    }

    public function add_comment($post_id) {
    
        $content = $this->input->post('content');
        $user_id = $this->session->userdata('user_id');
        
        // 댓글 데이터 준비
        $data = [
            'post_id' => $post_id,
            'author_id' => $user_id,
            'content' => $content
        ];
    
        // 댓글 저장
        if ($this->CommentModel->create($data)) {
            // 댓글 저장 성공 시
            // 새로운 CSRF 토큰 갱신
            $new_csrf_hash = $this->security->get_csrf_hash();
            
            // 새 CSRF 토큰을 응답에 포함시켜 클라이언트로 반환
            echo json_encode([
                'status' => 'success',
                'new_csrf_token' => $new_csrf_hash
            ]);

            // redirect('/board/view_post/' . $post_id);
        } else {
            // 댓글 저장 실패 시
            show_error('댓글을 저장하는 데 실패했습니다.', 500);
        }
    }
    
}
