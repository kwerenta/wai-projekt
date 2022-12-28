<h1>views/photos/index.php</h1>
<p>Showing <?= count($photos) ?> of <?= $total ?> results.</p>
<div>
  <?php if ($page > 1) echo "<a href=\"/photos?page=" . ($page - 1) . "\">Previous</a>" ?>
  Page: <?= $page ?>
  <?php if ($page * $pageSize < $total) echo "<a href=\"/photos?page=" . ($page + 1) . "\">Next</a>" ?>
</div>
<form action="/favourites" method="POST">
  <?php foreach ($photos as $photo) : ?>
    <div>
      <p>Title: <?= $photo->title ?></p>
      <p>Author: <?= $photo->author ?></p>
      <input type="checkbox" name="favourite[]" value="<?= $photo->getId() ?>" <?= $photo->isFavourite() ? "checked disabled" : "" ?>>
      <a href="/photos/<?= $photo->getId() ?>">
        <img src="<?= $photo->getThumbnailPath() ?>" />
      </a>
    </div>
  <?php endforeach; ?>
  <button>Remember selected</button>
</form>
