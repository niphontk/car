<?php

require_once(realpath(dirname(__FILE__) ."/../../db_function/connection.php"));
require_once(realpath(dirname(__FILE__) ."/../../db_function/function.php"));

if(isset($_GET["action"]) && $_GET["action"] == "save_category"){


    if(!empty($_POST["driver_id"])){

        $req = array(
            "is_active" => isset($_POST["is_active"]) ? $_POST["is_active"] : "N",
            "driver_name" => isset($_POST["driver_name"]) ? $_POST["driver_name"] : "",
            "driver_id" => isset($_POST["driver_id"]) ? $_POST["driver_id"] : "",
        );

        $required = array(
            "driver_name" => "driver_name",   
            "driver_id" => "driver_id",   
        );
    
        if(validate($req, $required) === FALSE){
            $_SESSION["STATUS"] = FALSE;
            $_SESSION["MSG"] = lang("Invalid Data.", false);
            header("location:../../index.php?page=driver");
            exit();
        }

        $req["driver_name"] = filter_var_string($_POST["driver_name"], "Driver Name");

        try{
            $sql = "UPDATE `driver` SET ";
            $sql .= " `is_active` = :is_active, ";
            $sql .= " `name` = :driver_name ";
            $sql .= "  WHERE `id` = :driver_id  ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":is_active",$req["is_active"]);
            $stmt->bindParam(":driver_name",$req["driver_name"]);
            $stmt->bindParam(":driver_id",$req["driver_id"]);
            $result = $stmt->execute();
        
            if($result){
                $_SESSION["STATUS"] = TRUE;
                $_SESSION["MSG"] = lang("Data update successful.", false);
                header("location:../../index.php?page=driver");
                exit();
             
            }
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            die();
        }

    }else{
        $req = array(
            "is_active" => isset($_POST["is_active"]) ? $_POST["is_active"] : "",
            "driver_name" => isset($_POST["driver_name"]) ? $_POST["driver_name"] : "",
        );
    
        $required = array(
            "driver_name" => "driver_name",   
        );
    
        if(validate($req, $required) === FALSE){
            $_SESSION["STATUS"] = FALSE;
            $_SESSION["MSG"] = lang("Invalid Data.", false);
            header("location:../../index.php?page=driver");
            exit();
        }

        $req["driver_name"] = filter_var_string($_POST["driver_name"], "Driver Name");

        try{
            $sql = "INSERT INTO `driver` SET ";
            $sql .= " `is_active` = :is_active, ";
            $sql .= " `name` = :driver_name ";
            // $sql .= "  WHERE `id` = :id  ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":is_active",$req["is_active"]);
            $stmt->bindParam(":driver_name",$req["driver_name"]);
            $result = $stmt->execute();
        
            if($result){
                $_SESSION["STATUS"] = TRUE;
                $_SESSION["MSG"] = lang("Successfully saved data.", false);
                header("location:../../index.php?page=driver");
                exit();
             
            }
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            die();
        }
    }
    

}elseif(isset($_GET["action"]) && $_GET["action"] == "delete"){

    $req = array(
        "driver_id" => $_GET["driver_id"],
    );

    $required = array(  
        "driver_id" => "Driver ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        header("location:../../index.php?page=driver");
        exit();
    }

try{
    $sql = "UPDATE `driver` SET  ";
    $sql .= " `is_delete` = 'Y'  ";
    $sql .= "  WHERE `id` = :driver_id ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":driver_id",$req["driver_id"], PDO::PARAM_INT);
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Successful data deletion.", false);
        header("location:../../index.php?page=driver");
        exit();
     
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}


}elseif(isset($_GET["action"]) && $_GET["action"] == "delete_all"){

    $req = array(
        "driver_id" => $_POST["ch"],
    );

    $required = array(  
        "driver_id" => "Driver ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        header("location:../../index.php?page=driver");
        exit();
    }

    $arr = array();
    $driver_id = implode(",", $req["driver_id"]);

try{
    $sql = "UPDATE `driver` SET  ";
    $sql .= " `is_delete` = 'Y'  ";
    $sql .= "  WHERE `id` IN ($driver_id) ";

    $stmt = $conn->prepare($sql);
    // $stmt->bindParam(":user_id",$user_id, PDO::PARAM_INT);
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Successful data deletion.", false);
        header("location:../../index.php?page=driver");
        exit();
     
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}

}elseif(isset($_GET["action"]) && $_GET["action"] == "confirm_delete"){

    $req = array(
        "driver_id" => $_GET["driver_id"],
    );

    $required = array(  
        "driver_id" => "Driver ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        header("location:../../index.php?page=driver");
        exit();
    }

    try{
        $sql = "DELETE FROM `driver`  ";
        $sql .= "  WHERE `id` = :driver_id ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":driver_id",$req["driver_id"], PDO::PARAM_INT);
        $result = $stmt->execute();

        if($result){
            $_SESSION["STATUS"] = TRUE;
            $_SESSION["MSG"] = lang("Successful data deletion.", false);
            header("location:../../index.php?page=driver/delete");
            exit();
        
        }
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        die();
    }

}elseif(isset($_GET["action"]) && $_GET["action"] == "cancel_delete"){

    $req = array(
        "driver_id" => $_GET["driver_id"],
    );

    $required = array(  
        "driver_id" => "Driver ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        header("location:../../index.php?page=driver");
        exit();
    }

    try{
        $sql = "UPDATE `driver` SET  ";
        $sql .= " `is_delete` = 'N'  ";
        $sql .= "  WHERE `id` = :driver_id ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":driver_id",$req["driver_id"], PDO::PARAM_INT);
        $result = $stmt->execute();

        if($result){
            $_SESSION["STATUS"] = TRUE;
            $_SESSION["MSG"] = lang("Cancel successful.", false);
            header("location:../../index.php?page=driver/delete");
            exit();
        
        }
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        die();
    }

}else{
    defined('APPS') OR exit('No direct script access allowed');
}





?>