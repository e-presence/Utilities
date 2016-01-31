<?php
/**
 * @author Viktor Bliszkó <viktor.bliszko@e-presence.hu>
 * @copyright Copyright (c) 2015-2016, e-presence, http://e-presence.hu
 */
use EPresence\Utilities\OperatingSystem;

class OperatingSystemTest extends PHPUnit_Framework_TestCase {
	private $os;

	public function setUp() {
		$this->os = OperatingSystem::getInstance();
	}

	public function testInstance() {
		$this->assertTrue($this->os instanceof EPresence\Utilities\OperatingSystem);
	}
	
	public function testNewInstance() {
		//$os = new OperatingSystem();
	}
	
	/**
	 * @todo add more possible values
	 */
	public function testIsWindows() {
		$os_name = strtolower(PHP_OS);
		if ($os_name == 'linux'
			|| $os_name == 'freebsd') {
			$this->assertFalse($this->os->isWindows());
		}
		if ($os_name == 'windows') {
			$this->assertTrue($this->os->isWindows());
		}
	}

}
