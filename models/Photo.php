<?php

namespace app\models;

use app\Database;

class Photo
{
  private static $collection = "photos";

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
    return Database::getCollection(static::$collection)->insertOne([
      "title" => $this->title,
      "name" => $this->name,
      "author" => $this->author
    ]);
  }

  public static function all()
  {
    $response = Database::getCollection(static::$collection)->find();
    $photos = [];

    foreach ($response as $photo) {
      $photos[] = new Photo($photo["title"], $photo["name"], $photo["author"]);
    }

    return $photos;
  }
}
