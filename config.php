<?php

error_reporting(E_ALL);
ob_start();
session_start();
date_default_timezone_set("Asia/Bangkok");



if(strpos($_SERVER['DOCUMENT_ROOT'], ":")){
    $db_config = array(
        "DB_host" => "localhost",
        "DB_name" => "car",
        "DB_user" => "root",
        "DB_pass" => "123456",
        "DB_charset" => "utf8",
    );
}else{
    $db_config = array(
        "DB_host" => "localhost",
        "DB_name" => "car",
        "DB_user" => "root",
        "DB_pass" => "123456",
        "DB_charset" => "utf8",
    );
}


?>