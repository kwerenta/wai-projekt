<?php

namespace app\services;

class ThumbnailCreator
{
  public static function call($image, $fileName)
  {
    $thumbnail = imagescale($image, 200, 125);
    imagepng($thumbnail, IMAGES_PATH . "thumbnail_" . $fileName);
    imagedestroy($thumbnail);
  }
}
