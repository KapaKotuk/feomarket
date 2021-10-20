<?php
namespace Feomarket;

require __DIR__.'/vendor/autoload.php';

use Feomarket\MySql\MySqlConnect;
use Feomarket\Seo\Seo;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="yandex-verification" content="5f5301777495d6a6" />
	
	<link rel="icon" href="https://feomarket.ru/favicon.ico" type="image/x-icon">
	
    <?php

		
		$pathname = filter_input(INPUT_GET, 'data');
		$arr_data = explode('/', $pathname);
							
		if (!empty($arr_data[0])) $page = $arr_data[0]; 
		else $page = 'index';
		
		if (!file_exists( __DIR__."/tpl/{$page}.tpl")) $page = 'index';

        $mySqlConnect = new MySqlConnect();
        $pdo = $mySqlConnect->getPdo();
		
		$Seo = new Seo($pdo);
		if ($pathname == '') $pathname = 'index';
		$Seo->pathname = $pathname;
		$Seo->selectDb();
		
		if($Seo->title)	
			echo '<title>'.$Seo->title.'</title>';
		else 
			echo '<title>АгроМагазин Сад и Огород</title>';
		if($Seo->description) echo '<meta name="description" content="'.$Seo->description.'"/>';
		if($Seo->keywords)	echo '<meta name="keywords" content="'.$Seo->keywords.'"/>';
	?>


	<script src="/js/jquery/jquery.min.js"></script>
    <script src="/js/jquery/jquery.maskedinput.js"></script>
  
	<script src="/js/class/cItem.js"></script>
	<script src="/js/class/cOrderItemsList.js"></script>
	<script src="/js/class/cSiteVar.js"></script>
	<script src="/js/class/cSiteVarSearch.js"></script>
	<script src="/js/class/cDialog.js"></script>
	<script src="/js/class/cModalPanel.js"></script>
	<script src="/js/class/cModalPanelFilter.js"></script>
	
	<script src="/js/items.js"></script>
	<script src="/js/subcategories.js"></script>
	<script src="/js/basket.js"></script>
	<script src="/js/dialog.js"></script>
	<script src="/js/filters.js"></script>
	<script src="/js/page.js"></script>
	<script src="/js/top_sales.js"></script>
	
	<script src="/script.js"></script>

	<link rel="stylesheet" href="/mod/mmenu/dist/mmenu.css" />
	<style>@import url("/style.css");</style>

    <script src="/mod/mmenu/dist/mmenu.polyfills.js"></script>
    <script src="/mod/mmenu/dist/mmenu.js"></script>

</head>
<body onload="initialize();">
    <div class="page_wrapper">
        <div class="page">
            <div class="header block_shadow" id="header_block">
				<div class="header_top"></div>
				<div class="header_mobile"></div>
			</div>

			<div class="main-wrapper">
				<div class="main">
					<div class="left_panel"></div><div class="content_panel">
						<?php include __DIR__."/tpl/block/search.tpl"; ?>
						<?php include __DIR__."/tpl/{$page}.tpl";	?>
					</div><div class="right_panel"></div>
				</div>
			</div>

			<div class="modal_box"></div>
			<div class="dialog_box"></div>
			
			<?php include __DIR__."/tpl/block/mmenu.tpl"; ?>
			<?php include __DIR__."/tpl/block/footer.tpl"; ?>
		</div>
	</div>
</body>
</html>