
<?php
//added 
include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);

$aId = isset($_GET['aId']) ? trim($_GET['aId']) : '';
$viewId = isset($_GET['viewId']) ? trim($_GET['viewId']) : '';
$student_name ="";
if(isset($_GET['editpromoted'])){
    
    $query = mysqli_query($con,"SELECT * FROM tblpromoted as p LEFT JOIN (SELECT Id,firstName,lastName FROM tblstudent) as s ON p.studentId = s.Id WHERE p.Id='$_GET[editpromoted]'");
    if($rowi = mysqli_fetch_assoc($query)){
        if($rowi){
            //$add_info = student_load_section($row['sectionId'],$_SESSION['global_session']);
            $student_name = $rowi['firstName'].' '.$rowi['lastName'];
        }
    }
}
else{ 
    echo "<script type = \"text/javascript\">
    window.location = (\"promote.php\")
    </script>"; 
}

if(isset($_POST['promote']))
{
    $alertStyle ="";
    $statusMsg="";

        $levelId = $_POST['levelId'];
        $sectionId = $_POST['sectionId'];
        $studentId = $_POST['studentId'];
        $dateCreated = date("Y-m-d");

        $query = mysqli_query($con,"UPDATE tblpromoted SET levelId='$levelId', sectionId='$sectionId' WHERE Id='$_GET[editpromoted]'");
     
        if ($query) 
            {
                echo "<script type = \"text/javascript\">
                window.location = (\"promote.php?aId=$aId&viewId=$viewId\")
                </script>"; 
            }
            else
            {
                 $alertStyle ="alert alert-danger";
                $statusMsg="An error Occurred!";
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
<body>
    <!-- Left Panel -->
    <?php $page="student"; include 'includes/Advisee_menu.php';?>

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
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Advisee</a></li>
                                <?php //added
                                    $global_level =0;
                                    $global_session =0;
                                    $sql_query = "SELECT a.sectionId,a.sessionId,a.teacherId,s.Id,s.sectionName,s.levelId FROM tbladviser as a LEFT JOIN (SELECT Id,levelId,sectionName FROM tblsection) as s ON a.sectionId = s.Id WHERE a.teacherId ='".$_SESSION['Id']."' AND a.sectionId = '".$_GET['viewId']."' AND a.sessionId = '".$_SESSION['global_session']."'";
                                    $query=mysqli_query($con,$sql_query);
                                    while ($row=mysqli_fetch_array($query)) {
                                        $global_level = $row['levelId'];
                                        $global_session = $row['sessionId'];
                                        $level = $global_level+1;
                                ?>    
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $row['sectionName'];?></li>
                          </ol>
                        </nav>
                </div>
            </div>

    <div class="content">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Promote <?php echo $student_name; ?>
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
                                                <label for="x_card_code" class="control-label mb-1">Section</label>
                                                    <?php 
                                                        $query=mysqli_query($con,"select * from tblsection WHERE levelId = '".$level."' ORDER BY sectionName ASC");                        
                                                        $count = mysqli_num_rows($query);
                                                        if($count > 0){                       
                                                            echo ' <select  name="sectionId" id="section_Id" class="form-select">';
                                                            echo'<option value="">Select Section</option>';
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                echo'<option value="'.$row['Id'].'" >'.$row['sectionName'].'</option>';
                                                            }
                                                            echo '</select>';
                                                        }
                                                    ?>  
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" name="promote" class="btn">Promote Students</button>
                                    </div>
                            </form>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- END OF SCRIPT-->

</body>
</html>
