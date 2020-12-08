<?php

require_once(realpath(dirname(__FILE__) ."/../config.php"));

try{
    $conn = new PDO("mysql:host={$db_config['DB_host']};dbname={$db_config['DB_name']}", $db_config['DB_user'], $db_config['DB_pass']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("set names ".$db_config['DB_charset']);
}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

?>