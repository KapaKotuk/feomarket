<?php

namespace Feomarket\Items;

class ItemsListFilterBlock extends ItemsList {
	
	protected $arr_properties_data = ['company' => ['title' => 'Торговая марка', 'units' => []], 
									'volume' => ['title' => 'Объем', 'units' => ['1' => 'мл.', '1000' => 'л.']],
									'weight' => ['title' => 'Вес', 'units' => ['1' => 'гр.', '1000' => 'кг.']],
									'amount' => ['title' => 'Количество', 'units' => []],
									'layer' => ['title' => 'Слоев', 'units' => ['1' => 'сл.']],
									'operating_principle' => ['title' => 'Принцип дествия', 'units' => []],
									'hazard_class' => ['title' => 'Класс опасности', 'units' => []]
									];

	public function __construct($db) {
		parent::__construct($db);
	}

	function selectDbList() {

		$query = "SELECT * FROM catalog"
				. " WHERE cat_label = ?";

		$query .= " AND visible = 1 AND arhiv = 0";

		$params = array($this->cat);
		
		$res = $this->db->prepare($query);
		$res->execute($params);

		if ($res) {
			$this->setResult($res);
			$this->getCount();
		}
	}
	
	public function rewritePropertiesList() {
		
		foreach ($this->arr_properties as $prop => $arr_list) {
			
			foreach ($arr_list as $prop_name => $prop_value) {
				$this->arr_properties[$prop][$prop_name] = 0;
			}
		}
		
		foreach($this->arr_fetch_items as $item) {
			$arr_properties = json_decode($item->arr_properties, true);
			
			if (empty($arr_properties))	continue;
			
			foreach($arr_properties as $name => $value) {
				
				if (array_key_exists($value, $this->arr_properties[$name])) 
					$this->arr_properties[$name][$value]++;
			}
		}
	}
	
	function createHtml() {

		$html = '';
		
		foreach ($this->arr_properties as $prop => $arr_list) {
			
			$arr_units = $this->arr_properties_data[$prop]['units'];
			
			$html .= '<div id="filter_' . $prop . '" class="filter_item"><span>' . $this->arr_properties_data[$prop]['title'] . '</span><ul>';
			
			foreach ($arr_list as $prop_name => $prop_value) {
				$unit = $this->convertUnits($arr_units, $prop_name);
				
				$arr_select = array();
				if (!empty($this->arr_properties_selected[$prop]))
					$arr_select = $this->arr_properties_selected[$prop];
				
				if (in_array($prop_name, $arr_select)) {
					$html .= '<li><input type="checkbox" checked value="' . $prop_name . '"><span>' . $unit . ' (' . $prop_value . ')</span></li>';
				} else {
					$html .= '<li><input type="checkbox" value="' . $prop_name . '"><span>' . $unit . ' (' . $prop_value . ')</span></li>';
				}
			}
			
			$html .= '</ul></div>';
		}

		return $html;
	}
	
	protected function convertUnits($arr, $convert_value) {

		if (empty($arr)) return $convert_value;
		$temp_key = '1';
		foreach ($arr as $key => $value) {
			if ($key <= $convert_value) $temp_key = $key;
		}
		return $convert_value/$temp_key . ' ' . $arr[$temp_key];
	}

}
