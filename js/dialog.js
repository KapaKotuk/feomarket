function openDialogBuyItem() {
	
	var id = $(this).parents('.item').attr('data-id');

	let Item = new cItem('#item_' + id);
	
	let OrderItemsList = new cOrderItemsList();
	Item.count = OrderItemsList.getItemCount(Item);

	let Dialog = new cDialogBuyItem();
	Dialog.createHtml(Item);
	Dialog.create();
}

function dialogBuySuccess() {
	let OrderItemsList = new cOrderItemsList();
	
	var arr_items = OrderItemsList.getOrderItems();
	var price_sum = OrderItemsList.getTotalSum();
	var client_phone = $('#phone').val();
	var client_address = $('#client_address').val();
	closeDialog();
	
	$.getJSON("/php/addOrder.php", {arr_items: arr_items,
									client_phone: client_phone,
									price_sum: price_sum,
									client_address: client_address}
		, function (data) {
			
			if (!!data.error) {
				let Dialog = new cDialogWarning();
				Dialog.createHtml(data.error);
				Dialog.create();
			} else {
				let Dialog = new cDialogBuySuccess();
				Dialog.createHtml(data.order_number);
				Dialog.create();
		}	
	});
}

function closeDialog() {
	let Dialog = new cDialog();
	Dialog.close();
}

