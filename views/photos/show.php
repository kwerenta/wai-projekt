<h1>views/photos/show.php</h1>
<div>Title: <?= $photo->title ?></div>
<img src="<?= $photo->getWatermarkPath() ?>" />
