<?php
use Alexdeovidal\Crud\Update;

include __DIR__ . "/config.php";
include dirname(__DIR__, 1) . "/vendor/autoload.php";

Update::setTable("users");
Update::setData([
    "id" => 33,
    "name" => "Alex de Oliveira Vidal",
    "birth_date" => "1984-09-23",
    "genre" => "M",
]);
Update::send();

if($id = Update::save()){
    echo $id;
}