<?php

namespace Alexdeovidal\Crud;

use JsonException;
use PDO;
use PDOException;

/**
 * Connection PDO
 */
class Conn
{
    /**
     * @var PDO
     */
    private static PDO $pdo;

    /**
     * connect pdo
     * @throws JsonException
     */
    //PDO::FETCH_OBJ
    public static function conn(): PDO
    {
        if(!self::$pdo){
            try {
                self::$pdo = new PDO(DB_DSN,DB_USER,DB_PASS);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            }catch (PDOException $ex){
                Resource::response(400, $ex->getMessage());
            }
        }
        return self::$pdo;
    }
}