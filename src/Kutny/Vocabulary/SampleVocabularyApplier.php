<?php

namespace Kutny\Vocabulary;

use Kutny\FixturesBundle\ISampleDataApplier;
use Kutny\User\UserFilter;
use Kutny\User\UserRepository;
use Kutny\Vocabulary\UserVocabulary\UserVocabularyInsertionFacade;
use Symfony\Component\Console\Output\OutputInterface;

class SampleVocabularyApplier implements ISampleDataApplier {

	private $userVocabularyInsertionFacade;
	private $userRepository;

	public function __construct(UserVocabularyInsertionFacade $userVocabularyInsertionFacade, UserRepository $userRepository) {
		$this->userVocabularyInsertionFacade = $userVocabularyInsertionFacade;
		$this->userRepository = $userRepository;
	}

	public function apply(OutputInterface $output) {
		$output->writeln('Adding sample vocabulary');

		$this->createVocabulary(
			'tilt',
			'převrhnout',
			'to move something so that one side is lower than the other',
			'How should you tilt a bottle to pour the liquid out fastest?'
		);

		$this->createVocabulary(
			'cheeky',
			'drzý, hubatý',
			'behaving in a way that does not show respect, especially towards someone who is older or more important',
			'How do you handle cheeky and rude 12 year olds?'
		);

		$this->createVocabulary(
			'plea',
			'námitka u soudu',
			'a legal statement that someone makes in a court of law to say whether they are guilty of a crime or not',
			'India top court refuses plea to review gay sex ban'
		);

		$this->createVocabulary(
			'outcast',
			'psanec, vyvrženec',
			'someone who other people will not accept as a member of society or of a particular group or community',
			'He has spent his entire life as an outcast hidden on a remote island'
		);

		$this->createVocabulary(
			'extortion',
			'vydírání',
			'a crime in which someone gets money or information from someone else by using force or threats',
			null
		);

		$this->createVocabulary(
			'confluence',
			'soutok',
			'a place where two rivers join',
			null
		);
	}

	private function createVocabulary($vocabulary, $userTranslation, $explanation, $note) {
		$user = $this->getUser(1);

		$userVocabulary = $this->userVocabularyInsertionFacade->insert($vocabulary, $userTranslation, $note, $user);
		$userVocabulary->setExplanation($explanation);

		$this->userVocabularyInsertionFacade->update($userVocabulary);
	}

	private function getUser($userId) {
		$userFilter = new UserFilter();
		$userFilter->setId($userId);

		return $this->userRepository->fetch($userFilter);
	}

}
