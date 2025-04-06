<!-- edit.php -->
<h2>반려동물 수정</h2>

<form action="/pet/update/<?= $pet->id ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"value="<?= $this->security->get_csrf_hash(); ?>" />
    <label for="name">이름</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($pet->name) ?>" required>

    <label for="species">종</label>
    <input type="text" id="species" name="species" value="<?= htmlspecialchars($pet->species) ?>" required>

    <label for="birth">생일</label>
    <input type="date" id="birth" name="birth" value="<?= $pet->birth ?>" required>

    <label for="image">사진</label>
    <input type="file" id="image" name="image">

    <!-- 현재 이미지 미리보기 -->
    <?php if ($pet->image_path): ?>
        <div>
            <img src="<?= base_url($pet->image_path) ?>" alt="현재 반려동물 이미지" style="width: 100px; height: auto; border-radius: 8px;">
        </div>
    <?php else: ?>
        <p>현재 등록된 사진이 없습니다.</p>
    <?php endif; ?>

    <button type="submit">수정 저장</button>
</form>
