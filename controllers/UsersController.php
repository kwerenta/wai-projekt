<?php

namespace app\controllers;

use app\models\User;
use app\Helper;

class UsersController extends ApplicationController
{
  public function new()
  {
    if (Helper::isLoggedIn())
      return header("Location: /");
    $this->view->setName("signup");
  }

  public function newSession()
  {
    if (Helper::isLoggedIn())
      return header("Location: /");
    $this->view->setName("signin");
  }

  public function create()
  {
    if (User::isUnique($_POST["email"], $_POST["login"]))
      $_SESSION["errors"][] = "User with that email or login already exists.";

    if ($_POST["password"] != $_POST["passwordConfirmation"])
      $_SESSION["errors"][] = "Passwords don't match.";

    if (isset($_SESSION["errors"])) {
      header("Location: /signup");
      return;
    }

    $passwordHash = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $user = new User($_POST["email"], $_POST["login"], $passwordHash);
    $user->save();

    header("Location: /signin");
  }

  public function createSession()
  {
    $user = User::find($_POST["login"]);

    if (!$user) {
      $_SESSION["errors"][] = "User with that login doesn't exist.";
      header("Location: /signin");
      return;
    }

    if (!$user->verifyPassword($_POST["password"])) {
      $_SESSION["errors"][] = "Invalid password.";
      header("Location: /signin");
      return;
    }

    session_regenerate_id();
    $_SESSION["user"] = $user;
    header("Location: /");
  }

  public function destroySession()
  {
    session_unset();
    session_destroy();
    header("Location: /signin");
  }
}
