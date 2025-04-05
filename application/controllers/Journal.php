<?php
require_once(APPPATH . 'core/Secure_Controller.php');

class Journal extends Secure_Controller
{
  protected $require_login = true;

  public function __construct()
  {
    parent::__construct();
    $this->load->model('JournalModel');
    $this->load->model('PetModel');
    $this->load->helper(['form', 'url']);
    $this->load->library('upload');
  }

  public function write($id = NULL)
  {
      // 수정일 경우 해당 기록을 가져오기
      if ($id) {
          $journal = $this->JournalModel->get_by_id($id);
          if (!$journal) {
              show_404();
          }
          $pet = $this->PetModel->get_by_id($journal->pet_id);
      } else {
          // 새로 작성하는 경우
          $journal = NULL;
          $pet = NULL;
      }
  
      // 반려동물 목록 가져오기
      $pets = $this->PetModel->get_all_by_user($this->user->id);
  
      // 뷰로 데이터 전달
      $this->load->view('user/common/header');
      $this->load->view('user/journal/write', [
          'journal' => $journal,
          'pet' => $pet,
          'pets' => $pets
      ]);
      $this->load->view('user/common/footer');
  }

  public function list()
  {
      $this->require_login = true; // 로그인 필수

      // 사용자 기록 목록 가져오기
      $journals = $this->JournalModel->get_all_by_user($this->user->id);

      // 뷰로 전달
      $this->load->view('user/common/header');
      $this->load->view('user/journal/list', [
          'journals' => $journals
      ]);
      $this->load->view('user/common/footer');
  }

  public function store() {

    $title = $this->input->post('title', TRUE);
    $content = $this->input->post('content', TRUE);
    $emotion = $this->input->post('emotion', TRUE);
    $pet_id = $this->input->post('pet_id');  // 반려동물 선택
    $image_path = '';  // 기본 이미지 경로 초기화
    $user_id = $this->user->id;

    // 파일 업로드
    if (!empty($_FILES['image']['name'])) {

      $upload_dir = $this->create_user_directory($user_id, 'journals');  // journals 폴더

      $config['upload_path']   = $upload_dir;
      $config['allowed_types'] = 'jpg|jpeg|png|gif';
      $config['encrypt_name']  = TRUE;

      $this->load->library('upload');
      $this->upload->initialize($config);

      if ($this->upload->do_upload('image')) {
          $image_data = $this->upload->data();
          $image_path = '/uploads/users/'.$user_id . '/journals/' . $image_data['file_name'];

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
    $this->JournalModel->create([
        'user_id'   => $this->user->id,
        'pet_id'    => $pet_id,
        'title'     => $title,
        'content'   => $content,
        'emotion'   => $emotion,
        'image_path'=> $image_path
    ]);

    redirect('/journal/list');
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

  public function view($id)
  {
      // 로그인 필수
      $this->require_login = true;

      // 해당 기록 정보 가져오기
      $journal = $this->JournalModel->get_by_id($id);

      // 해당 기록이 존재하지 않으면 404 에러 페이지로 리디렉션
      if (!$journal) {
          show_404();
      }

      // 해당 기록에 연관된 반려동물 정보도 가져오기
      $pet = $this->PetModel->get_by_id($journal->pet_id);

      // 뷰로 데이터 전달

      $this->load->view('user/common/header');
      $this->load->view('user/journal/view', [
          'journal' => $journal,
          'pet'     => $pet
      ]);
      $this->load->view('user/common/footer');
  }

  // 하루기록 저장(새로 작성 또는 수정)
  public function save($id = NULL) {
    // 로그인 필수
    $this->require_login = true;

    // 입력된 데이터 받기
    $title = $this->input->post('title', TRUE);
    $content = $this->input->post('content', TRUE);
    $emotion = $this->input->post('emotion', TRUE);
    $pet_id = $this->input->post('pet_id');  // 반려동물 선택
    $image_path = '';  // 기본 이미지 경로 초기화

    // 기존 이미지 파일 경로 (수정할 때 삭제)
    $old_image_path = '';

    // 수정일 경우 기존 데이터 불러오기
    if ($id) {
        $journal = $this->JournalModel->get_by_id($id);
        if (!$journal) {
            show_404();
        }
        // 기존 이미지 경로 저장
        $old_image_path = $journal->image_path;
    }

    // 이미지 업로드 및 처리
    if (!empty($_FILES['image']['name'])) {
        $config['upload_path'] = './uploads/users/' . $this->user->id . '/journals/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload('image')) {
            $image_data = $this->upload->data();
            $image_path = '/uploads/users/' . $this->user->id . '/journals/' . $image_data['file_name'];

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
    } else {
        // 이미지가 없으면 기존 이미지를 그대로 사용
        $image_path = $old_image_path;
    }

    // 데이터 저장(새로 작성 또는 수정)
    $data = [
        'user_id'   => $this->user->id,
        'pet_id'    => $pet_id,
        'title'     => $title,
        'content'   => $content,
        'emotion'   => $emotion,
        'image_path'=> $image_path
    ];

    if ($id) {
        // 수정일 경우
        // 기존 이미지 삭제
        if ($old_image_path && file_exists('.' . $old_image_path)) {
            unlink('.' . $old_image_path);  // 기존 이미지 삭제
        }

        $this->JournalModel->update($id, $data);
    } else {
        // 새로 작성일 경우
        $this->JournalModel->create($data);
    }

    // 기록 후 리스트 페이지로 리디렉션
    redirect('/journal/list');
  }

  public function delete($id){
    // 로그인 필수
    $this->require_login = true;

    // 해당 기록 정보 가져오기
    $journal = $this->JournalModel->get_by_id($id);

    // 해당 기록이 존재하지 않으면 404 에러 페이지로 리디렉션
    if (!$journal) {
        show_404();
    }

    // 이미지 파일 삭제 (해당 파일이 존재하면 삭제)
    if ($journal->image_path) {
        $file_path = '.' . $journal->image_path;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // DB에서 해당 하루기록 삭제
    $this->JournalModel->delete($id);

    // 삭제 후 리스트 페이지로 리디렉션
    redirect('/journal/list');
  }
}
