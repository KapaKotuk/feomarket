<?php

namespace Feomarket\Categories;

use Feomarket\MySql\MysqlTable;

class Category extends MysqlTable {

	protected $db_table = 'categories';
	
	var $id; //int(10) unsigned
	var $name; //varchar(45)
	var $title; //varchar(45)
	var $note; //varchar(45)
	var $label; //varchar(45)
	var $parent_id; //int(10)
	var $priority; //int
	var $visible; //boolean
	var $properties; //boolean
	
	protected $arr_source = array(
		"name" => "",
		"title" => "",
		"note" => "",
		"label" => "",
		"parent_id" => "",
		"priority" => "",
		"visible" => "",
		"properties" => ""
	);

	public function __construct($db) {
		parent::__construct($db);
		$this->label = filter_input(INPUT_POST, 'cat');
	}

	function selectDb() {

		if ($this->checkById()) {
			$query = "SELECT * FROM {$this->db_table} WHERE id = :id LIMIT 1;";
			$res = $this->db->prepare($query);
			$res->execute(array($this->id));
			$this->setResult($res);

			return;
		}

		if ($this->label) {
			$query = "SELECT * FROM {$this->db_table} WHERE label = :label LIMIT 1;";
			$res = $this->db->prepare($query);
			$res->execute(array($this->label));
			$this->setResult($res);
		}
	}

	function selectDbParentCategory() {
		if ($this->parent_id) {
			$query = "SELECT * FROM {$this->db_table} WHERE id = :parent_id LIMIT 1;";
			$res = $this->db->prepare($query);
			$res->execute(array($this->parent_id));
			$this->setResult($res);
		}
	}

	function incMaxPriority() {
		$query = "SELECT priority FROM {$this->db_table} WHERE parent_id = :parent_id ORDER BY priority DESC LIMIT 1;";
		$res = $this->db->prepare($query);
		$res->execute(array($this->parent_id));
		$this->priority = $res->fetchColumn() + 1;
	}

}
