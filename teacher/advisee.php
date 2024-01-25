
<?php
//added 
include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);

if(isset($_GET['viewId'])){
    $_SESSION['viewId'] = $_GET['viewId'];
    $query = "SELECT * FROM tblsection WHERE Id = '".$_SESSION['viewId']."' ";
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
    <?php $page="grade_list"; include 'includes/Advisee_menu.php';?>

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
                                <li class="breadcrumb-item">Advisory Class</a></li>
                                <li class="breadcrumb-item">List of Students</li>
                                <?php //added
                                    $sql_query = "SELECT a.sectionId,a.teacherId,s.Id,s.sectionName,a.sessionId FROM tbladviser as a LEFT JOIN (SELECT Id,sectionName FROM tblsection) as s ON a.sectionId = s.Id WHERE a.teacherId ='".$_SESSION['Id']."'AND a.sectionId = '".$_SESSION['viewId']."'AND a.sessionId = '".$_SESSION['global_session']."'";
                                    $query=mysqli_query($con,$sql_query);
                                    while ($row=mysqli_fetch_array($query)) {
                                ?>    
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $row['sectionName'];?></li>
                          </ol>
                        </nav>
                </div>
            </div>

        <div class="content">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">All Student of Section <?php echo $row['sectionName']; ?>
                            <?php 
                                }//added end
                            ?></h2></strong>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                            <table  class="table table-bordered table-hover table-striped ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>FullName</th>
                                        <th>LRN</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $ret=mysqli_query($con,"SELECT p.studentId,p.sectionId,p.sessionId,s.Id,s.firstName,s.lastName,s.middleName,s.LRN,s.dateCreated FROM tblpromoted as p  LEFT JOIN (SELECT Id,firstName,lastName,middleName,LRN,dateCreated FROM tblstudent) as s ON p.studentId = s.Id WHERE p.sectionId = '".$_GET['viewId']."' AND p.sessionId = '".$_SESSION['global_session']."' ORDER BY s.lastName ASC");
                                    $cnt=1;
                                    while ($row=mysqli_fetch_array($ret)) {
                                                        ?>
                                <tr>
                                <td><?php echo $cnt;?></td>
                                <td ><?php  echo $row['lastName'];?>, <?php  echo $row['firstName'];?></td>
                                <td ><?php  echo $row['LRN'];?></td>
                                <td ><a href="../teacher/card.php?viewId=<?php echo $_GET['viewId']?>&cardid=<?php echo $row['studentId'];?>&aId=<?php echo $_GET['aId']?>" title="View Student Card"><i class="las la-info-circle"></i><i><u>Grade Report</u></i></a></td>
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
