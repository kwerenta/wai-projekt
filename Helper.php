<?php

namespace app;

use app\Session;

class Helper
{
  public static function isLoggedIn()
  {
    return Session::user_id() !== null;
  }

  public static function showErrors()
  {
    $errors = &Session::errors();
    if (count($errors) !== 0) {
      static::renderList($errors, "errors");
      Session::clearErrors();
    }
  }

  public static function showNotices()
  {
    $notices = &Session::notices();
    if (count($notices) !== 0) {
      static::renderList($notices, "notices");
      Session::clearNotices();
    }
  }

  private static function renderList($dataArray, $containerClass)
  {
    echo "<ul class=\"$containerClass\">";
    foreach ($dataArray as $data) {
      echo "<li>$data</li>";
    }
    echo "</ul>";
  }
}
