<?php

/**
 * @var string $name;
 */

?>

<h1>Elegancka Galeria Zdjęć</h1>
<p>Witaj, <?= $name ?></p>
<form method="POST" action="/photos" enctype="multipart/form-data">
  <input type="file" name="photo" accept="image/jpeg,image/png">
  <button>Submit</button>
</form>
