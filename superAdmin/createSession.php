
<?php

    include('../includes/dbconnection.php');
    include('../includes/session.php');
error_reporting(0);

if(isset($_GET['status']) && $_GET['status'] == "success"){

      $alertStyle ="alert alert-success";
      $statusMsg="Session Set and Updated Successfully!";
}


if(isset($_POST['submit'])){

     $alertStyle ="";
      $statusMsg="";

  $sessionName=$_POST['sessionName'];
  $dateCreated = date("Y-m-d H:i:s");


    $query=mysqli_query($con,"select * from tblsession where sessionName ='$sessionName'");
    $ret=mysqli_fetch_array($query);
    if($ret > 0){

      $alertStyle ="alert alert-danger";
      $statusMsg="This Session already exist!";


    }
    else{

  $query=mysqli_query($con,"insert into tblsession(sessionName,isActive,dateCreated) value('$sessionName','0','$dateCreated')");

    if ($query) {

        
      $alertStyle ="alert alert-success";
      $statusMsg="Session Added Successfully!";


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
    <?php $page="session"; include 'includes/leftMenu.php';?>

   <!-- /#left-panel -->

<div class="main-content">


        <!-- Header-->
            <?php include 'includes/header.php';?>
        <!-- /header -->
        <main>
            <div class="card-head">
                <div class="page-title">
                    <h2>School Year</h2>
                </div>
            </div>

            <div class="content">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"><h2 align="center">Add New School Year </h2></strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>
                                <form method="Post" action="">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">School Year:</label>
                                                <input id="sessionName" name="sessionName" type="phone" maxlength="9" minlength="9" class="form-control cc-exp" value="" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-exp="Please enter a valid security code" placeholder="">
                                            </div>
                                        </div>
                                                
                                    </div>
                                    <div>
                                        <button type="submit" name="submit" class="btn ">Add School Year</button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- .card -->
               

                <br><br>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"><h2 align="center">All School Year</h2></strong>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table id="bootstrap-data-table" class="table table-bordered table-hover table-striped " width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>School Year</th>
                                            <th>Status</th>
                                            <th>Actions</th>                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                      
                                        <?php
                                            $ret=mysqli_query($con,"SELECT * FROM tblsession ORDER BY dateCreated DESC");
                                            $cnt=1;
                                            while ($row=mysqli_fetch_array($ret)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php  echo $row['sessionName'];?></td>
                                            <td><?php  if($row['isActive'] == 1){ echo "Active";}else{ echo "InActive";}?></td>
                                            <td><a href="activateSession.php?activateId=<?php echo $row['Id'];?>" onclick="change_color(this)" title="Activate Session"><i class="las la-check-square "></i></a>
                                                <a href="editSession.php?editid=<?php echo $row['Id'];?>" title="Edit Session Details"><i class="las la-edit"></i></a>
                                                <a class="delete" data-href="deleteSession.php?delid=<?php echo $row['Id'];?>" title="Delete Session"><i class="las la-trash-alt"></i></a></td>
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

</div>

<!-- END OF BODY-->

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
           // Menu Trigger
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script>
            function change_color(key){
                $(key).closest('tr').css({
                    'background-color': 'green',
                    'color': 'white',
                }).siblings('tr').css({
                    'background-color': 'white',
                    'color': 'black',
                })
            }
        </script>

    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
      } );

      
  </script>

<script src=../assets/plugins/bootstrap-sweetalert/sweetalert.min.js></script>
<script src="../_common/delete_swal.js"></script>
<!--<script
  src="https://code.jquery.com/jquery-3.6.3.slim.min.js"
  integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo="
  crossorigin="anonymous"></script>
  
  <script>
      $(document).ready(function() {
      $('#sessionName').on('input',function(){
         var expression= /[^0-9\-]/g;
          if($(this).val().match(expression)){
              $(this).val($(this).val().replace(expression,""));
          }
      })
     })
  </script>-->

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
