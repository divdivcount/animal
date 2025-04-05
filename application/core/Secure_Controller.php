<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secure_Controller extends CI_Controller
{
    // 로그인 필수 여부 (기본: false)
    protected $require_login = false;

    // 로그인한 사용자는 이 페이지 접근 불가 (기본: false)
    protected $block_if_logged_in = false;

    // 로그인된 유저 정보 바인딩
    protected $user = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        // 🔐 보안 헤더 설정
        $this->output->set_header("X-Frame-Options: DENY");
        $this->output->set_header("X-XSS-Protection: 1; mode=block");
        $this->output->set_header("X-Content-Type-Options: nosniff");

        // ✅ 로그인 상태 바인딩
        if ($this->session->userdata('is_logged_in')) {
            $this->user = (object)[
                'id'       => $this->session->userdata('user_id'),
                'nickname' => $this->session->userdata('nickname'),
                'role'     => $this->session->userdata('role')
            ];
        }

        // ✅ 로그인 필수 기능일 경우
        if ($this->require_login && !$this->user) {
            redirect('/account'); // 로그인 페이지로 이동
            exit;
        }

        // ✅ 현재 메서드명 가져오기
        $current_method = $this->router->fetch_method();

        // ✅ 로그인한 사람은 차단되는 페이지이지만, logout 메서드는 예외
        if ($this->block_if_logged_in && $this->user && $current_method !== 'logout') {
            redirect('/main'); // 메인 페이지로 리디렉트
            exit;
        }
    }
}
