<?php

namespace app\controllers\photos;

use app\controllers\ApplicationController;
use app\models\Photo;
use app\models\User;
use app\Helper;
use app\Router;
use app\services\ThumbnailCreator;
use app\services\WatermarkCreator;
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

		$currentUser = User::find(Session::user_id());
		$author = Helper::isLoggedIn() ? $currentUser->login : (empty($_POST["author"]) ? null : $_POST["author"]);

		if (!$this->validateRequiredFields(["title", "watermark"]) || $author === null) {
			$errors[] = "Some required fields are empty.";
		}

		if (count($errors) !== 0 || !$image)
			Router::redirect("/");

		$fileName =  uniqid() . time() . $extension;
		$targetPath = IMAGES_PATH . $fileName;


		ThumbnailCreator::call($image, $fileName);
		WatermarkCreator::call($image, $fileName);

		$privateOwner = Helper::isLoggedIn() && isset($_POST["isPrivate"]) && $_POST["isPrivate"] === "true" ? $currentUser->getId() : null;
		$photo = new Photo($_POST["title"], $fileName, $author, $privateOwner);
		$photo->save();

		move_uploaded_file($file["tmp_name"], $targetPath);
		Router::redirect("/photos");
	}
}
