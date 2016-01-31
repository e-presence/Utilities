<?php
/**
 * @author Viktor Bliszkó <viktor.bliszko@e-presence.hu>
 * @copyright Copyright (c) 2015-2016, e-presence, http://e-presence.hu
 */
namespace EPresence\Utilities;

use EPresence\Utilities\Exceptions\NotCliModeException;
use EPresence\Utilities\Exceptions\WindowsException;

class ProcessLock {
	private $name;
	private $path;
	private $extension;
	private $fullName;

	/**
	 * @throws EPresence\Utilities\Exceptions\NotCliModeException
	 * @throws EPresence\Utilities\Exceptions\WindowsException
	 */
	public function __construct() {
		if (strtolower(PHP_SAPI) != 'cli') {
			throw new NotCliModeException();
		}
		if (OperatingSystem::getInstance()->isWindows()) {
			throw new WindowsException();
		}
		global $argv;
		$this->path = sys_get_temp_dir();
		$this->extension = '.lock';
		$this->name = basename($argv[0]);
		$this->fullName = $this->path . DIRECTORY_SEPARATOR . $this->name . $this->extension;
	}

	/**
	 * @return bool
	 */
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

	/**
	 * @return bool
	 */
	public function lock() {
		$result = false;
		if (!$this->isRunning()) {
			$result = file_put_contents($this->fullName, getmypid() . "\n");
			$result = (bool) $result;
		}

		return $result;
	}

	/**
	 * @return bool
	 */
	public function unlock() {
		$unlocked = false;
		if ($this->isRunning()) {
			@unlink($this->fullName);
			$unlocked = true;
		}

		return $unlocked;
	}

}
