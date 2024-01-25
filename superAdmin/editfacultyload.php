
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);


if(isset($_GET['editloadid'])){

$_SESSION['editloadid'] = $_GET['editloadid'];

$query = mysqli_query($con,"SELECT fl.teacherId,fl.sessionId,fl.sectionId,fl.subjectId,a.fullName,se.sessionName,sub.subjectTitle,s.sectionName FROM tblfacultyload as fl LEFT JOIN (SELECT Id, fullName FROM tbladmin) as a ON fl.teacherId = a.Id LEFT JOIN (SELECT Id,sessionName FROM tblsession) as se ON fl.sessionId = se.Id LEFT JOIN(SELECT Id,subjectTitle FROM tblsubject) as sub ON fl.subjectId = sub.Id LEFT JOIN (SELECT Id, sectionName FROM tblsection) as s ON fl.sectionId = s.Id WHERE fl.id='$_SESSION[editloadid]'");
$rowi = mysqli_fetch_array($query);

}

else{

echo "<script type = \"text/javascript\">
window.location = (\"editfacultyload.php\")
</script>"; 
}


if(isset($_POST['submit'])){

 $alertStyle ="";
 $statusMsg="";

 $facultyId=$_POST['facultyId'];
 $sectionId=$_POST['sectionId'];
 $subjectId=$_POST['subjectId'];
 $dateCreated = date("Y-m-d");

$query=mysqli_query($con,"UPDATE tblfacultyload SET teacherId='$facultyId', sectionId='$sectionId', subjectId='$subjectId' where id='$_SESSION[editloadid]'");
if($query){
    $alertStyle ="alert alert-success";
    $statusMsg="Faculty Load Edited Successfully!";
   
}
else {

    $alertStyle ="alert alert-danger";
    $statusMsg="An Error Occurred!";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.css" integrity="sha512-pZE3NzBgokXUM9YLBGQIw99omcxiRdkMhZkz0o7g0VjC0tCFlBUqbcLKUuX8+jfsZgiZNIWFiLuZpLxXoxi53w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<script src="../js/jquery-1.12.1.min.js"></script>
<script>
    
    $(document).ready(function(){
    $("#sectionId").change(function(){ 
        var aid = $("#sectionId").val();
        $.ajax({
            url: 'data.php',
            method: 'post',
            data: 'aid=' + aid, 
        }).done(function(section){
            console.log(section);
            section = JSON.parse(section);
            $('#subjectId').empty();
            $('#subjectId').append('<option value="">Select Subject</option>')
            section.forEach(function(sections){
                $('#subjectId').append('<option value="'+   sections.Id +'">' + sections.subjectTitle + '</option>')
            })
        })
    })
})
    </script>
<body>
  <!-- Left Panel -->
  <?php $page="faculty"; include 'includes/leftMenu.php';?>

<!-- /#left-panel -->

<div class="main-content">


     <!-- Header-->
         <?php include 'includes/header.php';?>
     <!-- /header -->
     <main>
         <div class="card-head">
             <div class="page-title">
                 <h2>Faculty</h2>
             </div>
             <div class="page-header">
                     <nav aria-label="breadcrumb">
                         <ol class="breadcrumb">
                             <li class="breadcrumb-item">Dashboard</li>
                             <li class="breadcrumb-item">Faculty</li>
                             <li class="breadcrumb-item active" aria-current="page">Faculty Load</li>
                       </ol>
                     </nav>
             </div>
         </div>


    <div class="content">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Edit Subject Handled</h2></strong>
                        </div>
                        <div class="card-body">
                            <!-- Credit Card -->
                                   <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>
                                    <form method="Post" action="">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="x_card_code" class="control-label mb-1">Teacher</label>
                                                    <?php 
                                                        $query=mysqli_query($con,"SELECT * FROM tbladmin WHERE adminTypeId ='4'");                        
                                                        $count = mysqli_num_rows($query);
                                                        if($count > 0){                       
                                                            echo ' <select required id="teacher" name="facultyId" class="form-select">';
                                                            echo'<option value="">Select Teacher</option>';
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                echo'<option value="'.$row['Id'].'" >'.$row['fullName'].'</option>';
                                                            }
                                                            echo '</select>';
                                                        }
                                                    ?>      
                                                </div>
                                            </div> 
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="x_card_code" class="control-label mb-1">Section</label>
                                                    <?php 
                                                        $query=mysqli_query($con,"select * from tblsection ORDER BY levelId ASC");                        
                                                        $count = mysqli_num_rows($query);
                                                        if($count > 0){                       
                                                            echo ' <select  name="sectionId" id="sectionId" class="form-select">';
                                                            echo'<option value="">Select Section</option>';
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                echo'<option value="'.$row['Id'].'" >'.$row['sectionName'].'</option>';
                                                            }
                                                            echo '</select>';
                                                        }
                                                    ?>   
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="x_card_code" class="control-label mb-1">Subject</label>
                                                    <?php                        
                                                             $query=mysqli_query($con,"select * from tblsubject ORDER BY levelId ASC");                        
                                                             $count = mysqli_num_rows($query);
                                                             if($count > 0){                      
                                                            echo ' <select  name="subjectId" id="subjectId" class="form-select">';
                                                            echo'<option value="">Select Subject</option>';
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                echo'<option value="'.$row['Id'].'" >'.$row['subjectTitle'].'</option>';
                                                            }
                                                            echo '</select>';
                                                        }
                                                    ?>   
                                                </div>
                                            </div>
                                        </div>
                                        <div class ="rows">
                                            <div class="cancel">
                                            <button type="submit" name="cancel" class="btn" ><a href="../superAdmin/facultyload.php" >Cancel</a></button>
                                            </div>
                                            <button type="submit" name="submit" class="btn ">Edit Handled</button>
                                        </div>
                                        <div>
                                            
                                        </div>
                                    </form>
                                </div>
                    </div> <!-- .card -->
                </div><!--/.col-->

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

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    ></script>

    <script>
        $("#teacher").val("<?= isset($_POST['facultyId']) ? $_POST['facultyId'] : ''; ?>");
        $("#subjectId").val("<?= isset($_POST['subjectId']) ? $_POST['subjectId'] : ''; ?>");
        $("#sectionId").val("<?= isset($_POST['sectionId']) ? $_POST['sectionId'] : ''; ?>");
        $("#year").val("<?= isset($_POST['sessionId']) ? $_POST['sessionId'] : ''; ?>");
    </script>
    <script>
        $("#teacher").selectize({});
        $("#sectionId").selectize({});
        $("#year").selectize({});
    </script>


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
