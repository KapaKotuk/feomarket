<?php

namespace Feomarket\Orders;

use Feomarket\MySql\MysqlTable;

class Order extends MysqlTable {
	
	protected $db_table = 'orders';
	
	var $id; //int(10) unsigned
	var $number; //int(10) unsigned
	var $arr_items; //text
	var $arr_items_delivery; //text
	var $price_sum; //mediumint(8) unsigned
	var $price_sum_delivery; //mediumint(8) unsigned
	var $price_delivery; //smallint(5) unsigned
	var $client_id; //mediumint(8) unsigned
	protected $client_address; //text
	var $time_buy; //datetime
	var $time_reply; //datetime
	var $time_delivery; //datetime
	var $other_info; //text
	protected $client_phone; //varchar (15)
	var $status; //tinyint
	
	protected $arr_source = array(
		"number" => "",
		"arr_items" => "",
		"arr_items_delivery" => "",
		"price_sum" => "",
		"price_sum_delivery" => "",
		"price_delivery" => "",
		"client_id" => "",
		"client_address" => "",
		"time_buy"=>"",
		"time_reply"=>"",
		"time_delivery"=>"",
		"other_info"=>"",
		"client_phone"=>"",
		"status"=>""
	);
	
	public function __construct($db) {
		parent::__construct($db);
	}
	
	function getMaxId() {
		$res = $this->db->prepare("SELECT MAX(id) FROM {$this->db_table};");
		$res->execute();
		return (int) $res->fetchColumn();
	}

	public function createHtml() {
		$html = '<h4>Номер заказа: </h4><span>' . $this->number . '</span><br />'
				. '<hr>'
				. '<div class="order_button"><button id="order_add_delivery">В доставку</button></div>'
				. '<div class="order_button"><button id="order_pending">Отложить</button></div><br />'
				. '<hr>'
				. '<h4>Время заказа: </h4><span>' . $this->time_buy . '</span><br />'
				. '<h4>Время обработки: </h4><span>' . $this->time_reply . '</span><br />'
				. '<h4>Время доставки: </h4><span>' . $this->time_delivery . '</span><br />'
				. '<hr>'
				. '<h4>Адресс доставки: </h4> <button id="order_add_client_address">Добавить</button>'
				. '<textarea rows="5" id="order_edit_address" class="" autocomplete="off">' . $this->client_address . '</textarea><br />'
				. '<hr>'
				. '<h4>Стоимость заказа: </h4><span>' . $this->price_sum . '</span><br />'
				. '<h4>Стоимость доставки: </h4><span>' . $this->price_delivery . '</span><br />'
				. '<h4>Общая стоимость: </h4><span>' . $this->price_sum . '</span><br />'
				. '<hr>'
				. '<h4>Дополнительные заметки: </h4>'
				. '<textarea rows="5" id="order_edit_other_info" class="" autocomplete="off">' . $this->other_info . '</textarea>'
				. '<button>В корзину</button>';

		return $html;
	}

	public function __get($property) {

		if ($property == 'client_phone') {
			$phone = $this->client_phone;
			$phone = substr_replace($phone, "+", 0, 0);
			$phone = substr_replace($phone, " (", 2, 0);
			$phone = substr_replace($phone, ") ", 7, 0);
			$phone = substr_replace($phone, "-", 12, 0);
			$phone = substr_replace($phone, "-", 15, 0);

			return $phone;
		}

		if ($property == 'client_address') {
			return $this->client_address;
		}
	}

	public function __set($property, $value) {

		if ($property == 'client_phone') {
			$value = preg_replace('/[^0-9]/', '', $value);
			$this->client_phone = $value;
		}

		if ($property == 'client_address') {
			$escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
			$replacements = '';
			$value = str_replace($escapers, $replacements, $value);
			$value = str_replace("  ", "", $value);
			$value = trim($value);

			$this->client_address = $value;
		}
	}

}
