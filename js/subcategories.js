function viewSubcategoriesList() {
	
	let SiteVar = new cSiteVar();
	
	if (SiteVar.cat) {
		selectSubcategoriesItem(SiteVar.prev);
		$('#ul_sub_' + SiteVar.cat).show();
	} 	
}

function selectSubcategoriesItem(prev) {
	$('#cat_' + prev).addClass("active");
}

function showSubcategoriesPanel() {
	$(this).css('background-color', '#f2f2f2');
	$(this).children('.sub_menu').show();
}

function hideSubcategoriesPanel() {
	$(this).css('background-color', 'white');
	$(this).children('.sub_menu').hide();
}

function showSubcategoriesMenu() {
	if($(this).parent('li').children('.cat_sub_menu_mobile').is(":visible")) {
		$(this).parent('li').children('.cat_sub_menu_mobile').hide(600);
	} else {
		$(this).parent('li').children('.cat_sub_menu_mobile').show(600);
	};
}