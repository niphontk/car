<?php
  defined('APPS') OR exit('No direct script access allowed');

  $fields = "*";
  $table = "inventory";
  $conditions = " WHERE is_active ='Y'";
  $inventorys = fetch_all($fields, $table, $conditions);

  $fields = "*";
  $table = "department";
  $conditions = "";
  $department = fetch_all($fields, $table, $conditions);

  $fields = "*";
  $table = "driver";
  $conditions = "WHERE  position = '3' ";
  $driver = fetch_all($fields, $table);

  $fields = "*";
  $table = "usetime";  
  $usetime = fetch_all($fields, $table);

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><?php lang("usecar1");?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="./"><?php lang("Home");?></a></li>
            <?php if($_SESSION["POSITION"] != 2){?>
            <li class="breadcrumb-item"><a href="?page=usecar"><?php lang("usecar1");?></a></li>
            <?php } ?>
            <li class="breadcrumb-item active"><?php lang("usecar1");?></li>
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
              <form id="forminfo" class="form-horizontal" enctype="multipart/form-data" action="apps/usecar/do_usecar.php?action=create_repair"
                method="POST" autocomplete="off">
                <?php if($_SESSION["POSITION"] == "1" || $_SESSION["POSITION"] == "4"){ ?>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"><?php lang("carname");?> <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                  <select class="form-control select2bs4 select2-hidden-accessible" name="inven" id="inven" style="width: 100%;" tabindex="-1" aria-hidden="true">                    
                    <option value="">-- <?php lang("Please Select Inventory");?> --</option>
                    <?php
                      foreach($inventorys as $v){
                    ?>
                    <option value="<?php echo $v["id"];?>"><?php echo $v["name"];?>[เลขทะเบียน : <?php echo $v["serial_number"];?>]</option>
                    <?php } ?>
                  </select>
                </div>
                </div>
                <?php } ?>
                <div class="form-group row">
                  <label for="name" class="col-sm-2 col-form-label"><?php lang("usedate");?> <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control" id="usedate" name="usedate" value="" style="width:200px;"
                      placeholder="<?php lang("goto");?>" required>                      
                  </div>
                </div>

                <div class="form-group row">
                  <label for="problem" class="col-sm-2 col-form-label"><?php lang("usetime");?> <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <select name="usetime" id="usetime" class="form-control select2bs4 select2-hidden-accessible" style="width: 200px;">
                        <option value="">-- <?php lang("Please Select Time");?> --</option>
                        <?php
                          foreach($usetime as $v){
                        ?>
                          <option value="<?php echo $v["id"];?>"><?php echo $v["name"];?></option>
                        <?php } ?>
                      </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="problem" class="col-sm-2 col-form-label"><?php lang("departuse");?> <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <select name="depart_id" id="depart_id" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;">
                        <option value="">-- <?php lang("Please Select Department");?> --</option>
                        <?php
                          foreach($department as $v){
                        ?>
                          <option value="<?php echo $v["id"];?>"><?php echo $v["depart_name"];?></option>
                        <?php } ?>
                      </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="name" class="col-sm-2 col-form-label"><?php lang("usename");?> <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" value=""
                      placeholder="<?php lang("usename");?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="name" class="col-sm-2 col-form-label"><?php lang("goto");?> <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="goto" name="goto" value=""
                      placeholder="<?php lang("goto");?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-2 col-form-label"><?php lang("personnum");?> <span
                      class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="person" name="person" value="1"
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
                          <option value="<?php echo $v["id"];?>"><?php echo $v["name"];?></option>
                        <?php } ?>
                      </select>
                  </div>
                </div>
                <?php } ?>

                <div class="form-group row">
                  <label for="Description" class="col-sm-2 col-form-label"><?php lang("Note");?> <span
                      class="text-danger"></span></label>
                  <div class="col-sm-10">
                    <textarea name="description" id="description"rows="5" class="form-control"></textarea>
                  </div>
                </div>
                
                <div class="form-group row">
                  <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary btn-upload"><i class="fas fa-check-circle"></i>
                    <?php lang("Save");?></button>
                  </div>
                </div>
              </form>
            </div><!-- /.card-body -->
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



<script>
var arr_inven = <?php echo json_encode($inventorys);?>;
var language = "<?php echo isset($_SESSION["LANGUAGE"]) ? $_SESSION["LANGUAGE"] : "en" ?>";
  var no_result = "<?php lang("No results found");?>";

  var msg_invent =  "<?php lang("Please Select Inventory");?>";
        var msg_problem = "<?php lang("Please Select Problem");?>";
        var msg_technician =  "<?php lang("Please Select Technician");?>";
</script>