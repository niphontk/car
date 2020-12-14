<?php
// Require composer autoload
require_once(realpath(dirname(__FILE__) ."/../../vendor/autoload.php"));

// เพิ่ม Font ให้กับ mPDF
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp',
    'fontdata' => $fontData + [
            'sarabun' => [ // ส่วนที่ต้องเป็น lower case ครับ
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabunNewItalic.ttf',
                'B' =>  'THSarabunNewBold.ttf',
                'BI' => "THSarabunNewBoldItalic.ttf",
            ]
        ],
]);

ob_start(); // Start get HTML code

 $fields = "*";
  $table = "inventory";
  $conditions = " WHERE `is_delete` = 'N' ";
  $inventory = fetch_all($fields, $table, $conditions);
  $count_inventory = count($inventory);

  $position = fetch_all("`per_id`, `per_name`","position");
  $position_txt = array();
  foreach($position as $per){
    $position_txt[$per["per_id"]] = $per["per_name"];
  }
  
  $fields = "*";
  $table = "users";
  $conditions = " WHERE `is_delete` = 'N' ";
  if($_SESSION["POSITION"] == "3" || $_SESSION["POSITION"] == "4"){
    $conditions .= " AND `position` IN (3) ORDER BY `position` DESC  ";
  }
  $users = fetch_all($fields, $table, $conditions);
  $count_users = count($users);
  $count_technician = count($users);


  $fields = "*";
  $table = "inventory";
  $conditions = " WHERE `is_delete` = 'N' AND `is_active` = 'Y' ";
  $inventory_y = fetch_all($fields, $table, $conditions);
  $count_inventory_y = count($inventory_y);

  $fields = "*";
  $table = "inventory";
  $conditions = " WHERE `is_delete` = 'N' AND `is_active` = 'N' ";
  $inventory_n = fetch_all($fields, $table, $conditions);
  $count_inventory_n = count($inventory_n);

  $fields = "*";
  $table = "inventory";
  $conditions = " WHERE `is_delete` = 'N' AND `is_active` = 'RP' ";
  $inventory_rp = fetch_all($fields, $table, $conditions);
  $count_inventory_rp = count($inventory_rp);

  $fields = "*";
  $table = "inventory";
  $conditions = " WHERE `is_delete` = 'N' AND `is_active` = 'WO' ";
  $inventory_wo = fetch_all($fields, $table, $conditions);
  $count_inventory_wo = count($inventory_wo);


  $fields = "*";
  $table = "repair";
  $repair_id = $_GET['repair_id'];
  $conditions = "WHERE id = '$repair_id'";
  $repair = fetch_all($fields, $table, $conditions);
  $arr_repair_id = array();
  foreach($repair as $v){
    $arr_repair_id[] = $v["id"];
    //$arr_inven_id[] = $v['inventory_id'];
  }

  $r_id = implode(",", $arr_repair_id);
 // $inven_id = implode(",",$arr_inven_id);

  $inventory = fetch_all("*","inventory");
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


  $r_status = fetch_all("*","status");
  $status_txt = array();
  foreach($r_status as $status){
    $status_txt[$status["id"]] = $status["name"];
    $bg_color[$status["id"]] = $status["bg_color"];
    $text_color[$status["id"]] = $status["text_color"];
  }

if(!empty($repair)){
  $conditions = " WHERE repair_id IN ($r_id) ";
 
  $repair_details = fetch_all("*","repair_detail", $conditions);
  $arr_repair_detail = array();
  $arr_repair_detail_status = array();
  foreach($repair_details as $repair_detail){
    $arr_repair_detail[] = $repair_detail;
    $arr_repair_detail_status[$repair_detail["repair_id"]] = $repair_detail["status_id"];
    $arr_repair_detail_note[$repair_detail["repair_id"]] = $repair_detail["note"];
    $arr_repair_detail_date[$repair_detail["repair_id"]] = $repair_detail["updated_at"];

  }
}

$dateData=time(); // วันเวลาขณะนั้น

?>

<!DOCTYPE html>
<html>
<head>
<title>PDF</title>
<link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
<style>
body {
    font-family: sarabun;
    font-size:18px;
}
table {
  border-collapse: collapse;
  width: 100%;
}

/* td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
} */

/* tr:nth-child(even) {
  background-color: #dddddd;
} */
</style>
</head>
<body>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0 text-dark"><?php lang("Repair List");?></h1> -->
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="./"><?php lang("Home");?></a></li>
            <li class="breadcrumb-item active"><?php lang("Repair List");?></li> -->
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
      <div class="col-lg-12">
          <div class="card">
            <!-- <div class="card-header">
              <a href="MyPDF.pdf" class="btn btn-success btn-sm float-right"><i class=""></i>
              <?php lang("PrintJob");?></a>
            </div> -->
            <div class="card-body">
                <div class="table-responsive">
                <table >
                    <tr>
                        <td width="40%">
                            
                        </td>
                        <td valign="bottom"><h2>ใบขออนุญาตใช้รถส่วนกลาง</h2></td> <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;แบบ ๓</td><br>                                                 
                    </tr>
                </table>
                <table >
                    <tr>
                    <td width="50%"></td>
                        <td valign="bottom">   
                                วันที่ <?php echo thai_date_and_time(strtotime(date('Y/m/d'))); //https://www.ninenik.com/content.php?arti_id=459 ?>                                                        
                        </td>                                                
                    </tr>  
                    <tr>
                        <td>เรียน (ผู้มีอำนาจสั่งใช้รถ) ผู้อำนวยการ โรงพยาบาลตระการพืชผล</td> 
                        <td></td>
                    </tr>
                    <tr>
                        <td>ข้าพเจ้า <?php echo "นายนิพนธ์  เทียนหอม"?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตำแหน่ง <?php echo "นักวิชาการคอมพิวเตอร์ ปฏิบัติการ"?></td>                        
                    </tr>
                    <tr>
                        <td colspan=2>ขออนุญาตใช้รถ (ไปที่ไหน) <?php echo "สำนักงานสาธารณสุขจังหวัดอุบลราชธานี"?></td>
                    </tr>                    
                    <tr>
                        <td colspan=2>เพื่อ <?php echo "ประชุม SA"?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;มีคนนั่ง <?php echo " 5 คน"?></td>
                    </tr>
                    
                    <tr>
                        <td colspan=2>ในวันที่ <?php echo thai_date_and_time(strtotime(date('Y/m/d')));?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เวลา <?php echo " 12.00 น."?></td>
                    </tr>                    
                    <tr>
                    <td colspan=2>ถึงวันที่ <?php echo thai_date_and_time(strtotime(date('Y/m/d')));?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เวลา <?php echo " 16.00 น."?></td>
                    </tr>

                    <tr>
                    <td width="50%"></td>
                        <td valign="bottom">   
                                ...............................ผู้ขออนุญาต                                                      
                        </td>                                                
                    </tr> 
                    <tr>

                    <td width="50%"></td>
                        <td valign="bottom">   
                                ...............................ผู้อำนวยการกอง/หัวหน้ากอง/หรือผู้แทน                                                      
                        </td>                                                
                    </tr> 

                    <tr>
                    <td width="50%"></td>
                        <td valign="bottom">   
                          <?php echo thai_date_and_time(strtotime(date('Y/m/d')));?>&nbsp;&nbsp;(วัน เดือน ปี)                                                      
                        </td>                                                
                    </tr> 

                    <tr>                    
                        <td valign="bottom">   
                        ให้&nbsp;&nbsp;<?php echo "นายพิทยา  จันทรา"?>&nbsp;&nbsp;  ขับรถหมายเลข &nbsp;&nbsp;<?php echo "รถตู้โดยสารขนาด 12 ที่นั่ง กก-3360"?>                                                
                        </td>    
                        <td width="50%"> </td>                                            
                    </tr> 

                    <tr>
                    <td width="50%"></td>
                        <td valign="bottom">   
                          <?php echo "นายพิทยา  จันทรา"?>&nbsp;&nbsp;ผู้จัดรถ                                                      
                        </td>                                                
                    </tr> 

                    <tr>                    
                        <td valign="bottom">   
                        (ลงนามผู้มีอำนาจสั่งใช้รถ)&nbsp;&nbsp;<?php echo "............................................."?><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงวันที่&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "....../........../........."?>
                        </td>    
                        <td width="50%"> </td>                                            
                    </tr> 

                    <tr>                    
                        <td >   
                        &nbsp;&nbsp;&nbsp;&nbsp;<?php echo ""?>
                        </td>    
                        <td width="50%"> </td>                                            
                    </tr>                     
                </table>  
                <table >
                    <tr>
                        <td width="40%">
                            
                        </td>
                        <td valign="bottom"><h2>การรับ - ส่งรถก่อนและหลังใช้งาน</h2></td> <td></td><br>                                                 
                    </tr>
                </table>  
                
                <table >                      
                    <tr>
                        <td>1. การรับรถ  &nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" id="checkall">&nbsp;&nbsp;ปกติ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="checkall">&nbsp;&nbsp;ผิดปกติ...............................</td> 
                        <td></td>
                    </tr>
                    <tr>
                        <td>ก่อนใช้งาน <?php echo "ผู้ส่ง..................................."?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้รับ <?php echo "................................."?></td>                        
                    </tr>
                    <tr>
                        <td>2. การส่งรถ &nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" id="checkall">&nbsp;&nbsp;ปกติ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="checkall">&nbsp;&nbsp;ผิดปกติ...............................</td> 
                    </tr>                    
                    <tr>
                    <td>หลังใช้งาน <?php echo "ผู้ส่ง..................................."?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้รับ <?php echo "................................."?></td>                        
                    </tr>
                    
                    <tr>
                        <td >หมายเหตุ ก่อนรับรถทุกครั้งให้ตรวจสภาพรถและอุปกรณ์ประจำรถโดยละเอียด</td>
                    </tr>                                        
                </table>  
                
                </div>
            </div>
          </div>
      </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>

<?php
$html = ob_get_contents();
$mpdf->WriteHTML($html);
$mpdf->Output("MyPDF.pdf");
ob_end_flush()
?>