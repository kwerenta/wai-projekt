<?php

namespace app\controllers\photos;

use app\controllers\ApplicationController;
use app\models\Photo;
use app\Helper;

class PhotosController extends ApplicationController
{
	public function index()
	{
		$page = intval($_GET["page"] ?? 1);
		if ($page <= 0) $page = 1;

		$photos = Photo::page($page);
		$this->view->addData(["photos" => $photos, "page" => $page, "total" => Photo::count(), "pageSize" => Photo::PAGE_SIZE]);
	}

	public function show()
	{
		$photo = Photo::find($this->params["id"]);
		$this->view->addData(["photo" => $photo]);
	}

	public function create()
	{
		$file = $_FILES["photo"];

		if ($file["error"] !== 0) {
			$_SESSION["errors"][] = "File wasn't uploaded correctly.";
			header("Location: /");
			return;
		}

		if (filesize($file["tmp_name"]) > 1000000) {
			$_SESSION["errors"][] = "Max file size is 1MB.";
		}

		$mimeType = mime_content_type($file["tmp_name"]);
		$image = NULL;
		$extension = ".";
		if ($mimeType === "image/jpeg") {
			$image = imagecreatefromjpeg($file["tmp_name"]);
			$extension .= "jpg";
		} else if ($mimeType === "image/png") {
			$image = imagecreatefrompng($file["tmp_name"]);
			$extension .= "png";
		} else {
			$_SESSION["errors"][] = "Invalid File type.";
		}

		if (isset($_SESSION["errors"]) || !$image) {
			header("Location: /");
			return;
		};

		$fileName =  uniqid() . time() . $extension;
		$targetPath = IMAGES_PATH . $fileName;

		$thumbnail = imagescale($image, 200, 125);
		imagepng($thumbnail, IMAGES_PATH . "thumbnail_" . $fileName);
		imagedestroy($thumbnail);

		$this->createWatermark($image, $fileName);

		$author = Helper::isLoggedIn() ? $_SESSION["user"]->login : $_POST["author"];
		$privateOwner = Helper::isLoggedIn() && isset($_POST["isPrivate"]) && $_POST["isPrivate"] === "true" ? $_SESSION["user"]->getId() : null;
		$photo = new Photo($_POST["title"], $fileName, $author, $privateOwner);
		$photo->save();

		move_uploaded_file($file["tmp_name"], $targetPath);
		header("Location: /photos");
	}

	private function createWatermark($image, $name)
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
