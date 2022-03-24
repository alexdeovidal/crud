<?php
use Alexdeovidal\Crud\Read;

include __DIR__ . "/config.php";
include dirname(__DIR__, 1) . "/vendor/autoload.php";

Read::setTable("users");
Read::setData([
    "*"
]);
$user = Read::find(columns:["name", "genre"]);

echo "Nome: {$user->name} <br>";
echo "Sexo: {$user->genre} <br>";
