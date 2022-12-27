<?php

use app\Application;

?>
<h1>views/photos/index.php</h1>
<a href="<?= Application::$app->router->getPath('show_photo', ["id" => 5]) ?>">Photo 5</a>
<?php
foreach ($photos as $photo) {
  echo "<img src='{$photo->getThumbnailPath()}' />";
}
?>
