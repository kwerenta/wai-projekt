<?php

namespace app\models;

use MongoDB;
use app\Database;

class Photo
{
  private static $COLLECTION = "photos";
  public static $PAGE_SIZE = 10;

  private $_id;
  public $title;
  public $name;
  public $author;

  public function __construct($title, $name, $author, $id = NULL)
  {
    $this->_id = $id;
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

  public function getId()
  {
    return $this->_id;
  }

  public function save()
  {
    return Database::getCollection(static::$COLLECTION)->insertOne([
      "title" => $this->title,
      "name" => $this->name,
      "author" => $this->author
    ]);
  }

  public static function find($id)
  {
    $response = Database::getCollection(static::$COLLECTION)->findOne(["_id" => new MongoDB\BSON\ObjectId($id)]);
    if ($response == NULL) return NULL;
    return new Photo($response["title"], $response["name"], $response["author"], $response["_id"]);
  }

  public static function findMany($ids)
  {
    $idObjects = array_map(function ($id) {
      return new MongoDB\BSON\ObjectId($id);
    }, $ids);

    $response = Database::getCollection(static::$COLLECTION)->find([
      "_id" => ["\$in" => $idObjects]
    ]);
    return static::getArray($response);
  }

  public static function page($page)
  {
    $response = Database::getCollection(static::$COLLECTION)->find([], [
      "limit" => static::$PAGE_SIZE,
      "skip" => static::$PAGE_SIZE * ($page - 1)
    ]);
    return static::getArray($response);
  }

  public static function count()
  {
    return Database::getCollection(static::$COLLECTION)->count();
  }

  private static function getArray($response)
  {
    $photos = [];

    foreach ($response as $photo) {
      $photos[] = new Photo($photo["title"], $photo["name"], $photo["author"], strval($photo["_id"]));
    }
    return $photos;
  }

  public function isFavourite()
  {
    return in_array($this->_id, $_SESSION["favourite"] ?? []);
  }
}
