<?php
/**
 * @author Viktor Bliszkó <viktor.bliszko@e-presence.hu>
 * @copyright Copyright (c) 2015-2016, e-presence, http://e-presence.hu
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

use EPresence\Utilities\ProcessLock;
use EPresence\Utilities\Console;

$process = new ProcessLock();
$console = new Console();

if ($process->isRunning()) {
	$console->warning('Already running.');
	exit(1);
}

$process->lock();
$console->readLn('Try to run this script in other terminal, then press [Enter] here');
$process->unlock();
exit(0);
