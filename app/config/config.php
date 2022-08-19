<?php
// DB params

//Get Heroku ClearDB connection information
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"], 1);
$active_group = 'default';
$query_builder = TRUE;

// Connect to DB
// $conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

define('DB_HOST', $cleardb_server);
define('DB_USER', $cleardb_username);
define('DB_PASS', $cleardb_password);
define('DB_NAME', $cleardb_db);


/* App root
    __FILE__ : /opt/lampp/htdocs/eventeny/app/config/config.php
    what we want: the app root: /opt/lampp/htdocs/eventeny/app
    dirname - remove the last file. We want to remove two files */
define('APPROOT', dirname(dirname(__FILE__)));

// URL root
define('URLROOT', 'https://eventeny-discount-code.herokuapp.com');

// Site Name
define('SITENAME', 'Eventeny');
