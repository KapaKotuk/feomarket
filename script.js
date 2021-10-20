//index.php
function initialize() {
	
	curentWindowSize = 0;
	checkSize = [1050, 1300];
	reloadBlock();
	$(window).resize(resizeWindow);
	
	mod_mmenu_reload();

	let SiteVar = new cSiteVar();

	switch (SiteVar.page) {
		case 'catalog':
			viewCatalogList();
		case 'product':
			viewItemInfo();
			break;
		case 'subcategories':
			viewSubcategoriesList();
			break;
		case 'search':
			viewItemsListSearch();
			break;
		case 'basket':
			viewBasketList();
			break;
		case 'page':
			selectPage();
			break;
		case 'sale':
			viewCatalogListSale();
			break;
		default:
			viewSaleBlockItems();
			viewTopSalesBlockItems();
			break;
	}
	
	viewBasketCountMin();

	$(document).on('click', '.btn_minus', decrementItemCount);
	$(document).on('click', '.btn_plus', incrementItemCount);
	$(document).on('click', '.dialog_close', closeDialog);
	$(document).on('click', '.modal_close', closeModalPanel);

	$(document).on('click', '#open_filters_mobile', openPanelFilters);
	$(document).on('click', '.buy_success', dialogBuySuccess);
	
	$(document).on('click', '.item_buy', openDialogBuyItem);
	$(document).on('click', '.item_add_backet', addItemToBasket);
	$(document).on('click', '.content_box span', contentBoxClick);
	$(document).on('click', '.basket_item_delete', deleteItemFromBasket);
	
	$(document).on('click', '#basket_clear', clearBasket);
	$(document).on('click', '#basket_submit', submitBasket);
	
	$(document).on('click', '.cat_title_mobile', showSubcategoriesMenu);
	$(document).on('mouseover', '.cat_block li', showSubcategoriesPanel);
	$(document).on('mouseout', '.cat_block li', hideSubcategoriesPanel);
	
	$(document).on('change', '#fiter_block_select_sort', changeSortFilter);
	$(document).on('click', '.filter_item span', showFiltersMenu);
	$(document).on('click', '.filter_block input[type="checkbox"]', reloadFiltersBlock);
	$(document).on('click', '#apply_filters', applyFilters);
	$(document).on('click', '#clear_filters', clearFilters);
	
	$(document).on('click', '#apply_filters_search', applyFiltersSearch);
	
	
	$(document).on('click', '.categories_modal_open', function() {
		viewFilterSearchBlock();
	});
}

function resizeWindow() {
	var need_reload = false;
	
	if(checkSize[0] < $(window).width() && checkSize[0] >= curentWindowSize) need_reload = true;
	if(checkSize[0] > $(window).width() && checkSize[0] <= curentWindowSize) need_reload = true;
	if(checkSize[1] < $(window).width() && checkSize[1] >= curentWindowSize) need_reload = true;
	if(checkSize[1] > $(window).width() && checkSize[1] <= curentWindowSize) need_reload = true;
	
	if(need_reload) reloadBlock();
	curentWindowSize = $(window).width();
}

function reloadBlock() {
	let SiteVar = new cSiteVar();

	if($(window).width() <= checkSize[0]) {
		$('#header_block').load("/tpl/block/header_mobile.tpl", {}, viewBasketCountMin);
		$('.left_panel').html('');
		$('.right_panel').html('');
		$('#block_categories_list_mobile').load("/tpl/block/categories_list_mobile.tpl", {}, viewBasketCountMin);
		$('.selection_filter_box').html('');
	}
	
	if($(window).width() > checkSize[0] && $(window).width() <= checkSize[1]) {
		$('#header_block').load("/tpl/block/header_top.tpl", {}, viewBasketCountMin);
		$('.left_panel').load("/php/selectLeftPanel.php");
		$('.right_panel').html('');
		$('#block_categories_list_mobile').html('');
		$('.selection_filter_box').load("/tpl/block/filter.tpl");		
	}
	
	if ($(window).width() > checkSize[1]) {
		$('#header_block').load("/tpl/block/header_top.tpl", {}, viewBasketCountMin);
		$('.left_panel').load("/php/selectLeftPanel.php");
		$('.right_panel').load("/php/selectRightPanel.php", {'page': SiteVar.page}, viewFilterBlock);
		$('#block_categories_list_mobile').html('');
		$('.selection_filter_box').html('');
	}
	
	curentWindowSize = $(window).width();
}

function mod_mmenu_reload() {
	new Mmenu(document.querySelector('#menu'));

	document.addEventListener('click', function (evnt) {
		var anchor = evnt.target.closest('a[href^="#/"]');
		if (anchor) {
			alert("Thank you for clicking, but that's a demo link.");
			evnt.preventDefault();
		}
	});
}
