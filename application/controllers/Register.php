<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->model('UserModel');
        $this->load->library('session');
    }

	public function index()
	{
        $this->load->view('/user/common/header');
		$this->load->view('/user/auth/register');
        $this->load->view('/user/common/footer');
	}

    public function registerTreatment() {
        $this->load->library('session');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $this->input->post('email');
            $nickname = $this->input->post('nickname');
            $password = $this->input->post('password');
            $password_confirm = $this->input->post('password_confirm');
    
            // 기본 검증
            if ($password !== $password_confirm) {
                $this->session->set_flashdata('error', '비밀번호가 일치하지 않습니다.');
                redirect('register');
            }
    
            if ($this->UserModel->exists_by_email($email)) {
                $this->session->set_flashdata('error', '이미 가입된 이메일입니다.');
                redirect('register');
            }

            if ($this->User_model->get_by_nickname($nickname)) {
                $this->session->set_flashdata('error', '이미 사용 중인 닉네임입니다.');
                redirect('auth/register');
            }
    
            // 비밀번호 해싱
            $hashed = password_hash($password, PASSWORD_BCRYPT);
    
            $this->UserModel->create([
                'email' => $email,
                'nickname' => $nickname,
                'password' => $hashed,
                'login_type' => 'local',
                'role' => 'user',
                'status' => 'active'
            ]);
    
            $this->session->set_flashdata('success', '회원가입이 완료되었습니다. 로그인 해주세요!');
            redirect('login');
        } else {
            $this->load->view('register');
        }
    }

    public function check_nickname()
    {
        $nickname = $this->input->post('nickname');
        $exists = $this->UserModel->get_by_nickname($nickname);

        echo json_encode(['exists' => $exists ? true : false]);
    }

}
