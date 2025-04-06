<div class="container">
    <h1>게시글 목록</h1>

    <a href="<?= site_url('/board/create_post') ?>">새 게시글 작성</a>

    <?php if (!empty($posts)): ?>
        <div class="post-list">
            <?php foreach ($posts as $post): ?>
                <div class="post-item">
                    <h2><a href="<?= site_url('/board/view_post/' . $post->id) ?>"><?= htmlspecialchars($post->title) ?></a></h2>
                    <p>작성자: <?= htmlspecialchars($post->author_id) ?> | 작성일: <?= $post->created_at ?></p>
                    <p><?= htmlspecialchars($post->summary) ?></p>
                    <a href="<?= site_url('/board/view_post/' . $post->id) ?>">상세보기</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>등록된 게시글이 없습니다.</p>
    <?php endif; ?>
</div>
