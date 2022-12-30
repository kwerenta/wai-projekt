<?php

namespace app;

use app\Session;

class Helper
{
  public static function isLoggedIn()
  {
    return Session::user() !== null;
  }

  public static function showErrors()
  {
    $errors = &Session::errors();
    if (count($errors) !== 0) {
      echo "<ul class=\"errors\">";
      foreach ($errors as $error) {
        echo "<li>$error</li>";
      }
      echo "</ul>";
      Session::clearErrors();
    }
  }
}
