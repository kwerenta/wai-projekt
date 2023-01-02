<?php

namespace app\models;

use MongoDB\BSON\ObjectId;
use app\Database;
use app\Helper;
use app\Session;

class Photo
{
  const COLLECTION = "photos";
  const PAGE_SIZE = 5;

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
    try {
      $response = Database::getCollection(self::COLLECTION)->findOne([
        "_id" => new ObjectId($id)
      ]);
      if ($response == null) return null;
      return new Photo($response["title"], $response["name"], $response["author"], $response["privateOwner"] ?? NULL, $response["_id"]);
    } catch (\Exception $e) {
      return null;
    }
  }

  public static function findMany($ids)
  {
    $idObjects = [];
    foreach ($ids as $id)
      $idObjects[] = new ObjectId($id);

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

  public static function isNextPage($page)
  {
    return $page * self::PAGE_SIZE < static::count();
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
    return Helper::isLoggedIn() ? User::find(Session::user_id())->getId() : null;
  }

  private static function privateFilter()
  {
    return ["\$in" => [null, static::getUserId()]];
  }
}
