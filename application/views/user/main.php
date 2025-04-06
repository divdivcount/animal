<div class="container">
    <div class="header">
        <?php if ($user): ?>
            <h1>환영합니다, <?= htmlspecialchars($user->nickname) ?>님!</h1>
        <?php else: ?>
            <h1>환영합니다! 로그인 해주세요.</h1>
            <a href="<?= site_url('account') ?>" class="btn-login">로그인</a>
        <?php endif; ?>
    </div>

    <div class="post-section">
        <h2>최근 게시글</h2>

        <?php if (!empty($posts)): ?>
            <div class="post-list">
                <?php foreach ($posts as $post): ?>
                    <div class="post-item">
                        <h3><a href="<?= site_url('/board/view_post/' . $post->id) ?>"><?= htmlspecialchars($post->title) ?></a></h3>
                        <p>작성자: <?= htmlspecialchars($post->author_id) ?> | 작성일: <?= $post->created_at ?></p>
                        <p><?= htmlspecialchars($post->summary) ?></p>
                        <a href="<?= site_url('/board/view_post/' . $post->id) ?>" class="btn-view">상세보기</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>현재 게시글이 없습니다.</p>
        <?php endif; ?>
    </div>

    <?php if ($user): ?>
        <div class="create-post-section">
            <a href="<?= site_url('/board/create_post') ?>" class="btn-create-post">새 게시글 작성</a>
        </div>
    <?php endif; ?>
</div>

<!-- 스타일 (CSS) -->
<style>
    .container {
        width: 80%;
        margin: 0 auto;
        font-family: 'Arial', sans-serif;
    }

    .header {
        text-align: center;
        margin: 40px 0;
    }

    h1 {
        font-size: 2rem;
        color: #333;
    }

    .btn-login {
        display: inline-block;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 20px;
    }

    .btn-login:hover {
        background-color: #45a049;
    }

    .post-section {
        margin-top: 40px;
    }

    .post-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .post-item {
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    .post-item h3 {
        font-size: 1.5rem;
        margin: 0;
    }

    .btn-view {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 16px;
        background-color: #007BFF;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }

    .btn-view:hover {
        background-color: #0056b3;
    }

    .create-post-section {
        margin-top: 40px;
        text-align: center;
    }

    .btn-create-post {
        display: inline-block;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
    }

    .btn-create-post:hover {
        background-color: #45a049;
    }
</style>
