<?php

namespace app;

use MongoDB;

class Database
{
	private static $client = null;

	public static function getInstance()
	{
		if (!isset(static::$client))
			static::$client = new MongoDB\Client(
				"mongodb://localhost:27017/wai",
				[
					"username" => "wai_web",
					"password" => "w@i_w3b"
				]
			);

		return static::$client->wai;
	}

	public static function getCollection($name)
	{
		return static::getInstance()->$name;
	}
}
