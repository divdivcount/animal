<?php
require_once(APPPATH . 'core/Secure_Controller.php');

class Pet extends Secure_Controller {

  protected $require_login = true;

  public function __construct() {
    parent::__construct();
    $this->load->model('PetModel');
    $this->load->helper(['form', 'url']);
    $this->load->library('upload');
  }

  public function register() {
    $this->load->view('/user/common/header');
    $this->load->view('/user/pet/register');
    $this->load->view('/user/common/footer');
  }

  public function store(){
    $name     = $this->input->post('name', TRUE);
    $species  = $this->input->post('species', TRUE);
    $birth    = $this->input->post('birth', TRUE);
    $image_path = '';

      // 파일 업로드
    if (!empty($_FILES['image']['name'])) {

      $user_id = $this->user->id;  // 로그인한 사용자의 ID

      $upload_dir = $this->create_user_directory($user_id, 'pets');  // 사용자 폴더 생성

      $config['upload_path']   = $upload_dir;
      $config['allowed_types'] = 'jpg|jpeg|png|gif';
      $config['encrypt_name']  = TRUE;

      $this->load->library('upload');
      $this->upload->initialize($config);

      if ($this->upload->do_upload('image')) {
          $image_data = $this->upload->data();
          $image_path = '/uploads/users/'.$user_id . '/pets/' . $image_data['file_name'];

          // 이미지 리사이즈 및 압축 처리
          $resize_config = [
              'image_library' => 'gd2',
              'source_image'  => $image_data['full_path'],
              'maintain_ratio'=> TRUE,
              'width'         => 1200,
              'quality'       => '80%'
          ];
          $this->load->library('image_lib');
          $this->image_lib->initialize($resize_config);
          $this->image_lib->resize();
          $this->image_lib->clear();
      }
    }

      // DB 저장
      $this->PetModel->create([
          'user_id'    => $this->user->id,
          'name'       => $name,
          'species'    => $species,
          'birth'      => $birth,
          'image_path' => $image_path
      ]);

      redirect('/pet/list');
  }

  // 사용자 폴더 생성 함수 (pets, journals 구분)
  function create_user_directory($user_id, $type)
  {
      $user_dir = './uploads/users/' . $user_id . '/' . $type . '/';  // pets or journals 폴더
      if (!is_dir($user_dir)) {
          mkdir($user_dir, 0755, true);  // 권한 0777로 디렉토리 생성
      }
      return $user_dir;
  }

  public function list() {
    $pets = $this->PetModel->get_all_by_user($this->user->id);
    $this->load->view('user/common/header');
    $this->load->view('/user/pet/list', ['pets' => $pets]);
    $this->load->view('user/common/footer');
  }
}
