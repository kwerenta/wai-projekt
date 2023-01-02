<h1><?= $photo->title ?></h1>
<h2><?= $photo->author ?></h2>
<img src="<?= $photo->getWatermarkPath() ?>" />
