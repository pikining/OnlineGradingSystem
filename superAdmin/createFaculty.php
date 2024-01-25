
<?php

    include('../includes/dbconnection.php');
    include('../includes/session.php');
error_reporting(0);

if(isset($_POST['submit'])){

  $alertStyle ="";
  $statusMsg="";

  $lname=$_POST['lname'];
  $fname=$_POST['fname'];
  $mname=$_POST['mname'];
  $fid=$_POST['fid'];
  $designation=$_POST['designation'];
  $dateCreated = date("Y-m-d H:i:s");


        $query=mysqli_query($con,"select * from tblfaculty where fid ='$fid'");
        $ret=mysqli_fetch_array($query);
        $query=mysqli_query($con,"select * from tbladmin where staffId ='$fid'");
        $ret=mysqli_fetch_array($query);
    
        $pw = strtoupper(substr($fname, 0, 1));
        $pw .= strtolower(substr($lname, 0, 1));
        $pw .= rand(10000, 99999);
        $pw .= "!";

        if($ret > 0){ //Check the LRN
          $alertStyle ="alert alert-danger";
          $statusMsg="Teacher already exist!";
        }
        else{
            $query = mysqli_query($con,"INSERT INTO tblfaculty (lname,fname,mname,fid,password,designation,dateCreated) VALUES ('$lname','$fname','$mname','$fid','$pw','$designation','$dateCreated')");
            if($query){
                $last_id = mysqli_insert_id($con);
                $alertStyle ="alert alert-success";
                $statusMsg="Teacher Added Successfully!";
            
            }
            else
            {
                 $alertStyle ="alert alert-danger";
                $statusMsg="An error Occurred!";
            }
            $query =mysqli_query($con,"INSERT INTO tbladmin (userId,fullName,staffid,staffpass,adminTypeId,dateCreated) 
            VALUES ('$last_id','$fname $lname','$fid','$pw','4','$dateCreated')") ;
            
            if($query) 
            {
                $alertStyle ="alert alert-success";
                $statusMsg="Teacher Added Successfully!";
            }
            else
            {
                 $alertStyle ="alert alert-danger";
                $statusMsg="An error Occurred!";
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
                                <li class="breadcrumb-item active" aria-current="page">Add New Faculty</li>
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
                                <strong class="card-title"><h2 align="center">Add New Faculty</h2></strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                       <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>
                                        <form method="Post" action="">
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Last Name:</label>
                                                        <input id="last" name="lname" type="tel" class="form-control cc-exp" value="" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">First Name:</label>
                                                        <input id="first" name="fname" type="tel" class="form-control cc-exp" value="" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Middle Name:</label>
                                                        <input id="middle" name="mname" type="tel" class="form-control cc-exp" value="" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Employee ID:</label>
                                                        <input id="" name="fid" type="tel" class="form-control cc-exp" value="" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="">
                                                    </div>
                                                </div>
                                                        <!-- TRY LANG
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Teacher Position:</label>
                                                        <input id="" name="designation" type="tel" class="form-control cc-exp" value="" placeholder="">
                                                    </div>
                                                </div>-->
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Teacher Position:</label>
                                                            <select  name="designation" id="designation" class="form-select">
                                                                <option value="">Select Position</option>
                                                                <option value="Instructor I">Instructor I</option>
                                                                <option value="Instructor II">Instructor II</option>
                                                                <option value="Instructor III">Instructor III</option>
                                                                <option value="Master Teacher I">Master Teacher I</option>
                                                                <option value="Master Teacher II">Master Teacher II</option>
                                                                <option value="Master Teacher III">Master Teacher III</option>
                                                                <option value="Special Education Teacher I">Special Education Teacher I</option>
                                                                <option value="Special Education Teacher II">Special Education Teacher II</option>
                                                                <option value="Special Education Teacher III">Special Education Teacher III</option>
                                                                <option value="Special Education Teacher III">Special Education Teacher III</option>
                                                                <option value="Teacher I">Teacher I</option>
                                                                <option value="Teacher II">Teacher II</option>
                                                                <option value="Teacher III">Teacher III</option>
                                                            </select>
                                                    </div>
                                                </div>
                                            </div>
                                                
                                            <!--<div class="row" >
                                            <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Grade Level</label>
                                                            <select Required name="levelId" id="facultyCategory" onchange="changeStatus()" class="custom-select form-control">
                                                                <option value="">Select Category</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                            </select>
                                                    </div>
                                                </div>
                                            <div class="col-4" id="MyCode1">
                                                    <div class="form-group">
                                                    <label for="x_card_code" class="control-label mb-1">Section</label>
                                                        <?php 
                                                        $query=mysqli_query($con,"select * from tblsection ORDER BY levelId ASC");                        
                                                        $count = mysqli_num_rows($query);
                                                        if($count > 0){                       
                                                            echo ' <select  name="section" class="custom-select form-control">';
                                                            echo'<option value="">Select Section</option>';
                                                            while ($row = mysqli_fetch_array($query)) {
                                                            echo'<option value="'.$row['Id'].'" >'.$row['sectionName'].'</option>';
                                                                }
                                                                    echo '</select>';
                                                                }
                                                        ?>   
                                                    </div>
                                                </div>
                                                <div class="col-4" id="MyCode">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Subject</label>
                                                        <input id="" name="subj[]" type="text" class="form-control cc-exp" value="" placeholder="">
                                                    </div>
                                                </div>
                                            </div>-->
                                            <div>
                                                <button type="submit" name="submit" class="btn ">Add Faculty</button>
                                            </div>

                                        </form>
                            </div>
                        </div> <!-- .card -->
               
                   <!--
                <br><br>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"><h2 align="center">All Faculty</h2></strong>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Faculty Name</th>
                                            <th>Faculty ID</th>
                                            <th>Designation</th>
                                            <th>Date Created</th>
                                            <th>Action</th>
                                                                                    
                                            </tr>
                                    </thead>
                                    <tbody>
                                      
                                        <?php
                                            $ret=mysqli_query($con,"SELECT tbladmin.Id, tbladmin.fullName ,tbladmin.staffId,tbladmin.dateCreated, tblfaculty.designation, tblfaculty.fid, tbladmin.adminTypeId
                                            FROM tbladmin 
                                            LEFT JOIN tblfaculty ON tblfaculty.fid = tbladmin.staffId
                                            WHERE adminTypeId ='4' ORDER BY fullName ASC");
                                            $cnt=1;
                                            while ($row=mysqli_fetch_array($ret)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td ><?php  echo $row['fullName'];?></td>
                                            <td ><?php  echo $row['staffId'];?></td>
                                            <td ><?php  echo $row['designation'];?></td>
                                            <td ><?php  echo $row['dateCreated'];?></td>
                                            <td ><a href="editFaculty.php?editid=<?php echo $row['staffId'];?>" title="Edit Faculty Details"><i class="las la-edit"></i></a>
                                                <a class="delete" data-href="deleteFaculty.php?delid=<?php echo $row['staffId'];?>" title="Delete Faculty Details"><i class="las la-trash-alt"></i></a></td>
                                            
                                        </tr>
                                        <?php 
                                            $cnt=$cnt+1;
                                            }
                                        ?>
                                              
                                                                                
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>-->
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
      <form class="bulk-form" action="../superAdmin/bulkfaculty.php" enctype="multipart/form-data"  id="bulk-form" method="POST" >
      <div class="modal-body">
        <div class="col-12">
            <label for="x_card_code" class="form-label">Import csv file :</label>
            <input class="form-control" type="file" id="csv" name="csv">
        </div><br>
        <div class="col-12">
            <div class="form-group">
                <a href="../New_Faculty.xlsx" target="_blank" download="template">DOWNLOAD TEMPLATE</a>
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
        $("#designation").selectize({});
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

<script
  src="https://code.jquery.com/jquery-3.6.3.slim.min.js"
  integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo="
  crossorigin="anonymous"></script>
  
<script>
     $(document).ready(function() {
      $('#first').on('input',function(){
         var expression= /[^a-zA-Z\s]/g;
          if($(this).val().match(expression)){
              $(this).val($(this).val().replace(expression,""));
          }
      })
     })
     $(document).ready(function() {
      $('#middle').on('input',function(){
          var expression= /[^a-zA-Z\s]/g;
          if($(this).val().match(expression)){
              $(this).val($(this).val().replace(expression,""));
          }
      })
     })
     $(document).ready(function() {
      $('#last').on('input',function(){
          var expression= /[^a-zA-Z\s]/g;
          if($(this).val().match(expression)){
              $(this).val($(this).val().replace(expression,""));
          }
      })
     })
     
     
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- END OF SCRIPT-->

</body>
</html>
