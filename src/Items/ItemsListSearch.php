<?php

namespace Feomarket\Items;

class ItemsListSearch extends ItemsList {

	var $search;
	
	public $arr_properties = array(
		'sad-i-ogorod' => '',
		'bytovaya-himiya' => '',
		'detskie-tovary' => '',
		'zootovary' => '',
		'krasota-i-zdorove' => '',
		'stroyka-i-remont' => '',
		'turizm' => ''
	);

	public function __construct($db) {
		parent::__construct($db);

		$this->search = urldecode(filter_input(INPUT_POST, 'search'));
	}

	function selectDbList() {

		$query = "SELECT * FROM catalog"
				. " WHERE name LIKE CONCAT('%', ?, '%')";

		$query .= " AND visible = 1 AND arhiv = 0";


		if ($this->sort === 1)
			$query .= " ORDER BY name";
		if ($this->sort === 2)
			$query .= " ORDER BY price";
		if ($this->sort === 3)
			$query .= " ORDER BY price DESC";

		$start_list = ($this->list - 1) * $this->items_to_list;
		if ($start_list < 0)
			$start_list = 0;

		$query .= " LIMIT " . $start_list . ',' . $this->items_to_list;
		$query .= ";";

		$res = $this->db->prepare($query);

		$params = array($this->search);

		$res->execute($params);

		if ($res) {
			$this->setResult($res);
			$this->getCount();
		}
	}

	protected function replaceQuertyAndToOr($query) {

		$query = implode('', explode('AND', $query, 2));
		$query = str_replace('AND', 'OR', $query);

		if (!empty($query))
			$query = ' AND (' . $query . ')';

		return $query;
	}

	function createUrlPagination($list) {
		$url = '/search/' . $this->cat . '?list=' . $list;
		$url .= '&search=' . $this->search;

		if (!empty($this->sort))
			$url .= '&sort=' . $this->sort;

		foreach ($this->arr_properties as $key => $value) {
			if (!empty($value) && is_array($value))
				$url .= "&" . $key . "=" . implode(":", $value);
		}

		return $url;
	}

}
