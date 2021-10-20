<?php
	include "./php/class/cCategory.php";
	
	$Category = new cCategory($pdo);
	$pathname = filter_input(INPUT_GET, 'data');
	$arr_data = explode('/', $pathname);
	$Category->label = $arr_data[1];

	$Category->selectDb();
?>

<div class="content_title">
	<a href="//feomarket.ru/"><img src="/img/theme/pro_back.png" alt="Назад png"></a>
	<span>
		<?php echo $Category->name; ?>
	</span>
</div>

<?php include "./tpl/block/subcategories_list_mobile.tpl"; ?>

