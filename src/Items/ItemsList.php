<?php

namespace Feomarket\Items;

use Feomarket\MySql\MySqlList;

class ItemsList extends MysqlList {

	protected $db_class_table = 'Feomarket\Items\Item';
	
	var $cat;
	var $parent_cat;
	var $list;
	var $sort;
	
	var $items_to_list;
	
	var $items_count;
	var $title;
	
	public $arr_properties = array();
	public $arr_properties_selected = array();

	
	public function __construct($db) {
		parent::__construct($db);

		$this->items_to_list = 20;

		$this->cat = filter_input(INPUT_POST, 'cat');
		$this->sort = filter_input(INPUT_POST, 'sort', FILTER_VALIDATE_INT);
		$this->list = filter_input(INPUT_POST, 'list', FILTER_VALIDATE_INT);
	}

	function selectDbList() {

		if (empty($this->cat))
			return false;

		$query = "SELECT item.* FROM catalog as item "
				. "WHERE item.cat_label = ?";

		$query .= " AND item.visible = 1 AND item.arhiv = 0";

		if ($this->sort == '1')
			$query .= " ORDER BY name";
		if ($this->sort == '2')
			$query .= " ORDER BY price";
		if ($this->sort == '3')
			$query .= " ORDER BY price DESC";

		$query .= ";";

		$res = $this->db->prepare($query);

		$params = array($this->cat);

		$res->execute($params);

		if ($res) {
			$this->setResult($res);
			$this->filterList();
			$this->getCount();
		}
	}
	
	public function getSelectedProperties() {
		
		foreach ($this->arr_properties as $property_name => $value) {
			
			$property_value = urldecode(filter_input(INPUT_POST, $property_name));

			if (!empty($property_value))
				$this->arr_properties_selected[$property_name] = explode(":", $property_value);
		}
	}
	
	public function filterList() {
		
		$this->createPropertiesList();
		$this->getSelectedProperties();

		$this->rewriteItemsList();

	}
	
	public function rewriteItemsList() {
		
		foreach($this->arr_fetch_items as $index => $item) {
			
			$filter_item = array();
			$arr_properties = json_decode($item->arr_properties, true);

			foreach ($this->arr_properties_selected as $arr_property_value) {

				$filter_value = false;

				foreach ($arr_property_value as $property_value) {
					if (in_array($property_value, $arr_properties)) {
						$filter_value = true;
					}
				}

				array_push($filter_item, $filter_value);
			}

			if (in_array(false, $filter_item)) {
				 unset($this->arr_fetch_items[$index]);
			}
		}
	}
	
	public function createPropertiesList() {
		
		$this->clearPropertiesList();
		
		foreach($this->arr_fetch_items as $item) {
			$arr_properties = json_decode($item->arr_properties, true);
			
			if (empty($arr_properties))	continue;
			
			foreach($arr_properties as $key => $value) {
				$this->addPropertyToList($key, $value);
			}
		}

	}
	
	
	protected function addPropertyToList($name, $value) {
		
		if (!array_key_exists($name, $this->arr_properties)) 
					$this->arr_properties[$name] = array();
				
		if (array_key_exists($value, $this->arr_properties[$name])) 
			$this->arr_properties[$name][$value]++;
		else 
			$this->arr_properties[$name][$value] = 1;
	}
	
	protected function clearPropertiesList() {
		$this->arr_properties = array();
	}
	
	public function sortPropertiesList() {
		foreach ($this->arr_properties as $key => $value) {
			ksort($this->arr_properties[$key]);
		}
	}

	function getCount() {
		$this->items_count = count($this->arr_fetch_items);
	}

	function createHtml() {

		$html = '';
		$i = 0;
		
		if (empty($this->list) || $this->list === 0) $this->list = 1;
		
		$from_item = (($this->list - 1) * $this->items_to_list) + 1;
		$to_item = $from_item + $this->items_to_list - 1;
				
		foreach ($this->arr_fetch_items as $item) {
			
			$i++;
			if ($from_item > $i || $i > $to_item) continue;

			$html .= '<div class="item item_units" '
					. 'data-id="' . $item->id . '" '
					. 'data-name="' . $item->name . '" '
					. 'data-price="' . $item->price . '" '
					. 'data-count="1" '
					. 'data-sale="' . $item->sale . '" '
					. 'id="item_' . $item->id . '">';

			$html .= '<div class="item_content">';

			$url = '/product/' . $item->cat_label . '/' . $item->label . '?' . 'id=' . $item->id;

			$html .= '<a href="' . $url . '" rel="nofollow">';

			if ($item->sale > 0) {

				$html .= '<div class="item_sale">'
						. '<img src="/img/theme/item_sale.png" alt="Скидка">'
						. '<div class="item_sale_price">'
						. '<span>' . $item->sale . '</span> руб./шт.'
						. '</div>'
						. '</div>';
			}
			
			$image_file = '/uploads/' . $item->id . '/1_small.jpg';
			$image_not = '/img/theme/no_image.jpg';
			
			if (file_exists('../' . $image_file)) {
				$html .= '<img src="' . $image_file . '" alt="' . $item->name . '">';
			} else {
				$html .= '<img src="' . $image_not . '">';
			}

			$html .= '<div><h4>' . $item->name . '</h4></div>';
			$html .= '</a>';

			if ($item->sale > 0) {
				$html .= '<div><div class="item_price item_price_sale">'
						. '<span>' . $item->price . '</span> руб./шт.'
						. '</div></div>';
			} else {
				$html .= '<div><div class="item_price">'
						. '<span>' . $item->price . '</span> руб./шт.'
						. '</div></div>';
			}

		//	$html .= '<button class="btn item_buy">Купить</button>';
			$html .= '</div>';
			$html .= '</div>';
		}

		return $html;
	}

	function createHtmlPagination() {

		$result = '';

		if ($this->items_count <= $this->items_to_list)
			return $result;

		$first = $this->list - 2;
		$last = $this->list + 2;
		$max = ceil($this->items_count / $this->items_to_list);

		$result .= '<div class="pagination"><div class="block_shadow"><ul>';

		if ($last > $max)
			$last = $max;

		if ($first > 1) {
			$result .= '<li><a href="' . $this->createUrlPagination(1) . '">«</a></li>';
		}

		for ($first; $first <= $last; $first++) {
			if ($first > 0) {

				if ($this->list == $first) {
					$result .= '<li><a class="active" href="' . $this->createUrlPagination($first) . '">' . $first . '</a></li>';
				} else {
					$result .= '<li><a href="' . $this->createUrlPagination($first) . '">' . $first . '</a></li>';
				}
			}
		}

		if ($last < $max) {
			$result .= '<li><a href="' . $this->createUrlPagination($max) . '">»</a></li>';
		}

		$result .= '</ul></div></div>';

		return $result;
	}

	function createUrlPagination($list) {
		$url = '/catalog/' . $this->cat . '?list=' . $list;
		if (!empty($this->sort))
			$url .= '&sort=' . $this->sort;

		foreach ($this->arr_properties_selected as $property_name => $property_value) {
			if (!empty($property_value) && is_array($property_value))
				$url .= "&" . $property_name . "=" . implode(":", $property_value);
		}

		return $url;
	}

}
