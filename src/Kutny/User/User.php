<?php

namespace Kutny\User;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class User implements UserInterface, \Serializable {

    const ROLE_USER = 'ROLE_USER';

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=150, unique=true)
	 * @Assert\Email()
	 */
	private $email;

	/**
	 * @ORM\Column(type="string", length=150, nullable=true)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $password;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $active;

	/**
	 * @ORM\Column(type="string", length=40, nullable=true)
	 */
	private $facebookId;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

	/**
	 * @ORM\Column(type="string", length=15, nullable=true)
	 */
	private $registrationIpAddress;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $lastLoginAt;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	private $role;

	public function __construct($email) {
		$this->email = $email;
		$this->role = self::ROLE_USER;
		$this->active = true;
	}

	public function setActive($active) {
		$this->active = $active;
	}

	public function getActive() {
		return $this->active;
	}

	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
	}

	public function getCreatedAt() {
		return $this->createdAt;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setFacebookId($facebookId) {
		$this->facebookId = $facebookId;
	}

	public function getFacebookId() {
		return $this->facebookId;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setLastLoginAt($lastLoginAt) {
		$this->lastLoginAt = $lastLoginAt;
	}

	public function getLastLoginAt() {
		return $this->lastLoginAt;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setRegistrationIpAddress($registrationIpAddress) {
		$this->registrationIpAddress = $registrationIpAddress;
	}

	public function getRegistrationIpAddress() {
		return $this->registrationIpAddress;
	}

	public function setRole($role) {
		$this->role = $role;
	}

	public function getRole() {
		return $this->role;
	}

	/**
	 * @inheritDoc
	 */
	public function getUsername() {
		return $this->email;
	}

	/**
	 * @inheritDoc
	 */
	public function getSalt() {
		return null;
	}

	/**
	 * @inheritDoc
	 */
	public function getRoles() {
		return array($this->role);
	}

	public function eraseCredentials() {

	}

	public function serialize() {
		return serialize(array(
			$this->id,
			$this->email,
			$this->password
		));
	}

	public function unserialize($serialized) {
		list (
			$this->id,
			$this->email,
			$this->password
		) = unserialize($serialized);
	}

}
