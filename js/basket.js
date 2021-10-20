function addItemToBasket() {
	$('.item_add_backet').attr('disabled', true);

	let Item = new cItem('#dialog_item_' + $('.item_add_backet').attr('data-id'));

	let OrderItemsList =  new cOrderItemsList();
	OrderItemsList.addItem(Item);

	$('.item_add_backet').removeAttr('disabled');

	let Dialog = new cDialog();
	Dialog.close();
	
	viewBasketCountMin();
}

function deleteItemFromBasket() {
	$(this).attr('disabled', true);

	let Item = new cItem('#basket_item_' + $(this).parents('.item').attr('data-id'));

	let OrderItemsList =  new cOrderItemsList();
	OrderItemsList.deleteItem(Item);

	$(this).removeAttr('disabled');

	viewBasketList();
}

function viewBasketList() {

	let OrderItemsList =  new cOrderItemsList();

	$('.basket_items_list').html(OrderItemsList.createHtml());
	$('.basket_items_total_sum span').html(OrderItemsList.getTotalSum());
	$('.basket_items_count span').html(OrderItemsList.getOrdersCount());

	viewBasketCountMin();
}

function viewBasketSaleList() {

	let OrderItemsList =  new cOrderItemsList();

	$('.basket_sale_list').html(OrderItemsList.createHtml());
	$('.basket_total_sum_sale_list span').html(OrderItemsList.getTotalSum());
	$('.basket_count_sale_list span').html(OrderItemsList.getOrdersCount());
	$('#phone').mask('+7(999) 999-99-99');

	viewBasketCountMin();
	
	return false;
}

function clearBasket() {

	let OrderItemsList =  new cOrderItemsList();
	OrderItemsList.clearDataInLocalStorage();

	viewBasketList();
}

function submitBasket() {
	let Dialog = new cDialogBuySubmit();
	Dialog.close();
	Dialog.createHtml();
	Dialog.create();

	viewBasketSaleList();
}

function viewBasketCountMin() {
	let OrderItemsList =  new cOrderItemsList();
	$('.basket_count').html(OrderItemsList.getOrdersCount());
}
