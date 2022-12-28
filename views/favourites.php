<h1>Favourites</h1>
<?php if (count($photos) === 0) : ?>
  <p>You don't have any favorite photos.</p>
<?php else : ?>
  <form action="/favourites" method="POST">
    <input type="hidden" name="_method" value="DELETE">
    <?php foreach ($photos as $photo) : ?>
      <div>
        <p>Title: <?= $photo->title ?></p>
        <p>Author: <?= $photo->author ?></p>
        <input type="checkbox" name="unfavourite[]" value="<?= $photo->getId() ?>">
        <img src="<?= $photo->getThumbnailPath() ?>" />
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
  <button>Remove selected</button>
  </form>
