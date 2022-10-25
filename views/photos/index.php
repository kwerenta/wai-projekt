<?php

use app\Application;

?>
<h1>views/photos/index.php</h1>
<a href="<?= Application::$app->router->getPath('show_photo', ["id" => 5]) ?>">Photo 5</a>