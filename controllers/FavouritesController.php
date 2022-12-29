<?php

namespace app\controllers;

use app\models\Photo;
use app\Router;
use app\Session;

class FavouritesController extends ApplicationController
{
  public function index()
  {
    $this->view->setName("favourites");
    $favourites = Photo::findMany(Session::favourites());
    $this->view->addData(["photos" => $favourites]);
  }

  public function create()
  {
    $favourites = &Session::favourites();
    $favourites = array_unique(array_merge(Session::favourites(), $_POST["favourite"] ?? []), SORT_REGULAR);
    Router::redirect("/photos");
  }

  public function destroy()
  {
    $favourites = &Session::favourites();
    $favourites = array_diff(Session::favourites(), $_POST["unfavourite"] ?? []);
    Router::redirect("/favourites");
  }
}
