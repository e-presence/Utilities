<?php
/**
 * @author Viktor Bliszkó <viktor.bliszko@e-presence.hu>
 * @copyright Copyright (c) 2015-2016, e-presence, http://e-presence.hu
 */
namespace EPresence\Utilities\Exceptions;

use \Exception;

class WindowsException extends Exception {
	public function __construct() {
		parent::__construct();
		$this->message = 'Not compatible with MS Windows systems.';
	}

}
