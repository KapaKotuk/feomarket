<?php

namespace Feomarket;

header('Content-Type: text/html; charset=utf-8');
if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) or ($_SERVER['HTTP_X_REQUESTED_WITH']) != 'XMLHttpRequest')
    die('Ошибка запроса!');

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Feomarket\MySql\MySqlConnect;
use Feomarket\Categories\Category;


$mySqlConnect = new MySqlConnect();
$pdo = $mySqlConnect->getPdo();

$Category = new Category($pdo);
$Category->selectDb();

$title = $Category->title;

$Category->selectDbParentCategory();

$parent_cat = $Category->label;

$result = array('title' => $title, 'parent_cat' => $parent_cat);
echo json_encode($result);

