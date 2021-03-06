<?php

namespace Feomarket;

header('Content-Type: text/html; charset=utf-8');
if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) or ($_SERVER['HTTP_X_REQUESTED_WITH']) != 'XMLHttpRequest')
    die('Ошибка запроса!');

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Feomarket\MySql\MySqlConnect;
use Feomarket\Items\Item;

$mySqlConnect = new MySqlConnect();
$pdo = $mySqlConnect->getPdo();

$Item = new Item($pdo);
$Item->selectDb();

$result = array('name' => $Item->name);
echo json_encode($result);
