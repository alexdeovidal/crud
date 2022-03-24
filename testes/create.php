<?php
use Alexdeovidal\Crud\Create;

include __DIR__ . "/config.php";
include dirname(__DIR__, 1) . "/vendor/autoload.php";

Create::setTable("users");
Create::setData([
    "id" => 33,
    "name" => "Alex de Oliveira Vidal",
    "birth_date" => "1984-09-233",
    "genre" => "M",
]);
Create::store();

if($id = Create::save()){
    echo $id;
}