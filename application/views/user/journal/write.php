<h2><?= $journal ? '하루기록 수정' : '하루기록 작성' ?></h2>

<form action="/journal/save/<?= $journal ? $journal->id : '' ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"value="<?= $this->security->get_csrf_hash(); ?>" />
    <input type="text" name="title" value="<?= $journal ? htmlspecialchars($journal->title) : '' ?>" placeholder="제목" required><br>
    <textarea name="content" placeholder="내용" required><?= $journal ? htmlspecialchars($journal->content) : '' ?></textarea><br>

    <select name="emotion">
        <option value="기쁨" <?= $journal && $journal->emotion == '기쁨' ? 'selected' : '' ?>>😊 기쁨</option>
        <option value="슬픔" <?= $journal && $journal->emotion == '슬픔' ? 'selected' : '' ?>>😢 슬픔</option>
        <option value="위로" <?= $journal && $journal->emotion == '위로' ? 'selected' : '' ?>>🌿 위로</option>
        <option value="자랑" <?= $journal && $journal->emotion == '자랑' ? 'selected' : '' ?>>🎉 자랑</option>
        <option value="이별" <?= $journal && $journal->emotion == '이별' ? 'selected' : '' ?>>🌈 이별</option>
    </select><br>

    <!-- 반려동물 선택 드롭다운 추가 -->
    <select name="pet_id">
        <option value="">🐾 반려동물 선택</option>
        <?php foreach ($pets as $pet): ?>
            <option value="<?= $pet->id ?>" <?= $pet->id == ($journal ? $journal->pet_id : '') ? 'selected' : '' ?>>
                <?= htmlspecialchars($pet->name) ?> (<?= htmlspecialchars($pet->species) ?>)
            </option>
        <?php endforeach; ?>
    </select><br>

    <input type="file" name="image" accept="image/*"><br>
    <button type="submit"><?= $journal ? '수정 저장' : '작성하기' ?></button>
</form>
