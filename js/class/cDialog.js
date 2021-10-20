class cDialog {

	html_content = '';

	constructor() {}

	create()
	{

		var dialog_wrapper = $('<div/>', {'class': 'dialog_wrapper'});
		var dialog_layer = $('<div/>', {'class': 'dialog_layer'});
		var dialog = $('<div/>', {'class': 'dialog'});
		var dialog_content = $('<div/>', {'class': 'dialog_content'});
		var dialog_close = $('<button/>', {'class': 'btn_close dialog_close'});

		$(dialog).append(dialog_close);
		$(dialog).append(dialog_content);
		$(dialog_wrapper).append(dialog_layer);
		$(dialog_wrapper).append(dialog);

		$('.dialog_box').append(dialog_wrapper);
		$('.dialog_content').append(this.html_content);
	}

	close()
	{
		$('.dialog_box').html('');
	}	
}

class cDialogBuyItem extends cDialog {
	
	createHtml(Item) {
		var item = $('<div/>', {'class': 'item', 'data-id': Item.id, 'data-title': Item.title, 'data-name': Item.name, 'data-price': Item.price, 'data-count': Item.count, 'data-sale': Item.sale, 'id': 'dialog_item_' + Item.id});
		var item_content = $('<div/>', {'class': 'item_content'});
		var img = $('<img/>', {'src': '/uploads/' + Item.id + '/1_small.jpg', 'alt': Item.name});
		var name = $('<h4/>', {text: Item.name});
		
		var item_price = $('<div/>', {'class': 'item_price', text: ' руб./шт.'}).prepend($('<span/>', {text: Item.price}));
		if(Item.sale > 0) {
			$(item_price).find('span').html(Item.sale);
		} 
			
		var item_count = $('<div/>', {'class': 'item_count'}).append($('<div/>', {'class': 'count_box'}).append($('<button/>', {'class': 'btn_minus'}).add($('<input/>', {'value': Item.count, 'type': 'text'}).add($('<button/>', {'class': 'btn_plus'}).add($('<span/>', {text: 'Количество'}))))));
		var item_count_text = $('<div/>', {'class': 'item_note', text: 'данный товар уже есть в корзине'});
		var item_backet_add = $('<button/>', {'class': 'btn item_add_backet', 'data-id': Item.id, text: 'Добавить в корзину'});
		var item_backet_edit = $('<button/>', {'class': 'btn item_add_backet', 'data-id': Item.id, text: 'Изменить количество'});

		$(item_content).append(img);
		$(item_content).append(name);
		$(item_content).append(item_price);
		$(item_content).append(item_count);
		if (Number(Item.count) > 1) {
			$(item_content).append(item_count_text);
			$(item_content).append(item_backet_edit);
		}
		else {
			$(item_content).append(item_backet_add);
		}	
		
		$(item).append(item_content);

		this.html_content = item;
	}
}

class cDialogBuySubmit extends cDialog {
	
	createHtml() {
		var content = '<div class="dialog_basket_submit">';
		
		content += '<h4>Введите Ваши данные.</h4>';
		content += '<div>Номер телевона:</div>';
		content += '<input type="tel" autocomplete="off" class="form-control" id="phone" name="phone" placeholder="+7 (999) 99 99 999">';
		content += '<div>Адресс доставки:</div>';
		content += '<textarea id="client_address" rows="4">г.Феодосия, ул. </textarea>';
		content += '<button class="btn buy_success">Оформить покупку</button>';
		content += '<div class="basket_count_sale_list">Выбрано товаров: <span>0</span> шт.</div>';
		content += '<div class="basket_total_sum_sale_list">Общей стоимостью <span>0</span> рублей.</div>';
		content += '<div class="basket_sale_list"><ul></ul></div>';
		content += '</div>';

		this.html_content = content;
	}
}

class cDialogBuySuccess extends cDialog {
	
	createHtml(order_id) {
		var content = '<div class="dialog_buy_success">';

		content += '<h4>Ваш заказ №<span>' + order_id + '</span><br />успешно оформлен.</h4>';
		content += '<p>В течении получаса Наш консультант перезвонит Вам и согласует с Вами адресс и время доставки.</p>';
		content += '<p>Если в течении получаса вам не позвонили, сообщите пожалуйста нам об этом.<br /><a href="/page/contact">Наши контакты вы найдете здесь.</a></p>';
		content += '</div>';
		
		this.html_content = content;
	}
}

class cDialogWarning extends cDialog {
	
	createHtml(error) {
		var content = '<div class="dialog_warning">';

		content += '<h4>Внимание!!!</h4>';
		content += '<p>' + error + '</p>';
		content += '</div>';

		this.html_content = content;
	}
}