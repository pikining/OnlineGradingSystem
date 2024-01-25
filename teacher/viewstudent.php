
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(1);

$levelId ="";
$section_name ="";
if(isset($_GET['viewId'])){
    $_SESSION['viewId'] = $_GET['viewId'];
    $query =mysqli_query($con, "SELECT * FROM tblsection WHERE Id = '".$_SESSION['viewId']."' ");
    if($row = mysqli_fetch_assoc($query)){
        if($row){
            //$add_info = student_load_section($row['sectionId'],$_SESSION['global_session']);
            $section_name = $row['sectionName'];
            $levelId = $row['levelId'];
        }
    }
}

if(isset($_POST['submit'])){

 $alertStyle ="";
  $statusMsg="";

$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$middlename=$_POST['middlename'];
$age=$_POST['age'];
$gender=$_POST['gender'];
$lrn=$_POST['lrn'];
$levelId=$_POST['levelId'];
$section=$_POST['section'];
$facultyId=$_POST['facultyId'];
$sessionId=$_POST['sessionId'];
$father=$_POST['father'];
$fathernum=$_POST['fathernum'];
$mother=$_POST['mother'];
$mothernum=$_POST['mothernum'];
$guardian=$_POST['guardian'];
$guardiannum=$_POST['guardiannum'];
$dateCreated = date("Y-m-d ");

$query=mysqli_query($con,"select * from tblstudent where LRN ='$lrn'");
$ret=mysqli_fetch_array($query);
$query=mysqli_query($con,"select * from tbladmin where staffId ='$lrn'");
$ret=mysqli_fetch_array($query);

$pw = strtoupper(substr($firstname, 0, 1));
$pw .= strtolower(substr($lastname, 0, 1));
$pw .= rand(10000, 99999);
$pw .= "!";

$pw2 = strtoupper(substr($guardian, 0, 1));
$pw2 .= rand(10000, 99999);
$pw2 .= "!";


if($ret > 0){

  $alertStyle ="alert alert-danger";
  $statusMsg="Student with the LRN already exist!";

}
else{
$query=mysqli_query($con,"insert into  tbladmin (fullName,staffid,staffpass,adminTypeId,dateCreated) 
    VALUES ('$firstname $lastname','$lrn','$pw','5','$dateCreated')");
$query=mysqli_query($con,"insert into  tbladmin (fullName,staffid,staffpass,adminTypeId,dateCreated) 
    VALUES ('$guardian','$guardiannum','$pw2','6','$dateCreated')");
$query=mysqli_query($con,"insert into tblstudent(firstName,lastName,middleName,age,gender,LRN,password,levelId,sectionId,sessionId,father,fathernum,mother,mothernum,guardian,guardiannum,dateCreated) 
value('$firstname','$lastname','$middlename','$age','$gender','$lrn','$pw','$levelId','$section','$sessionId','$father','$fathernum','$mother','$mothernum','$guardian','$guardiannum','$dateCreated')");
if($query){
    $last_id = mysqli_insert_id($con);

}
//promote last_id as student id
$query=mysqli_query($con,"insert into  tblpromoted (studentId,levelId,sectionId,sessionId,dateCreated) 
VALUES ('$last_id','$levelId','$section','$sessionId','$dateCreated')");

//

if ($query) {

  $alertStyle ="alert alert-success";
  $statusMsg="Student Added Successfully!";
}
else
{
  $alertStyle ="alert alert-danger";
  $statusMsg="An error Occurred!";
}
}
}

// if(isset($_POST['form_submit'])){


// if(isset( $_FILES['csv'] )) :
//     $csv_file = $_FILES['csv']['tmp_name'];
//     if(is_file( $csv_file)) :
//         $counter = 0;
//       if(($handle = fopen($csv_file,"r")) !== FALSE) :
//          while (($csv_data = fgetcsv($handle, 1000, ",")) !== FALSE)  {
//             if($counter == 0){
//                 //skip headers
//                 counter++;
//                 continue;
//             }
//         print_r($csv_data);
       
//          $num = count($csv_data);
//           for ($c=0; $c < $num; $c++):
//             $colum[$c] = $csv_data[$c]; 
//           endfor;         
//           $inserted= mysqli_query($con,"INSERT INTO tblstudent (LRN,lastName,firstName,middleName,age,gender,levelId,sectionId,sessionId,father,fathernum,mother,mothernum,guardian,guardiannum,password)
//            VALUES('".$colum[0]."','".$colum[1]."','".$colum[2]."','".$colum[3]."','".$colum[4]."','".$colum[5]."','".$colum[6],."','$colum[7]','$colum[8]','$colum[9]','$colum[10]','$colum[11]','$colum[12]','$colum[13]','$colum[14]','$colum[15]')");

//            echo "INSERT INTO tblstudent (LRN,lastName,firstName,middleName,age,gender,levelId,sectionId,sessionId,father,fathernum,mother,mothernum,guardian,guardiannum,password)
//            VALUES('$colum[0]','$colum[1]','$colum[2]','$colum[3]','$colum[4]','$colum[5]','$colum[6]','$colum[7]','$colum[8]','$colum[9]','$colum[10]','$colum[11]','$colum[12]','$colum[13]','$colum[14]','$colum[15]')";
//            exit();
//          }


//          $msg = "Data uploaded successfully.";
//          fclose($handle);
//       else :
//         $msg = "unable to read the format try again";
//       endif;
//     else :
//       $msg = "CSV format File not found";
//     endif;
//   else :
//       $msg = "Please try again.";
//   endif;
//   echo $msg;
// }
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

<body>
    <!-- Left Panel -->
    <?php $page="newstudent"; include 'includes/Advisee_menu.php';?>

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
                                <li class="breadcrumb-item">Advisee</li>
                                <li class="breadcrumb-item">Student</li>
                                <li class="breadcrumb-item active" aria-current="page">View List of Student</li>
                            </ol>
                        </nav>
                </div>
            </div>
            <div class="content">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">All Student</h2></strong>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                            <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>FullName</th>
                                        <th>LRN</th>
                                        <!--<th>Date Created</th>-->
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                    <?php
                                        $ret=mysqli_query($con,"SELECT p.studentId,p.sectionId,p.sessionId,s.Id,s.firstName,s.lastName,s.middleName,s.LRN,s.dateCreated FROM tblpromoted as p  LEFT JOIN (SELECT Id,firstName,lastName,middleName,LRN,dateCreated FROM tblstudent) as s ON p.studentId = s.Id WHERE p.sectionId = '".$_GET['viewId']."' AND p.sessionId = '".$_SESSION['global_session']."' ORDER BY s.dateCreated DESC");
                                        $cnt=1;
                                        while ($row=mysqli_fetch_array($ret)) {
                                     ?>
                                    <tr>
                                        <td><?php echo $cnt;?></td>
                                        <td><?php echo $row['lastName'].', '.$row['firstName'].' '.$row['middleName'];?></td>
                                        <td><?php echo $row['LRN'];?></td>
                                        <!--<td><?php echo $row['dateCreated'];?></td>-->
                                        <td><a href="editStudent.php?editStudentId=<?php echo $row['studentId'];?>&viewId=<?php echo $_SESSION['viewId'];?>&aId=<?php echo $_GET['aId'];?>" title="Edit Details"><i class="las la-edit"></i></a>
                                        <a href="viewStudentinfo.php?editid=<?php echo $row['studentId'];?>&viewId=<?php echo $_SESSION['viewId'];?>&aId=<?php echo $_GET['aId'];?>" title="Edit Faculty Details"><i class="las la-info-circle"></i></a>
                                        <a class="delete" data-href="deleteStudent.php?delid=<?php echo $row['studentId'];?>&viewId=<?php echo $_SESSION['viewId'];?>&aId=<?php echo $_GET['aId'];?>" title="Delete Student Details"><i class="las la-trash-alt"></i></a></td>
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
      <form class="bulk-form" action="<?php echo "../teacher/import_file.php?viewId=".$_GET['viewId']; ?>" enctype="multipart/form-data"  id="bulk-form" method="POST" >
      <div class="modal-body">
     
            <div class="col-4">
                <div class="form-group">
                    <label for="x_card_code" class="control-label mb-1">Import csv file :</label>
                    <input type="file" name="csv" id="csv" class="input-large">
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

<script>
    
    var fiscal = $('#fiscal-popup')
    var button = $('#set_fy_btn')
        $(document).ready(function () {
        $("#bulk-form").on("submit", function () {
            console.log('dumaan');
            return;
            e.preventDefault();

            var valid = true;
            
            var fiscal = $("#set_session").val();

            if (fiscal == "") {
                $("#set_session").html("required.");
                $("#set_session").addClass("input-error");
                return;
            }
        return valid;
    });
});

    </script>

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
       // Menu Trigger
       $("#grade").selectize({});
       $("#year").selectize({});
       $("#gender").selectize({});
       $("#section_sel").selectize({});
        $('#menuToggle').on('click', function(event) {
        var windowWidth = $(window).width();   		 
        if (windowWidth<1010) { 
            $('body').removeClass('open'); 
            if (windowWidth<760){ 
            $('#left-panel').slideToggle(); 
            } else {
            $('#left-panel').toggleClass('open-menu');  
            } 
        } else {
            $('body').toggleClass('open');
            $('#left-panel').removeClass('open-menu');  
        } 
            
        }); 


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

    <?php

if(isset($_SESSION['import_file'])){
    echo "var json_result = ".$_SESSION['import_file'].";\r\n";
    echo "console.log(json_result);";
    echo "alert(json_resultBASE.msg);";
   // unset($_SESSION['import_file']);
}

?>
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- END OF SCRIPT-->

</body>
</html>
