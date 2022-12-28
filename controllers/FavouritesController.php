<?php

namespace app\controllers;

use app\models\Photo;

class FavouritesController extends ApplicationController
{
  public function index()
  {
    $this->view->setName("favourites");
    $favourites = Photo::findMany($_SESSION["favourite"] ?? []);
    $this->view->addData(["photos" => $favourites]);
  }

  public function create()
  {
    $_SESSION["favourite"] = array_unique(array_merge($_SESSION["favourite"] ?? [], $_POST["favourite"] ?? []), SORT_REGULAR);
    header("Location: /photos");
  }

  public function destroy()
  {
    $_SESSION["favourite"] = array_diff($_SESSION["favourite"] ?? [], $_POST["unfavourite"] ?? []);
    header("Location: /favourites");
  }
}
