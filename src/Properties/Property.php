<?php

namespace Feomarket\Properties;

use Feomarket\MySql\MysqlTable;

class Property extends MysqlTable {
	
	protected $db_table = 'properties';
	
	var $name; //varchar(45)
	var $label; //varchar(45)
	var $arr_units; //text
	
	var $arr_source = array(
		"name"=>"",
		"label"=>"",
		"arr_units"=>"",
	);
	
	public function __construct($db, $item_id = null) {
		parent::__construct($db);
	}

	

	function createHtml() {
		$html = '<div>';

		

		$html .= '</div>';

		return $html;
	}

}
