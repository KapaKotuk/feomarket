<?php

namespace Feomarket\Items;

class ItemInfo extends Item {

	public $properties_html;

	function createHtml() {

		$html = '<div class="content_item_info">';
		$html .= '<div>';

		$html .= '<div class="item" '
				. 'data-id="' . $this->id . '" '
				. 'data-name="' . $this->name . '" '
				. 'data-price="' . $this->price . '" '
				. 'data-count="1" '
				. 'data-sale="' . $this->sale . '" '
				. 'id="item_' . $this->id . '">';

		$html .= '<div class="item_content">';
		$html .= '<div class="item_gallery">'
				. '<img src="/uploads/' . $this->id . '/1_medium.jpg" '
				. 'alt="' . $this->name . '">'
				. '</div>';

		$html .= '<h2>' . $this->name . '</h2>';
		$html .= '<span>В наличии</span>';

		if ($this->sale > 0) {
			$html .= '<div class="item_sale_info">'
					. '<img src="/img/theme/item_sale.png" alt="Скидка">'
					. '<div class="item_sale_price_info">'
					. '<span>' . $this->sale . '</span> руб./шт.'
					. '</div>'
					. '</div>';
			$html .= '<div class="item_price_box">'
					. '<div class="item_price item_price_sale">'
					. '<span>' . $this->price . '</span> руб./шт.'
					. '</div>'
					. '</div>';
		} else {
			$html .= '<div class="item_price_box">'
					. '<div class="item_price">'
					. '<span>' . $this->price . '</span> руб./шт.'
					. '</div>'
					. '</div>';
		}

//		$html .= '<button class="btn item_buy">Купить</button>';
		$html .= '</div>';
		$html .= '</div>';
		
		$html .= '<div class="content_box" value="0">'
				. '<h3 style="margin-top: 0;">Описание:</h3>'
				. $this->desc
				. '</div>';

		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}
}
