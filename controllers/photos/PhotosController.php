<?php

namespace app\controllers\photos;

use app\controllers\ApplicationController;
use app\models\Photo;
use app\Helper;
use app\Router;
use app\Session;

class PhotosController extends ApplicationController
{
	public function index()
	{
		$page = intval($_GET["page"] ?? 1);
		if ($page <= 0) Router::redirect("/photos");

		$photos = Photo::page($page);
		if (empty($photos) && $page !== 1) Router::pageNotFound();

		$this->view->addData(["photos" => $photos, "page" => $page, "total" => Photo::count()]);
	}

	public function show()
	{
		$photo = Photo::find($this->params["id"]);
		if ($photo === null) Router::pageNotFound();

		$this->view->addData(["photo" => $photo]);
	}

	public function create()
	{
		$file = $_FILES["photo"];
		$errors = &Session::errors();

		if ($file["error"] !== 0) {
			$errors[] = "File wasn't uploaded correctly.";
			Router::redirect("/");
		}

		if (filesize($file["tmp_name"]) > 1000000) {
			$errors[] = "Max file size is 1MB.";
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
			$errors[] = "Invalid file type.";
		}

		$currentUser = Session::user();
		$author = Helper::isLoggedIn() ? $currentUser->login : (empty($_POST["author"]) ? null : $_POST["author"]);

		if (!$this->validateRequiredFields(["title", "watermark"]) || $author === null) {
			$errors[] = "Some required fields are empty.";
		}

		if (count($errors) !== 0 || !$image)
			Router::redirect("/");

		$fileName =  uniqid() . time() . $extension;
		$targetPath = IMAGES_PATH . $fileName;

		$thumbnail = imagescale($image, 200, 125);
		imagepng($thumbnail, IMAGES_PATH . "thumbnail_" . $fileName);
		imagedestroy($thumbnail);

		$this->createWatermark($image, $fileName);

		$privateOwner = Helper::isLoggedIn() && isset($_POST["isPrivate"]) && $_POST["isPrivate"] === "true" ? $currentUser->getId() : null;
		$photo = new Photo($_POST["title"], $fileName, $author, $privateOwner);
		$photo->save();

		move_uploaded_file($file["tmp_name"], $targetPath);
		Router::redirect("/photos");
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
