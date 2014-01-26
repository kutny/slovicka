<?php

namespace KutnyLib\DateTime;

use InvalidArgumentException;

class Time {

	private $hour;
	private $minute;
	private $second;

	public static function fromFormat($format, $value) {
		$dateTime = date_create_from_format($format, $value);

		if (!$dateTime) {
			throw new InvalidArgumentException();
		}

		$timestamp = $dateTime->getTimestamp();

		return new Time(
			date('H', $timestamp),
			date('i', $timestamp),
			date('s', $timestamp) + ($timestamp - (int)$timestamp)
		);
	}

	public function __construct($hour, $minute, $second) {
		$this->hour = (int)$hour;
		$this->minute = (int)$minute;
		$this->second = (float)$second;
	}

	public function getHour() {
		return $this->hour;
	}

	public function getMinute() {
		return $this->minute;
	}

	public function getSecond() {
		return $this->second;
	}

	public function toFormat($format) {
		return date(
			$format,
			mktime(
				$this->hour,
				$this->minute,
				round($this->second)
			)
		);
	}

	public function toSeconds() {
		return $this->hour * 3600 + $this->minute * 60 + $this->second;
	}
}
