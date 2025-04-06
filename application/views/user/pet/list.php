<h2>🐶 등록된 반려동물</h2>

<?php if (empty($pets)): ?>
  <p>등록된 반려동물이 없습니다.</p>
  <a href="/pet/register" style="color: #4CAF50; text-decoration: none;">반려동물 등록하기</a>
<?php else: ?>
  <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: space-around;">
    <?php foreach ($pets as $pet): ?>
      <div style="border: 1px solid #ccc; border-radius: 12px; padding: 16px; width: 220px; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        
        <!-- 반려동물 사진 -->
        <?php if ($pet->image_path): ?>
          <img src="<?= base_url($pet->image_path) ?>" alt="펫 사진" style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px;">
        <?php else: ?>
          <div style="width: 100%; height: 120px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; color: #777;">
            사진 없음
          </div>
        <?php endif; ?>

        <!-- 반려동물 이름, 종, 생일 -->
        <h3 style="margin-top: 10px; font-size: 18px; color: #333;"><?= htmlspecialchars($pet->name) ?></h3>
        <p style="font-size: 14px; color: #555;">종: <?= htmlspecialchars($pet->species) ?></p>
        <p style="font-size: 14px; color: #555;">생일: <?= $pet->birth ? htmlspecialchars($pet->birth) : '정보 없음' ?></p>

        <!-- 수정 및 삭제 버튼 -->
        <div style="margin-top: 10px; text-align: center;">
          <a href="/pet/edit/<?= $pet->id ?>" style="color: #4CAF50; text-decoration: none; font-weight: bold;">수정</a> |
          <a href="/pet/delete/<?= $pet->id ?>" style="color: #f44336; text-decoration: none; font-weight: bold;" onclick="return confirm('정말 삭제하시겠습니까?');">삭제</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>