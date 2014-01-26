<?php

namespace Kutny\Mail\Queue\ItemState;

class MailQueueItemStateFilter {

	private $queuedState;
	private $sendingState;
	private $retryState;
	private $sentState;
	private $errorState;

	public function setStateQueued() {
		$this->queuedState = true;
	}

	public function getStateQueued() {
		return $this->queuedState;
	}

	public function setStateSending() {
		$this->sendingState = true;
	}

	public function getStateSending() {
		return $this->sendingState;
	}

	public function setStateRetry() {
		$this->retryState = true;
	}

	public function getStateRetry() {
		return $this->retryState;
	}

	public function setStateSent() {
		$this->sentState = true;
	}

	public function getStateSent() {
		return $this->sentState;
	}

	public function setStateError() {
		$this->errorState = true;
	}

	public function getStateError() {
		return $this->errorState;
	}
}
