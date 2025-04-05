<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'core/Secure_Controller.php');

class Account extends Secure_Controller {

  protected $block_if_logged_in = true;

  public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('UserModel');
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
      redirect('account');
    }

    //해당 세션 초기화
    $this->session->sess_regenerate(TRUE); 

    $this->session->set_userdata([
      'user_id' => $user->id,
      'nickname' => $user->nickname,
      'is_logged_in' => true,
      'role' => $user->role
    ]);

    redirect('main'); // 게시판 메인으로 이동
  }

  public function logout()
  {
      $this->session->sess_destroy();

      $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate');
      $this->output->set_header('Pragma: no-cache');
      $this->output->set_header('Expires: 0');
    
      redirect('/account');
      exit;
  }
}
