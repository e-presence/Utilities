<?php
/**
 * @author Viktor Bliszkó <viktor.bliszko@e-presence.hu>
 * @copyright Copyright (c) 2015-2016, e-presence, http://e-presence.hu
 */

namespace EPresence\Utilities;

class StdIo {

	const DEFAULT_INPUT_BYTES = 128;
	
	private $ioBuffer;
	
	public function read($bytes = self::DEFAULT_INPUT_BYTES) {
		$handler = fopen('php://stdin', 'r');
		$bytes = $this->validateInputBytesCount($bytes);
		$this->ioBuffer = rtrim(fgets($handler, $bytes));
		fclose($handler);
		return $this->ioBuffer;
	}
	
	private function validateInputBytesCount($bytes = self::DEFAULT_INPUT_BYTES) {
		$bytes = (integer)$bytes;
		if ($bytes <= 0) {
			$bytes = self::DEFAULT_INPUT_BYTES;
		}
		return $bytes;
	}
	
}
