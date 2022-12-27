<h1>views/photos/index.php</h1>
<p>Showing <?= count($photos) ?> of <?= $total ?> results.</p>
<div>
  <?php if ($page > 1) echo "<a href=\"/photos?page=" . ($page - 1) . "\">Previous</a>" ?>
  Page: <?= $page ?>
  <?php if ($page * $pageSize < $total) echo "<a href=\"/photos?page=" . ($page + 1) . "\">Next</a>" ?>
</div>
<?php
foreach ($photos as $photo) {
  echo <<<HTML
<a href="/photos/{$photo->getId()}">
  <div>
    <p>Title: $photo->title</p>
    <p>Author: $photo->author</p>
    <img src="{$photo->getThumbnailPath()}"/>
  </div>
</a>
HTML;
}
?>
