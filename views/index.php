<h1>Formula One Gallery</h1>
<?php app\Helper::showErrors(); ?>
<form method="POST" action="/photos" enctype="multipart/form-data">
  <div>
    <label for="photo">Photo</label>
    <input type="file" name="photo" accept="image/jpeg,image/png">
  </div>
  <div>
    <label for="title">Title</label>
    <input type="text" name="title">
  </div>
  <div>
    <label for="author">Author</label>
    <input type="text" name="author" <?= (app\Helper::isLoggedIn() ? "value=\"" . app\Session::user()->login . "\" disabled" : "") ?>>
  </div>
  <div>
    <label for="watermark">Watermark</label>
    <input type="text" name="watermark">
  </div>
  <?php if (app\Helper::isLoggedIn()) : ?>
    <div>
      Public <input type="radio" name="isPrivate" value="false" checked>
      Private <input type="radio" name="isPrivate" value="true">
    </div>
  <?php endif; ?>
  <button>Submit</button>
</form>
