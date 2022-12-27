<h1>Formula One Gallery</h1>
<?php
if (isset($_SESSION['errors'])) {
  foreach ($_SESSION["errors"] as $error) {
    echo "<p>$error</p>";
  }
  unset($_SESSION['errors']);
}
if (isset($_SESSION["user"]))
  echo $_SESSION["user"];
?>
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
    <input type="text" name="author">
  </div>
  <div>
    <label for="watermark">Watermark</label>
    <input type="text" name="watermark">
  </div>
  <button>Submit</button>
</form>
