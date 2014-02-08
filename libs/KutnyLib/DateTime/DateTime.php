<?php

namespace KutnyLib\DateTime;

use DateInterval;
use InvalidArgumentException;

class DateTime {

	private $date;
	private $time;

	public static function fromFormat($format, $value) {
		$dateTime = date_create_from_format($format, $value);

		if (!$dateTime) {
			throw new InvalidArgumentException();
		}

		return self::fromTimestamp($dateTime->getTimestamp());
	}

	public static function fromTimestamp($timestamp) {
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

	public static function fromPhpDateTime(\DateTime $dateTime) {
		return self::fromTimestamp($dateTime->getTimestamp());
	}

	public function __construct(Date $date, Time $time) {
		$this->date = $date;
		$this->time = $time;
	}

	public function getDate() {
		return $this->date;
	}

	public function getTime() {
		return $this->time;
	}

	public function toFormat($format) {
		return date($format, $this->toTimestamp());
	}

	/** @return \DateTime */
	public function toDateTime() {
		return new \DateTime($this->toFormat('r'));
	}

	public function toTimestamp() {
		return mktime(
			$this->time->getHour(),
			$this->time->getMinute(),
			(int)$this->time->getSecond(),
			$this->date->getMonth(),
			$this->date->getDay(),
			$this->date->getYear()
		);
	}

	public function isBetween(DateTime $start, DateTime $end) {
		$thisDateTime = $this->toDateTime();
		return $thisDateTime < $end->toDateTime() ? $thisDateTime > $start->toDateTime() : false;
	}

	public function addDays($days) {
		$thisDateTime = $this->toDateTime();
		$thisDateTime->add(new DateInterval('P' . $days . 'D'));

		return self::fromTimestamp($thisDateTime->getTimestamp());
	}

	public function addInterval(DateInterval $interval) {
		$thisDateTime = $this->toDateTime();
		$thisDateTime->add($interval);

		return self::fromTimestamp($thisDateTime->getTimestamp());
	}

	public function subInterval(DateInterval $interval) {
		$thisDateTime = $this->toDateTime();
		$thisDateTime->sub($interval);

		return self::fromTimestamp($thisDateTime->getTimestamp());
	}

	public function addWorkingDays($days) {
		$weekendDays = ((int)($days / 5) * 2);

		$thisDateTime = $this->toDateTime();
		$thisDateTime->add(new DateInterval('P' . ($days + $weekendDays) . 'D'));

		if ($thisDateTime->format('N') < $this->toDateTime()->format('N')) {
			$thisDateTime->add(new DateInterval('P' . ((int)$this->toDateTime()->format('N') === 7 ? 1 : 2) . 'D'));
		}

		if ((int)$thisDateTime->format('N') === 7) {
			$thisDateTime->add(new DateInterval('P' . 1 . 'D'));
		}

		if ((int)$thisDateTime->format('N') === 6) {
			$thisDateTime->add(new DateInterval('P' . 2 . 'D'));
		}

		return self::fromTimestamp($thisDateTime->getTimestamp());
	}

	public function subDays($days) {
		$thisDateTime = $this->toDateTime();
		$thisDateTime->sub(new DateInterval('P' . $days . 'D'));

		return self::fromTimestamp($thisDateTime->getTimestamp());
	}
}
