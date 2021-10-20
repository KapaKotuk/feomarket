class cModalPanelFilter extends cModalPanel {
	
	getContentHtml() {
		
		var div_filters_block = $('<div/>', {class: 'filters_block'});
		var div_filter_block_mobile = $('<div/>', {class: 'filter_block'});
		
		var button_clear = $('<button/>', {class: 'btn', id: 'clear_filters', text: 'Отчистить фильтры'});
		var button_apply = $('<button/>', {class: 'btn', id: 'apply_filters', text: 'Применить'});
		
		$(div_filters_block).append(div_filter_block_mobile);
		$(div_filters_block).append(button_clear);
		$(div_filters_block).append(button_apply);

		this.html_content = div_filters_block;
	}
}

