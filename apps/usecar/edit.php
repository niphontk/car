<?php
  Defined('APPS') OR exit('No direct script access allowed');
  $fields = "*";
  $table = "usecar";
  $req = array(
    "id" => $_GET["id"]
  );
  $value = " WHERE `id` = :id ";
  $usecar = fetch_all($fields,$table,$value,$req);
  if(!empty($usecar)){
    $usecar = $usecar[0];
  }else{
    header("location:./?page=usecar");
    exit();
  }

  $fields = "*";
  $table = "department";
  $conditions = "";
  $department = fetch_all($fields, $table, $conditions);

  $fields = "*";
  $table = "driver";
  $conditions = "";
  $driver = fetch_all($fields, $table, $conditions);


  $fields = "*";
  $table = "status";
  $status = fetch_all($fields, $table);
  $status_name = array();
  foreach($status as $v){
    $status_name[$v["id"]] = $v["name"]; 
  }

  $fields = "*";
  $table = "inventory";
  $conditions = " WHERE is_active ='Y'";
  $inventory = fetch_all($fields, $table, $conditions);

  $fields = "*";
  $table = "problem";
  $conditions = "";
  $problem = fetch_all($fields, $table, $conditions);

  $fields = "*";
  $table = "place";
  $conditions = "WHERE  position = '3' ";
  $users = fetch_all($fields, $table);

  $fields = "*";
  $table = "usetime";
  $usetime = fetch_all($fields, $table);

$disabled = "";
if($_SESSION["POSITION"] == "3"){
  $disabled = "disabled";
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
            <li class="breadcrumb-item"><a href="?page=usecar"><?php lang("usecar");?></a></li>
            <li class="breadcrumb-item active"><?php echo $usecar["id"];?></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
  
        <!-- /.col -->
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="tab-content">
                <!-- /.tab-pane -->
                <div class="tab-pane active" id="info">
                  <form id="forminfo" class="form-horizontal" action="apps/usecar/do_usecar.php?action=update_repair&id=<?php echo $usecar["id"];?>"
                    method="POST" autocomplete="off">
                    <input type="hidden" id="id" name="id" value="<?php echo $usecar["id"];?>">
                   
                <div class="form-group row">
                  <label for="inven" class="col-sm-2 col-form-label"><?php lang("carname");?> <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <select name="inven" id="inven" class="form-control select2bs4 select2-hidden-accessible" <?php echo $disabled;?> style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option value="">-- <?php lang("Please Select Inventory");?> --</option>
                        <?php
                          foreach($inventory as $v){
                        ?>
                          <option value="<?php echo $v["id"];?>" <?php if($usecar["inventory_id"] == $v["id"]){echo "selected";}?>><?php echo $v["name"];?>[เลขทะเบียน : <?php echo $v["serial_number"];?>]</option>
                        <?php } ?>
                      </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="name" class="col-sm-2 col-form-label"><?php lang("usedate");?> <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control" id="usedate" name="usedate" value="<?php echo $usecar["use_date"];?>" style="width:200px;">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inven" class="col-sm-2 col-form-label"><?php lang("usetime");?> <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <select name="usetime" id="usetime" class="form-control select2bs4 select2-hidden-accessible" <?php echo $disabled;?> style="width: 200px;" tabindex="-1" aria-hidden="true">
                        <option value="">-- <?php lang("Please Select Time");?> --</option>
                        <?php
                          foreach($usetime as $v){
                        ?>
                          <option value="<?php echo $v["id"];?>" <?php if($usecar["use_time"] == $v["id"]){echo "selected";}?>><?php echo $v["name"];?></option>
                        <?php } ?>
                      </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="department" class="col-sm-2 col-form-label"><?php lang("department");?> <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <select name="depart_id" id="depart_id" class="form-control select2bs4 select2-hidden-accessible" <?php echo $disabled;?> style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option value="">-- <?php lang("department");?> --</option>
                        <?php
                          foreach($department as $v){
                        ?>
                          <option value="<?php echo $v["id"];?>" <?php if($usecar["depart_id"] == $v["id"]){echo "selected";}?>><?php echo $v["depart_name"];?></option>
                        <?php } ?>
                      </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="name" class="col-sm-2 col-form-label"><?php lang("usename");?> <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $usecar["title"];?>"
                      placeholder="<?php lang("usename");?>" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="name" class="col-sm-2 col-form-label"><?php lang("goto");?> <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="goto" name="goto" value="<?php echo $usecar["goto"];?>"
                      placeholder="<?php lang("goto");?>" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="password" class="col-sm-2 col-form-label"><?php lang("personnum");?> <span
                      class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="person" name="person" value="<?php echo $usecar["person"];?>"
                      placeholder="<?php lang("personnum");?>" required>
                  </div>
                </div>   
                
                <?php if($_SESSION["POSITION"] == "1" || $_SESSION["POSITION"] == "4"){ ?>
                <div class="form-group row">
                  <label for="technician" class="col-sm-2 col-form-label"><?php lang("Driver");?> <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <select name="driver" id="driver" class="form-control">
                        <option value="">-- <?php lang("Please Select Driver");?> --</option>
                        <?php
                          foreach($driver as $v){
                        ?>
                          <option value="<?php echo $v["id"];?>" <?php if($usecar["driver_id"] == $v["id"]){echo "selected";}?>><?php echo $v["name"];?></option>                          
                        <?php } ?>
                      </select>
                  </div>
                </div>
                <?php } ?>

                <div class="form-group row">
                  <label for="Description" class="col-sm-2 col-form-label"><?php lang("Note");?> <span
                      class="text-danger"></span></label>
                  <div class="col-sm-10">
                  <textarea name="description" id="Description"rows="5" class="form-control" ><?php echo $usecar["description"];?></textarea>
                  </div>
                </div>

                <?php if(empty($disabled)){?>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> <?php lang("Save");?></button>
                      </div>
                    </div>
                  </form>
                </div>
                <?php } ?>                  
                
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
            <div class="card-footer">
              <?php echo $usecar["created_at"];?>
            </div>
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<script type="text/javascript">
  var msg = "<?php echo isset($_SESSION["MSG"]) ? $_SESSION["MSG"] : ""  ?>";
  var status = "<?php echo isset($_SESSION["STATUS"]) ? $_SESSION["STATUS"] : ""  ?>";

  var language = "<?php echo isset($_SESSION["LANGUAGE"]) ? $_SESSION["LANGUAGE"] : "en" ?>";
  var no_result = "<?php lang("No results found");?>";

  var msg_invent =  "<?php lang("Please Select Inventory");?>";
        var msg_problem = "<?php lang("Please Select Problem");?>";
       var msg_description =  "<?php lang("Please Enter Description");?>";
        var msg_technician =  "<?php lang("Please Select Technician");?>";
</script>

<?php unset($_SESSION["STATUS"],$_SESSION["MSG"]); ?>