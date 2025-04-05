<form action="/pet/store" method="post" enctype="multipart/form-data">
  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"value="<?= $this->security->get_csrf_hash(); ?>" />
  <input type="text" name="name" placeholder="이름" required><br>
  <input type="text" name="species" placeholder="종 (ex: 강아지, 고양이)" required><br>
  <input type="date" name="birth"><br>
  <input type="file" name="image" accept="image/*"><br>
  <img id="imagePreview" src="#" alt="미리보기" style="display:none; max-width: 300px; margin-top:10px; border-radius: 8px;" />
  <button type="submit">등록하기</button>
</form>
<script>
function previewImage(input) {
  const preview = document.getElementById('imagePreview');
  const file = input.files[0];

  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
    }
    reader.readAsDataURL(file);
  } else {
    preview.src = '#';
    preview.style.display = 'none';
  }
}
</script>