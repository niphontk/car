<?php
  defined('APPS') OR exit('No direct script access allowed');
  $fields = "*";
  $table = "repair";
  $req = array(
    "inventory_id" => $_GET["inventory_id"]
  );
  $conditions = "WHERE inventory_id = :inventory_id";
  $repair = fetch_all($fields, $table, $conditions, $req);
  $arr_repair_id = array();
  foreach($repair as $v){
    $arr_repair_id[] = $v["id"];
  }

  $r_id = implode(",", $arr_repair_id);

  $inventory = fetch_all("*","inventory");
  $inventory_txt = array();
  foreach($inventory as $inven){
    $inventory_txt[$inven["id"]] = $inven["name"];
    $inventory_idnumber[$inven["id"]] = $inven["id_number"];
    $inventory_id[$inven["id"]] = $inven["id"];
  }

  $users = fetch_all("*","users");
  $users_txt = array();
  foreach($users as $user){
    $users_txt[$user["id"]] = $user["first_name"]." ".$user["last_name"];
    $technician[$user["id"]] = $user["first_name"]." ".$user["last_name"];
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
  }
}


?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><?php lang("HistoryList");?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="./"><?php lang("Home");?></a></li>
            <li class="breadcrumb-item"><a href="?page=inventory"><?php lang("Inventory");?></a></li>
            <li class="breadcrumb-item active"><?php if(empty($v["inventory_id"])) {}else{echo $inventory_txt[$v["inventory_id"]]; } ?></li>
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

        <!-- /.col-md-6 -->
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">              
                <div class="table-responsive">
                  <table class="table table-striped table-hover table-sm">
                    <thead>
                      <tr>
                        <th>#</th>                    
                        <th><?php lang("Date");?></th>
                        <th><?php lang("Inventory");?></th>
                        <th><?php lang("Problem");?></th>
                        <th><?php lang("Repairer");?></th>
                        <th><?php lang("Technician1");?></th>
                        <th><?php lang("Status");?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                $i = 1;
                         
                  foreach($repair as $repair){
                    $status = $status_txt[$arr_repair_detail_status[$repair["id"]]];
                    if($arr_repair_detail_status[$repair["id"]] == 1){
                      $bg = "warning";
                    }elseif($arr_repair_detail_status[$repair["id"]] == 2){
                      $bg = "success";
                    }else{
                      $bg = "danger";
                    }                    
                ?>
                      <tr>
                        <td><?php echo $i++;?></td>                                                
                        <td><?php echo $repair["created_at"];?></td>
                        <td><?php echo $inventory_txt[$repair["inventory_id"]];?>[<?php echo $inventory_idnumber[$repair["inventory_id"]];?>]</td>
                        <td><?php echo $repair["description"];?></td>
                        <td><?php echo isset($users_txt[$repair["user_id"]]) ? $users_txt[$repair["user_id"]] : "-";?></td>
                        <td><?php echo isset($technician[$repair["technician"]]) ? $technician[$repair["technician"]] : "-";?></td>
                        <td><span class="badge badge-pill" style="background: <?php echo $bg_color[$arr_repair_detail_status[$repair["id"]]];?>; color: <?php echo $text_color[$arr_repair_detail_status[$repair["id"]]];?>;"><?php echo $status;?></span></td>
                        
                      </tr>                      
                      <?php } ?>                      
                    </tbody>
                  </table>
                </div>   
                <div class="row">
                  <div class="col-md-12">
                    <div class="btn-group">
                    <a href="?page=inventory" <?php lang("Inventory");?> class="btn-sm btn btn-info"><i class=""></i>
                      <?php lang("Inventory");?></a>
                    </div>
                  </div>
                </div>           
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
</script>

<?php unset($_SESSION["STATUS"],$_SESSION["MSG"]); ?>
