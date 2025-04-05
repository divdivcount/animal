<h2>🐶 등록된 반려동물</h2>

<?php if (empty($pets)): ?>
  <p>등록된 반려동물이 없습니다.</p>
  <a href="/pet/register">반려동물 등록하기</a>
<?php else: ?>
  <div style="display: flex; flex-wrap: wrap; gap: 20px;">
    <?php foreach ($pets as $pet): ?>
      <div style="border: 1px solid #ccc; border-radius: 12px; padding: 16px; width: 220px;">
        <?php if ($pet->image_path): ?>
          <img src="<?= $pet->image_path ?>" alt="펫 사진" style="width: 100%; border-radius: 8px;">
        <?php else: ?>
          <div style="width: 100%; height: 120px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">사진 없음</div>
        <?php endif; ?>

        <h3 style="margin-top: 10px;"><?= htmlspecialchars($pet->name) ?></h3>
        <p>종: <?= htmlspecialchars($pet->species) ?></p>
        <p>생일: <?= $pet->birth ? htmlspecialchars($pet->birth) : '정보 없음' ?></p>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

