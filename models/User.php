<?php

namespace app\models;

use app\Database;

class User
{
  private static $COLLECTION = "users";

  public $email;
  public $login;
  private $passwordHash;

  public function __construct($email, $login, $passwordHash)
  {
    $this->email = $email;
    $this->login = $login;
    $this->passwordHash = $passwordHash;
  }

  public function save()
  {
    Database::getCollection(static::$COLLECTION)->insertOne([
      "email" => $this->email,
      "login" => $this->login,
      "password" => $this->passwordHash
    ]);
  }

  public function getPassword()
  {
    return $this->passwordHash;
  }

  public static function isUnique($email, $login)
  {
    return !!Database::getCollection(static::$COLLECTION)->findOne([
      "\$or" => [
        ["email" => $email],
        ["login" => $login]
      ]
    ]);
  }

  public static function find($login)
  {
    $response = Database::getCollection(static::$COLLECTION)->findOne([
      "login" => $login
    ]);
    if (!$response) return null;

    return new User($response["email"], $response["login"], $response["password"]);
  }
}
