<?php

require_once(realpath(dirname(__FILE__) ."/../../db_function/connection.php"));
require_once(realpath(dirname(__FILE__) ."/../../db_function/function.php"));

if(isset($_GET["action"]) && $_GET["action"] == "save_category"){


    if(!empty($_POST["place_id"])){

        $req = array(
            "is_active" => isset($_POST["is_active"]) ? $_POST["is_active"] : "N",
            "place_name" => isset($_POST["place_name"]) ? $_POST["place_name"] : "",
            "place_id" => isset($_POST["place_id"]) ? $_POST["place_id"] : "",
        );

        $required = array(
            "place_name" => "place_name",   
            "place_id" => "place_id",   
        );
    
        if(validate($req, $required) === FALSE){
            $_SESSION["STATUS"] = FALSE;
            $_SESSION["MSG"] = lang("Invalid Data.", false);
            header("location:../../index.php?page=category");
            exit();
        }

        $req["place_name"] = filter_var_string($_POST["place_name"], "Place Name");

        try{
            $sql = "UPDATE `place` SET ";
            $sql .= " `is_active` = :is_active, ";
            $sql .= " `name` = :place_name ";
            $sql .= "  WHERE `id` = :place_id  ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":is_active",$req["is_active"]);
            $stmt->bindParam(":place_name",$req["place_name"]);
            $stmt->bindParam(":place_id",$req["place_id"]);
            $result = $stmt->execute();
        
            if($result){
                $_SESSION["STATUS"] = TRUE;
                $_SESSION["MSG"] = lang("Data update successful.", false);
                header("location:../../index.php?page=place");
                exit();
             
            }
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            die();
        }

    }else{
        $req = array(
            "is_active" => isset($_POST["is_active"]) ? $_POST["is_active"] : "",
            "place_name" => isset($_POST["place_name"]) ? $_POST["place_name"] : "",
        );
    
        $required = array(
            "place_name" => "place_name",   
        );
    
        if(validate($req, $required) === FALSE){
            $_SESSION["STATUS"] = FALSE;
            $_SESSION["MSG"] = lang("Invalid Data.", false);
            header("location:../../index.php?page=place");
            exit();
        }

        $req["place_name"] = filter_var_string($_POST["place_name"], "Place Name");

        try{
            $sql = "INSERT INTO `place` SET ";
            $sql .= " `is_active` = :is_active, ";
            $sql .= " `name` = :place_name ";
            // $sql .= "  WHERE `id` = :id  ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":is_active",$req["is_active"]);
            $stmt->bindParam(":place_name",$req["place_name"]);
            $result = $stmt->execute();
        
            if($result){
                $_SESSION["STATUS"] = TRUE;
                $_SESSION["MSG"] = lang("Successfully saved data.", false);
                header("location:../../index.php?page=place");
                exit();
             
            }
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            die();
        }
    }
    

}elseif(isset($_GET["action"]) && $_GET["action"] == "delete"){

    $req = array(
        "place_id" => $_GET["place_id"],
    );

    $required = array(  
        "place_id" => "Place ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        header("location:../../index.php?page=place");
        exit();
    }

try{
    $sql = "UPDATE `place` SET  ";
    $sql .= " `is_delete` = 'Y'  ";
    $sql .= "  WHERE `id` = :place_id ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":place_id",$req["place_id"], PDO::PARAM_INT);
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Successful data deletion.", false);
        header("location:../../index.php?page=place");
        exit();
     
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}


}elseif(isset($_GET["action"]) && $_GET["action"] == "delete_all"){

    $req = array(
        "place_id" => $_POST["ch"],
    );

    $required = array(  
        "place_id" => "Place ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        header("location:../../index.php?page=place");
        exit();
    }

    $arr = array();
    $place_id = implode(",", $req["place_id"]);

try{
    $sql = "UPDATE `place` SET  ";
    $sql .= " `is_delete` = 'Y'  ";
    $sql .= "  WHERE `id` IN ($place_id) ";

    $stmt = $conn->prepare($sql);
    // $stmt->bindParam(":user_id",$user_id, PDO::PARAM_INT);
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Successful data deletion.", false);
        header("location:../../index.php?page=place");
        exit();
     
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}

}elseif(isset($_GET["action"]) && $_GET["action"] == "confirm_delete"){

    $req = array(
        "place_id" => $_GET["place_id"],
    );

    $required = array(  
        "place_id" => "Place ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        header("location:../../index.php?page=place");
        exit();
    }

    try{
        $sql = "DELETE FROM `place`  ";
        $sql .= "  WHERE `id` = :place_id ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":place_id",$req["place_id"], PDO::PARAM_INT);
        $result = $stmt->execute();

        if($result){
            $_SESSION["STATUS"] = TRUE;
            $_SESSION["MSG"] = lang("Successful data deletion.", false);
            header("location:../../index.php?page=place/delete");
            exit();
        
        }
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        die();
    }

}elseif(isset($_GET["action"]) && $_GET["action"] == "cancel_delete"){

    $req = array(
        "place_id" => $_GET["place_id"],
    );

    $required = array(  
        "place_id" => "Place ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        header("location:../../index.php?page=place");
        exit();
    }

    try{
        $sql = "UPDATE `place` SET  ";
        $sql .= " `is_delete` = 'N'  ";
        $sql .= "  WHERE `id` = :place_id ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":place_id",$req["place_id"], PDO::PARAM_INT);
        $result = $stmt->execute();

        if($result){
            $_SESSION["STATUS"] = TRUE;
            $_SESSION["MSG"] = lang("Cancel successful.", false);
            header("location:../../index.php?page=place/delete");
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