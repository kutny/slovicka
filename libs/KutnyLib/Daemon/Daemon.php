<?php

namespace KutnyLib\Daemon;

use KutnyLib\Application\IRunnable;
use KutnyLib\Application\Output\IOutput;
use KutnyLib\Php\GarbageCollector;

declare(ticks = 1);

class Daemon implements IDaemon {

	protected $runnable;
	protected $garbageCollector;
	protected $output;
	protected $run;

	public function __construct(IRunnable $runnable, IOutput $output, GarbageCollector $garbageCollector) {
		$this->runnable = $runnable;
		$this->output = $output;
		$this->garbageCollector = $garbageCollector;
	}

	public function engage() {
		$this->output->writeln('Starting...');
		$this->registerSignalHandlers();
		$this->run = true;

		while ($this->run) {
			$this->runnable->run();
			$this->collectCycles();
		}

		$this->output->writeln('Done. Exiting now.');
	}

	public function registerSignalHandlers() {
		if (PHP_OS === 'Linux') {
			pcntl_signal(SIGTERM, array($this, 'signalHandler'));
			pcntl_signal(SIGINT, array($this, 'signalHandler'));
		}
	}

	public function signalHandler($signal) {
		$this->output->writeln('Daemon was asked to die nicely. (signal ' . $signal . ')');
		$this->run = false;
	}

	protected function collectCycles() {
		$this->garbageCollector->collectCycles();
	}
}
