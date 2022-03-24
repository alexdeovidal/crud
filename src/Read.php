<?php

namespace Alexdeovidal\Crud;

use PDO;

/**
 * @Alexdeovidal\Crud
 */
class Read extends Crud
{
    /**
     * @param array|string[] $columns
     * @param bool $all
     * @return object
     */
    public static function find(array $columns = ["*"], bool $all = false): object
    {
        self::$columns = implode(", ", array_keys(self::$data));
        $columns = implode(", ", $columns);

        self::$prepare = self::$conn->prepare("SELECT " . $columns . " FROM ".self::$table);

        self::$prepare->execute();
        if($all){
            return (object) self::$prepare->fetchAll(PDO::FETCH_OBJ);
        }
        return (object) self::$prepare->fetch(PDO::FETCH_OBJ);

    }

    /**
     * @param string $query
     * @return object
     */
    public static function fullFind(string $query): object
    {
        self::setData();
        self::$prepare = self::$conn->prepare($query);
        self::$prepare->execute();
        return (object) self::$prepare->fetchAll(PDO::FETCH_OBJ);

    }
}