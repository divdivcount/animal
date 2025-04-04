<body class="bg-light">
  <div class="container mt-5" style="max-width: 500px;">
    <h3 class="text-center mb-4">회원가입</h3>

    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= site_url('/member/registerTreatment') ?>">
      <div class="mb-3">
        <label for="email">이메일</label>
        <input type="email" class="form-control" name="email" required>
      </div>

      <div class="mb-3">
        <label for="nickname">닉네임</label>
        <input type="text" class="form-control" id="nickname" name="nickname" required>
        <small id="nickname-feedback" class="form-text text-muted"></small>
      </div>

      <div class="mb-3">
        <label for="password">비밀번호</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <div class="mb-3">
        <label for="password_confirm">비밀번호 확인</label>
        <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
        <small id="password-feedback" class="form-text text-muted"></small>
      </div>

      <button class="btn btn-primary w-100">가입하기</button>
    </form>

    <div class="text-center mt-3">
      <a href="<?= site_url('account') ?>">이미 계정이 있으신가요?</a>
    </div>
  </div>
</body>
<script src="<?= base_url('/assets/js/registerCheck.js') ?>"></script>
