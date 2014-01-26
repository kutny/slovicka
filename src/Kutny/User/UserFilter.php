<?php

namespace Kutny\User;

use KutnyLib\Model\Filter\Filter;
use KutnyLib\Model\QueryBuilderFilter\Condition;
use KutnyLib\Model\QueryBuilderFilter\Parameter;

class UserFilter extends Filter {

	public function setId($id) {
		$parameter = new Parameter('userId', $id);
		$condition = new Condition('user.id = :userId', [$parameter]);

		$this->add($condition);
	}

	public function setEmail($email) {
		$parameter = new Parameter('email', $email);
		$condition = new Condition('user.email = :email', [$parameter]);

		$this->add($condition);
	}

	public function setActive($active) {
		if ($active === true) {
			$condition = new Condition('user.active = 1');
		}
		else if ($active === false) {
			$condition = new Condition('user.active = 0');
		}
		else {
			throw new \Exception('Unexpected value: ' . var_export($active));
		}

		$this->add($condition);
	}

	public function getEntityClass() {
		return User::class;
	}

	public function getAlias() {
		return 'user';
	}
}
