<?php

namespace app;

class Session
{
  public static function &errors()
  {
    return static::array("errors");
  }

  public static function &favourites()
  {
    return static::array("favourites");
  }

  public static function &user()
  {
    if (!isset($_SESSION["user"]))
      $_SESSION["user"] = null;

    return $_SESSION["user"];
  }

  private static function &array($key)
  {
    if (!isset($_SESSION[$key]))
      $_SESSION[$key] = [];

    return $_SESSION[$key];
  }
}
