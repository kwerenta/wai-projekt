<?php

namespace app\controllers;

use app\models\User;
use app\Helper;
use app\Router;

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
    if (User::isUnique($_POST["email"], $_POST["login"]))
      $_SESSION["errors"][] = "User with that email or login already exists.";

    if ($_POST["password"] != $_POST["passwordConfirmation"])
      $_SESSION["errors"][] = "Passwords don't match.";

    if (isset($_SESSION["errors"]))
      Router::redirect("/signup");

    $passwordHash = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $user = new User($_POST["email"], $_POST["login"], $passwordHash);
    $user->save();

    Router::redirect("/signin");
  }

  public function createSession()
  {
    $user = User::find($_POST["login"]);

    if (!$user) {
      $_SESSION["errors"][] = "User with that login doesn't exist.";
      Router::redirect("/signin");
    }

    if (!$user->verifyPassword($_POST["password"])) {
      $_SESSION["errors"][] = "Invalid password.";
      Router::redirect("/signin");
    }

    session_regenerate_id();
    $_SESSION["user"] = $user;
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
