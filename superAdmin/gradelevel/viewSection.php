
<?php

    include('../../includes/dbconnection.php');
    include('../../includes/session.php');
error_reporting(0);


if(isset($_GET['viewId'])){

$_SESSION['viewId'] = $_GET['viewId'];

$query = mysqli_query($con,"select * from tblstudent where sectionId='$_SESSION[viewId]'");
$rowi = mysqli_fetch_array($query);

}
 
else{

echo "<script type = \"text/javascript\">
    window.location = (\"grade1.php\")
    </script>"; 
}


  ?>

<!doctype html>
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include '../includes/title.php';?>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="../../assets/img/student-grade.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../../assets/css/lib/datatable/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/style2.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>

<body>
    <!-- Left Panel -->
    <?php $page="faculty"; include '..//includes/leftMenu.php';?>

   <!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
            <?php include '../includes/header.php';?>
        <!-- /header -->
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Dashboard</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Faculty</a></li>
                                    <li class="active">Edit Faculty</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"><h2 align="center">Edit Faculty</h2></strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>
                                        <form method="Post" action="">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Teachers ID:</label>
                                                        <input id="" name="facultyID" type="tel" class="form-control cc-exp" value="<?php echo $rowi['fid']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="Faculty Name" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Teachers Name:</label>
                                                        <input id="" name="lastName" type="tel" class="form-control cc-exp" value="<?php echo $rowi['lname']?>, <?php echo $rowi['fname']?> <?php echo $rowi['mname']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="Faculty Name" disabled>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Category:</label>
                                                            <select Required name="category" id="facultyCategory" onchange="changeStatus()" class="custom-select form-control" disabled>
                                                                <option value="<?php echo $rowi['category']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year"><?php echo $rowi['category']?></option>
                                                                <option value="generalist"> Generalist</option>
                                                                <option value="departmentalized">Departmentalized</option>
                                                            </select>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Teacher Designation</label>
                                                            <select Required name="level" id="facultyLevel" onchange="changeStatus()" class="custom-select form-control" disabled>
                                                                <option value="<?php echo $rowi['fdesignation']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="Faculty Name"><?php echo $rowi['fdesignation']?></option>
                                                                <option value="grade1">Grade 1</option>
                                                                <option value="grade2">Grade 2</option>
                                                                <option value="grade3">Grade 3</option>
                                                                <option value="grade4">Grade 4</option>
                                                                <option value="grade5">Grade 5</option>
                                                                <option value="grade6">Grade 6</option>
                                                            </select>
                                                    </div>
                                                </div>
                                                    </div>

                                                    <div class="row">
                                                        
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Faculty Password</label>
                                                        <input id="" name="facultyPass" type="tel" class="form-control cc-exp" value="<?php echo $rowi['fpass']?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="Faculty Name" disabled>
                                                    </div>
                                                </div>
                                                
                                                
                                           <div class="col-6" style="font-size: 20px;">
                                            <div class="form-group" id="MyCode">
                                                        <label for="cc-exp" class="control-label mb-1">List of Handled Subjects: </label><br>
                                                         <font color="red">
                                                            
                                                        <?php 

                                                        $mark = explode(",", $rowi['subj']);
                                                            foreach($mark as $out) {
                                                                echo $out."<br/>";
                                                            }
                                                            ?>
                                                        </font>
                                                        <br>
                                                    </div>
                                                </div>
                                               </div>
                                                    <div>
                                                        <a href="editFaculty.php?editid=<?php echo $row['Id'];?>" title="Edit Faculty Details"><i class="fa fa-edit fa-1x"></i></a>

                                                <button type="submit" name="submit" class="btn btn-primary">Edit Faculty</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- .card -->
                    </div><!--/.col-->
            

                <br><br>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"><h2 align="center">All Faculty</h2></strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Faculty Name</th>
                                            <th>Faculty ID</th>
                                            <th>Faculty Password</th>
                                            <th>Category</th>
                                            <th>Date Created</th>
                                            <th>Action</th>
                                                                                    
                                            </tr>
                                    </thead>
                                    <tbody>
                                      
                            <?php
        $ret=mysqli_query($con,"SELECT * from tblfaculty");
        $cnt=1;
        while ($row=mysqli_fetch_array($ret)) {
                            ?>
                <tr>
                <td width="3%"><?php echo $cnt;?></td>
                <td width="29%"><?php  echo $row['lname'];?>, <?php  echo $row['fname'];?> <?php  echo $row['mname'];?></td>
                <td width="20%"><?php  echo $row['fid'];?></td>
                <td width="20%"><?php  echo $row['fpass'];?></td>
                <td width="10%"><?php  echo $row['category'];?></td>
                <td width="13%"><?php  echo $row['dateCreated'];?></td>
                <td width="5%"><a href="editFaculty.php?editid=<?php echo $row['Id'];?>" title="Edit Faculty Details"><i class="fa fa-edit fa-1x"></i></a>
                    <a href="viewFacultyinfo.php?editid=<?php echo $row['Id'];?>" title="Edit Faculty Details"><i class="fa fa-info-circle fa-1x"></i></a>
                    <a onclick="return confirm('Are you sure you want to delete?')" href="deleteFaculty.php?delid=<?php echo $row['Id'];?>" title="Delete Faculty Details"><i class="fa fa-trash fa-1x"></i></a></td>
                </tr>
                <?php 
                $cnt=$cnt+1;
                }?>
                                              
                                                                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<!-- end of datatable -->

            </div>
        </div><!-- .animated -->
    </div><!-- .content -->

    <div class="clearfix"></div>

        <?php include 'includes/footer.php';?>


</div><!-- /#right-panel -->

<!-- Right Panel -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="../assets/js/main.js"></script>

<script src="../../assets/js/lib/data-table/datatables.min.js"></script>
    <script src="../../assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="../../assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="../../assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="../../assets/js/lib/data-table/jszip.min.js"></script>
    <script src="../../assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="../../assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="../../assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="../../assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="../../assets/js/init/datatables-init.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
      } );

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

</body>
</html>
