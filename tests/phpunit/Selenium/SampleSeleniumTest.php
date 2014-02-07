<?php

use KutnyLib\PhpUnit\TestCase;

class SampleSeleniumTest extends TestCase {

	/** @var RemoteWebDriver */
	private $driver;

	protected function setUp() {
		$host = 'http://127.0.0.1:4444/wd/hub'; // this is the default
		$capabilities = array(WebDriverCapabilityType::BROWSER_NAME => 'chrome');
		$this->driver = RemoteWebDriver::create($host, $capabilities);
	}

	/** @test */
	public function sampleTest() {
		$page = $this->driver->get('http://slovicka.my');

		$this->assertContains('Slovicka', $page->getTitle());

		$username = $this->driver->findElement(WebDriverBy::name('_username'));
		$username->sendKeys('jirkakoutny@gmail.com');
	}

}
