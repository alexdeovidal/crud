<?php

namespace Alexdeovidal\Crud;

use PDOException;
use PDO;

/**
 * @Alexdeovidal\Crud
 * Class Conn
 */
class Conn
{
    /**
     * @var PDO|null
     */
    protected static ?PDO $pdo = null;
    /**
     * @var PDOException|null
     */
    protected static ?PDOException $exception = null;

    /**
     * @return PDO|null
     */
    public static function conn(): ?PDO
    {
        if (!self::$pdo) {
            try {
                self::$pdo = (new PDO('mysql:host=' . CRUD_HOST . ';dbname=' . CRUD_DBASE . '', CRUD_USER, CRUD_PASS));
                self::setAttribute();
            } catch (PDOException $exception) {
                self::$exception = $exception;
            }
        }
        return self::$pdo;
    }

    public static function error(): ?PDOException
    {
        return self::$exception;
    }

    /**
     * setAttribute PDO
     */
    protected static function setAttribute(): void
    {
        self::$pdo?->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES " . CRUD_ENCODE);
        self::$pdo?->setAttribute(PDO::MYSQL_ATTR_FOUND_ROWS, true);
        self::$pdo?->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}