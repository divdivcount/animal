# 달숨기록

**기능 명세**

◼ 홈 화면
- 이야기 문구
- 오늘의 포스팅
- 가상 반려동물 명목 작성
- 내 기록/추억/커뮤니티 지도 버튼

◼ 하루 기록 (Journal)

- 날짜 자동 포함
- 사진 업로드 (5장 가능)
- 텍스트 작성
- 감정 태그 선택
- 해시태그 입력
- 공개정보: 내가보기 / 개발
- 반려동물 선택
  
◼ 추억 보관함
- 날짜/감정/반려동물 보기 필터
- 중요 기록 저장 (예: 즐겨찾기, 스크랩 기능)
- 자주 보는 기록은 '최중아픈 것으로' 표시
  
◼ 감정 커뮤니티
- 카테고리: 이별/귀여운 자랑/죄책감/공개하고 싶은 순간
- 그리고/들어오기/검색 가능
- 댓글, 좋아요, 리액션 기능 (공감 이모티콘 등)
- 꼭 마음 기능 (감정 저장)
- 익명 가능
  
◼ 반려동물 프로필
- 이름, 종, 생일, 입양일
- 반응 여러가지 (ex. 좋아하는 것, 피해 유형)
- 사진 검색 / 기본 검간
- 기념일 등록 및 보관

3. 패스쿠널 / 기술 요구

| 패턴 | 설명 |
|-----------|------|
| Backend | CodeIgniter 3, PHP, MySQL |
| Frontend | HTML/CSS/JS + Bootstrap or Tailwind |
| File Storage | AWS S3 or local /uploads |
| Image 처리 | 리사이징 + JSON 배열 형태 저장 |
| 커뮤니티 | Flarum 연동 or 자체 게시판 시스템 |
| 인증 시스템 | 세션 로그인 기반 + 이메일 인증 |
| 알림 | 크론 기반 기념일 알림 or 브라우저 푸시 API |

4. MVP 개발 정보

| 주차 | 작업 |
|--------|------|
| 1주차 | 기획 + DB 설계 |
| 2-3주차 | 회원가입/포스팅/기록 기능 개발 |
| 4주차 | 커뮤니티 / 보관함 개발 |
| 5주차 | 기본 UI 적용 + 테스트 |
| 6주차 | 런치 준비 + SNS 공유 마케팅 작성 |
