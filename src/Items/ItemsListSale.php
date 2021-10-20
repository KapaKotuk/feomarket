<?php

namespace Feomarket\Items;

class ItemsListSale extends ItemsList {

	function selectDbList() {

		$query = "SELECT * FROM catalog WHERE sale > 0";
		$query .= " AND visible = 1 AND arhiv = 0";

		if ($this->sort == '1')
			$query .= " ORDER BY name";
		if ($this->sort == '2')
			$query .= " ORDER BY price";
		if ($this->sort == '3')
			$query .= " ORDER BY price DESC";

		$start_list = ($this->list - 1) * $this->items_to_list;
		if ($start_list < 0)
			$start_list = 0;

		$query .= " LIMIT " . $start_list . ',' . $this->items_to_list;
		$query .= ";";

		$res = $this->db->prepare($query);
		$res->execute();

		if ($res) {
			$this->setResult($res);
		}
	}

}
