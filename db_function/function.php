<?php

function validate($req, $required){
    foreach($required as $key => $value){
        if(!isset($req[$key]) || empty($req[$key]) && $req[$key] != "0"){
            return false;
        }
    }
    return true;
}

function filter_var_string($req ,$name = NULL){
    $response = filter_var($req,FILTER_SANITIZE_STRING);
    if($response){
        return $response;
    }else{
        die("$name is not a valid string");
    }
    
}

function filter_var_email($req ,$name = NULL){
    $response = filter_var($req,FILTER_VALIDATE_EMAIL);
    if($response){
        return $response;
    }else{
        die("$name is not a valid email address");
    }
}

function filter_var_int($req ,$name = NULL){
    $response = (int)filter_var($req,FILTER_VALIDATE_INT);
    if($response){
        return $response;
    }else{
        die("$name is not a valid integer");
    }
}

function lang($text, $echo = true){
    global $conn;

    $lang = isset($_SESSION["LANGUAGE"]) ? $_SESSION["LANGUAGE"] : "th" ;

    $stmt =  $conn->prepare(" DESCRIBE ui_language   ");
    $stmt->bindParam(":lang",$lang);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $conditions = false;
    if($data === FALSE){
        if($echo){
            echo $text;
        }else{
            return $text;
        }
        
    }else{
        // print_r($data);
        foreach($data as $row){
            if($row["Field"] == $lang){
                $conditions = true;
            }
        }

        if($conditions){
            $stmt =  $conn->prepare("SELECT * FROM ui_language WHERE en = :txt OR th = :txt ");
            $stmt->bindParam(":txt",$text, PDO::PARAM_STR);
            $stmt->execute();
            $data = array();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if($data === FALSE){

                $sql = "INSERT INTO `ui_language` SET ";
                $sql .= " en = :txt ";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":txt",$text);
                $result = $stmt->execute();
            
                if($echo){
                    echo $text;
                }else{
                    return $text;
                }   
           
            }else{
                $txt_lang = !empty($data[$lang]) ? $data[$lang] : $data["en"];

                if($echo){
                    echo $txt_lang;
                }else{
                    return $txt_lang;
                }
                
            }
        }
       
    }

   
}


function login($req){
    global $conn;
    try{
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE `username` = :username AND `is_active` = 'Y' ");
        $stmt->bindParam(":username",filter_var_string($req["username"], "Username"));
        // $stmt->bindParam(":password",$req["password"]);
        $stmt->execute();
        $data = array();
        // if($count = $stmt->rowCount() > 0){
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if($data === FALSE){
            $response = array(
                "status" => FALSE,
                "msg" => "ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง กรุณาลองอีกครั้ง",
            );
        }else{

            $validPassword = password_verify(filter_var_string($req["password"], "Password"), $data['password']);

            if($validPassword){
                $_SESSION["LOGIN"] = TRUE;
                $_SESSION["USER_ID"] = $data["id"];
                $_SESSION["USERNAME"] = $data["username"];
                $_SESSION["FIRST_NAME"] = $data["first_name"];
                $_SESSION["LAST_NAME"] = $data["last_name"];
                $_SESSION["PROFILE"] = $data["profile"];
                $_SESSION["POSITION"] = $data["position"];

                $response = array(
                    "status" => TRUE,
                    "msg" => "เข้าสู่ระบบสำเร็จ",
                );
            }else{
                $response = array(
                    "status" => FALSE,
                    "msg" => "ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง กรุณาลองอีกครั้ง",
                );
            }
            
        }
        
        return $response;

    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        die();
    }
    
}

function fetch_all($fields, $table, $conditions = NULL , $req = NULL){
    global $conn;
    try{
        $stmt = $conn->prepare("SELECT $fields FROM `$table` $conditions ");
        if(!empty($req)){
            foreach($req as $key => $v){
                $stmt->bindParam(":".$key,$v);
            }
        }
        $result = $stmt->execute();
        $data = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          $data[] = $row;
        }
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        die();
    }
   
    return $data;
}

function num_rows($table){
    global $conn;
    try{
        $stmt = $conn->prepare("SELECT * FROM `$table` WHERE `status` = 'Y' ");
        $result = $stmt->execute();
        $count = $stmt->rowCount();
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        die();
    }
   
    return $count;
}
$dayTH = ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'];
$monthTH = [null,'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
$monthTH_brev = [null,'ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
function thai_date_and_time($time){   // 19 ธันวาคม 2556 เวลา 10:10:43
    global $dayTH,$monthTH;   
    $thai_date_return = date("j",$time);   
    $thai_date_return.=" ".$monthTH[date("n",$time)];   
    $thai_date_return.= " ".(date("Y",$time)+543);   
    //$thai_date_return.= " เวลา ".date("H:i:s",$time);
    return $thai_date_return;   
} 
//https://www.thaicreate.com/community/php-line-notify.html
function sendline($emesssage,$linetoken){
    ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	date_default_timezone_set("Asia/Bangkok");

	$sToken = "$linetoken";
	$sMessage = "$emesssage";

	
	$chOne = curl_init(); 
	curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt( $chOne, CURLOPT_POST, 1); 
	curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
	$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
	curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
	curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
	$result = curl_exec( $chOne ); 

	//Result error 
	if(curl_error($chOne)) 
	{ 
		echo 'error:' . curl_error($chOne); 
	} 
	else { 
		$result_ = json_decode($result, true); 
		echo "status : ".$result_['status']; echo "message : ". $result_['message'];
	} 
	curl_close( $chOne );   
}


?>