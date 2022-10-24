<?php

namespace app\controllers\photos;

use app\controllers\ApplicationController;

class PhotosController extends ApplicationController
{
    public function index() {
        echo "index photos";
    }

    public function show()
    {
        echo "show photos";
    }
}