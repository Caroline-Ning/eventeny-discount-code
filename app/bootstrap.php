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
$ip     = $_SERVER['HTTP_X_FORWARDED_FOR']; // user's IP address 
$json   = file_get_contents('ip-api.com/json/' . $ip); // obtain timezone by IP
$ipData = json_decode($json, true); // object, contain ip info
echo $ip, $json, $ipData;
if ($ipData['timezone']) {
  date_default_timezone_set($ipData['timezone']);
} else {
  echo "can't detect the timezone at your location";
}
