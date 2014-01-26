<?php

namespace KutnyLib\Db;

interface IQuoter {

	/**
	 * @param string $value to be escaped
	 * @return string
	 */
	public function quote($value);

	/**
	 * @param string $identifier to be escaped
	 * @return string
	 */
	public function quoteIdentifier($identifier);

}
