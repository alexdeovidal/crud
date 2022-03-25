## @Alexdeovidal\Crud
In this package you have the complete command of your crud, simply create, read, update and delete your database, it is worth remembering that we used in the MariaDB example, but @Alexdeovidal\Crud can be used with several other banks because it uses PDO.

[![Maintainer](http://img.shields.io/badge/maintainer-@alexdeovidal-blue.svg?style=flat-square)](https://twitter.com/alexdeovidal)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/alexdeovidal/crud.svg?style=flat-square)](https://packagist.org/packages/alexdeovidal/crud)
[![Latest Version](https://img.shields.io/github/release/alexdeovidal/crud.svg?style=flat-square)](https://github.com/alexdeovidal/crud/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Quality Score](https://img.shields.io/scrutinizer/g/alexdeovidal/crud.svg?style=flat-square)](https://scrutinizer-ci.com/g/alexdeovidal/crud)
[![Total Downloads](https://img.shields.io/packagist/dt/alexdeovidal/crud.svg?style=flat-square)](https://packagist.org/packages/alexdeovidal/crud)

## Installation

Composer:

```bash
"alexdeovidal/crud": "1.0.*"
```

Terminal

```bash
composer require alexdeovidal/crud
```

## Documentation

[![Video Documentation](https://github.com/alexdeovidal/crud/blob/main/youtube.png)](https://www.youtube.com/embed/DAZURz9f5kY)


Create a file and define the constants example config.php and add it to the project:
```php 
<?php
const CRUD_HOST = "localhost";
const CRUD_DBASE = "aula";
const CRUD_USER = "root";
const CRUD_PASS = "";
const CRUD_ENCODE = "utf8";
```

Create your database, this one below was used in the tests:

```mysql
-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 24/03/2022 às 01:06
-- Versão do servidor: 10.4.20-MariaDB
-- Versão do PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `aula`
--
CREATE DATABASE IF NOT EXISTS `aula` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `aula`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `genre` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
```
Use of Class Create: To register information in the database.

The ```Create::setTable("users")``` method sets the table name.

The ```Create::setData(["name" => "Maycon"])``` method sets the field and column value.
```php
<?php
use Alexdeovidal\Crud\Create;

include __DIR__ . "/config.php";
include dirname(__DIR__, 1) . "/vendor/autoload.php";

Create::setTable("users");
Create::setData([
    "name" => "Douuglas Rezende",
    "birth_date" => "1980-12-25",
    "genre" => "M",
]);
Create::store();

if($id = Create::save()){
    echo $id;
}
```
Use of Class Read: To read the information in the database.
####*First result found.
```php
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

```
####*All results found.
```php
<?php
use Alexdeovidal\Crud\Read;

include __DIR__ . "/config.php";
include dirname(__DIR__, 1) . "/vendor/autoload.php";

Read::setTable("users");
Read::setData([
    "*"
]);
$users = Read::find(columns:["name", "genre"], all:true);
foreach ($users as $user){
    echo "Nome: {$user->name} <br>";
    echo "Sexo: {$user->genre} <br>";
}

```

####*Query select manual.
```php
<?php
use Alexdeovidal\Crud\Read;

include __DIR__ . "/config.php";
include dirname(__DIR__, 1) . "/vendor/autoload.php";


$users = Read::fullFind(query: 'SELECT name, genre FROM users');

foreach ($users as $user) {
    echo "Nome = {$user->name} <br>";
    echo "Sexo = {$user->genre} <br>";
}
```
Using Class Update: To update information in the database.
```php
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
```
Using Class Delete: To delete information in the database.

```php
<?php
use Alexdeovidal\Crud\Delete;

include __DIR__ . "/config.php";
include dirname(__DIR__, 1) . "/vendor/autoload.php";

Delete::setTable("users");
Delete::setData([33]);

if(Delete::send()){
    echo "dado excluído com sucesso";
}
```

## Contribution

All contributions will be analyzed, if you make more than one change, make the commit one by one.

## Support


If you find faults send an email reporting to webav.com.br@gmail.com.

## Credits

- [Alex de O. Vidal](https://github.com/alexdeovidal) (Developer)
- [All contributions](https://github.com/alexdeovidal/crud/contributors) (Contributors)

## License

The MIT License (MIT). Please see [License](https://github.com/alexdeovidal/crud/LICENSE) for more information.
.