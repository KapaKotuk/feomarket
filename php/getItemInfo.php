<?php

namespace Feomarket;

header('Content-Type: text/html; charset=utf-8');
if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) or ($_SERVER['HTTP_X_REQUESTED_WITH']) != 'XMLHttpRequest')
    die('Ошибка запроса!');

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Feomarket\MySql\MySqlConnect;
use Feomarket\Items\ItemsList;

$mySqlConnect = new MySqlConnect();
$pdo = $mySqlConnect->getPdo();

$Item = new ItemInfo($pdo);
$Item->selectDb();

$Property = new cProperty($pdo, $Item->id);
$Property->selectDb();
$Item->properties_html = $Property->createHtml();

echo $Item->createHtml();
