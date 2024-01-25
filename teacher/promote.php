
<?php
//added 
include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);

$global_session =0;
$sql_query = "SELECT a.sectionId,a.sessionId,a.teacherId,s.Id,s.sectionName,s.levelId FROM tbladviser as a LEFT JOIN (SELECT Id,levelId,sectionName FROM tblsection) as s ON a.sectionId = s.Id WHERE a.teacherId ='".$_SESSION['Id']."' AND a.sectionId = '".$_GET['viewId']."'";
$query=mysqli_query($con,$sql_query);
while ($row=mysqli_fetch_array($query)) {
    $global_session = $row['sessionId'];}

$activesession ="";
$query=mysqli_query($con,"SELECT * FROM tblsession WHERE Id > '".$global_session."' ORDER BY Id ASC LIMIT 1");
if($row = mysqli_fetch_assoc($query)){
    if($row){
        //$add_info = student_load_section($row['sectionId'],$_SESSION['global_session']);
        $activesession = $row['Id'];
    }
}

$aId = isset($_GET['aId']) ? trim($_GET['aId']) : '';
if(isset($_POST['promote']))
{
    $student = $_POST['student'];
    foreach($student as $students)
    {
        $query=mysqli_query($con,"select * from tblpromoted where studentId ='$students' AND sessionId = '$activesession'");
    $ret=mysqli_fetch_array($query);

        $levelId = $_POST['levelId'];
        $sectionId = $_POST['sectionId'];
        $studentId = $_POST['studentId'];
        $dateCreated = date("Y-m-d H:i:s");

    if($ret > 0){
    
      $alertStyle ="alert alert-danger";
      $statusMsg="Student with the LRN already exist!";
    }
    else{
        $query = mysqli_query($con,"INSERT INTO tblpromoted (studentId,levelId,sectionId,sessionId,adviseeId,dateCreated) VALUES ('$students','$levelId','$sectionId','$activesession','$aId','$dateCreated')");
      
        if ($query) 
            {
                $alertStyle ="alert alert-success";
                $statusMsg="Students Promoted Successfully!";
            }
            else
            {
                 $alertStyle ="alert alert-danger";
                $statusMsg="Error!";
            }
    }
    }
}


?>

<!doctype html>
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include '../includes/title.php';?>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link  rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    
    <link rel="stylesheet" href="../assets/css/lib/datatable/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    
    
</head>
<script src="../js/jquery-1.12.1.min.js"></script>
    <script>
       $(document).ready(function(){
            $(".levelId").change(function(){ 
                var levelId = $(this).val();
                $.ajax({
                    url: 'data.php',
                    method: "POST",
                    data: {levelId : levelId},
                    success:function(data){
                        $("#select_sectionId").html(data);
                    }
                });
            });
        });
    </script> 
<script language="javascript">
    $(function () {
        // add multiple select / deselect functionality
        $("#selectall").click(function () {
            $('.name').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".name").click(function () {
            if ($(".name").length == $(".name:checked").length) {
                $("#selectall").attr("checked", "checked");
            } else {
                $("#selectall").removeAttr("checked");
            }
        });
    });
</script>
<body>
    <!-- Left Panel -->
    <?php $page="promote"; include 'includes/Advisee_menu.php';?>

   <!-- /#left-panel -->

<div class="main-content">


        <!-- Header-->
            <?php include 'includes/header.php';?>
        <!-- /header -->
        <main>
            <div class="card-head">
                <div class="page-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item">Advisee</li>
                                <?php //added
                                    $global_level =0;
                                    $global_session =0;
                                      $sql_query = "SELECT a.sectionId,a.sessionId,a.teacherId,s.Id,s.sectionName,s.levelId FROM tbladviser as a LEFT JOIN (SELECT Id,levelId,sectionName FROM tblsection) as s ON a.sectionId = s.Id WHERE a.teacherId ='".$_SESSION['Id']."' AND a.sectionId = '".$_GET['viewId']."' AND a.sessionId = '".$_SESSION['global_session']."'";
                                    $query=mysqli_query($con,$sql_query);
                                    while ($row=mysqli_fetch_array($query)) {
                                        $global_level = $row['levelId'];
                                        $global_session = $row['sessionId'];
                                ?>    
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $row['sectionName'];?></li>
                          </ol>
                        </nav>
                </div>
            </div>

    <div class="content">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Promote Student of Section <?php echo $row['sectionName']; ?>
                            <?php 
                                }//added end
                            ?></h2></strong>
                        </div>
                        <div class="card-body">
                            <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>
                                <form method="Post" action="">   
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="x_card_code" class="control-label mb-1">Grade Level</label>
                                                <select Required name="levelId" class="levelId form-select">
                                                    <?php 
                                                         echo'<option value="" >Select Grade Level</option>';
                                                        $query = mysqli_query($con,"SELECT * FROM tbllevel WHERE Id > '".$global_level."' ORDER BY levelName ASC LIMIT 1");
                                                      
                                                        $count = mysqli_num_rows($query);
                                                        if($count > 0){                       
                                                            
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                if($global_level < 6 AND $row['levelName'] == 'Graduate') { continue; }
                                                                echo'<option value="'.$row['Id'].'" >'.$row['levelName'].'</option>';
                                                            }
                                                           
                                                        }
                                                        echo '</select>';
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Section</label>
                                                <?php 
                                                 echo ' <select  id="select_sectionId" name="sectionId" class="form-select">';
                                                 echo'<option value="" >Select Section</option>';
                                                 echo '</select>';

                                                ?>  
                                            </div>
                                        </div>
                                      <!-- <div class="col-4">
                                            <div class="form-group">
                                                <label for="x_card_code" class="control-label mb-1">School Year</label>
                                                <?php 
                                                    $query=mysqli_query($con,"SELECT * FROM tblsession WHERE Id > '".$global_session."' ORDER BY Id ASC LIMIT 1");                        
                                                    $count = mysqli_num_rows($query);
                                                    if($count > 0){                       
                                                        echo ' <select required name="sessionId" class="form-select">';
                                                        echo'<option value="">Select Year</option>';
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            echo'<option value="'.$row['Id'].'" >'.$row['sessionName'].'</option>';
                                                        }
                                                        echo '</select>';
                                                    }
                                                ?>   
                                            </div>
                                        </div>-->
                                    </div>
                                    <div class="table-responsive">
                                        <table  class="table table-hover table-striped table-bordered center"  >
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectall"/> Select All</th>
                                                <th>FullName</th>
                                                <th>LRN</th>
                                                <!--<th>Date Created</th>-->
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            <tr>
                                        <?php
                                            $ret=mysqli_query($con,"SELECT p.studentId,p.sectionId,p.sessionId,s.Id,s.firstName,s.lastName,s.middleName,s.LRN,s.dateCreated FROM tblpromoted as p  LEFT JOIN (SELECT Id,firstName,lastName,middleName,LRN,dateCreated FROM tblstudent) as s ON p.studentId = s.Id WHERE p.sectionId = '".$_GET['viewId']."' AND p.sessionId = '".$_SESSION['global_session']."' ORDER BY s.lastname ASC");
                                            $cnt=1;
                                            while ($row=mysqli_fetch_array($ret)) {
                                                                ?>
                                            <tr>
                                                <td><input type="checkbox" class="name" name="student[]" value="<?php  echo $row['studentId'];?>"> </td>
                                                <td><?php  echo $row['lastName'];?>, <?php  echo $row['firstName'];?></td>
                                                <td><?php  echo $row['LRN'];?></td>
                                            </tr>
                                        <?php 
                                        }?>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <button type="submit" name="promote" class="btn">Promote Students</button>
                                    </div>
                            </form>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Promoted Students</h2></strong>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                            <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>FullName</th>
                                        <th>Grade Level</th>
                                        <th>Section</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                        <?php
                                        $ret=mysqli_query($con,"SELECT p.Id as pId,p.studentId,p.sectionId,p.sessionId,p.adviseeId,s.firstName,s.lastName,l.levelName,sec.sectionName,p.dateCreated FROM tblpromoted as p LEFT JOIN (SELECT Id,sectionName FROM tblsection) as sec ON p.sectionId = sec.Id LEFT JOIN (SELECT Id,levelName FROM tbllevel) as l ON p.levelId = l.Id LEFT JOIN (SELECT Id,firstName,lastName FROM tblstudent) as s ON p.studentId = s.Id WHERE p.adviseeId = '".$_GET['aId']."' AND p.sessionId = '".$activesession."' ORDER BY p.dateCreated DESC");
                                        $cnt=1;
                                        while ($row=mysqli_fetch_array($ret)) {
                                     ?>
                                    <tr>
                                        <td><?php echo $cnt;?></td>
                                        <td><?php echo $row['lastName'].', '.$row['firstName'];?></td>
                                        <td><?php echo $row['levelName'];?></td>
                                        <td><?php echo $row['sectionName'];?></td>
                                        <td><a href="editpromoted.php?editpromoted=<?php echo $row['pId'];?>&viewId=<?php echo $_SESSION['viewId'];?>&aId=<?php echo $_GET['aId'];?>" title="Edit Details"><i class="las la-edit"></i></a>
                                        <a class="delete" data-href="deletepromoted.php?delid=<?php echo $row['pId'];?>&viewId=<?php echo $_SESSION['viewId'];?>&aId=<?php echo $_GET['aId'];?>" title="Delete Student Details"><i class="las la-trash-alt"></i></a></td>
                                    </tr>
                                    <?php 
                                        $cnt=$cnt+1;
                                    }?>
                                                                                        
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
<!-- end of datatable -->

</div><!-- .content -->

<div class="clearfix"></div>

</main>
<!-- FOOTER-->
    <?php include 'includes/footer.php';?>
<!-- END OF FOOTER-->

</div><!-- /#right-panel -->

<!-- Right Panel -->

<!-- SCRIPT-->

<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="../assets/js/main.js"></script>

<script src="../assets/js/lib/data-table/datatables.min.js"></script>
<script src="../assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
<script src="../assets/js/lib/data-table/dataTables.buttons.min.js"></script>
<script src="../assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
<script src="../assets/js/lib/data-table/jszip.min.js"></script>
<script src="../assets/js/lib/data-table/vfs_fonts.js"></script>
<script src="../assets/js/lib/data-table/buttons.html5.min.js"></script>
<script src="../assets/js/lib/data-table/buttons.print.min.js"></script>
<script src="../assets/js/lib/data-table/buttons.colVis.min.js"></script>
<script src="../assets/js/init/datatables-init.js"></script>



<script type="text/javascript">
    $(document).ready(function() {
      $('#bootstrap-data-table-export').DataTable();
  } );

  
</script>



<script src=../assets/plugins/bootstrap-sweetalert/sweetalert.min.js></script>
<script src="../_common/delete_swal.js"></script>


<script>
    let arrow = document.querySelectorAll(".arrow");
    console.log(arrow);
    for (var i = 0; i < arrow.length; i++){
        arrow[i].addEventListener("click", (e)=>{
        let arrowParent = e.target.parentElement.parentElement
            arrowParent.classList.toggle("showMenu");
        });
    }

    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".la-bars");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click",()=>{
        sidebar.classList.toggle("close");
    });

</script>
<!--<script
  src="https://code.jquery.com/jquery-3.6.3.min.js"
  integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
  crossorigin="anonymous"></script>
<script >
    function select_all(){
        jQuery('input[type=checkbox]').each(function(){
           jQuery('#'+this.value).prop('checked',true);
        });
    }
</script>-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- END OF SCRIPT-->

</body>
</html>
