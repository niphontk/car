<?php
    require('config_car.php');
?>

<body>
<div class="container">
<div class="panel-body">
<div class="panel panel-success">
<div class="panel-heading"><h4><i class="glyphicon glyphicon-list-alt"></i> รายการจองใช้รถ </h3></div>
<div class="panel-body">             
    <?php    
	$dd = date("Y-m-d");
	$tt = date("H:i:s");
        $sql = "SELECT CONCAT(us.first_name,'  ',us.last_name) as fullname,usecar.title,usecar.goto,d.depart_name,usecar.person,usecar.created_at,usecar.use_date,usetime.`name` as usetime,ud.`name` as driver,inventory.`name` as carname ";
        $sql .= " from usecar ";
        $sql .= " INNER JOIN users us on us.id = usecar.user_id";
        $sql .= " INNER JOIN department d on d.id = usecar.depart_id";
        $sql .= " INNER JOIN usetime on usetime.id = usecar.use_time";
        $sql .= " INNER JOIN driver ud on ud.id = usecar.driver_id";
        $sql .= " INNER JOIN inventory on inventory.id = usecar.inventory_id";

        if(isset($_GET['keyword'])){$keyword=$_GET['keyword'];}else{$keyword="";}    
        if(isset($_GET['stdate'])){$stdate=$_GET['stdate'];}else{$stdate="";}
        if(isset($_GET['endate'])){$endate=$_GET['endate'];}else{$endate="";}

        if($keyword =="" && $stdate =="" && $endate ==""){
            $sql .= " where usecar.use_date = '$dd' ";
            $sql.=" order by usecar.use_date";
        }elseif($keyword =="" && $stdate !="" && $endate !=""){
            $sql.=" where (usecar.use_date BETWEEN '$stdate' AND '$endate') ";
            $sql.=" order by usecar.use_date";
        }elseif($keyword !="" && $stdate =="" && $endate ==""){
            $sql.=" where (usecar.id='$keyword' OR usecar.title LIKE '%$keyword%' ) ";
            $sql.=" order by usecar.use_date";
        }elseif($stdate !="" && $endate !=""){
            $sql.=" where (usecar.use_date BETWEEN '$stdate' AND '$endate') ";
            $sql.=" order by usecar.use_date";
        }elseif($keyword !="" && $stdate !="" && $endate !=""){
            $sql.=" where (usecar.id='$keyword' OR usecar.title LIKE '%$keyword%' and (usecar.use_date BETWEEN '$stdate' AND '$endate')) ";
            $sql.=" order by usecar.use_date";
        }        
    //echo $sql; exit;
        require('connect.php');	
    ?>
    <div class="panel-body">
    <form action="report.php" method="get" name="search_form" >
    <input name="id" type="hidden" value="<?php echo($keyword);?>">
    <div class="form-group">
        <div class="row">
        <div class="col-md-8">
        <div class="input-group">                                    
            <div class="input-group-addon">                                                                
                ค้นหา :
            </div>                                    
                <input class="form-control" name="keyword" type="text" style="width:200px;" value="<?php echo($keyword);?>">
                                      
            <div class="input-group-addon">                                                                
                วันที่ :
            </div>                                    
                <input class="form-control" name="stdate" type="date" style="width:200px;" value="<?php echo($stdate);?>">
            
            <div class="input-group-addon">                                                                
                ถึง :
            </div>                                    
                <input class="form-control" name="endate" type="date" style="width:200px;" value="<?php echo($endate);?>">                                               
                
        </div>   <br />
                <input class="btn btn-success" name="submit" type="submit" value="ค้นหา">
                <input class="btn btn-success" type="submit" name="Submit" value=" PRINT " onClick="javascript:this.style.display='none';window.print()">
        </div>
        </div>
    </div>
    </form>  
    
    <table class="table table-bordered" cellspacing="0" cellpadding="2">
    <tr class="success">
        <td>ผู้ขอรถ</td>
        <td>ชื่อเรื่อง</td>
        <td> สถานที่</td>
        <td >กลุ่มงาน</td>
        <td >จำนวนคน</td>
        <td >วันที่ขอ</td>
        <td >วันที่เดินทาง</td>
        <td >เวลาเดินทาง</td>
        <td >พนักงานขับรถ</td>
        <td >รถ</td>     
    
    <?php
        while($objResult10 = mysqli_fetch_array($result))
    {?>
    <tr> 
            <td><?=$objResult10["fullname"];?></td>
            <td><?=$objResult10["title"];?> </td>
            <td><?=$objResult10["goto"];?></td>
            <td><?=$objResult10["depart_name"];?></td>   
            <td><?=$objResult10["person"];?></td>            
            <td><?=$objResult10["created_at"];?></td>          
            <td><?=$objResult10["use_date"];?></td>      
            <td><?=$objResult10["usetime"];?></td>      
            <td><?=$objResult10["driver"];?></td>      
            <td><?=$objResult10["carname"];?></td>      
               
    </tr>
        <?php } ?>
</table>  
</div>
</div>
</div>
</div>  
</body>