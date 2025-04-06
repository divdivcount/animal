<div class="container">
    <h1>게시글 작성</h1>

    <form action="<?= site_url('/board/store_post') ?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
        <label for="title">제목</label>
        <input type="text" name="title" id="title" required>

        <label for="summary">요약</label>
        <textarea name="summary" id="summary"></textarea>

        <label for="content">내용</label>
        <textarea name="content" id="content" required></textarea>

        <label for="categories">카테고리</label>
        <select name="categories[]" id="categories" multiple>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">게시글 작성</button>
    </form>
</div>
