<link rel="stylesheet" href="/assets/css/main.css">
<body>
    <header>
        <div class="logo">
            <h1>달숨기록</h1>
        </div>
        <nav>
            <ul>
                <li><a href="/journal/write">하루기록 작성</a></li>
                <li><a href="/pet/list">반려동물 관리</a></li>
                <li><a href="/settings">설정</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <!-- 반려동물 목록 -->
        <section class="pets">
            <h2>나의 반려동물</h2>
            <div class="pet-cards">
                <div class="pet-card">
                    <img src="/path/to/pet-image.jpg" alt="반려동물 이름">
                    <h3>반려동물 이름</h3>
                    <p>종: 고양이</p>
                </div>
                <div class="pet-card">
                    <img src="/path/to/pet-image2.jpg" alt="반려동물 이름">
                    <h3>반려동물 이름</h3>
                    <p>종: 강아지</p>
                </div>
                <div class="pet-card add-new">
                    <a href="/pet/create">
                        <p>새 반려동물 추가하기</p>
                    </a>
                </div>
            </div>
        </section>

        <!-- 최근 하루기록 -->
        <section class="recent-records">
            <h2>최근 하루기록</h2>
            <div class="journal-cards">
                <div class="journal-card">
                    <img src="/path/to/journal-image.jpg" alt="하루기록 이미지">
                    <h3>기록 제목</h3>
                    <p>감정: 기쁨</p>
                    <a href="/journal/view/1">자세히 보기</a>
                </div>
                <div class="journal-card">
                    <img src="/path/to/journal-image2.jpg" alt="하루기록 이미지">
                    <h3>기록 제목</h3>
                    <p>감정: 슬픔</p>
                    <a href="/journal/view/2">자세히 보기</a>
                </div>
            </div>
        </section>
    </main>
</body>
