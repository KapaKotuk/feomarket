<?php

namespace Feomarket;

header('Content-Type: text/html; charset=utf-8');

if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) or ($_SERVER['HTTP_X_REQUESTED_WITH']) != 'XMLHttpRequest')
    die('Ошибка запроса!');

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Feomarket\MySql\MySqlConnect;
use Feomarket\Items\SalesBlockList;

$mySqlConnect = new MySqlConnect();
$pdo = $mySqlConnect->getPdo();


$ItemsList = new SaleBlockList($pdo);
$ItemsList->selectDbList();

echo '<div class="sale_title">'
		. '<div class="sale_text">Товаров со скидкой:<span>' . $ItemsList->items_count . '</span>шт.</div>'
		. '<div class="sale_url"><a href="/sale">Все акционные товары</a></div>'
		. '</div>'
		. '<div class="sale_items" id="sale_block_items">';

echo $ItemsList->createHtml();
echo '</div>';