<div class="container">
    <h1><?= htmlspecialchars($post->title) ?></h1>
    <p>작성자: <?= htmlspecialchars($post->author_id) ?> | 작성일: <?= $post->created_at ?></p>
    <p>요약: <?= htmlspecialchars($post->summary) ?></p>
    <div class="content">
        <p><?= nl2br(htmlspecialchars($post->content)) ?></p>
    </div>

    <!-- 댓글 작성 -->
    <h2>댓글</h2>
    <form action="<?= site_url('/board/add_comment/' . $post->id) ?>" method="POST">
    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
        <textarea name="content" placeholder="댓글을 작성해주세요" required></textarea>
        <button type="submit">댓글 작성</button>
    </form>

    <!-- 댓글 목록 -->
    <?php if (!empty($post->comments)): ?>
        <div class="comments">
            <?php foreach ($post->comments as $comment): ?>
                <div class="comment">
                    <p><?= htmlspecialchars($comment->content) ?> <small>- <?= htmlspecialchars($comment->author_id) ?></small></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>댓글이 없습니다.</p>
    <?php endif; ?>

    <!-- 게시글 좋아요 -->
    <a href="<?= site_url('/board/like_post/' . $post->id) ?>">좋아요</a>
</div>
