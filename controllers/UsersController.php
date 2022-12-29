<?php

namespace app\controllers;

use app\models\User;
use app\Helper;
use app\Router;
use app\Session;

class UsersController extends ApplicationController
{
  public function new()
  {
    $this->authenticateUser();
    $this->view->setName("signup");
  }

  public function newSession()
  {
    $this->authenticateUser();
    $this->view->setName("signin");
  }

  public function create()
  {
    $errors = &Session::errors();

    if (User::isUnique($_POST["email"], $_POST["login"]))
      $errors[] = "User with that email or login already exists.";

    if ($_POST["password"] != $_POST["passwordConfirmation"])
      $errors[] = "Passwords don't match.";

    if (count($errors) !== 0)
      Router::redirect("/signup");

    $passwordHash = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $user = new User($_POST["email"], $_POST["login"], $passwordHash);
    $user->save();

    Router::redirect("/signin");
  }

  public function createSession()
  {
    $user = User::find($_POST["login"]);
    $errors = &Session::errors();

    if (!$user) {
      $errors[] = "User with that login doesn't exist.";
      Router::redirect("/signin");
    }

    if (!$user->verifyPassword($_POST["password"])) {
      $errors[] = "Invalid password.";
      Router::redirect("/signin");
    }

    session_regenerate_id();
    $sessionUser = &Session::user();
    $sessionUser = $user;
    Router::redirect("/");
  }

  public function destroySession()
  {
    session_unset();
    session_destroy();
    Router::redirect("/signin");
  }

  private function authenticateUser()
  {
    if (Helper::isLoggedIn())
      Router::redirect("/");
  }
}
