<?php

namespace Alexdeovidal\Crud;

class Update extends Crud
{
    /**
     *
     */
    public static function send(): void
    {

        self::$values = null;

        foreach (self::$data as $value => &$content) {
            self::$values .= "$value = :{$value}, ";
        }

        if (self::$values) {
            self::$values = rtrim(self::$values, ", ");
        }

        self::$prepare = self::$conn->prepare("UPDATE " . self::$table . " SET " . self::$values . " WHERE `id` = " . self::$data["id"]);

        foreach (self::$data as $value => &$content) {
            self::$prepare->bindParam(":{$value}", $content);
        }

    }
}