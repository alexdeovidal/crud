<?php
use Alexdeovidal\Crud\Delete;

include __DIR__ . "/config.php";
include dirname(__DIR__, 1) . "/vendor/autoload.php";

Delete::setTable("users");
Delete::setData([33]);

if(Delete::send()){
    echo "dado excluído com sucesso";
}