<?php

namespace Kutny\Practising\Answer;

use Doctrine\ORM\Mapping as ORM;
use Kutny\Vocabulary\UserVocabulary\UserVocabulary;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Answer {

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var UserVocabulary
	 * @ORM\ManyToOne(targetEntity="\Kutny\Vocabulary\UserVocabulary\UserVocabulary")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $userVocabulary;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $answeredCorrectly;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	private $answeredAt;

	public function __construct($answeredCorrectly, UserVocabulary $userVocabulary, \DateTime $answeredAt) {
		$this->answeredCorrectly = $answeredCorrectly;
		$this->userVocabulary = $userVocabulary;
		$this->answeredAt = $answeredAt;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setUserVocabulary(UserVocabulary $userVocabulary) {
		$this->userVocabulary = $userVocabulary;
	}

	public function getUserVocabulary() {
		return $this->userVocabulary;
	}

	public function setAnsweredAt(\DateTime $answeredAt) {
		$this->answeredAt = $answeredAt;
	}

	public function getAnsweredAt() {
		return $this->answeredAt;
	}

	public function setAnsweredCorrectly($answeredCorrectly) {
		$this->answeredCorrectly = $answeredCorrectly;
	}

	public function getAnsweredCorrectly() {
		return $this->answeredCorrectly;
	}

}
