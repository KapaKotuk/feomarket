<?php

namespace Feomarket\Items;

use Feomarket\MySql\MysqlTable;

class Item extends MysqlTable {
	
	protected $db_table = 'catalog';
	
	public $id; //int(10) unsigned
	public $name; //varchar(45)
	public $note; //varchar(45)
	public $label; //varchar(45)
	public $cat_label; //int(10) unsigned
	public $price; //int(10) unsigned
	public $sale; //int(10) unsigned
	public $arr_properties; //TEXT
	public $desc; //text
	public $visible; //tinyint(1)
	public $arhiv; //tinyint(1)
	public $code_shop; //tinyint(1)
	public $count; //int (10)
	public $top;
	
	protected $arr_source = array(
		"name" => "",
		"note" => "",
		"label" => "",
		"cat_label" => "",
		"price" => "",
		"sale" => "",
		"arr_properties" => "",
		"desc" => "",
		"visible" => "",
		"arhiv" => "",
		"code_shop" => "",
		"count" => "",
		"top" => ""
	);

	public function __construct($db) {
		parent::__construct($db);
		$this->label = filter_input(INPUT_POST, 'item');
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

			return;
		}
		
		if ($this->code_shop) {
			$query = "SELECT * FROM {$this->db_table} WHERE code_shop = :code_shop LIMIT 1;";
			$res = $this->db->prepare($query);
			$res->execute(array($this->code_shop));
			$this->setResult($res);

			return;
		}
	}
	
	function selectDbFromCodeShop() {

		if ($this->code_shop) {
			$query = "SELECT * FROM {$this->db_table} WHERE code_shop = :code_shop LIMIT 1;";
			$res = $this->db->prepare($query);
			$res->execute(array($this->code_shop));
			$this->setResult($res);

			return;
		}
	}

	function insertDb() {

		if (!$this->id) {
			$this->setSource();
			$query = "INSERT INTO {$this->db_table} SET " . pdoSet($this->arr_source, $values);
			$res = $this->db->prepare($query);
			$res->execute($values);
			$this->id = $this->db->lastInsertId();
			$this->label = $this->id . "_" . $this->translit_sef($this->name);
			$this->updateDb();
		}
	}

	function updateDb() {

		if ($this->checkById()) {
			$this->label = $this->id . "_" . $this->translit_sef($this->name);
			$this->setSource();
			$sql = "UPDATE {$this->db_table} SET " . pdoSet($this->arr_source, $values) . "  WHERE id = :id";
			$res = $this->db->prepare($sql);
			$values["id"] = $this->id;
			$res->execute($values);
		}
	}

	function checkByLabel() {
		$res = $this->db->prepare("SELECT 1 FROM {$this->db_table} WHERE label = :label LIMIT 1");
		$res->execute(array($this->label));

		return (bool) $res->fetchColumn();
	}

	public function __get($property) {

		if ($property == 'name') {
			return $this->name;
		}
	}

	public function __set($property, $value) {
		if ($property == 'name') {
			$escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
			$replacements = '';
			$value = str_replace($escapers, $replacements, $value);
			$value = str_replace("  ", "", $value);
			$value = trim($value);

			$this->name = $value;
		}
	}

	public function translit_sef($value) {
		$converter = array(
			'??' => 'a', '??' => 'b', '??' => 'v', '??' => 'g', '??' => 'd',
			'??' => 'e', '??' => 'e', '??' => 'zh', '??' => 'z', '??' => 'i',
			'??' => 'y', '??' => 'k', '??' => 'l', '??' => 'm', '??' => 'n',
			'??' => 'o', '??' => 'p', '??' => 'r', '??' => 's', '??' => 't',
			'??' => 'u', '??' => 'f', '??' => 'h', '??' => 'c', '??' => 'ch',
			'??' => 'sh', '??' => 'sch', '??' => '', '??' => 'y', '??' => '',
			'??' => 'e', '??' => 'yu', '??' => 'ya',
		);

		$value = mb_strtolower($value);
		$value = strtr($value, $converter);
		$value = mb_ereg_replace('[^-0-9a-z]', '-', $value);
		$value = mb_ereg_replace('[-]+', '-', $value);
		$value = trim($value, '-');

		return $value;
	}

	function createJson() {

		$json = '{"item":[' . "\n";

		$json .= "\n" . '{' . '"id": "' . $this->id . '",';
		$json .= '"name": "' . $this->name . '",';
		$json .= '"note": "' . $this->note . '",';
		$json .= '"label": "' . $this->label . '",';
		$json .= '"cat_label": "' . $this->cat_label . '",';
		$json .= '"price": "' . $this->price . '",';
		$json .= '"sale": "' . $this->sale . '",';
		$json .= '"desc": "' . $this->desc . '",';
		$json .= '"visible": "' . $this->visible . '",';
		$json .= '"arhiv": "' . $this->arhiv . '",';
		$json .= '"code_shop": "' . $this->arhiv . '"';

		$json .= '},';

		$json = substr($json, 0, -1);
		$json .= '], "mimg": "OK", "status": "OK"}';

		return $json;
	}
	
	public function createHtml() {

		$arr_properties_data = ['company' => ['title' => '???????????????? ??????????', 'units' => []], 
									'volume' => ['title' => '??????????', 'units' => ['1' => '????.', '1000' => '??.']],
									'weight' => ['title' => '??????', 'units' => ['1' => '????.', '1000' => '????.']],
									'amount' => ['title' => '????????????????????', 'units' => []],
									'layer' => ['title' => '??????????', 'units' => ['1' => '????.']]
									];
		
		$html = '';

		$html .= '<button class="btn btn_dialog_open_item_image_add">???????????????? ????????????????</button>'
				. '<button class="btn btn_item_edit">????????????????</button>';
		
		$html .= '<div class="product_edit_box">'
				. '<div class="item_img column column_left dialog_image_add_editor">';

		if (is_file('../uploads/' . $this->id . '/1_medium.jpg')) 
			$html .= '<img src="/uploads/' . $this->id . '/1_medium.jpg" alt="??????????">';
		else
			$html .= '<img src="/img/theme/p_edit_no_image.png" alt="??????????">';
				
		$html .= '</div>';

		$html .= '<div class="column column_right">';
		
		$html .= '<div><h4>ID: <span id="item_edit_id">' . $this->id . '</span></h4></div>'
				. '<div><h4>????????????????:</h4><input value="' . $this->name . '" id="item_edit_name" autocomplete="off" type="text"></div>';
		
		$cat_list = '<select id="item_select_cat">'
					. '<option value="fungicidy">??????????????????</option>'
					. '<option value="gerbecidy">??????????????????</option>'
					. '<option value="insekticidy">??????????????????????</option>'
					. '<option value="regulyatory-rosta">???????????????????? ??????????</option>'
					. '<option value="udobreniya">??????????????????</option>'
					. '<option value="grunty-i-torfosmesi">???????????? ?? ????????????????????</option>'
					. '<option value="raznoe">????????????</option>'
					. '<optgroup label="????????????">'
					. '<option value="tomat">??????????</option>'
					. '<option value="ogurec">????????e??</option>'
					. '<option value="baklazhan">????????????????</option>'
					. '<option value="bobovye">??????????????</option>'
					. '<option value="morkov">??????????????</option>'
					. '<option value="kapusta">??????????????</option>'
					. '<option value="kabachok">??????????????</option>'
					. '<option value="perec">??????????</option>'
					. '<option value="kukuruza">????????????????</option>'
					. '<option value="redis">??????????</option>'
					. '<option value="redka">????????????</option>'
					. '<option value="tykva">??????????</option>'
					. '<option value="svekla">????????????</option>'
					. '<option value="luk">??????</option>'
					. '<option value="arbuz">??????????</option>'
					. '<option value="dynya">????????</option>'
					. '<option value="klubnika-zemlyanika">????????????????, ??????????????????</option>'
					. '<option value="zelen">????????????</option>'
					. '<option value="podsolnechnik">????????????????????????</option>'
					. '<option value="pryanye-travy">???????????? ??????????</option>'
					. '<option value="mikrozelen">??????????????????????</option>'
					. '<option value="ekzotika">????????????????</option>'
					. '<option value="semena-cvetov">???????????? ????????????</option>'
					. '<option value="miceliy-gribov">?????????????? ????????????</option>'
					. '<option value="gazonnaya-trava">???????????????? ??????????</option>'
					. '</optgroup>'
					. '</select>';
		
		$cat_list = str_replace('<option value="' . $this->cat_label . '">', '<option value="' . $this->cat_label . '" selected>', $cat_list);
		
		$html .= '<div><h4>????????????: </h4>'
				. $cat_list
				. '</div>';
		
		$html .= '<fieldset><legend>????????</legend>'
				. '<div><h4>????????:</h4><input value="' . $this->price . '" id="item_edit_price" autocomplete="off" type="text" maxlength="5" size="5"></div>'
				. '<div><h4>????????????:</h4><input value="' . $this->sale . '" id="item_edit_sale" autocomplete="off" type="text" maxlength="5" size="5"></div>'
				. '</fieldset>';	
		
		$html .= '<fieldset><legend>????????????????????????????</legend>'
				. '<div id="properties_box">';
		
		$arr_properties = json_decode($this->arr_properties, true);
		
		if (!empty($arr_properties)) {
			
			foreach($arr_properties as $key => $value) {
				$html .= '<div class="item_edit_property">'
						. '<select disabled>'
						. '<option value="' . $key . '">' . $arr_properties_data[$key]['title'] . '</option>'
						. '</select>'
						. '<input value="' . $value . '" id="item_edit_property_' . $key . '" autocomplete="off" type="text" maxlength="45">'
						. '</div>';
			}
		}
		
		$html .= '</div>'
				. '<button id="property_add">????????????????</button>'
				. '</fieldset>';
		
		$html .= '</div>';
		
		$html .= '<fieldset><legend>????????????????</legend>'
				. '<h4>??????????????:</h4><textarea rows="2" id="item_edit_note" class="" autocomplete="off">' . $this->note . '</textarea>'
				. '<h4>????????????????:</h4></br><a id="button_bold" href="#"><b>????????????</b></a><textarea rows="31" id="item_edit_desc" class="" autocomplete="off">' . $this->desc . '</textarea>'
				. '</fieldset>';
		
		$html .= '</div>';

		return $html;
	}

}
