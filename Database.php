<?php

namespace app;
use MongoDB;

class Database
{
    private $db;

    public function __construct()
    {
       $this->db = (new MongoDB\Client(
           "mongodb://localhost:27017/wai",
           [
               "username" => "wai_web",
               "password" => "w@i_w3b"
           ]))->wai;
    }

    public function getUsers() {
        $users = $this->db->users->find();
        foreach ($users as $user) {
            echo "<pre>Username: {$user['username']}</pre>";
        }   
    }

    public function addRandomUser() {
        $this->db->users->insertOne(["username" => str_shuffle("abcdef"), "password" => password_hash("test", PASSWORD_BCRYPT)]);
    }
}
