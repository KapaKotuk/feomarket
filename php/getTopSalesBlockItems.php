<?php

namespace Feomarket;

header('Content-Type: text/html; charset=utf-8');
if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) or ($_SERVER['HTTP_X_REQUESTED_WITH']) != 'XMLHttpRequest')
    die('Ошибка запроса!');

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Feomarket\MySql\MySqlConnect;
use Feomarket\Items\TableList;
use Feomarket\Items\TopSalesBlockList;

$mySqlConnect = new MySqlConnect();
$pdo = $mySqlConnect->getPdo();

$ItemsList = new TopSalesBlockList($pdo);
$ItemsList->selectDbList();

echo '<div class="top_sales_items" id="top_sales_block_items">';
echo $ItemsList->createHtml();
echo '</div>';