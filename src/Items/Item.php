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
			'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
			'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
			'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
			'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
			'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
			'ш' => 'sh', 'щ' => 'sch', 'ь' => '', 'ы' => 'y', 'ъ' => '',
			'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
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

		$arr_properties_data = ['company' => ['title' => 'Торговая марка', 'units' => []], 
									'volume' => ['title' => 'Объем', 'units' => ['1' => 'мл.', '1000' => 'л.']],
									'weight' => ['title' => 'Вес', 'units' => ['1' => 'гр.', '1000' => 'кг.']],
									'amount' => ['title' => 'Количество', 'units' => []],
									'layer' => ['title' => 'Слоев', 'units' => ['1' => 'сл.']]
									];
		
		$html = '';

		$html .= '<button class="btn btn_dialog_open_item_image_add">Добавить картинку</button>'
				. '<button class="btn btn_item_edit">Обновить</button>';
		
		$html .= '<div class="product_edit_box">'
				. '<div class="item_img column column_left dialog_image_add_editor">';

		if (is_file('../uploads/' . $this->id . '/1_medium.jpg')) 
			$html .= '<img src="/uploads/' . $this->id . '/1_medium.jpg" alt="пусто">';
		else
			$html .= '<img src="/img/theme/p_edit_no_image.png" alt="пусто">';
				
		$html .= '</div>';

		$html .= '<div class="column column_right">';
		
		$html .= '<div><h4>ID: <span id="item_edit_id">' . $this->id . '</span></h4></div>'
				. '<div><h4>Название:</h4><input value="' . $this->name . '" id="item_edit_name" autocomplete="off" type="text"></div>';
		
		$cat_list = '<select id="item_select_cat">'
					. '<option value="fungicidy">Фунгициды</option>'
					. '<option value="gerbecidy">Гербециды</option>'
					. '<option value="insekticidy">Инсектициды</option>'
					. '<option value="regulyatory-rosta">Регуляторы роста</option>'
					. '<option value="udobreniya">Удобрения</option>'
					. '<option value="grunty-i-torfosmesi">Грунты и торфосмеси</option>'
					. '<option value="raznoe">Разное</option>'
					. '<optgroup label="Семена">'
					. '<option value="tomat">Томат</option>'
					. '<option value="ogurec">Огурeц</option>'
					. '<option value="baklazhan">Баклажан</option>'
					. '<option value="bobovye">Бобовые</option>'
					. '<option value="morkov">Морковь</option>'
					. '<option value="kapusta">Капуста</option>'
					. '<option value="kabachok">Кабачок</option>'
					. '<option value="perec">Перец</option>'
					. '<option value="kukuruza">Кукуруза</option>'
					. '<option value="redis">Редис</option>'
					. '<option value="redka">Редька</option>'
					. '<option value="tykva">Тыква</option>'
					. '<option value="svekla">Свекла</option>'
					. '<option value="luk">Лук</option>'
					. '<option value="arbuz">Арбуз</option>'
					. '<option value="dynya">Дыня</option>'
					. '<option value="klubnika-zemlyanika">Клубника, земляника</option>'
					. '<option value="zelen">Зелень</option>'
					. '<option value="podsolnechnik">Подсолнечник</option>'
					. '<option value="pryanye-travy">Пряные травы</option>'
					. '<option value="mikrozelen">Микрозелень</option>'
					. '<option value="ekzotika">Экзотика</option>'
					. '<option value="semena-cvetov">Семена цветов</option>'
					. '<option value="miceliy-gribov">Мицелий грибов</option>'
					. '<option value="gazonnaya-trava">Газонная трава</option>'
					. '</optgroup>'
					. '</select>';
		
		$cat_list = str_replace('<option value="' . $this->cat_label . '">', '<option value="' . $this->cat_label . '" selected>', $cat_list);
		
		$html .= '<div><h4>Группа: </h4>'
				. $cat_list
				. '</div>';
		
		$html .= '<fieldset><legend>Цены</legend>'
				. '<div><h4>Цена:</h4><input value="' . $this->price . '" id="item_edit_price" autocomplete="off" type="text" maxlength="5" size="5"></div>'
				. '<div><h4>Скидка:</h4><input value="' . $this->sale . '" id="item_edit_sale" autocomplete="off" type="text" maxlength="5" size="5"></div>'
				. '</fieldset>';	
		
		$html .= '<fieldset><legend>Характеристики</legend>'
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
				. '<button id="property_add">Добавить</button>'
				. '</fieldset>';
		
		$html .= '</div>';
		
		$html .= '<fieldset><legend>Описание</legend>'
				. '<h4>Заметка:</h4><textarea rows="2" id="item_edit_note" class="" autocomplete="off">' . $this->note . '</textarea>'
				. '<h4>Описание:</h4></br><a id="button_bold" href="#"><b>Жирный</b></a><textarea rows="31" id="item_edit_desc" class="" autocomplete="off">' . $this->desc . '</textarea>'
				. '</fieldset>';
		
		$html .= '</div>';

		return $html;
	}

}
