<?php

namespace KutnyLib\DateTime;

class DateTimeFactory implements IDateTimeFactory {

	/** @return DateTime */
	public function getCurrentDateTime() {
		$timestamp = microtime(true);

		return new DateTime(
			new Date(
				date('Y', $timestamp),
				date('m', $timestamp),
				date('d', $timestamp)
			),
			new Time(
				date('H', $timestamp),
				date('i', $timestamp),
				date('s', $timestamp) + ($timestamp - (int)$timestamp)
			)
		);
	}

	public function getMicrotime() {
		return microtime(true);
	}
}
