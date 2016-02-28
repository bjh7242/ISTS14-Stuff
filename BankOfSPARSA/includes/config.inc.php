<?php
$folder = "/ISTS14-Stuff/BankOfSPARSA/";
$domain = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $folder;
$root = realpath($_SERVER["DOCUMENT_ROOT"]) . $folder;
// Bank API: https://github.com/csanders-git/BankOfSPARSA
define('DB_HOST', 'localhost');
define('DB_NAME', 'BankOfSPARSA');
define('DB_USER','root');
define('DB_PASSWORD','imxyubx');
define('BANK_API_ADDRESS','http://mycourses.tk');
define('BANK_API_PORT','5000');
define('LOCAL_ROUTING_NUMBER','01');  // routing number for this bank instance
define('API_ACCOUNT_NUM','0112345678');
define('API_PASSWORD','test3');
?>
