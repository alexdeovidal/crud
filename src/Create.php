<?php

namespace Alexdeovidal\Crud;

class Create extends Crud
{
    /**
     *
     */
    public static function store()
    {

        self::$values = ":" . implode(", :", array_keys(self::$data));
        self::$columns = implode(", ", array_keys(self::$data));


        self::$prepare = self::$conn->prepare("INSERT INTO " . self::$table . " (" . self::$columns . ") VALUES (" . self::$values . ")");

        foreach (self::$data as $value => &$content) {
            self::$prepare->bindParam(":{$value}", $content);
        }

    }
}