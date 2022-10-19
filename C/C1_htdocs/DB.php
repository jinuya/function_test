<?php

class DB
{
    private static $db = null;

    private static function getDB()
    {
        if(is_null(self::$db)){
            self::$db = new \PDO("mysql:host=localhost; dbname=house; charset=utf8mb4;", "root", "");
        }

        return self::$db;
    }

    public static function execute($sql, $data = array())
	{
		$query = self::getDB()->prepare($sql);
		return $query->execute($data);
	}

	public static function fetch($sql, $data = array())
	{
		$query = self::getDB()->prepare($sql);
		$query->execute($data);
		return $query->fetch(\PDO::FETCH_OBJ);
	}

	public static function fetchAll($sql, $data = array())
	{
		$query = self::getDB()->prepare($sql);
		$query->execute($data);
		return $query->fetchAll(\PDO::FETCH_OBJ);
	}

	public static function lastId()
	{
		return self::getDB()->lastInsertId();
	}

    public static function init()
    {
        if(DB::fetch("show table status like 'users'")->Auto_increment == 1){
            DB::execute("INSERT INTO users (id, password, name, img) VALUES (?, ?, ?, ?)", array("specialist1", "1234", "전문가1", "specialist1.jpg"));
            DB::execute("INSERT INTO users (id, password, name, img) VALUES (?, ?, ?, ?)", array("specialist2", "1234", "전문가2", "specialist2.jpg"));
            DB::execute("INSERT INTO users (id, password, name, img) VALUES (?, ?, ?, ?)", array("specialist3", "1234", "전문가3", "specialist3.jpg"));
            DB::execute("INSERT INTO users (id, password, name, img) VALUES (?, ?, ?, ?)", array("specialist4", "1234", "전문가4", "specialist4.jpg"));
        }
    }
}

DB::init();