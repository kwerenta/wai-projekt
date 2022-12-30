<h1>Formula One Gallery</h1>
<?php app\Helper::showErrors(); ?>
<form method="POST" action="/photos" enctype="multipart/form-data">
  <div class="form-container">
    <div class="input-group">
      <label for="photo">Photo</label>
      <input type="file" name="photo" id="photo" accept="image/jpeg,image/png" required>
    </div>
    <div class="input-group">
      <label for="title">Title</label>
      <input type="text" name="title" id="title" required>
    </div>
    <div class="input-group">
      <label for="author">Author</label>
      <input type="text" name="author" id="author" <?= (app\Helper::isLoggedIn() ? "value=\"" . app\Session::user()->login . "\" disabled" : "required") ?>>
    </div>
    <div class="input-group">
      <label for="watermark">Watermark</label>
      <input type="text" name="watermark" id="watermark" required>
    </div>
    <?php if (app\Helper::isLoggedIn()) : ?>
      <div class="radio-group">
        <label>Public <input type="radio" name="isPrivate" value="false" checked></label>
        <label>Private <input type="radio" name="isPrivate" value="true"></label>
      </div>
    <?php endif; ?>
    <button>Submit</button>
  </div>
</form>
