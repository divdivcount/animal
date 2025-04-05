<h2>하루기록 목록</h2>

<?php if (empty($journals)): ?>
    <p>아직 기록이 없습니다. 기록을 작성해 주세요!</p>
    <a href="/journal/write">하루기록 작성하기</a>
<?php else: ?>
    <ul>
    <?php foreach ($journals as $journal): ?>
        <li>
            <h3><?= htmlspecialchars($journal->title) ?></h3>
            <p>감정: <?= htmlspecialchars($journal->emotion) ?></p>
            <p>날짜: <?= $journal->created_at ?></p>
            <a href="/journal/view/<?= $journal->id ?>">자세히 보기</a>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
