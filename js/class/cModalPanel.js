class cModalPanel {

	title = '';
	html_content = '';

	constructor(title) {
		this.title = title;
	}

	create()
	{	
		var modal = $('<div/>', {'class': 'modal'});
		var modal_layer = $('<span/>', {'class': 'modal_layer'});
		var modal_active = $('<div/>', {'class': 'modal_active'});
		var modal_header = $('<div/>', {'class': 'modal_header'});
		var modal_header_div = $('<div/>', {});
		var modal_close = $('<button/>', {'class': 'btn_close modal_close'});
		var modal_title = $('<span/>', {text: this.title});
		var modal_content = $('<div/>', {'class': 'modal_content'});
		
		$(modal_header_div).append(modal_close);
		$(modal_header_div).append(modal_title);
		$(modal_header).append(modal_header_div);
		
		$(modal_active).append(modal_header);
		$(modal_active).append(modal_content);
		
		$(modal).append(modal_layer);
		$(modal).append(modal_active);

		$('.modal_box').html(modal);
		$('.modal_content').append(this.html_content);
	}

	close()
	{
		$('.modal_box').html('');
	}

	getContentHtml() {
		
	}

}