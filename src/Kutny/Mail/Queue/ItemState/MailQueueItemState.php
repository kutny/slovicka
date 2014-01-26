<?php

namespace Kutny\Mail\Queue\ItemState;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class MailQueueItemState {

	const ID_QUEUED = 1;
	const ID_SENDING = 2;
	const ID_RETRY = 3;
	const ID_SENT = 4;
	const ID_ERROR = 5;

	/**
	 * @ORM\Column(type="integer", nullable=false)
	 * @ORM\Id
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=15, nullable=false)
	 */
	private $name;

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

}
