<?php

namespace app;

class Session
{
  public static function &errors()
  {
    return static::array("errors");
  }

  public static function clearErrors()
  {
    static::unset("errors");
  }

  public static function &notices()
  {
    return static::array("notices");
  }

  public static function clearNotices()
  {
    static::unset("notices");
  }

  public static function &favourites()
  {
    return static::array("favourites");
  }

  public static function &user_id()
  {
    if (!isset($_SESSION["user_id"]))
      $_SESSION["user_id"] = null;

    return $_SESSION["user_id"];
  }

  private static function &array($key)
  {
    if (!isset($_SESSION[$key]))
      $_SESSION[$key] = [];

    return $_SESSION[$key];
  }

  private static function unset($key)
  {
    unset($_SESSION[$key]);
  }
}
