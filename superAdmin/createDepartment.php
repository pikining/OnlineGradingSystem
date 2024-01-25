
<?php
    include('../includes/dbconnection.php');
    include('../includes/session.php');
    error_reporting(0);

if(isset($_POST['submit'])){

     $alertStyle ="";
      $statusMsg="";

  $levelId=$_POST['levelId'];
  $sectionName=$_POST['sectionName'];
  $dateCreated = date("Y-m-d H:i:s");


    $query=mysqli_query($con,"SELECT * FROM tblsection WHERE sectionName = '$sectionName' ");
    $ret=mysqli_fetch_array($query);
    if($ret > 0){

      $alertStyle ="alert alert-danger";    
      $statusMsg="This Section already exist!";

    }
    else{

  $query=mysqli_query($con,"insert into tblsection(sectionName,levelId,dateCreated) value('$sectionName','$levelId','$dateCreated')");
 
    if ($query) {

      $alertStyle ="alert alert-success";
      $statusMsg="Section Added Successfully!";
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

</head>
<body>
    <!-- Left Panel -->
    <?php $page="section"; include 'includes/leftMenu.php';?>

   <!-- /#left-panel -->

<div class="main-content">


        <!-- Header-->
            <?php include 'includes/header.php';?>
        <!-- /header -->
        <main>
            <div class="card-head">
                <div class="page-title">
                    <h2>Dashboard</h2>
                </div>
                <div class="page-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item">Section</li>
                                <li class="breadcrumb-item active" aria-current="page">Add New Section</li>
                          </ol>
                        </nav>
                </div>
            </div> 

        <div class="content">
            <div class="bulk">
                <button type="button" data-bs-toggle="modal" data-bs-target="#bulk" name="submit" class="btn "><i class="las la-file-upload" ></i> Bulk Insert</button>
            </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
							
                                <strong class="card-title"><h2 align="center">Add New Section</h2></strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                       <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>
                                        <form method="Post" action="">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="x_card_code" class="control-label mb-1">Grade Level</label>
                                                            <?php 
                                                            $query=mysqli_query($con,"select * from tbllevel ORDER BY id ASC");                        
                                                            $count = mysqli_num_rows($query);
                                                            if($count > 0){                       
                                                                echo ' <select required name="levelId" class="form-select">';
                                                                echo'<option value="">Select Grade Level</option>';
                                                                while ($row = mysqli_fetch_array($query)) {
                                                                    if($row['levelName'] == 'Graduate') { continue; }
                                                                echo'<option value="'.$row['Id'].'" >'.$row['levelName'].'</option>';
                                                                    }
                                                                        echo '</select>';
                                                                    }
                                                            ?>        

                                                    </div>
                                                </div>
                                                    <div class="col-6">
                                                        <label for="x_card_code" class="control-label mb-1">Section</label>
                                                        <input id="sectionName" name="sectionName" type="tel" class="form-control cc-cvc" value="" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-cvc="Please enter a valid security code" placeholder="Section">
                                                    </div>
                                                    
                                                   <!-- <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="x_card_code" class="control-label mb-1">Adviser</label>
                                                            <?php 
                                                                $query=mysqli_query($con,"SELECT * FROM tbladmin WHERE adminTypeId ='4'");                        
                                                                $count = mysqli_num_rows($query);
                                                                if($count > 0){                       
                                                                    echo ' <select required name="facultyId" class="form-select">';
                                                                    echo'<option value="">Select Adviser</option>';
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
                                                            <label for="x_card_code" class="control-label mb-1">School Year</label>
                                                            <?php 
                                                                $query=mysqli_query($con,"select * from tblsession ORDER BY id ASC");                        
                                                                $count = mysqli_num_rows($query);
                                                                if($count > 0){                       
                                                                    echo ' <select required name="sessionId" class="form-select">';
                                                                    echo'<option value="">Select Session</option>';
                                                                    while ($row = mysqli_fetch_array($query)) {
                                                                    echo'<option value="'.$row['Id'].'" >'.$row['sessionName'].'</option>';
                                                                        }
                                                                            echo '</select>';
                                                                        }
                                                            ?>   
                                                        </div>
                                                    </div>-->
                                            </div>     
                                            <div>
                                                <button type="submit" name="submit" class="btn ">Add Section</button>
                                            </div>
                                        </form>
                                    </div>
                        </div> <!-- .card -->
                    </div><!--/.col-->
               

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
      <form class="bulk-form" action="../superAdmin/bulksection.php" enctype="multipart/form-data"  id="bulk-form" method="POST" >
      <div class="modal-body">
        <div class="col-12">
            <label for="x_card_code" class="form-label">Import csv file :</label>
            <input class="form-control" type="file" id="csv" name="csv">
        </div><br>
        <div class="col-12">
            <div class="form-group">
                <a href="../New_Section.xlsx" target="_blank" download="template">DOWNLOAD TEMPLATE</a>
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

    <script>


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
      $('#sectionName').on('input',function(){
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
