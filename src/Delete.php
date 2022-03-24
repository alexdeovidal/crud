<?php

namespace Alexdeovidal\Crud;

class Delete extends Crud
{
    /**
     * @return bool
     */
    public static function send(): bool
    {

        self::$prepare = self::$conn->prepare("DELETE FROM " . self::$table . " WHERE id=?");
        if (self::$prepare->execute(self::$data)) {
            return true;
        }
        return false;
    }
}