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
                            <img src="assets/img/crut.png" width="100" height="100">
                        </td>
                        <td valign="bottom"><h2>บันทึกข้อความ</h2> <br> 
                        </td>
                    </tr>
                </table>
                <table >
                    <tr>
                        <td >
                            <p>                             
                                ส่วนราชการ กลุ่มงานประกันสุขภาพ ยุทธศาสตร์และสารสนเทศทางการแพทย์ โรงพยาบาลตระการพืชผล                                                
                            </p>
                        </td>                        
                        
                    </tr>  
                    <tr>
                        <td>ที่ <?php echo "อบ. 0032.009.11/" ?>  </td> 
                        <td>วันที่ <?php echo thai_date_and_time(strtotime($v["updated_at"])); //https://www.ninenik.com/content.php?arti_id=459 ?></td>
                    </tr>
                    <tr>
                        <td>เรื่อง ขออนุมัติซ่อม/จัดซื้อทดแทน <?php echo $inventory_txt[$v["inventory_id"]];?></td>
                        <td align = "right">ใบส่งซ่อมเลขที่ 63/<?php echo $v["id"];?></td>
                    </tr>
                    <tr>
                        <td colspan=2>เรียน ผู้อำนวยการ โรงพยาบาลตระการพืชผล</td>
                    </tr>
                    
                    <tr>
                        <td colspan=2>
                        <p>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เนื่องด้วย &nbsp; <?php echo $depart_txt[$inventory_depart[$v["inventory_id"]]]; ?>&nbsp; มีความประสงค์ที่จะส่งซ่อม/จัดซื้อทดแทน อุปกรณ์ <?php echo $inventory_txt[$v["inventory_id"]].' เลขที่อุปกรณ์ '.$inventory_idnumber[$v["inventory_id"]]?> เนื่องจากพบปัญหา 
                        <?php echo $problem_txt[$v["problem"]] ?> 
                        <p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; จึงเรียนมาเพื่อพิจารณาดำเดินการ</p>
                        </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <!-- <td width="340"></td> -->
                        <td width="50%"> </td>
                         <td align="center">.....................................<br>(<?php echo $users_txt[$v["user_id"]]?>)<br>ผู้ขอรับบริการ</td>                         
                         
                    </tr>
                </table>
                <table border="1">
                    <tr>
                        <td width="50%" >
                        &nbsp;<h4>ผลการตรวจสอบ</h4>
                        <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; พบว่า <?php echo $v["jobdetail"];  ?><br><br>
                        </p>
                        <p>
                        
                        </p>
                        <br>
                        <br>
                        <br>
                        </td>
                        <td width="50%">
                        &nbsp;<h4>ผลการดำเนินงานซ่อม</h4>
                        <p>
                        &nbsp;&nbsp;&nbsp;&nbsp; ผลการซ่อม <?php echo $status_txt[$arr_repair_detail_status[$v["id"]]]." ".$arr_repair_detail_note[$v["id"]] ?><br><br>
                        </p>
                        <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ลงชื่อ......................................... <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $technician[$v["technician"]] ?>)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $position_name[$v["technician"]] ?> <br>          
                        </p>
                        </td>
                    </tr>
                    <tr>
                        
                        <td width="50%">
                        &nbsp;<h4>เรียนผู้อำนวยการ<?php echo "โรงพยาบาลตระการพืชผล"?></h4>
                        <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; จากการตรวจสอบอุปกรณ์ <?php echo $inventory_txt[$v["inventory_id"]];?> พบว่า <?php echo $v["jobdetail"]; ?> จึงขออนุมัติส่งซ่อม/จัดซื้อทดแทน <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; จึงเรียนมาเพื่อทราบและพิจารณาดำเนินการ<br>
                        </p>
                        <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ลงชื่อ..................................... <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (<?php echo "นายนิพนธ์  เทียนหอม" ?>)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo "นักวิชาการคอมพิวเตอร์" ?> <br>
                        </p>

                        </td>

                        <td width="50%">
                        &nbsp;<h4>ความเห็นหัวหน้ากลุ่มงานประกันสุขภาพ ฯ</h4>
                        <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;[&nbsp;&nbsp;&nbsp;&nbsp;] เห็นควร <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;[&nbsp;&nbsp;&nbsp;&nbsp;] ไม่เห็นควร&nbsp;&nbsp;&nbsp;&nbsp;ให้ดำเนินการตามที่เสนอ <br>
                        </p>
                        <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ลงชื่อ............................................... <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo "นายนิติชัย  ทุมนันท์" ?>) <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "นักวิชาการสาธารณสุข ชำนาญการ" ?> <br>
                        </p>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                        &nbsp;<h4>เสนอผู้อำนวยการ ตามรายการดังกล่าวข้างต้น</h4><br>
                        <p>
                        &nbsp;&nbsp;&nbsp;&nbsp; [&nbsp;&nbsp;&nbsp;&nbsp;] ให้ดำเนินการได้ <br> &nbsp;&nbsp;&nbsp;&nbsp; [&nbsp;&nbsp;&nbsp;&nbsp;] ไม่ควรดำเนินการเนื่องจาก .....................................
                        ........................................................................................ <br><br><br>
                        </p>
                        <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo "นายอุดม  โบจรัส" ?>)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "ผู้อำนวยการโรงพยาบาลตระการพืชผล" ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $data->DIRECTOR_POSITION2 ?>
                        </p>          
                        </td>
                        <td width="50%">
                        &nbsp;<h4>สำหรับผู้รับบริการลงชื่อเพื่อรับผลงาน</h4><br>
                        <p>
                        &nbsp;&nbsp;&nbsp;&nbsp; อุปกรณ์ <?php echo $inventory_txt[$v["inventory_id"]];?> ได้ทำการซ่อมบำรุงเสร็จสิ้น ได้ส่งมอบอุปกรณ์คืนแก่กลุ่มงานที่รับผิดชอบ<br>
                        เมื่อวันที่ ............................................. <br><br>
                        </p>
                        <p><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ลงชื่อ.........................................ผู้รับงาน<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (<?php echo $users_txt[$v["user_id"]]?>)
                        </p><br>
                        </td>        
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