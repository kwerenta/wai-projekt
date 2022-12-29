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
				DB_CONNECTION_STRING,
				[
					"username" => DB_USERNAME,
					"password" => DB_PASSWORD
				]
			);

		return static::$client->wai;
	}

	public static function getCollection($name)
	{
		return static::getInstance()->$name;
	}
}
