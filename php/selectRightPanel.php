<?php

namespace Feomarket;

header('Content-Type: text/html; charset=utf-8');

if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) or ($_SERVER['HTTP_X_REQUESTED_WITH']) != 'XMLHttpRequest')
    die('Ошибка запроса!');

$page = filter_input(INPUT_POST, 'page');

if ($page === 'catalog') {
	include __DIR__."/../tpl/block/filters.tpl";
	exit();
}

if ($page === 'search') {
	include __DIR__."/../tpl/block/filters_search.tpl";
	exit();
}

include __DIR__."/../tpl/block/right_reklama.tpl";


