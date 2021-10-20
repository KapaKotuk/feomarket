<?php

namespace Feomarket\Items;

use Feomarket\Items\ItemsList;

class SaleBlockList extends ItemsList
{

	function selectDbList()
    {
		$this->selectDbCount();

		$query = array();

		$arr = [0,1,2,3];
				
		if($this->items_count > 4)
			$arr = $this->numbers(4, 0, $this->items_count - 1);
		
		foreach ($arr as $value) 
		{
			$query[] = "(SELECT * FROM catalog WHERE sale > 0 AND visible = 1 AND arhiv = 0 LIMIT {$value}, 1)";
		}

		$query = implode(' UNION ', $query);
		$query .= ";";

		$res = $this->db->prepare($query);
		$res->execute();
		
		if($res) {
			$this->setResult($res);
		}
	}
	
	function selectDbCount()
    {
		$this->items_count = 0;
				
		$query = "SELECT COUNT(*) FROM catalog WHERE sale > 0 AND visible = 1 AND arhiv = 0;";

		$res = $this->db->prepare($query);
		$res->execute();
		
		$this->items_count = $res->fetchColumn();
	}
	
		/*
	$pieces - количество выводимых цифр
	$min - от какой цифры мы берем рандом
	$max - до какой цифры мы берем рандом
	*/
   function numbers($pieces, $min, $max) {
		if (($max - $min) < $pieces)
			$pieces = $max - $min;

		$arr = array();
		while ($pieces) {
			$number = mt_rand($min, $max);
			if (!in_array($number, $arr)) {
				$arr[] = $number;
			} else {
				$pieces++;
			}
			$pieces--;
		}
		return $arr;
	}

}
