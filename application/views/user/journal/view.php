<h2><?= htmlspecialchars($journal->title) ?></h2>

<!-- 반려동물 정보 표시 -->
<?php if ($pet): ?>
    <h3>반려동물: <?= htmlspecialchars($pet->name) ?> (<?= htmlspecialchars($pet->species) ?>)</h3>
<?php endif; ?>

<!-- 감정 표시 -->
<p><strong>감정:</strong> <?= htmlspecialchars($journal->emotion) ?></p>

<!-- 하루기록 내용 -->
<p><strong>내용:</strong></p>
<p><?= nl2br(htmlspecialchars($journal->content)) ?></p>

<!-- 이미지 표시 (이미지 경로는 상대경로로 저장되었으므로 그에 맞는 경로 표시) -->
<?php if ($journal->image_path): ?>
    <h4>이미지</h4>
    <img src="<?= base_url($journal->image_path) ?>" alt="이미지" style="max-width: 100%; height: auto;">
<?php endif; ?>

<!-- 작성 일자 -->
<p><strong>작성일:</strong> <?= date('Y-m-d H:i', strtotime($journal->created_at)) ?></p>

<!-- 수정/삭제 기능 추가 가능 -->
<a href="/journal/write/<?= $journal->id ?>">수정</a> |
<a href="/journal/delete/<?= $journal->id ?>">삭제</a>

