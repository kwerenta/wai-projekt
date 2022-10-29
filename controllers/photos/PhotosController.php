<?php

namespace app\controllers\photos;

use app\controllers\ApplicationController;

class PhotosController extends ApplicationController
{
    public function index() {
        echo "all photos";
    }

    public function show()
    {
        echo "photo id " . $this->params["id"];
    }
}