<?php
/**
 * @var string $name;
 */

use app\Application;

?>

<h1>Elegancka Galeria Zdjęć</h1>
<p>Witaj, <?= $name ?></p>
<a href="<?= Application::$app->router->getPath("index_photos") ?>">Photos</a>
