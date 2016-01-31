<?php
/**
 * @author Viktor Bliszkó <viktor.bliszko@e-presence.hu>
 * @copyright Copyright (c) 2015-2016, e-presence, http://e-presence.hu
 */
namespace EPresence\Utilities;

class OperatingSystem {
	private $isWindows;
	private static $instance;

	/**
	 * Gets the instance.
	 *
	 * @return self
	 */
	public static function getInstance() {
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * @return bool
	 */
	public function isWindows() {

		return $this->isWindows;
	}

	/**
	 * Dynamically internal instantiation.
	 */
	private function __construct() {
		global $argv;
		$this->isWindows = (strtolower(substr(PHP_OS, 0, 3)) === 'win');
	}

	/**
	 * Prevents the instance from being cloned.
	 */
	final private function __clone() {}

	/**
	 * Prevents from being unserialized.
	 */
	final private function __wakeup() {}

}
