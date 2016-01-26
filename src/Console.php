<?php
/**
 * @author Viktor Bliszkó <viktor.bliszko@e-presence.hu>
 * @copyright Copyright (c) 2015-2016, e-presence, http://e-presence.hu
 */

namespace EPresence\Utilities;

use EPresence\Utilities\Exceptions\NotCliModeException;

class Console {

	const RED = "\033[31m";
	const YELLOW = "\033[1;33m";
	const GREEN = "\033[32m";
	const BLUE = "\033[34m";
	const WHITE = "\033[1;37m";
	const COLOR_RESET = "\033[0m";
	
	private $ioBuffer;
	
	/**
	 * @throws EPresence\Utilities\Exceptions\NotCliModeException
	 */
	public function __construct() {
		if (strtolower(PHP_SAPI) != 'cli') {
			throw new NotCliModeException();
		}
	}
	
	/**
	 * @param string $message
	 * @param boolean $decorated
	 * @param boolean $line_break
	 * @return string
	 */
	public function read($message = '', $decorated = true, $line_break = false) {
		$message = trim($message);
		$decorated = (boolean)$decorated;
		$line_break = (boolean)$line_break;
		
		if ($decorated) {
			$message = $this->createDecoratedReadMessage($message);
		}
		if ($line_break) {
			$this->writeLn($message);
		} else {
			$this->write($message);
		}
		$this->ioBuffer = trim(fgets(STDIN));
		return $this->ioBuffer;
	}
	
	/**
	 * @param string $message
	 * @param boolean $decorated
	 * @return string
	 */
	public function readLn($message = '', $decorated = true) {
		return $this->read($message, $decorated, true);
	}
	
	/**
	 * @param string $message
	 */
	public function error($message = '') {
		$this->writeLn(static::RED . 'ERROR: ' . $message . static::COLOR_RESET);
	}
	
	/**
	 * @param string $message
	 */
	public function warning($message = '') {
		$this->writeLn(static::YELLOW . 'WARNING: ' . $message . static::COLOR_RESET);
	}
	
	/**
	 * @param string $message
	 */
	public function info($message = '') {
		$this->writeLn(static::GREEN . 'INFO: ' . $message . static::COLOR_RESET);
	}
	
	/**
	 * @param string $message
	 */
	public function debug($message = '') {
		$this->writeLn(static::BLUE . 'DEBUG: ' . $message . static::COLOR_RESET);
	}
	
	/**
	 * @param string $message
	 */
	public function write($message = '') {
		fwrite(STDOUT, $message);
	}
	
	/**
	 * @param string $message
	 */
	public function writeLn($message = '') {
		$this->write($message . PHP_EOL);
	}
	
	/**
	 * @param string $message
	 * @return string
	 */
	private function createDecoratedReadMessage($message = '') {
		$message = trim($message);
		if ($message > '') {
			$message .= ': ';
		}
		return $message;
	} 
	
}
