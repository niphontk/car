<?php

require_once(realpath(dirname(__FILE__) ."/../../db_function/connection.php"));
require_once(realpath(dirname(__FILE__) ."/../../db_function/function.php"));

if(isset($_GET["action"]) && $_GET["action"] == "save_depart"){


    if(!empty($_POST["depart_id"])){

        $req = array(
            "is_active" => isset($_POST["is_active"]) ? $_POST["is_active"] : "N",
            "depart_name" => isset($_POST["depart_name"]) ? $_POST["depart_name"] : "",            
            "depart_id" => isset($_POST["depart_id"]) ? $_POST["depart_id"] : "",
        );
        
        $required = array(
            "depart_name" => "depart_name",   
            "depart_id" => "depart_id",   
        );
    
        if(validate($req, $required) === FALSE){
            $_SESSION["STATUS"] = FALSE;
            $_SESSION["MSG"] = lang("Invalid Data.", false);
            header("location:../../index.php?page=department");
            exit();
        }

        $req["depart_name"] = filter_var_string($_POST["depart_name"], "depart_name");

        try{
            $sql = "UPDATE `department` SET ";
            $sql .= " `is_active` = :is_active, ";
            $sql .= " `depart_name` = :depart_name ";            
            $sql .= "  WHERE `id` = :depart_id  ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":is_active",$req["is_active"]);
            $stmt->bindParam(":depart_name",$req["depart_name"]);            
            $stmt->bindParam(":depart_id",$req["depart_id"]);
            $result = $stmt->execute();
        
            if($result){
                $_SESSION["STATUS"] = TRUE;
                $_SESSION["MSG"] = lang("Data update successful.", false);
                header("location:../../index.php?page=department");
                exit();
             
            }
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            die();
        }

    }else{
        $req = array(
            "is_active" => isset($_POST["is_active"]) ? $_POST["is_active"] : "N",
            "depart_name" => isset($_POST["depart_name"]) ? $_POST["depart_name"] : "",            
        );

        $required = array(
            "depart_name" => "depart_name",   
        );
    
        if(validate($req, $required) === FALSE){
            $_SESSION["STATUS"] = FALSE;
            $_SESSION["MSG"] = lang("Invalid Data.", false);
            header("location:../../index.php?page=department");
            exit();
        }

        $req["depart_name"] = filter_var_string($_POST["depart_name"], "depart_name");

        try{
            $sql = "INSERT INTO `department` SET ";
            $sql .= " `is_active` = :is_active, ";            
            $sql .= " `depart_name` = :depart_name ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":is_active",$req["is_active"]);
            $stmt->bindParam(":depart_name",$req["depart_name"]);            
            $result = $stmt->execute();
        
            if($result){
                $_SESSION["STATUS"] = TRUE;
                $_SESSION["MSG"] = lang("Successfully saved data.", false);
                header("location:../../index.php?page=department");
                exit();
             
            }
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            die();
        }
    }
    

}elseif(isset($_GET["action"]) && $_GET["action"] == "delete"){

    $req = array(
        "depart_id" => $_GET["depart_id"],
    );

    $required = array(  
        "depart_id" => "Depart ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        header("location:../../index.php?page=department");
        exit();
    }

try{
    $sql = "UPDATE `department` SET  ";
    $sql .= " `is_delete` = 'Y'  ";
    $sql .= "  WHERE `id` = :depart_id ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":depart_id",$req["depart_id"], PDO::PARAM_INT);
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Successful data deletion.", false);
        header("location:../../index.php?page=department");
        exit();
     
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}


}elseif(isset($_GET["action"]) && $_GET["action"] == "delete_all"){

    $req = array(
        "depart_id" => $_POST["ch"],
    );

    $required = array(  
        "depart_id" => "Depart ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        header("location:../../index.php?page=department");
        exit();
    }

    $arr = array();
    $depart_id = implode(",", $req["depart_id"]);

try{

    $sql = "UPDATE `department` SET  ";
    $sql .= " `is_delete` = 'Y'  ";
    $sql .= "  WHERE `id` IN ($depart_id) ";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Successful data deletion.", false);
        header("location:../../index.php?page=department");
        exit();
     
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}

}elseif(isset($_GET["action"]) && $_GET["action"] == "confirm_delete"){

    $req = array(
        "depart_id" => $_GET["depart_id"],
    );

    $required = array(  
        "depart_id" => "Depart ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        header("location:../../index.php?page=department");
        exit();
    }

    try{
        $sql = "DELETE FROM `department`  ";
        $sql .= "  WHERE `id` = :depart_id ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":depart_id",$req["depart_id"], PDO::PARAM_INT);
        $result = $stmt->execute();

        if($result){
            $_SESSION["STATUS"] = TRUE;
            $_SESSION["MSG"] = lang("Successful data deletion.", false);
            header("location:../../index.php?page=department/delete");
            exit();
        
        }
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        die();
    }

}elseif(isset($_GET["action"]) && $_GET["action"] == "cancel_delete"){

    $req = array(
        "depart_id" => $_GET["depart_id"],
    );

    $required = array(  
        "depart_id" => "Depart ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        header("location:../../index.php?page=department");
        exit();
    }

    try{
        $sql = "UPDATE `department` SET  ";
        $sql .= " `is_delete` = 'N'  ";
        $sql .= "  WHERE `id` = :depart_id ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":depart_id",$req["depart_id"], PDO::PARAM_INT);
        $result = $stmt->execute();

        if($result){
            $_SESSION["STATUS"] = TRUE;
            $_SESSION["MSG"] = lang("Cancel successful.", false);
            header("location:../../index.php?page=department/delete");
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