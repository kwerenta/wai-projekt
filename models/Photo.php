<?php

namespace app\models;

use MongoDB\BSON\ObjectId;
use app\Database;
use app\Helper;
use app\Session;

class Photo
{
  const COLLECTION = "photos";
  const PAGE_SIZE = 10;

  private $_id;
  public $title;
  public $name;
  public $author;
  public $privateOwner;

  public function __construct($title, $name, $author, $owner = NULL, $id = NULL)
  {
    $this->_id = $id;
    $this->title = $title;
    $this->name = $name;
    $this->author = $author;
    $this->privateOwner = $owner;
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

  public function isFavourite()
  {
    return in_array($this->_id, Session::favourites());
  }

  public function save()
  {
    return Database::getCollection(self::COLLECTION)->insertOne([
      "title" => $this->title,
      "name" => $this->name,
      "author" => $this->author,
      "privateOwner" => $this->privateOwner
    ]);
  }

  public static function find($id)
  {
    $response = Database::getCollection(self::COLLECTION)->findOne([
      "_id" => new ObjectId($id)
    ]);
    if ($response == NULL) return NULL;
    return new Photo($response["title"], $response["name"], $response["author"], $response["privateOwner"] ?? NULL, $response["_id"]);
  }

  public static function findMany($ids)
  {
    $idObjects = array_map(function ($id) {
      return new ObjectId($id);
    }, $ids);

    $response = Database::getCollection(self::COLLECTION)->find([
      "_id" => ["\$in" => $idObjects]
    ]);
    return static::getArray($response);
  }

  public static function page($page)
  {
    $response = Database::getCollection(self::COLLECTION)->find([
      "privateOwner" => static::privateFilter()
    ], [
      "limit" => self::PAGE_SIZE,
      "skip" => self::PAGE_SIZE * ($page - 1)
    ]);
    return static::getArray($response);
  }

  public static function search($query)
  {
    $response = Database::getCollection(self::COLLECTION)->find([
      "title" => ["\$regex" => $query, "\$options" => "i"],
      "privateOwner" => static::privateFilter()
    ]);
    return static::getArray($response);
  }

  public static function count()
  {
    return Database::getCollection(self::COLLECTION)->count([
      "privateOwner" => static::privateFilter()
    ]);
  }

  private static function getArray($response)
  {
    $photos = [];

    foreach ($response as $photo) {
      $photos[] = new Photo($photo["title"], $photo["name"], $photo["author"], $photo["privateOwner"] ?? NULL, strval($photo["_id"]));
    }
    return $photos;
  }

  private static function getUserId()
  {
    return Helper::isLoggedIn() ? Session::user()->getId() : null;
  }

  private static function privateFilter()
  {
    return ["\$in" => [null, static::getUserId()]];
  }
}
