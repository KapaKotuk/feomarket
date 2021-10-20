class cSiteVarSearch extends cSiteVar {
	
	search = '';
	
	arr_properties = new Map([
		['sad-i-ogorod', ''],
		['bytovaya-himiya', ''],
		['detskie-tovary', ''],
		['zootovary', ''],
		['krasota-i-zdorove', ''],
		['stroyka-i-remont', ''],
		['turizm', '']
	]);

	constructor() {
		super();
		
		this.search = this.$_GET('search');
		for (let key of this.arr_properties.keys()) {
			this.arr_properties.set(key, this.$_GET(key));
		}
	}
	
	createPostParameter() {
		var literal = {};
		
		literal = super.createPostParameter();
		
		if (!!this.search) literal.search = this.search;
		
		for (let key of this.arr_properties.keys()) {
			var value = this.arr_properties.get(key);
			if (!!value) literal[key] = value;	
		}
		
		return literal;
	}
	
	createGetParameters() {
		var res = '?';
		res = super.createGetParameters();

		if (!!this.search) res += 'search=' + this.search + '&';

		return res;
	}
}