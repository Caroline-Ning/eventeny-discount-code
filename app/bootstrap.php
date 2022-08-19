<?php
// load config
require_once 'config/config.php';

// load helper functions
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';


// load all libraries
spl_autoload_register(function ($className) {
  require_once 'libraries/' . $className . '.php';
});

// set timezone to user's browser
// date_default_timezone_set("America/New_York");
