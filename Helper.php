<?php

namespace app;

class Helper
{
  public static function isLoggedIn()
  {
    return isset($_SESSION["user"]);
  }

  public static function showErrors()
  {
    if (isset($_SESSION['errors'])) {
      foreach ($_SESSION["errors"] as $error) {
        echo "<p>$error</p>";
      }
      unset($_SESSION['errors']);
    }
  }
}
