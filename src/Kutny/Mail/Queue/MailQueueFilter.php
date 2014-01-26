<?php

namespace Kutny\Mail\Queue;

class MailQueueFilter {

	private $stateIds;
	private $order;
	private $limit;

	public function __construct() {
		$this->order = array();
	}

	public function setStateIds(array $ids) {
		$this->stateIds = $ids;
	}

	public function addOrderByCreatedOn($asc) {
		$this->order[] = array('createdOn' => $asc);
	}

	public function addOrderByStateId($asc) {
		$this->order[] = array('state.id' => $asc);
	}

	public function setLimit($count) {
		$this->limit = $count;
	}

	public function getStateIds() {
		return $this->stateIds;
	}

	public function getOrder() {
		return $this->order;
	}

	public function getLimit() {
		return $this->limit;
	}
}
