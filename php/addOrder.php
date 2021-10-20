<?php

namespace Feomarket;

header('Content-Type: text/html; charset=utf-8');
if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) or ($_SERVER['HTTP_X_REQUESTED_WITH']) != 'XMLHttpRequest')
die('Ошибка запроса!');

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Feomarket\MySql\MySqlConnect;
use Feomarket\Orders\Order;

$mySqlConnect = new MySqlConnect();
$pdo = $mySqlConnect->getPdo();

$arr_items = filter_input(INPUT_GET, 'arr_items');
$client_phone = filter_input(INPUT_GET, 'client_phone');
$client_address = filter_input(INPUT_GET, 'client_address');
$price_sum = filter_input(INPUT_GET, 'price_sum');

if(!$client_phone) exit(
    json_encode(array('error' => 'Отсутствует номер телефона.<br />
                            Пожалуйста повторите "Оформление заказа" и введите номер телефона.<br />
                            <button id="basket_submit" class="btn">Оформить заказ</button>')));

$Order = new Order($pdo);

$Order->arr_items = $arr_items;
$Order->client_phone = $client_phone;
$Order->client_address = $client_address;
$Order->price_sum = $price_sum;
$Order->time_buy = date('Y-m-d H:i:s', time());
$Order->status = 1;
$Order->price_delivery = 50;
$max_id = $Order->getMaxId() + 1;
$number = substr(time(), -2, 1) . $max_id . substr(time(), -1);
$Order->number = substr($number, -6);

$Order->insertDb();

$result = array('order_number' => $Order->number);
echo json_encode($result);
