<?php
    $conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
    mysqli_query($conn,"SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
    $result=mysqli_query($conn,$sql);
?>