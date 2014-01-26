<?php

namespace KutnyLib\Db;

class SqlFileImporter {

	private $dbHost;
	private $dbName;
	private $dbUser;
	private $dbPassword;
	private $dbPort;
	private $mysqlBinariesPath;

	public function __construct($dbHost, $dbName, $dbUser, $dbPassword, $dbPort, $mysqlBinariesPath) {
		$this->dbHost = $dbHost;
		$this->dbName = $dbName;
		$this->dbUser = $dbUser;
		$this->dbPassword = $dbPassword;
		$this->dbPort = $dbPort;
		$this->mysqlBinariesPath = $mysqlBinariesPath;
	}

	public function import($sqlImportFilePath) {
		exec($this->buildImportCommand($sqlImportFilePath), $output, $returnValue);

		if ($returnValue !== 0) {
			throw new UnableToImportSqlFileException(implode(', ', $output));
		}
	}

	private function buildImportCommand($sqlImportFilePath) {
		return
		'"' . $this->mysqlBinariesPath . DIRECTORY_SEPARATOR . 'mysql" --host=' . $this->dbHost . ' --port=' . $this->dbPort .
		' --user=' . $this->dbUser . ' --password=' . $this->dbPassword . ' --database=' . $this->dbName . ' 2>&1 < ' . $sqlImportFilePath;
	}

}
