<?php

namespace Feomarket\MySql;

use PDO;

class MysqlList {

	protected $db;
	protected $db_class_table = 'Feomarket\MySql\MysqlTable';
	
	public $arr_fetch_items = array();

	public function __construct($db) {
		$this->db = $db;
	}

	function setResult($res) {

		while ($row = $res->fetch(PDO::FETCH_LAZY)) {
			$Item = new $this->db_class_table($this->db);
			$Item->setVariable($row);

			array_push($this->arr_fetch_items, $Item);
		}
	}

	function createHtml() {

		$html = '';

		foreach ($this->arr_fetch_items as $item) {
			$html .= '';
		}

		return $html;
	}

}
