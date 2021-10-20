class cSiteVar {

	page = 'index';
	cat = '';
	item = '';

	cat_id = '0';
	id = '0';
	prev = '';
	sort = '0';
	list = '0';
	
	arr_properties = new Map([
		['company', ''],
		['volume', ''],
		['weight', ''],
		['amount', ''],
		['layer', '']
	]);

	constructor() {
		this.page = this.$_GET_PATHNAME('page');
		this.cat = this.$_GET_PATHNAME('cat');
		this.item = this.$_GET_PATHNAME('item');
		this.prev = this.$_GET('prev');
		this.sort = this.$_GET('sort');
		if (!this.sort || this.sort > 4)
			this.sort = '1';
		this.list = this.$_GET('list');
		if (!this.list || this.list < 0)
			this.list = '1';
		this.id = this.$_GET('id');
		this.cat_id= this.$_GET('cat_id');
		
		for (let key of this.arr_properties.keys()) {
			this.arr_properties.set(key, this.$_GET(key));
		}
	}

	getURL() {
		
		var url = "/" + this.page;

		if (this.cat) {
			url += "/" + this.cat;
			if (this.item) {
				url += "/" + this.item;
			}
		}
		
		url += this.createGetParameters();

		return url;
	}
	
	createPostParameter() {
		var literal = {};
		
		if (!!this.cat) literal.cat = this.cat;
		if (!!this.item) literal.item = this.item;
		if (!!this.sort) literal.sort = this.sort;
		if (!!this.list) literal.list = this.list;
		if (!!this.id) literal.id = this.id;
		if (!!this.cat_id) literal.cat_id = this.cat_id;
		
		for (let key of this.arr_properties.keys()) {
			var value = this.arr_properties.get(key);
			if (!!value) literal[key] = value;
		}
		
		return literal;
	}
	
	clearFilters() {
		for (let key of this.arr_properties.keys()) {
			this.arr_properties.set(key, '');
		}
	}
	
	setFilters() {
		for (let key of this.arr_properties.keys()) {
			var value = encodeURI($('#filter_' + key + ' input[type="checkbox"]:checked').map(function() {return this.value;}).get().join(':'));
			this.arr_properties.set(key, value);
		}
	}
	
	createGetParameters() {
		var res = '?';
		
		if (!!this.cat) res += 'cat=' + this.cat + '&';
		if (!!this.item) res += 'item=' + this.item + '&';
		if (!!this.sort) res += 'sort=' + this.sort + '&';
		if (!!this.list) res += 'list=' + this.list + '&';
		if (!!this.id) res += 'id=' + this.id + '&';
		if (!!this.cat_id) res += 'cat_id=' + this.cat_id + '&';
		
		for (let key of this.arr_properties.keys()) {
			var value = this.arr_properties.get(key);
			if (!!value) res += key + '=' + value + '&';
		}
		
		return res;
	}

	$_GET(key) {
		var s = window.location.search;
		s = s.match(new RegExp(key + '=([^&=]+)'));
		return s ? s[1] : false;
	}
	
	$_GET_PATHNAME(key) {
		var key_arr = new Map([['page', '1'], ['cat', '2'], ['item', '3']]); 
		var s = window.location.pathname;
		var s_arr = s.toString().split('/');
		return s_arr ? s_arr[key_arr.get(key)] : false;
	}

	set page(value)
	{
		if (!value)
			this._page = "index";
		this._page = value;
	}
}