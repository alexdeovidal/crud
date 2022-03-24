<?php
use Alexdeovidal\Crud\Read;

include __DIR__ . "/config.php";
include dirname(__DIR__, 1) . "/vendor/autoload.php";


$users = Read::fullFind(query: 'SELECT name, genre FROM users');

foreach ($users as $user) {
    echo "Nome = {$user->name} <br>";
    echo "Sexo = {$user->genre} <br>";
}


