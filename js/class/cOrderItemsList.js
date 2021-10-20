class cOrderItemsList {

	storage_lable = 'order_items_list';
	prefix = 'i_'; //Меняет тип интексирования массива с int на string

	arr_order_items = '';
	
	html_price_check_view = '';

	constructor() {
		this.getDataFromLocalStorage();
	}

	getDataFromLocalStorage() {
		this.arr_order_items = JSON.parse(localStorage.getItem(this.storage_lable)) || {};
	}

	setDataToLocalStorage() {
		localStorage.setItem(this.storage_lable, JSON.stringify(this.arr_order_items));
		return false;
	}

	clearDataInLocalStorage() {
		localStorage.removeItem(this.storage_lable);
	}

	addItem(Item) {
		this.arr_order_items[this.prefix + Item.id] = {'name' : Item.name, 'price' : Item.price, 'sale' : Item.sale, 'count' : Item.count};
		this.setDataToLocalStorage();
	}

	deleteItem(Item) {
		delete this.arr_order_items[this.prefix + Item.id];
		this.setDataToLocalStorage();
	}

	changeItem(Item) {

		if (!this.checkItem(Item)) return;
		
		this.arr_order_items[this.prefix + Item.id] = Item;
		this.setDataToLocalStorage();
	}

	getOrderItems() {	
		return JSON.stringify(this.arr_order_items);
	}
	
	setOrderItems(arr_items) {
		this.arr_order_items = arr_items;
		this.setDataToLocalStorage();
		
	}
	
	getTotalSum() {	
		var price_sum = 0;
		
		for (var item_index in this.arr_order_items) {
			let Item = new cItem();
			Item.setItem(this.arr_order_items[item_index]);
			price_sum += Item.getPriceSum();
		}
		
		return price_sum;
	}
	
	getOrdersCount() {	
		return Object.keys(this.arr_order_items).length;
	}

	checkItem(Item) {
		return this.arr_order_items.hasOwnProperty(this.prefix + Item.id);
	}
	
	getItemCount(Item) {
		if (!this.checkItem(Item)) return 1;
		return this.arr_order_items[this.prefix + Item.id].count;
	}

	createHtml() {

		var html = '';
		this.html_price_check_view = '';

		if (this.arr_order_items === null)
			return false;

		for (var item_index in this.arr_order_items) {
			
			let Item = new cItem();
			
			Item.setItem(this.arr_order_items[item_index]);
			Item.id = item_index.replace(this.prefix, '');
			
			html += Item.createHtml();
			
			this.html_price_check_view += '<li>' + Item.name + '<span>' + Item.count + ' шт. х ' + Item.price + ' руб. = ' + Item.sum + ' руб.</span></li>';
		}
		
		return html;
	}
}