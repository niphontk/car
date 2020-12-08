<?php
  defined('APPS') OR exit('No direct script access allowed');
  $fields = "*";
  $table = "usecar";
  if($_SESSION["POSITION"] == "1"){
    $conditions = " order by created_at desc";
  }else{
    $conditions = " where user_id = '".$_SESSION["USER_ID"]."' order by created_at desc";
  }
  $repair = fetch_all($fields, $table, $conditions);
  $arr_repair_id = array();
  foreach($repair as $v){
    $arr_repair_id[] = $v["id"];
  }

  $r_id = implode(",", $arr_repair_id);

  $inventory = fetch_all("*","inventory");
  $inventory_txt = array();
  foreach($inventory as $inven){
    $inventory_txt[$inven["id"]] = $inven["name"];
    $inventory_idnumber[$inven["id"]] = $inven["serial_number"];
  }

  $users = fetch_all("*","users");
  $users_txt = array();
  foreach($users as $user){
    $users_txt[$user["id"]] = $user["first_name"]." ".$user["last_name"];
    $technician[$user["id"]] = $user["first_name"]." ".$user["last_name"];
  }

  $fields = "*";
  $table = "driver";
  $conditions = "WHERE  position = '3' ";
  $driver = fetch_all($fields, $table);
  foreach($driver as $driver){
    $driver_txt[$driver["id"]] = $driver["name"];
  }

  $r_status = fetch_all("*","status");
  $status_txt = array();
  foreach($r_status as $status){
    $status_txt[$status["id"]] = $status["name"];
    $bg_color[$status["id"]] = $status["bg_color"];
    $text_color[$status["id"]] = $status["text_color"];
  }

?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><?php lang("usecar");?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="./"><?php lang("Home");?></a></li>
            <li class="breadcrumb-item active"><?php lang("usecar");?></li>
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
<?php

// echo "<pre>";
// print_r($arr_repair_detail);
// echo "</pre>";

?>
        <!-- /.col-md-6 -->
        <div class="col-lg-12">
          <div class="card">
          <?php if($_SESSION["POSITION"] == "1" || $_SESSION["POSITION"] == "2" || $_SESSION["POSITION"] == "3" || $_SESSION["POSITION"] == "4"){ ?>
            <div class="card-header">
              <a href="?page=usecar/add" class="btn btn-success btn-sm float-right"><i class="fas fa-plus-circle"></i>
              <?php lang("usecar1");?></a>
            </div>
          <?php } ?>
            <div class="card-body">
              <form action="apps/usecar/do_usecar.php?action=delete_all" id="frm" method="POST">
                <div class="table-responsive">
                  <table class="table table-striped table-hover table-sm">
                    <thead>
                      <tr>
                        <th>#</th>
                        <?php if($_SESSION["POSITION"] == "1"){ ?>
                        <th></th>
                        <?php } ?>
                        <th><?php lang("Date");?></th>
                        <th><?php lang("carname");?></th>
                        <th><?php lang("usename");?></th>
                        <th><?php lang("goto");?></th>
                        <th><?php lang("personnum");?></th>
                        <th><?php lang("driver");?></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                $i = 1;

                         
                   foreach($repair as $repair){
                                 
                ?>
                      <tr>
                        <td><?php echo $i++;?></td>                        
                        <?php if($_SESSION["POSITION"] == "1"){ ?>
                        <td class="text-center">
                          <div class="icheck-primary d-inline">
                            <input type="checkbox" id="checK_<?php echo $i;?>" name="ch[]"
                              value="<?php echo $repair["id"];?>">
                            <label for="checK_<?php echo $i;?>">
                            </label>
                          </div>
                        </td>
                        <?php } ?>
                        <td><?php echo $repair["created_at"];?>[JobID : <?php echo $repair["id"];?>]</td>
                        <td><?php echo $inventory_txt[$repair["inventory_id"]];?>[<?php echo $inventory_idnumber[$repair["inventory_id"]];?>]</td>
                        <td><?php echo $repair["title"];?></td>
                        <td><?php echo $repair["goto"];?></td>
                        <td><?php echo $repair["person"];?></td>  
                        <td><?php echo isset($driver_txt[$repair["driver_id"]]) ? $driver_txt[$repair["driver_id"]] : "-";?></td>  
                        <td>
                          <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                              id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <?php if($_SESSION["POSITION"] == "1" || $_SESSION["POSITION"] == "4"){ ?>
                              <small><a class="dropdown-item"
                                  href="?page=usecar/edit&id=<?php echo $repair["id"];?>"><i class="fas fa-edit"></i>
                                  <?php lang("Edit");?></a></small>
                              <?php }else{ ?>
                                <small><a class="dropdown-item"
                                  href="?page=repair/edit_job&id=<?php echo $repair["id"];?>"><i class="fas fa-edit"></i>
                                  <?php lang("Edit");?></a></small>
                              <?php } ?>

                              <small><a class="dropdown-item" href="javascript:void(0);" data-toggle="modal"
                                  data-target="#modalApprove" data-approve-id="<?php echo $repair["id"];?>"
                                  data-repairname="<?php echo $repair["title"];?>"
                                  ><i class="fas fa-edit"></i>
                                  <?php lang("approve");?></a></small>

                              <small><a class="dropdown-item"
                                  href="?page=repair/print&repair_id=<?php echo $repair["id"];?>"><i class="fas fa-edit"></i>
                                  <?php lang("PrintJob");?></a></small>
                             
                              <?php if($_SESSION["POSITION"] == "1"){ ?>
                              <small><a class="dropdown-item" href="javascript:void(0);" data-toggle="modal"
                                  data-target="#modalDelete" data-repair-id="<?php echo $repair["id"];?>"
                                  data-repairname="<?php echo $repair["title"];?>"
                                  ><i class="fas fa-minus-circle"></i>
                                  <?php lang("Delete");?></a></small>
                              <?php } ?>
                      
                            </div>
                          </div>
                        </td>

                      </tr>                      
                      <?php } ?>                      
                    </tbody>
                  </table>
                </div>

                <?php if($_SESSION["POSITION"] == "1"){ ?>
                <div class="row">
                  <div class="col-md-12">
                    <div class="btn-group">
                      <button type="button" class="btn-sm btn">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="checkall">
                          <label for="checkall"> <?php lang("Select All");?>
                          </label>
                        </div>
                      </button>
                      <button type="button" class="btn-sm btn btn-danger btn-delete-all" disabled data-toggle="modal"
                        data-target="#modalDeleteAll"><i class="fas fa-minus-circle"></i> <?php lang("Delete");?>
                      </button>
                    </div>
                  </div>
                </div>
                <?php } ?>
       
                <form>                  
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


<div class="modal" id="modalDeleteAll" role="dialog" tabindex="-1" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <i class="fas fa-exclamation-circle"></i> <?php lang("Are you want to delete all?");?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php lang("No");?></button>
        <button type="button" class="btn btn-primary btn-continue"><?php lang("Yes");?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalDelete" role="dialog" tabindex="-1" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <i class="fas fa-exclamation-circle"></i>
        <span></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php lang("No");?></button>
        <button type="button" class="btn btn-primary btn-continue" onClick=""><?php lang("Yes");?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalApprove" role="dialog" tabindex="-1" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <i class="fas fa-exclamation-circle"></i>
        <span></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php lang("No");?></button>
        <button type="button" class="btn btn-primary btn-continue" onClick=""><?php lang("Yes");?></button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  var msg = "<?php echo isset($_SESSION["MSG"]) ? $_SESSION["MSG"] : ""  ?>";
  var status = "<?php echo isset($_SESSION["STATUS"]) ? $_SESSION["STATUS"] : ""  ?>";
  var position = "<?php echo $_SESSION["POSITION"] ?>";

  var language = "<?php echo isset($_SESSION["LANGUAGE"]) ? $_SESSION["LANGUAGE"] : "en" ?>";

  var alert_delete_modal = "<?php lang("Do you want to delete this information?");?>";

  var alert_approve_modal = "<?php lang("Are you want to approve job?");?>";
</script>

<?php unset($_SESSION["STATUS"],$_SESSION["MSG"]); ?>
