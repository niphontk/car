<?php
  defined('APPS') OR exit('No direct script access allowed');
  $fields = "inventory_id,count(inventory_id) as inven";
  $table = "repair";
  $form_date = date("Y-m-d")." 00:00:00";
  $to_date = date("Y-m-d")." 23:59:59";
  $conditions = " GROUP BY inventory_id ";
  $repair = fetch_all($fields, $table, $conditions);

  $fields = "count(technician) as inven,technician";
  $table = "repair";
  $form_date = date("Y-m-d")." 00:00:00";
  $to_date = date("Y-m-d")." 23:59:59";
  $conditions = " GROUP BY technician ";
  $repair1 = fetch_all($fields, $table, $conditions);

  $fields = "problem,count(inventory_id) as inven";
  $table = "repair";
  $form_date = date("Y-m-d")." 00:00:00";
  $to_date = date("Y-m-d")." 23:59:59";
  $conditions = " GROUP BY problem ";
  $repair2 = fetch_all($fields, $table, $conditions);

  $fields = "*";
  $table = "inventory";  
  $conditions = "";
  $inventory = fetch_all($fields, $table, $conditions);
  foreach($inventory as $inven){
      $inventory_txt[$inven["id"]] = $inven["name"]; 
      $inventory_id[$inven["id"]] = $inven["type"]; 
      $depart_id[$inven["id"]] = $inven["depart_id"]; 
  }

  $fields = "*";
  $table = "type";  
  $conditions = " ";
  $type = fetch_all($fields, $table, $conditions);
  foreach($type as $type){
      $type_txt[$type["id"]] = $type["name"];       
  }

  $fields = "*";
  $table = "problem";  
  $conditions = "";
  $problem = fetch_all($fields, $table, $conditions);
  foreach($problem as $problem){
      $problem_txt[$problem["id"]] = $problem["name"];       
  }

  $fields = "*";
  $table = "department";  
  $conditions = "";
  $department = fetch_all($fields, $table, $conditions);
  foreach($department as $depart){
      $depart_txt[$depart["id"]] = $depart["depart_name"]; 
  }

  $fields = "*";
  $table = "users";  
  $conditions = "";
  $users = fetch_all($fields, $table, $conditions);
  foreach($users as $u){
      $user_txt[$u["id"]] = $u["first_name"]."  ".$u["last_name"]; 
  }


?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><?php lang("Report01");?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="./"><?php lang("Home");?></a></li>
            <li class="breadcrumb-item active"><?php lang("Report01");?></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- /.col-md-6 -->
        <div class="col-lg-12">
          <div class="card">    
          <div class="card-header">
              แยกตามสาเหตุ         
          </div>    
            <!-- </div> -->
            <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-hover table-sm">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th><?php lang("problem");?></th>
                        <th><?php lang("Count");?></th>
                        <th><?php //lang("Status");?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      
                      $i = 1;
                      foreach($repair2 as $v){    
                        $xx = $v["problem"];                                                  
                      ?>                      
                      <tr>
                        <td><?php echo $i++;?></td>
                        <td><?php echo $problem_txt["$xx"]?></td>
                        <td><?php echo $v["inven"]?></td>
                        <td><span class="badge badge-<?php //echo $bg;?> badge-pill"><?php //echo $status;?></span></td>
                        
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <!-- <input type="text" id="hdcount" name="hdcount" value="1"> -->       
            </div>
          </div>
        </div>
        <!-- /.col-md-6 -->

      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <!-- /.content -->
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- /.col-md-6 -->
        <div class="col-lg-12">
          <div class="card">  
          <div class="card-header">
              แยกตามกลุ่มงาน              
          </div>          
            <!-- </div> -->
            <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-hover table-sm">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th><?php lang("Department");?></th>
                        <th><?php lang("Count");?></th>
                        <th><?php //lang("Status");?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      
                      $i = 1;
                      foreach($repair as $v){    
                        $xx = $v["inventory_id"];                                                  
                      ?>                      
                      <tr>
                        <td><?php echo $i++;?></td>
                        <td><?php echo $depart_txt[$depart_id["$xx"]]?></td>
                        <td><?php echo $v["inven"]?></td>
                        <td><span class="badge badge-<?php //echo $bg;?> badge-pill"><?php //echo $status;?></span></td>
                        
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <!-- <input type="text" id="hdcount" name="hdcount" value="1"> -->       
            </div>
          </div>
        </div>
        <!-- /.col-md-6 -->

      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <!-- /.content -->
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- /.col-md-6 -->
        <div class="col-lg-12">
          <div class="card"> 
          <div class="card-header">
              แยกตามช่างผู้รับผิดชอบงาน
          </div>           
            <!-- </div> -->
            <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-hover table-sm">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th><?php lang("Users");?></th>
                        <th><?php lang("Count");?></th>
                        <th><?php //lang("Status");?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      
                      $i = 1;
                      foreach($repair1 as $v){    
                        $user_id = $v["technician"];                                                
                      ?>                      
                      <tr>
                        <td><?php echo $i++;?></td>
                        <td><?php echo $user_txt["$user_id"]?></td>
                        <td><?php echo $v["inven"]?></td>
                        <td><span class="badge badge-<?php //echo $bg;?> badge-pill"><?php //echo $status;?></span></td>
                        
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <!-- <input type="text" id="hdcount" name="hdcount" value="1"> -->       
            </div>
          </div>
        </div>
        <!-- /.col-md-6 -->

      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <!-- /.content -->
</div>


<script type="text/javascript">
  var msg = "<?php echo isset($_SESSION["MSG"]) ? $_SESSION["MSG"] : ""  ?>";
  var status = "<?php echo isset($_SESSION["STATUS"]) ? $_SESSION["STATUS"] : ""  ?>";
  var position = "<?php echo $_SESSION["POSITION"] ?>";

  var language = "<?php echo isset($_SESSION["LANGUAGE"]) ? $_SESSION["LANGUAGE"] : "en" ?>";

  var alert_delete_modal = "<?php lang("Do you want to delete this information?");?>";
  var required_name = "<?php lang("Please Enter Brand");?>";
  var required_type = "<?php lang("Please Select Type");?>";
</script>

<?php unset($_SESSION["STATUS"],$_SESSION["MSG"]); ?>
