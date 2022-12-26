<?php

namespace app\controllers\photos;

use app\controllers\ApplicationController;
use app\models\Photo;

class PhotosController extends ApplicationController
{
    public function index()
    {
        $photos = Photo::all();
        $this->view->addData(["photos" => $photos]);
    }

    public function show()
    {
        $this->view->addData(["id" => $this->params["id"]]);
    }

    public function create()
    {
        $file = $_FILES["photo"];
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . "/images/" . basename($file["name"]);;

        if ($file["error"] !== 0) {
            echo "Error occured.";
            return;
        }

        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $file["tmp_name"]);

        if (filesize($file["tmp_name"]) >= 1000000) {
            echo "Max file size is 2MB.";
            return;
        }

        if (!in_array($mimeType, ["image/jpeg", "image/png"])) {
            echo "Invalid File type";
            return;
        }

        if (move_uploaded_file($file["tmp_name"], $targetPath))
            echo "Photo saved successfully.";
        else
            echo "Photo wasn't saved.";
    }
}
