<?php

namespace Kutny\Vocabulary;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Vocabulary {

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255, unique=true)
	 */
	private $englishVocabulary;

	public function __construct($englishVocabulary) {
		$this->englishVocabulary = $englishVocabulary;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setEnglishVocabulary($englishVocabulary) {
		$this->englishVocabulary = $englishVocabulary;
	}

	public function getEnglishVocabulary() {
		return $this->englishVocabulary;
	}

}
