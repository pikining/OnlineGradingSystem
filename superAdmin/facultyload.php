
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);


$activesession ="";
$query = mysqli_query($con,"SELECT * FROM tblsession WHERE isActive ='1'");
if($row = mysqli_fetch_assoc($query)){
    if($row){
        //$add_info = student_load_section($row['sectionId'],$_SESSION['global_session']);
        $activesession = $row['Id'];
    }
}

if(isset($_POST['submit'])){

$alertStyle ="";
$statusMsg="";

$facultyId=$_POST['facultyId'];
$sectionId=$_POST['sectionId'];
$subjectId=$_POST['subjectId'];
$dateCreated = date("Y-m-d H:i:s");


    $query=mysqli_query($con,"SELECT * FROM tblfacultyload WHERE sectionId = '$sectionId' and subjectId ='$subjectId' and sessionId = '$activesession'");
    $ret=mysqli_fetch_array($query);

    if($ret > 0){ //Check the LRN
      $alertStyle ="alert alert-danger";
      $statusMsg="Load already exist!";
    }
    else{

        $query=mysqli_query($con,"INSERT INTO tblfacultyload (teacherId, sectionId, subjectId, sessionId,dateCreated) 
        VALUES ('".$facultyId."','".$sectionId."','".$subjectId."','".$activesession."','".$dateCreated."')");
        
        
        if ($query) 
        {
            $alertStyle ="alert alert-success";
            $statusMsg="Faculty Load Added Successfully!";
        }
        else
        {
             $alertStyle ="alert alert-danger";
            $statusMsg="This section has an adviser!";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.css" integrity="sha512-pZE3NzBgokXUM9YLBGQIw99omcxiRdkMhZkz0o7g0VjC0tCFlBUqbcLKUuX8+jfsZgiZNIWFiLuZpLxXoxi53w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<script src="../js/jquery-1.12.1.min.js"></script>
<script>
    
    $(document).ready(function(){
    $("#sectionId").change(function(){ 
        var aid = $("#sectionId").val();
        $.ajax({
            url: '../superAdmin/data.php',
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
                             <li class="breadcrumb-item">Faculty</li>
                             <li class="breadcrumb-item active" aria-current="page">Add Subject Handled</li>
                       </ol>
                     </nav>
             </div>
         </div>

    <div class="content">
        <div class="bulk">
            <button type="button" data-bs-toggle="modal" data-bs-target="#bulk" name="submit" class="btn "><i class="las la-file-upload" ></i> Bulk Insert</button>
        </div>
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Subject Handled</h2></strong>
                        </div>
                        <div class="card-body">
                            <!-- Credit Card -->
                                   <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>
                                    <form method="Post" action="">
                                    <div class="row">
                                            <!--<div class="col-4">
                                                <div class="form-group"> 
                                                 <label for="x_card_code" class="control-label mb-1">School Year</label>
                                                <?php 
                                                    $query=mysqli_query($con,"select * from tblsession where isActive = '1' ORDER BY id ASC");                        
                                                    $count = mysqli_num_rows($query);
                                                    if($count > 0){                       
                                                        echo ' <select required id="year" name="sessionId" class="form-select">';
                                                        echo'<option value="">Select Session</option>';
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            echo'<option value="'.$row['Id'].'" >'.$row['sessionName'].'</option>';


                                                        }
                                                        echo '</select>';
                                                        }
                                                ?>   
                                                </div>
                                            </div>-->
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="x_card_code" class="control-label mb-1">Teacher</label>
                                                    <?php 
                                                        $query=mysqli_query($con,"SELECT * FROM tbladmin WHERE adminTypeId ='4'");                        
                                                        $count = mysqli_num_rows($query);
                                                        if($count > 0){                       
                                                            echo ' <select required id="teacher" name="facultyId" class="form-select"  >';
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
                                                            echo ' <select  name="sectionId" id="sectionId" class="form-select" >';
                                                            echo'<option value="">Select Section</option>';
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                echo'<option value="'.$row['Id'].'" >'.$row['levelId'].' - '.$row['sectionName'].'</option>';
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
                                        <div>
                                            <button type="submit" name="submit" class="btn btn-success">Add Handled</button>
                                        </div>

                                    </form>
                                </div>
                    </div> <!-- .card -->
           
               
            <br><br>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Subject Handled</h2></strong>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                            <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                        <th>Faculty Name</th>
                                        <th>Section </th>
                                        <th>Subject </th>
                                        <th>Session </th>
                                        <th>Action</th>
                                                                                
                                        </tr>
                                </thead>
                                <tbody>
                                                        
                                    <?php
                                        $ret=mysqli_query($con,"SELECT  tbladmin.Id, tbladmin.fullName ,tblsection.Id, tblsubject.Id, tblsubject.subjectTitle, tblsection.sectionName ,tblfacultyload.dateCreated, tblsession.Id, tblsession.sessionName, tblfacultyload.id
                                        FROM tblfacultyload 
                                        LEFT JOIN tbladmin ON tbladmin.Id = tblfacultyload.teacherId
                                        LEFT JOIN tblsection ON tblsection.Id = tblfacultyload.sectionId
                                        LEFT JOIN tblsubject ON tblsubject.Id = tblfacultyload.subjectId
                                        LEFT JOIN tblsession ON tblsession.Id = tblfacultyload.sessionId ORDER BY tblfacultyload.dateCreated DESC");
                                        $cnt=1;
                                        while ($row=mysqli_fetch_array($ret)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $cnt;?></td>
                                        <td ><?php  echo $row['fullName'];?></td>
                                        <td ><?php  echo $row['sectionName'];?></td>
                                        <td ><?php  echo $row['subjectTitle'];?></td>
                                        <td ><?php  echo $row['sessionName'];?></td>
                                        <td ><a href="editfacultyload.php?editloadid=<?php echo $row['id'];?>" title="Edit Faculty Details"><i class="las la-edit"></i></a>
                                            <a class="delete" data-href="deletefacultyload.php?delloadid=<?php echo $row['id'];?>" title="Delete Faculty Details"><i class="las la-trash-alt"></i></a></td>
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

<!-- MODAL -->
<div class="modal fade" id="bulk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" align="center">
        <h5 class="modal-title" id="exampleModalLongTitle">Bulk Data upload</h5>
      </div>
      <form class="bulk-form" action="../superAdmin/bulkfacultyload.php" enctype="multipart/form-data"  id="bulk-form" method="POST" >
      <div class="modal-body">
            <div class="col-12">
                <label for="x_card_code" class="form-label">Import csv file :</label>
                <input class="form-control" type="file" id="csv" name="csv">
            </div><br>
            <div class="col-12">
                <div class="form-group">
                    <a href="../facultyload.xlsx" target="_blank" download="template">DOWNLOAD TEMPLATE</a>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="import_file" id="send">Import file</button>
      </div>
     </form>
    </div>
  </div>
</div>

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
       // $("#teacher").val("<?= isset($_POST['facultyId']) ? $_POST['facultyId'] : ''; ?>");
       // $("#subjectId").val("<?= isset($_POST['subjectId']) ? $_POST['subjectId'] : ''; ?>");
       // $("#sectionId").val("<?= isset($_POST['sectionId']) ? $_POST['sectionId'] : ''; ?>");
       // $("#year").val("<?= isset($_POST['sessionId']) ? $_POST['sessionId'] : ''; ?>");
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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
<script>
        $('.delete').on('click',function(e){
        e.preventDefault();
        var href = $(this).attr('data-href');

Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )
    window.location.href = './' + href
  }
})
});
</script>
<script>
<?php
if(isset($_SESSION['import_file'])){
    echo "var json_result = ".$_SESSION['import_file'].";\r\n";
?>
    Swal.fire({
        title: json_result.msg,
        icon: json_result.status,
        button:'Ok'
    });
<?php
   unset($_SESSION['import_file']);
}
?>
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- END OF SCRIPT-->

</body>
</html>
