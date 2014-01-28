<?php

namespace Kutny\Vocabulary\UserVocabulary;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Kutny\User\User;
use Kutny\Vocabulary\Vocabulary;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="user_vocabulary", columns={"user_id", "vocabulary_id"})})
 * @ORM\Entity
 */
class UserVocabulary {

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

	/**
	 * @var Vocabulary
	 * @ORM\ManyToOne(targetEntity="\Kutny\Vocabulary\Vocabulary")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $vocabulary;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="\Kutny\User\User")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $user;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $userTranslation;

	/**
	 * @ORM\Column(type="string", length=1000, nullable=true)
	 */
	private $explanation;

	/**
	 * @ORM\Column(type="string", length=1000, nullable=true)
	 */
	private $note;

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setCreatedAt(DateTime $createdAt) {
		$this->createdAt = $createdAt;
	}

	public function getCreatedAt() {
		return $this->createdAt;
	}

	public function setUser($user) {
		$this->user = $user;
	}

	public function getUser() {
		return $this->user;
	}

	public function setVocabulary(Vocabulary $vocabulary) {
		$this->vocabulary = $vocabulary;
	}

	public function getVocabulary() {
		return $this->vocabulary;
	}

	public function setUserTranslation($userTranslation) {
		$this->userTranslation = $userTranslation;
	}

	public function getUserTranslation() {
		return $this->userTranslation;
	}

	public function setExplanation($explanation) {
		$this->explanation = $explanation;
	}

	public function getExplanation() {
		return $this->explanation;
	}

	public function setNote($note) {
		$this->note = $note;
	}

	public function getNote() {
		return $this->note;
	}

}
