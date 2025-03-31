<link href="/assets/css/member_login.css" rel="stylesheet">
<body class="bg-light">
  <div class="container mt-5" style="max-width: 400px;">
    <h3 class="text-center mb-4">로그인</h3>

    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger">
        <?= $this->session->flashdata('error') ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?= site_url('auth/login') ?>">
      <div class="mb-3">
        <label for="email">이메일</label>
        <input type="email" class="form-control" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password">비밀번호</label>
        <input type="password" class="form-control" name="password" required>
      </div>
      <button class="btn btn-primary w-100">로그인</button>
    </form>

    <div class="d-flex justify-content-center mt-2 mb-3 text-center small login-links">
      <a href="<?= site_url('auth/find_id') ?>">아이디 찾기</a>
      <span>|</span>
      <a href="<?= site_url('auth/reset_password') ?>">비밀번호 재발급</a>
      <span>|</span>
      <a href="<?= site_url('auth/register') ?>">회원가입</a>
    </div>


    <hr class="my-4">

    <div class="text-center mb-2">소셜 계정으로 간편 로그인</div>
    <div class="d-flex justify-content-between mt-2 mb-3 text-center small">
      <a href="<?= site_url('auth/kakao') ?>">
        <img src="/assets/images/kakao_logo.png" class="sns-icon">
      </a>
      <a href="<?= site_url('auth/naver') ?>">
        <img src="/assets/images/naver_logo.png" class="sns-icon">
      </a>
      <a href="<?= site_url('auth/google') ?>">
        <img src="/assets/images/google_logo.png" class="sns-icon">
      </a>
    </div>
    
  </div>
</body>