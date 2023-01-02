<?php

namespace app\models;

use app\Database;
use MongoDB\BSON\ObjectId;

class User
{
  const COLLECTION = "users";

  private $_id;
  public $email;
  public $login;
  private $passwordHash;

  public function __construct($email, $login, $passwordHash, $id = NULL)
  {
    $this->_id = $id;
    $this->email = $email;
    $this->login = $login;
    $this->passwordHash = $passwordHash;
  }

  public function save()
  {
    return Database::getCollection(self::COLLECTION)->insertOne([
      "email" => $this->email,
      "login" => $this->login,
      "password" => $this->passwordHash
    ]);
  }

  public function getId()
  {
    return $this->_id;
  }

  public function verifyPassword($password)
  {
    return password_verify($password, $this->passwordHash);
  }

  public static function isUnique($email, $login)
  {
    return !!Database::getCollection(self::COLLECTION)->findOne([
      "\$or" => [
        ["email" => $email],
        ["login" => $login]
      ]
    ]);
  }

  public static function find($id)
  {
    try {
      $response = Database::getCollection(self::COLLECTION)->findOne([
        "_id" => new ObjectId($id)
      ]);
      if (!$response) return null;
      return new User($response["email"], $response["login"], $response["password"], $response["_id"]);
    } catch (\Exception $e) {
      return null;
    }
  }

  public static function findByLogin($login)
  {
    $response = Database::getCollection(self::COLLECTION)->findOne([
      "login" => $login
    ]);
    if (!$response) return null;

    return new User($response["email"], $response["login"], $response["password"], $response["_id"]);
  }
}
