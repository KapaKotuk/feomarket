<?php

namespace Feomarket;

header('Content-Type: text/html; charset=utf-8');

if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) or ($_SERVER['HTTP_X_REQUESTED_WITH']) != 'XMLHttpRequest')
    die('Ошибка запроса!');

include __DIR__."/../tpl/block/categories_list.tpl";
include __DIR__."/../tpl/block/news.tpl";
