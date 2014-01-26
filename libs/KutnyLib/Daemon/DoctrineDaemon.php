<?php

namespace KutnyLib\Daemon;

use Doctrine\ORM\EntityManager;
use KutnyLib\Application\IRunnable;
use KutnyLib\Application\Output\IOutput;
use KutnyLib\Php\GarbageCollector;

class DoctrineDaemon extends Daemon {

	private $entityManager;

	public function __construct(
		EntityManager $entityManager,
		IRunnable $runnable,
		IOutput $output,
		GarbageCollector $garbageCollector
	) {
		$this->entityManager = $entityManager;
		parent::__construct($runnable, $output, $garbageCollector);
	}

	protected function collectCycles() {
		$this->entityManager->clear();
		parent::collectCycles();
	}
}
