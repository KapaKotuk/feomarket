<?php

namespace Feomarket\Seo;

use Feomarket\MySql\MysqlTable;


class Seo extends MysqlTable {

	protected $db_table = 'seo';
	
	var $id; //int(10) unsigned
	var $pathname; //varchar(45)
	var $title; //varchar(45)
	var $description; //varchar(45)
	var $keywords; //int(10) unsigned
	
	var $arr_source = array(
		"pathname" => "",
		"title" => "",
		"description" => "",
		"keywords" => ""
	);

	public function __construct($db) {
		parent::__construct($db);
	}

	function selectDb() {

		if ($this->pathname) {
			$query = "SELECT * FROM {$this->db_table} WHERE pathname = :pathname LIMIT 1";
			$res = $this->db->prepare($query);
			$res->execute(array($this->pathname));
			$this->setResult($res);
		}
	}

}
