<?php
    // DB params
    define('DB_HOST','localhost');
    define('DB_USER','root');
    define('DB_PASS','');
    define('DB_NAME','eventeny');

    /* App root
    __FILE__ : /opt/lampp/htdocs/eventeny/app/config/config.php
    what we want: the app root: /opt/lampp/htdocs/eventeny/app
    dirname - remove the last file. We want to remove two files */
    define('APPROOT',dirname(dirname(__FILE__)));

    // URL root
    define('URLROOT','http://localhost:8080/eventeny');

    // Site Name
    define('SITENAME','Eventeny');

    
