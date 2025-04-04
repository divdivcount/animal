const nicknameInput = document.getElementById('nickname');
const nicknameFeedback = document.getElementById('nickname-feedback');

nicknameInput.addEventListener('blur', function () {
const nickname = nicknameInput.value;

if (nickname.length > 0) {
    fetch("/member/check_nickname", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "nickname=" + encodeURIComponent(nickname)
    })
    .then(res => res.json())
    .then(data => {
    if (data.exists) {
        nicknameFeedback.textContent = "이미 사용 중인 닉네임입니다.";
        nicknameFeedback.className = "form-text text-danger";
    } else {
        nicknameFeedback.textContent = "사용 가능한 닉네임입니다.";
        nicknameFeedback.className = "form-text text-success";
    }
    });
} else {
    nicknameFeedback.textContent = "";
}
});

// 비밀번호 일치 여부 확인
const pw = document.getElementById('password');
const pwConfirm = document.getElementById('password_confirm');
const pwFeedback = document.getElementById('password-feedback');

function checkPasswordMatch() {
if (pw.value && pwConfirm.value) {
    if (pw.value === pwConfirm.value) {
    pwFeedback.textContent = "비밀번호가 일치합니다.";
    pwFeedback.className = "form-text text-success";
    } else {
    pwFeedback.textContent = "비밀번호가 일치하지 않습니다.";
    pwFeedback.className = "form-text text-danger";
    }
} else {
    pwFeedback.textContent = "";
}
}

pw.addEventListener('input', checkPasswordMatch);
pwConfirm.addEventListener('input', checkPasswordMatch);
