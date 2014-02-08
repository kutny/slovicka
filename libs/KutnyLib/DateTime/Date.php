<?php

namespace KutnyLib\DateTime;

use DateTime as DateTimePhp;
use InvalidArgumentException;

class Date {

	private $year;
	private $month;
	private $day;

	public static function fromFormat($format, $value) {
		$dateTime = date_create_from_format($format, $value);

		if (!$dateTime) {
			throw new InvalidArgumentException();
		}

		$timestamp = $dateTime->getTimestamp();

		return new Date(
			date('Y', $timestamp),
			date('m', $timestamp),
			date('d', $timestamp)
		);
	}

	public static function fromDateTime(DateTimePhp $dateTime) {
		return new Date(
			$dateTime->format('Y'),
			$dateTime->format('m'),
			$dateTime->format('d')
		);
	}

	public function __construct($year, $month, $day) {
		$this->year = (int)$year;
		$this->month = (int)$month;
		$this->day = (int)$day;
	}

	public function getYear() {
		return $this->year;
	}

	public function getMonth() {
		return $this->month;
	}

	public function getDay() {
		return $this->day;
	}

	public function toFormat($format) {
		return date(
			$format,
			mktime(
				0,
				0,
				0,
				$this->month,
				$this->day,
				$this->year
			)
		);
	}

	public function toDateTime() {
		return new DateTimePhp(date("c", mktime(0, 0, 0, $this->month, $this->day, $this->year)));
	}
}
