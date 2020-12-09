<?php

require_once(realpath(dirname(__FILE__) ."/../../db_function/connection.php"));
require_once(realpath(dirname(__FILE__) ."/../../db_function/function.php"));

if(isset($_GET["action"]) && $_GET["action"] == "create_repair"){


    $req = array(
        "inventory" => isset($_POST["inven"]) ? $_POST["inven"] : "0",
        "use_date" => isset($_POST["usedate"]) ? $_POST["usedate"] : "",
        "use_time" => isset($_POST["usetime"]) ? $_POST["usetime"] : "",
        "depart_id" => isset($_POST["depart_id"]) ? $_POST["depart_id"] : "",
        "title" => isset($_POST["title"]) ? $_POST["title"] : "",
        "description" => isset($_POST["description"]) ? $_POST["description"] : "",        
        "goto" => isset($_POST["goto"]) ? $_POST["goto"] : "",
        "person" => isset($_POST["person"]) ? $_POST["person"] : "",
        "driver" => isset($_POST["driver"]) ? $_POST["driver"] : "0",
    );

    $required = array(
        //"inventory" => "inventory",     
        "depart_id" => "depart_id",   
        "title" => "title",
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=usecar");
        }else{
            header("location:../../index.php?page=usecar");
        }
       
        exit();
    }

    //$req["description"] = filter_var_string($_POST["description"], "Description");

try{

    $sql = "INSERT INTO `usecar` SET ";
    $sql .= " `depart_id` = :depart_id, ";
    $sql .= " `use_date` =:use_date , ";
    $sql .= " `use_time` =:use_time , ";
    $sql .= " `title` = :title, ";
    $sql .= " `goto` = :goto, ";
    $sql .= " `person` = :person, ";
    $sql .= " `inventory_id` = :inventory, ";
    $sql .= " `driver_id` = :driver, ";
    $sql .= " `user_id` = :user_id, ";
    $sql .= " `description` = :description ";
    // $sql .= "  WHERE `id` = :id  ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":depart_id",$req["depart_id"]);
    $stmt->bindParam(":use_date",$req["use_date"]);
    $stmt->bindParam(":use_time",$req["use_time"]);
    $stmt->bindParam(":title",$req["title"]);
    $stmt->bindParam(":goto",$req["goto"]);
    $stmt->bindParam(":person",$req["person"]);
    $stmt->bindParam(":inventory",$req["inventory"]);
    $stmt->bindParam(":driver",$req["driver"]);
    $stmt->bindParam(":user_id",$_SESSION["USER_ID"]);
    $stmt->bindParam(":description",$req["description"]);
    $result = $stmt->execute();
    $id = $conn->lastInsertId();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Successfully saved data.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=usecar");
        }else{
            
            header("location:../../index.php?page=usecar");
        }
        exit();     
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}

}elseif(isset($_GET["action"]) && $_GET["action"] == "delete"){

    $req = array(
        "repair_id" => $_GET["repair_id"],
    );

    $required = array(  
        "repair_id" => "Repair ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=usecar");
        }else{
            header("location:../../index.php?page=usecar");
        }
        exit();
    }


try{
    $sql = "DELETE FROM `usecar`  ";
    $sql .= "  WHERE `id` = :repair_id ";
    echo $sql; exit;
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":repair_id",$req["repair_id"], PDO::PARAM_INT);
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Successful data deletion.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=usecar");
        }else{
            header("location:../../index.php?page=usecar");
        }
        exit();
     
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}


}elseif(isset($_GET["action"]) && $_GET["action"] == "endjob"){

    $req = array(
        "approve_id" => $_GET["id"],
    );

    $required = array(  
        "approve_id" => "Approve ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=usecar");
        }else{
            header("location:../../index.php?page=usecar");
        }
        exit();
    }


try{
    $is_active="1";
    $sql = "UPDATE `usecar` SET ";
    $sql .= " `approve` =:approve ";
    $sql .= "  WHERE `id` = :id  ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":approve",$is_active);
    $stmt->bindParam(":id",$req["approve_id"]);    
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Data update successful.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=usecar");
        }else{
            header("location:../../index.php?page=usecar");
        }
        exit();
     
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}


}elseif(isset($_GET["action"]) && $_GET["action"] == "update_repair"){
    
    $req = array(
        "id" => isset($_POST["id"]) ? $_POST["id"] : "",
        "inventory" => isset($_POST["inven"]) ? $_POST["inven"] : "",
        "use_date" => isset($_POST["usedate"]) ? $_POST["usedate"] : "",
        "use_time" => isset($_POST["usetime"]) ? $_POST["usetime"] : "",
        "depart_id" => isset($_POST["depart_id"]) ? $_POST["depart_id"] : "",
        "title" => isset($_POST["title"]) ? $_POST["title"] : "",
        "description" => isset($_POST["description"]) ? $_POST["description"] : "",        
        "goto" => isset($_POST["goto"]) ? $_POST["goto"] : "",
        "person" => isset($_POST["person"]) ? $_POST["person"] : "",
        "driver" => isset($_POST["driver"]) ? $_POST["driver"] : "0",
    );

    $required = array(
        "inventory" => "inventory",     
        "depart_id" => "depart_id",   
        "title" => "title",
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=usecar");
        }else{
            header("location:../../index.php?page=usecar");
        }
        exit();
    }

try{

    $sql = "UPDATE `usecar` SET ";
    $sql .= " `inventory_id` =:inventory_id ,";
    $sql .= " `use_date` =:use_date ,";
    $sql .= " `use_time` =:use_time ,";
    $sql .= " `depart_id` =:depart_id ,";
    $sql .= " `title` =:title ,";
    $sql .= " `description` =:description ,";
    $sql .= " `goto` =:goto ,";
    $sql .= " `person` =:person ,";
    $sql .= " `driver_id` =:driver ";
    $sql .= "  WHERE `id` = :id  ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":inventory_id",$req["inventory"]);
    $stmt->bindParam(":use_date",$req["use_date"]);
    $stmt->bindParam(":use_time",$req["use_time"]);
    $stmt->bindParam(":depart_id",$req["depart_id"]);
    $stmt->bindParam(":title",$req["title"]);
    $stmt->bindParam(":description",$req["description"]);
    $stmt->bindParam(":goto",$req["goto"]);
    $stmt->bindParam(":person",$req["person"]);
    $stmt->bindParam(":driver",$req["driver"]);
    $stmt->bindParam(":id",$req["id"]);
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Data update successful.", false);
        header("location:../../index.php?page=usecar");        
        exit();     
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}

}elseif(isset($_GET["action"]) && $_GET["action"] == "update_repair_job"){
    
    $req = array(      
        "repair_id" => isset($_GET["repair_id"]) ? $_GET["repair_id"] : "",
        "jobdetail" => isset($_POST["jobdetail"]) ? $_POST["jobdetail"] : "",
        "technician" => isset($_POST["technician"]) ? $_POST["technician"] : "0",
    );

    $required = array(  
        "repair_id" => "Repair ID",           
        "jobdetail" => "jobdetail",    
        "technician" => "technician",                
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=dashboard");
        }else{
            header("location:../../index.php?page=usecar");
        }
        exit();
    }

try{

    $sql = "UPDATE `repair` SET ";
    $sql .= " `jobdetail` =:jobdetail ,";    
    $sql .= " `technician` =:technician ";
    $sql .= "  WHERE `id` = :repair_id  ";
    $stmt = $conn->prepare($sql);    
    $stmt->bindParam(":jobdetail",$req["jobdetail"]);    
    $stmt->bindParam(":technician",$req["technician"]);
    $stmt->bindParam(":repair_id",$req["repair_id"]);
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Data update successful.", false);
        header("location:../../index.php?page=repair/edit_job&repair_id=".$req["repair_id"]);
        if(!empty($_POST["technician"])){
            $users_2 = fetch_all("*","users");
            $users_txt = array();
            foreach($users_2 as $user){
                $users_txt[$user["id"]] = $user["first_name"]." ".$user["last_name"];
                $technician[$user["id"]] = $user["first_name"]." ".$user["last_name"];
                $position_name[$user["id"]] = $user["position_name"];
            }

            $fields = "*";
            $table = "repair";
            $req = array(
              "repair_id" => $_GET["repair_id"]
            );
            $value = " WHERE `id` = :repair_id ";
            $repair = fetch_all($fields,$table,$value,$req);
            if(!empty($repair)){
              $repair = $repair[0];
            }else{
              exit();
            }
            
            $fields = "*";
            $table = "inventory";
            //$conditions = " WHERE id = '$inventory_id'";
            $inventory = fetch_all($fields, $table);            
            $inventory_txt = array();
            foreach($inventory as $inven){
                $inventory_txt[$inven["id"]] = $inven["name"];
                $inventory_depart[$inven["id"]] = $inven["depart_id"];
                $inventory_idnumber[$inven["id"]] = $inven["id_number"];
            }

            $department = fetch_all("*","department");
            $department_txt = array();
            foreach($department as $depart){
                $depart_txt[$depart["id"]] = $depart['depart_name'];
            }

            $problems = fetch_all("*","problem");
            $problem_txt = array();
            foreach($problems as $problem){
                $problem_txt[$problem["id"]] = $problem["name"];
            }
            
            $linetoken = fetch_all("*","linetoken");
            $linetoken_txt = array();
            foreach($linetoken as $linetoken){
                $linetoken_txt[$linetoken["linetoken"]] = $linetoken["linetoken"];
            }
            
            $txt = "มอบหมายงาน ".$users_txt[$_POST["technician"]]." หมายเลขงาน ".$repair["id"]." อุปกรณ์ ".$inventory_txt[$repair["inventory_id"]]." ปัญหา ".$problem_txt[$repair["problem"]]." รายละเอียด ".$repair["description"]." : กลุ่มงาน ".$depart_txt[$inventory_depart[$repair["inventory_id"]]]." กรุณาตรวจสอบ" ;
            
            $line_token = $linetoken["linetoken"];   
                   
            sendline("$txt","$line_token");
        }
        exit();
     
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}
}elseif(isset($_GET["action"]) && $_GET["action"] == "update_job_user"){
    
    $req = array(
        "id" => isset($_POST["id"]) ? $_POST["id"] : "",
        "use_date" => isset($_POST["usedate"]) ? $_POST["usedate"] : "",
        "use_time" => isset($_POST["usetime"]) ? $_POST["usetime"] : "",
        "depart_id" => isset($_POST["depart_id"]) ? $_POST["depart_id"] : "",
        "title" => isset($_POST["title"]) ? $_POST["title"] : "",
        "description" => isset($_POST["description"]) ? $_POST["description"] : "",        
        "goto" => isset($_POST["goto"]) ? $_POST["goto"] : "",
        "person" => isset($_POST["person"]) ? $_POST["person"] : "",
    );

    $required = array( 
        "depart_id" => "depart_id",   
        "title" => "title",
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=usecar");
        }else{
            header("location:../../index.php?page=usecar");
        }
        exit();
    }

try{

    $sql = "UPDATE `usecar` SET ";
    $sql .= " `use_date` =:use_date ,";
    $sql .= " `use_time` =:use_time ,";
    $sql .= " `depart_id` =:depart_id ,";
    $sql .= " `title` =:title ,";
    $sql .= " `description` =:description ,";
    $sql .= " `goto` =:goto ,";
    $sql .= " `person` =:person ";
    $sql .= "  WHERE `id` = :id  ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":use_date",$req["use_date"]);
    $stmt->bindParam(":use_time",$req["use_time"]);
    $stmt->bindParam(":depart_id",$req["depart_id"]);
    $stmt->bindParam(":title",$req["title"]);
    $stmt->bindParam(":description",$req["description"]);
    $stmt->bindParam(":goto",$req["goto"]);
    $stmt->bindParam(":person",$req["person"]);
    $stmt->bindParam(":id",$req["id"]);
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Data update successful.", false);
        header("location:../../index.php?page=usecar");        
        exit();     
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}

}elseif(isset($_GET["action"]) && $_GET["action"] == "delete_all"){

    $req = array(
        "repair_id" => $_POST["ch"],
    );

    $required = array(  
        "repair_id" => "Repair ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=usecar");
        }else{
            header("location:../../index.php?page=usecar");
        }
        exit();
    }

    $arr = array();

    foreach($_POST["ch"] as $v){
        $arr[] = explode(",",$v);
    }

    $user_id = "";

    foreach($arr as $v){
        $user_id .= $v[0].",";

    }


    $repair_id = substr($user_id, 0,-1);


try{
    $sql = "DELETE FROM `usecar`  ";
    $sql .= "  WHERE `id` IN ($repair_id) ";

    echo $sql;
    $stmt = $conn->prepare($sql);
    // $stmt->bindParam(":user_id",$user_id, PDO::PARAM_INT);
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Successful data deletion.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=usecar");
        }else{
            header("location:../../index.php?page=usecar");
        }
        exit();
     
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}

}elseif(isset($_GET["action"]) && $_GET["action"] == "created_detail"){

    $req = array(
        "note" => filter_var_string($_POST["note"], "Note"),
        "status" => $_POST["status"],
        "repair_id" => $_POST["repair_id"],
    );

    $required = array(
        "status" => "status",   
        "repair_id" => "repair_id",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        header("location:../../index.php?page=repair/edit&repair_id=".$req["repair_id"]);
        exit();
    }

try{

    $sql = "INSERT INTO `repair_detail` SET ";
    $sql .= " `repair_id` = :repair_id, ";
    $sql .= " `note` = :note, ";
    $sql .= " `status_id` = :status ";
    // $sql .= "  WHERE `id` = :id  ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":repair_id",$req["repair_id"]);
    $stmt->bindParam(":note",$req["note"]);
    $stmt->bindParam(":status",$req["status"]);
    $result = $stmt->execute();
    $id = $conn->lastInsertId();
 
    

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Successfully saved data.", false);
        header("location:../../index.php?page=repair/edit&repair_id=".$req["repair_id"]);
        exit();
     
    }

}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}


}elseif(isset($_GET["action"]) && $_GET["action"] == "created_detail_job"){

    $req = array(
        "note" => filter_var_string($_POST["note"], "Note"),
        "status" => $_POST["status"],
        "repair_id" => $_POST["repair_id"],
    );

    $required = array(
        "status" => "status",   
        "repair_id" => "repair_id",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        header("location:../../index.php?page=repair/edit_job&repair_id=".$req["repair_id"]);
        exit();
    }

try{

    $sql = "INSERT INTO `repair_detail` SET ";
    $sql .= " `repair_id` = :repair_id, ";
    $sql .= " `note` = :note, ";
    $sql .= " `status_id` = :status ";
    // $sql .= "  WHERE `id` = :id  ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":repair_id",$req["repair_id"]);
    $stmt->bindParam(":note",$req["note"]);
    $stmt->bindParam(":status",$req["status"]);
    $result = $stmt->execute();
    $id = $conn->lastInsertId();
 
    

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Successfully saved data.", false);
        header("location:../../index.php?page=repair/edit_job&repair_id=".$req["repair_id"]);
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