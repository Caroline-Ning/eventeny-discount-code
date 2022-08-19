<?php
// load all libriares
require_once '../app/bootstrap.php';

// init core library
$init = new Core;

error_reporting(E_ALL & E_STRICT);
ini_set('display_errors', '1');
ini_set('log_errors', '0');
ini_set('error_log', './');
