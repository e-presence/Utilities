<?php
/**
 * @author Viktor Bliszkó <viktor.bliszko@e-presence.hu>
 * @copyright Copyright (c) 2015-2016, e-presence, http://e-presence.hu
 */

namespace EPresence\Utilities;

use \Exception;

class ProcessLock {

	private $name;
	private $path;
	private $fullName;
	private $extension;
	
	public function __construct() {
		if (strtolower(PHP_SAPI) != 'cli') {
			throw new Exception('Only for CLI!');
		}
		if (strtolower(PHP_OS) != 'linux') {
			throw new Exception('Only for Linux!');
		}
		global $argv;
		$this->path = '/tmp/';
		$this->extension = '.lock';
		$this->name = basename($argv[0]);
		$this->fullName = $this->path . $this->name . $this->extension;
	}

	public function isRunning() {
		$is_running = false;
		if (file_exists($this->fullName)) {
			$locking_pid = trim(file_get_contents($this->fullName));
			$pids = explode("\n", trim(`ps -e | awk '{print $1}'`));
			if (in_array($locking_pid, $pids)) {
				$is_running = true;
			}
		}
		return $is_running;
	}
	
	public function lock() {
		$result = false;
		if (!$this->isRunning()) {
			$result = file_put_contents($this->fullName, getmypid() . "\n");
			$result = (boolean)$result;
		}
		return $result;
	}
	
	public function unlock() {
		$unlocked = false;
		if ($this->isRunning()) {
			@unlink($this->fullName);
			$unlocked = true;
		}
		return $unlocked;
	}

}
