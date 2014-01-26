<?php

namespace Kutny\User;

use KutnyLib\Model\EntityList;

class UserList extends EntityList {

	public function getIds() {
		return $this->map(function(User $user) {
			return $user->getId();
		});
	}

}
