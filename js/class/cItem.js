class cItem {
	id = 0;
	name = '';
	price = 0;
	sale = 0;
	count = 1;
	
	arr_source_str = ['name'];
	arr_source_number = ['price', 'sale', 'count'];

	constructor(selector = null) {
		this.sale = 0;
		this.parseItemData(selector);
	}
	
	setItem(obj_item) {
		this.id = obj_item.id;
		
		for (var value of this.arr_source_str) {
			this[value] = obj_item[value];
		}
		
		for (var value of this.arr_source_number) {
			this[value] = Number(obj_item[value]);
		}	
	}

	parseItemData(selector) {
		this.id = Number($(selector).attr('data-id'));
		
		for (var value of this.arr_source_str) {
			this[value] = $(selector).attr('data-' + value);
		}
		
		for (var value of this.arr_source_number) {
			this[value] = Number($(selector).attr('data-' + value));
		}
	}
	
	getPriceSum() {
		if (this.sale > 0) return this.sale * this.count;
			
		return this.price * this.count;
	}
	
	incCount() {
		this.count++;
		if (this.count < 1) this.count = 1;
	}
	
	decCount() {
		this.count--;
		if (this.count < 1) this.count = 1;
	}
	
	createHtml() {
		var html = '<div class="item basket_item" data-id="' + this.id
				+ '" data-name="' + this.name
				+ '" data-price="' + this.price
				+ '" data-sale="' + this.sale
				+ '" data-count="' + this.count
				+ '" id="basket_item_' + this.id + '">';
		
		html += '<div class="item_content">';
		html += '<button class="btn_close basket_item_delete"></button>';
		html += '<div class="basket_img"><img src="/uploads/' + this.id + '/1_small.jpg" alt="' + this.name + '"></div>';
		html += '<div class="basket_item_box">';
		html += '<div class="basket_item_info"><h4>' + this.name + '</h4></div>';
		html += '<div class="basket_price_box">';
		html += '<div class="basket_item_price">';

		if (this.sale > 0) {
			html += '<div class="item_price basket_item_sale"><span>' + this.sale + '</span> руб./шт.</div>';
			html += '<div class="item_price item_price_sale"><span>' + this.price + '</span> руб./шт.</div>';
		} else {
			html += '<div class="item_price"><span>' + this.price + '</span> руб./шт.</div>';
		}

		html += '</div>';
		html += '<div class="item_count basket_count_box">';
		html += '<div class="count_box"><button class="btn_minus"></button><input value="' + this.count + '" type="text"><button class="btn_plus"></button><span>Количество</span></div>';
		html += '<div class="item_price_sum"><span>' + this.getPriceSum() + '</span> рублей</div>';
		html += '</div>';
		html += '</div>';
		html += '</div>';
		html += '</div>';
		html += '</div>';
		
		return html;
	}
}