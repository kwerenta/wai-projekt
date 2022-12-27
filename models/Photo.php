<?php

namespace app\models;

use app\Database;

class Photo
{
  private static $COLLECTION = "photos";
  public static $PAGE_SIZE = 10;

  public $title;
  public $name;
  public $author;

  public function __construct($title, $name, $author)
  {
    $this->title = $title;
    $this->name = $name;
    $this->author = $author;
  }

  public function getPath()
  {
    return "/images/" . basename($this->name);
  }

  public function getWatermarkPath()
  {
    return "/images/watermark_" . basename($this->name);
  }

  public function getThumbnailPath()
  {
    return "/images/thumbnail_" . basename($this->name);
  }

  public function save()
  {
    return Database::getCollection(static::$COLLECTION)->insertOne([
      "title" => $this->title,
      "name" => $this->name,
      "author" => $this->author
    ]);
  }

  public static function page($page)
  {
    $response = Database::getCollection(static::$COLLECTION)->find([], ["limit" => static::$PAGE_SIZE, "skip" => static::$PAGE_SIZE * ($page - 1)]);
    $photos = [];

    foreach ($response as $photo) {
      $photos[] = new Photo($photo["title"], $photo["name"], $photo["author"]);
    }

    return $photos;
  }

  public static function count()
  {
    return Database::getCollection(static::$COLLECTION)->count();
  }
}
