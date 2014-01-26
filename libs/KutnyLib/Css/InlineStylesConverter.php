<?php

namespace KutnyLib\Css;

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class InlineStylesConverter {

	public function convert($html, $css = null) {
		$cssToInlineStyles = new CssToInlineStyles($html, $css);
		$cssToInlineStyles->setUseInlineStylesBlock($css === null);

		return $cssToInlineStyles->convert(false);
	}

}
