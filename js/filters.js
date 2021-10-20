function openPanelFilters() {
	
	var checkSize = 1050;
	
	if(checkSize <= $(window).width()) {
		if($('.selection_filter_block').is(":visible")) {
			$('.selection_filter_block').hide(600);
		} else {
			$('.selection_filter_block').show(600);
		};
	}
	
	if(checkSize > $(window).width()) {
		openModalPanelFilters();
	}
	
	viewFilterBlock();
}

function closeModalPanel() {
	let ModalPanel = new cModalPanel();
	ModalPanel.close();
}

function openModalPanelFilters() {
	let ModalPanel = new cModalPanelFilter('Фильтры');
	ModalPanel.getContentHtml();
	ModalPanel.create();
}

function viewFilterBlock() {
	let SiteVar = new cSiteVar();
	$('.filter_block').load("/php/getFilterBlock.php" + SiteVar.createGetParameters(), SiteVar.createPostParameter(), hideInactiveFilterMenu);
}

function hideInactiveFilterMenu() {
	$('.filter_item').each(function(index) {
		var count_check = $(this).find('input[type="checkbox"]:checked').length;
		if (count_check && index) $(this).children('span').click()
	});
}

function setStatusFilterMenu() {	
	$('.right_panel').each(function() {
		$.each(this.attributes, function() {
			if(this.specified) {
				if (this.value === '0') $('#' + this.name + ' ul').css('display', 'none');
				if (this.value === '1') $('#' + this.name + ' ul').css('display', 'block');
			}
		});
	});
}

function showFiltersMenu() {
	if($(this).parent('div').children('ul').is(":visible")) {
		$(this).parent('div').children('ul').hide(600);
		$('.right_panel').attr($(this).parent('div').attr('id'), '0');
	} else {
		$(this).parent('div').children('ul').show(600);
		$('.right_panel').attr($(this).parent('div').attr('id'), '1');
	};
}

function reloadFiltersBlock() {
	let SiteVar = new cSiteVar();
	SiteVar.setFilters();
console.log(SiteVar.createPostParameter());
	$('.filter_block').load("/php/getFilterBlock.php", SiteVar.createPostParameter(), setStatusFilterMenu);
}

function applyFilters() {
	let SiteVar = new cSiteVar();
	SiteVar.list = 1;
	SiteVar.setFilters();

	$(location).attr('href',SiteVar.getURL());
}

function clearFilters() {
	let SiteVar = new cSiteVar();
	SiteVar.clearFilters();
	$(location).attr('href',SiteVar.getURL());
}

function changeSortFilter() { 	
	if($(this).val() == 0) return false; 

	let SiteVar = new cSiteVar();
	SiteVar.sort = $(this).val();
	$(location).attr('href',SiteVar.getURL());
}

function viewFilterSearchBlock() {
	let SiteVar = new cSiteVarSearch();
	$('.filter_search_block').load("/php/getFilterSearchBlock.php", SiteVar.createPostParameter());
}

function applyFiltersSearch() {
	let SiteVar = new cSiteVarSearch();
	SiteVar.list = 1;
	SiteVar.setFilters();

	$(location).attr('href',SiteVar.getURL());
}