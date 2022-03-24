<?php

namespace Alexdeovidal\Crud;

use PDOException;
use PDO;

/**
 * @Alexdeovidal\Crud
 */
class Crud
{
    /**
     * @var PDO|PDOException|null
     */
    protected static null|PDO|PDOException $conn;
    /**
     * @var string
     */
    protected static string $table;
    /**
     * @var string|null
     */
    protected static null|string $values;
    /**
     * @var string
     */
    protected static string $columns;
    /**
     * @var array
     */
    protected static array $data;
    /**
     * @var object|null
     */
    protected static null|object $prepare;

    /**
     * @param array $data
     * @return PDOException|void|null
     */
    public static function setData(array $data = [])
    {
        self::$data = $data;
        self::$conn = Conn::conn();
        if (!self::$conn) {
            echo Conn::error();
            die();
        }
    }

    /**
     * @param string $table
     */
    public static function setTable(string $table): void
    {
        self::$table = $table;
    }

    /**
     * @return bool|int
     */
    public static function save(): bool|int
    {
        self::$prepare->execute();
        if (self::$prepare->rowCount()) {
            return intval(self::$conn->lastInsertId()) ? intval(self::$conn->lastInsertId()) : self::$data["id"];
        }
        return false;
    }


}