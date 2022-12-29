<?php

namespace app\controllers;

use app\controllers\ApplicationController;
use app\models\Photo;

class SearchController extends ApplicationController
{
  public function index()
  {
    if (empty($_GET["query"])) {
      $this->view->setName("search");
      return;
    }

    $photos = Photo::search($_GET["query"]);

    $output = "";

    foreach ($photos as $photo) : ?>
      <div>
        <p>Title: <?= $photo->title ?> <?php if ($photo->privateOwner !== null) echo "(private)" ?></p>
        <p>Author: <?= $photo->author ?></p>
        <input type="checkbox" name="favourite[]" value="<?= $photo->getId() ?>" <?= $photo->isFavourite() ? "checked disabled" : "" ?>>
        <a href="/photos/<?= $photo->getId() ?>">
          <img src="<?= $photo->getThumbnailPath() ?>" />
        </a>
      </div>
<?php endforeach;

    echo $output;
    exit;
  }
}
