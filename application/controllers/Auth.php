<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('UserModel');
    $this->load->library('session');
  }

  public function index() {
    $this->load->view('/user/common/header');
    $this->load->view('/user/auth/login');
    $this->load->view('/user/common/footer');
  }

  public function login() {
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    $user = $this->UserModel->get_by_email($email);

    if (!$user || !password_verify($password, $user->password)) {
      $this->session->set_flashdata('error', '이메일 또는 비밀번호가 올바르지 않습니다.');
      redirect('auth');
    }

    $this->session->set_userdata([
      'user_id' => $user->id,
      'nickname' => $user->nickname,
      'is_logged_in' => true,
      'role' => $user->role
    ]);

    redirect('main'); // 게시판 메인으로 이동
  }

  public function logout() {
    $this->session->sess_destroy();
    redirect('auth');
  }
}
