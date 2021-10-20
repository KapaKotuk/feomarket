function viewItemInfo() {
	
	let SiteVar = new cSiteVar();
	
	if (SiteVar.id < 1) return false;
	$('.content_item_info').load('/php/getItemInfo.php' + SiteVar.createGetParameters(), SiteVar.createPostParameter());
	viewItemTitleInfo();
}

function viewItemTitleInfo() {
	
	let SiteVar = new cSiteVar();
	
	if (SiteVar.id < 1) return false;

	$.post('/php/getItemTitleInfo.php', SiteVar.createPostParameter(), function (data) {

		let SiteVar = new cSiteVar();
		SiteVar.page = "catalog";
		SiteVar.item = "";
		SiteVar.id = 0;
		
		$('#p_unit_title a').attr('href', SiteVar.getURL());
		$('#p_unit_title span').html(data.name);
		
	}, "json");

}

function viewCatalogList() {
	let SiteVar = new cSiteVar();
	$('.catalog_content').load('/php/getCatalogList.php', SiteVar.createPostParameter());
	viewCatalogTitleInfo();
}

function viewCatalogTitleInfo() {
	
	let SiteVar = new cSiteVar();
	
	$.post('/php/getCatalogTitleInfo.php',  SiteVar.createPostParameter(), function (data) {

		let SiteVar = new cSiteVar();
		
		SiteVar.page = "index";
		SiteVar.prev = SiteVar.cat;
		SiteVar.cat = '';
		SiteVar.list = 0;

		$('.content_title a').attr('href', SiteVar.getURL());
		$('.content_title span').html(data.title);
	}, "json");
}

function viewCatalogListSale() {
	
	let SiteVar = new cSiteVar();

	$('.block_sale_list').load("/php/getSaleList.php", SiteVar.createPostParameter());
}

function viewSaleBlockItems() {
	$('.sale_block').load("/php/getSaleBlockItems.php");
}

function viewItemsListSearch() {	
	let SiteVar = new cSiteVarSearch();
	if (!SiteVar.search) return false;
	
	$('#search-text').attr('value', decodeURI(SiteVar.search));
	$('#search_box').load('/php/getSearchList.php', SiteVar.createPostParameter(), viewFilterSearchBlock);
}

function incrementItemCount() {
	
	let Item = new cItem($(this).parents('.item'));

	Item.incCount();
	
	let OrderItemsList = new cOrderItemsList();
	OrderItemsList.changeItem(Item);

	var sum = Item.getPriceSum();
	var total_sum = OrderItemsList.getTotalSum();

	$(this).parent().children('input').attr('value', Item.count);
	$(this).parents('.item').attr('data-count', Item.count);
	$(this).parents('.item').find('.item_price_sum').children('span').html(sum);
	$('.basket_items_total_sum span').html(total_sum);
}

function decrementItemCount() {

	let Item = new cItem($(this).parents('.item'));

	Item.decCount();
	
	let OrderItemsList = new cOrderItemsList();
	OrderItemsList.changeItem(Item);
	
	var sum = Item.getPriceSum();
	var total_sum = OrderItemsList.getTotalSum();

	$(this).parent().children('input').attr('value', Item.count);
	$(this).parents('.item').attr('data-count', Item.count);
	$(this).parents('.item').find('.item_price_sum').children('span').html(sum);
	$('.basket_items_total_sum span').html(total_sum);
}

function contentBoxClick() {
	var flag = $(this).parents('.content_box').attr('value');

	if (flag === '0') {
		$(this).parents('.content_box').children('p').css("height", "auto");
		$(this).parents('.content_box').children('span').html('Скрыть <img src="/img/theme/but_arrow_to_up_min.png">');
		$(this).parents('.content_box').attr('value', '1');
	} else	{
		$(this).parents('.content_box').children('p').css("height", "100px");
		$(this).parents('.content_box').children('span').html('Показать все <img src="/img/theme/but_arrow_to_down_min.png">');
		$(this).parents('.content_box').attr('value', '0');
	}
}