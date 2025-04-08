<div class="container">
    <h1><?= htmlspecialchars($post->title) ?></h1>
    <p>작성자: <?= htmlspecialchars($author->nickname) ?> | 작성일: <?= $post->created_at ?></p>
    <p>요약: <?= htmlspecialchars($post->summary) ?></p>
    <div class="content">
        <p><?= nl2br(htmlspecialchars($post->content)) ?></p>
    </div>

    <!-- 댓글 작성 -->
    <h2>댓글</h2>
    <form id="comment-form">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
        <textarea id="comment-content" name="content" placeholder="댓글을 작성해주세요" required></textarea>
        <button type="submit">댓글 작성</button>
    </form>

    <!-- 댓글 목록 -->
    <div id="comments-list"></div> <!-- 댓글을 비동기적으로 불러옵니다. -->

    <!-- 게시글 좋아요 -->
    <?php if ($is_liked): ?>
        <a href="<?= site_url('board/unlike_post/' . $post->id) ?>" class="btn btn-danger">좋아요 취소</a>
    <?php else: ?>
        <a href="<?= site_url('board/like_post/' . $post->id) ?>" class="btn btn-primary">좋아요</a>
    <?php endif; ?>
</div>

<!-- jQuery CDN 추가 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
 $(document).ready(function() {
    var postId = <?= $post->id ?>; // 게시글 ID

    // 페이지 로딩 시 댓글 불러오기
    loadComments(postId);

    // 댓글 불러오기 함수
    function loadComments(postId) {
        $.ajax({
            url: '<?= site_url('board/load_comments/') ?>' + postId,  // 댓글 API
            method: 'GET',
            success: function(response) {
                var comments = JSON.parse(response);
                var commentsHtml = '';
                
                comments.forEach(function(comment) {
                    commentsHtml += '<div class="comment">';
                    commentsHtml += '<p>' + comment.content + ' <small>- ' + comment.nickname + '</small></p>';
                    commentsHtml += '<small>' + comment.created_at + '</small>';
                    commentsHtml += '</div>';
                });

                $('#comments-list').html(commentsHtml);  // 댓글 목록 표시
            },
            error: function() {
                alert('댓글을 불러오는 데 실패했습니다.');
            }
        });
    }

    var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

    $('#comment-form').on('submit', function(e) {
        e.preventDefault(); // 기본 폼 제출 막기
        var content = $('#comment-content').val();

        // CSRF 토큰 가져오기
        var csrfName = '<?=$this->security->get_csrf_token_name();?>'; // 서버에서 사용하는 CSRF 토큰 이름

        if (content) {
            $.ajax({
                url: '<?= site_url('board/add_comment/' . $post->id) ?>',
                method: 'POST',
                data: {
                    content: content,
                    [csrfName]: csrfHash
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // XMLHttpRequest로 설정
                    'Content-Type': 'application/x-www-form-urlencoded'  // 올바른 Content-Type 설정
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    // 새 CSRF 토큰으로 갱신
                    csrfHash = data.new_csrf_token;
                    $('#comment-content').val('');  // 댓글 작성란 비우기
                    loadComments(postId);  // 댓글 목록 새로 고침
                },
                error: function() {
                    alert('댓글을 작성하는 데 실패했습니다.');
                }
            });
        } else {
            alert('댓글을 입력해 주세요.');
        }
    });
});
</script>
