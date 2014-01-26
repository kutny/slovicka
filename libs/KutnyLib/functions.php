<?php

/**
 * @SuppressWarnings(PMD.ShortMethodName)
 */
function vd($variable, $label = null) {
	if ($label) {
		echo '<div style="color: blue">' . $label . ':</div>';
	}

	echo '<pre>';
	var_dump($variable);
	echo '</pre>';
}

function vdf($var, $label = null) {
	vd($var, $label);

	if (ob_get_level() > 0) {
		ob_flush();
	}

	flush();
}

/**
 * @SuppressWarnings(PMD.ExitExpression)
 */
function vdx($var, $label = null) {
	vd($var, $label);
	exit;
}

function mbchr($u) {
	return html_entity_decode("&#{$u};", ENT_NOQUOTES, 'UTF-8');
}

function xmlspecialchars($text) {
	return str_replace('&#039;', '&apos;', htmlspecialchars($text, ENT_QUOTES));
}
