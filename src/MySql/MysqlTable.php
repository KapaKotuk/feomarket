<?php

namespace Feomarket\MySql;

use PDO;

class MysqlTable {

	protected $db;
	protected $db_table = 'table_name';
	
	public $id; //int(10) unsigned
	
	protected $arr_source = array();

	public function __construct($db) {
		$this->db = $db;
		$this->id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
	}

	function setSource() {

		foreach ($this->arr_source as $key => $value) {
			$this->arr_source[$key] = $this->$key;
		}
	}
	
	function setResult($res) {

		if ($res) {
			$row = $res->fetch(PDO::FETCH_LAZY);
			if (!empty($row)) {
				$this->setVariable($row);
			}
		}
	}

	function setVariable($row) {
		$this->id = $row->id;

		foreach ($this->arr_source as $key => $value) {
			$this->$key = $row->$key;
		}
	}

	function selectDb() {

		if ($this->checkById()) {
			$query = "SELECT * FROM {$this->db_table} WHERE id = :id LIMIT 1;";
			$res = $this->db->prepare($query);
			$res->execute(array($this->id));
			$this->setResult($res);

			return;
		}
	}

	function insertDb() {

		if (!$this->id) {
			$this->setSource();
			$query = "INSERT INTO {$this->db_table} SET " . pdoSet($this->arr_source, $values) . ";";
			$res = $this->db->prepare($query);
			$res->execute($values);
			$this->id = $this->db->lastInsertId();
		}
	}

	function updateDb() {
		
		if ($this->checkById()) {
			$this->setSource();
			$query = "UPDATE {$this->db_table} SET " . pdoSet($this->arr_source, $values) . "  WHERE id = :id;";
			$res = $this->db->prepare($query);
			$values["id"] = $this->id;
			$res->execute($values);
		}
	}

	function checkById() {

		if (!$this->id)
			return false;
		$query = "SELECT 1 FROM {$this->db_table} WHERE id = :id LIMIT 1;";
		$res = $this->db->prepare($query);
		$res->execute(array($this->id));

		return (bool) $res->fetchColumn();
	}

}
