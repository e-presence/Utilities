<?php
/**
 * @author Viktor Bliszkó <viktor.bliszko@e-presence.hu>
 * @copyright Copyright (c) 2015-2016, e-presence, http://e-presence.hu
 */

namespace EPresence\Utilities;

class Console {

	const DEFAULT_INPUT_BYTES = 128;
	const RED = "\033[31m";
	const YELLOW = "\033[1;33m";
	const GREEN = "\033[32m";
	const BLUE = "\033[34m";
	const WHITE = "\033[1;37m";
	const COLOR_RESET = "\033[0m";
	
	private $ioBuffer;
	
	public function read($bytes = self::DEFAULT_INPUT_BYTES) {
		$handler = fopen('php://stdin', 'r');
		$bytes = $this->validateInputBytesCount($bytes);
		$this->ioBuffer = rtrim(fgets($handler, $bytes));
		fclose($handler);
		return $this->ioBuffer;
	}
	
	public function error($message) {
		$this->write(static::RED . 'ERROR: ' . $message . $this->getResetCode());
	}
	
	public function warning($message) {
		$this->write(static::YELLOW . 'WARNING: ' . $message . $this->getResetCode());
	}
	
	public function info($message) {
		$this->write(static::GREEN . 'INFO: ' . $message . $this->getResetCode());
	}
	
	public function debug($message) {
		$this->write(static::BLUE . 'DEBUG: ' . $message . $this->getResetCode());
	}
	
	public function write($message) {
		echo $message;
	}
	
	private function getResetCode() {
		return static::COLOR_RESET . PHP_EOL;
	}
	
	private function validateInputBytesCount($bytes = self::DEFAULT_INPUT_BYTES) {
		$bytes = (integer)$bytes;
		if ($bytes <= 0) {
			$bytes = self::DEFAULT_INPUT_BYTES;
		}
		return $bytes;
	}
	
}
