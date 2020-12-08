<?php

require_once(realpath(dirname(__FILE__) ."/../../db_function/connection.php"));
require_once(realpath(dirname(__FILE__) ."/../../db_function/function.php"));

if(isset($_GET["action"]) && $_GET["action"] == "create_repair"){


    $req = array(
        "problem" => isset($_POST["problem"]) ? $_POST["problem"] : "",
        "technician" => isset($_POST["technician"]) ? $_POST["technician"] : "0",
        "description" => isset($_POST["description"]) ? $_POST["description"] : "",
        "inventory" => isset($_POST["inven"]) ? $_POST["inven"] : "",
        "user_id" => $_SESSION["USER_ID"],
    );

    $required = array(
        "problem" => "Problem",     
        "description" => "Description",   
        "inventory" => "Inventory",
        "user_id" => "User ID",
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=dashboard");
        }else{
            header("location:../../index.php?page=repair");
        }
       
        exit();
    }

    $req["description"] = filter_var_string($_POST["description"], "Description");

try{

    $sql = "INSERT INTO `repair` SET ";
    $sql .= " `problem` = :problem, ";
    $sql .= " `description` = :description, ";
    $sql .= " `inventory_id` = :inventory, ";
    $sql .= " `technician` = :technician, ";
    $sql .= " `user_id` = :user_id ";
    // $sql .= "  WHERE `id` = :id  ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":problem",$req["problem"]);
    $stmt->bindParam(":description",$req["description"]);
    $stmt->bindParam(":inventory",$req["inventory"]);
    $stmt->bindParam(":technician",$req["technician"]);
    $stmt->bindParam(":user_id",$req["user_id"]);
    $result = $stmt->execute();
    $id = $conn->lastInsertId();
    $status_id = "14";
    if($result){
       
    $sql = "INSERT INTO `repair_detail` SET ";
    $sql .= " `repair_id` = :repair_id, ";
    $sql .= " `status_id` = :status_id ";
    // $sql .= "  WHERE `id` = :id  ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":repair_id",$id, PDO::PARAM_INT);
    $stmt->bindParam(":status_id",$status_id, PDO::PARAM_INT);
    $result = $stmt->execute();

    $jobtype = "RP";
    $sql = "UPDATE `inventory` SET ";
    $sql .= " `is_active` =:is_active ";    
    $sql .= "  WHERE `id` = :inventory_id  ";
    $stmt = $conn->prepare($sql);    
    $stmt->bindParam(":is_active",$jobtype);    
    $stmt->bindParam(":inventory_id",$req["inventory"]);
    $result = $stmt->execute();    

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Successfully saved data.", false);
        if($_SESSION["POSITION"] == "2"){
            $inventory_id = $_POST["inven"];
            $fields = "*";
            $table = "inventory";
            $conditions = " WHERE id = '$inventory_id'";
            $inventory = fetch_all($fields, $table, $conditions);            
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

            $users_2 = fetch_all("*","users");
            $users_txt = array();
            foreach($users_2 as $user){
                $users_txt[$user["id"]] = $user["first_name"]." ".$user["last_name"];
                $technician[$user["id"]] = $user["first_name"]." ".$user["last_name"];
                $position_name[$user["id"]] = $user["position_name"];
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
            
            $txt ="อุปกรณ์ ".$inven["name"]." เลขครุภัณฑ์ ".$inven["id_number"]." : อาการ ".$problem_txt[$_POST["problem"]]." : รายละเอียด ".$_POST["description"]. " : ผู้ส่งซ่อม ".$users_txt[$_SESSION["USER_ID"]]." : กลุ่มงาน ".$depart_txt[$inventory_depart[$inven["id"]]]." กรุณาตรวจสอบ" ;
            
            $line_token = $linetoken["linetoken"];   
                   
            sendline("$txt","$line_token");
            header("location:../../index.php?page=dashboard");
        }else{
            $inventory_id = $_POST["inven"];
            $fields = "*";
            $table = "inventory";
            $conditions = " WHERE id = '$inventory_id'";
            $inventory = fetch_all($fields, $table, $conditions);            
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

            $users_2 = fetch_all("*","users");
            $users_txt = array();
            foreach($users_2 as $user){
                $users_txt[$user["id"]] = $user["first_name"]." ".$user["last_name"];
                $technician[$user["id"]] = $user["first_name"]." ".$user["last_name"];
                $position_name[$user["id"]] = $user["position_name"];
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
            
            $txt ="อุปกรณ์ ".$inven["name"]." เลขครุภัณฑ์ ".$inven["id_number"]." : อาการ ".$problem_txt[$_POST["problem"]]." : รายละเอียด ".$_POST["description"]. " : ผู้ส่งซ่อม ".$users_txt[$_SESSION["USER_ID"]]." : กลุ่มงาน ".$depart_txt[$inventory_depart[$inven["id"]]]." กรุณาตรวจสอบ" ;
            
            $line_token = $linetoken["linetoken"];   
                   
            sendline("$txt","$line_token");
            header("location:../../index.php?page=repair");
        }
        exit();
     
    }

      
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
            header("location:../../index.php?page=dashboard");
        }else{
            header("location:../../index.php?page=repair");
        }
        exit();
    }


try{
    $sql = "DELETE FROM `repair`  ";
    $sql .= "  WHERE `id` = :repair_id ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":repair_id",$req["repair_id"], PDO::PARAM_INT);
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Successful data deletion.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=dashboard");
        }else{
            header("location:../../index.php?page=repair");
        }
        exit();
     
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}


}elseif(isset($_GET["action"]) && $_GET["action"] == "endjob"){

    $req = array(
        "inven_id" => $_GET["inven_id"],
    );

    $required = array(  
        "inven_id" => "Inven ID",   
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=dashboard");
        }else{
            header("location:../../index.php?page=repair");
        }
        exit();
    }


try{
    $is_active="Y";
    $sql = "UPDATE `inventory` SET ";
    $sql .= " `is_active` =:is_active ";
    $sql .= "  WHERE `id` = :inventory_id  ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":is_active",$is_active);
    $stmt->bindParam(":inventory_id",$req["inven_id"]);
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Data update successful.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=dashboard");
        }else{
            header("location:../../index.php?page=repair");
        }
        exit();
     
    }
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}


}elseif(isset($_GET["action"]) && $_GET["action"] == "update_repair"){
    
    $req = array(      
        "repair_id" => isset($_GET["repair_id"]) ? $_GET["repair_id"] : "",
        "inventory_id" => isset($_POST["inven"]) ? $_POST["inven"] : "",
        "problem" => isset($_POST["problem"]) ? $_POST["problem"] : "",
        "description" => isset($_POST["description"]) ? $_POST["description"] : "",
        "technician" => isset($_POST["technician"]) ? $_POST["technician"] : "0",
        //"user_id" => $_SESSION["USER_ID"],
    );

    $required = array(  
        "repair_id" => "Repair ID",   
        "inventory_id" => "Inventory",
        "problem" => "Problem",     
        "description" => "Description",    
        "technician" => "technician",        
        //"user_id" => "User ID",
    );

    if(validate($req, $required) === FALSE){
        $_SESSION["STATUS"] = FALSE;
        $_SESSION["MSG"] = lang("Invalid Data.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=dashboard");
        }else{
            header("location:../../index.php?page=repair");
        }
        exit();
    }

try{

    $sql = "UPDATE `repair` SET ";
    $sql .= " `inventory_id` =:inventory_id ,";
    $sql .= " `problem` =:problem ,";
    $sql .= " `description` =:description ,";
    //$sql .= " `user_id` =:user_id ,";
    $sql .= " `technician` =:technician ";
    $sql .= "  WHERE `id` = :repair_id  ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":inventory_id",$req["inventory_id"]);
    $stmt->bindParam(":problem",$req["problem"]);
    $stmt->bindParam(":description",$req["description"]);
    //$stmt->bindParam(":user_id",$req["user_id"]);
    $stmt->bindParam(":technician",$req["technician"]);
    $stmt->bindParam(":repair_id",$req["repair_id"]);
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Data update successful.", false);
        header("location:../../index.php?page=repair/edit&repair_id=".$req["repair_id"]);
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
            header("location:../../index.php?page=repair");
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
            header("location:../../index.php?page=dashboard");
        }else{
            header("location:../../index.php?page=repair");
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
    $sql = "DELETE FROM `repair`  ";
    $sql .= "  WHERE `id` IN ($repair_id) ";

    echo $sql;
    $stmt = $conn->prepare($sql);
    // $stmt->bindParam(":user_id",$user_id, PDO::PARAM_INT);
    $result = $stmt->execute();

    if($result){
        $_SESSION["STATUS"] = TRUE;
        $_SESSION["MSG"] = lang("Successful data deletion.", false);
        if($_SESSION["POSITION"] == "2"){
            header("location:../../index.php?page=dashboard");
        }else{
            header("location:../../index.php?page=repair");
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