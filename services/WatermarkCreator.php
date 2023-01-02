<?php

namespace app\services;

class WatermarkCreator
{
  public static function call($image, $name)
  {
    $font = ROOT_PATH . "/static/fonts/Poppins-Regular.ttf";

    $watermarkBox = imagettfbbox(16, 0, $font, $_POST["watermark"]);
    $watermarkX = $watermarkBox[2] - $watermarkBox[0];
    $watermarkY = $watermarkBox[3] - $watermarkBox[5];

    $watermark = imagecreatetruecolor($watermarkX + 16, $watermarkY + 16);
    imagefilledrectangle($watermark, 0, 0, $watermarkX + 16, $watermarkY + 16, 0xFFFFFF);
    imagettftext($watermark, 16, 0, 8, $watermarkY + 8, 0x000000, $font, $_POST["watermark"]);

    imagecopymerge($image, $watermark, (imagesx($image) - imagesx($watermark) - 16) / 2, (imagesy($image) - imagesy($watermark) - 16) / 2, 0, 0, $watermarkX + 16, $watermarkY + 16, 50);
    imagepng($image, IMAGES_PATH . "watermark_" . basename($name));

    imagedestroy($image);
    imagedestroy($watermark);
  }
}
