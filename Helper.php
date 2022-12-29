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
      foreach ($errors as $error) {
        echo "<p>$error</p>";
      }
      unset($errors);
    }
  }
}
