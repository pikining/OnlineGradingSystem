
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');
$activesession ="";
    $query=mysqli_query($con,"SELECT * FROM tblsession WHERE IsActive = 1");
    if($row = mysqli_fetch_assoc($query)){
    if($row){
        //$add_info = student_load_section($row['sectionId'],$_SESSION['global_session']);
        $activesession = $row['Id'];
    }
}
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
    <?php $page="student"; include 'includes/leftMenu.php';?>

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
                                <li class="breadcrumb-item">Student Card</li>
                                <li class="breadcrumb-item">List of Students</li>
                                <?php //added
                                    $sql_query = "SELECT a.sectionId,a.teacherId,s.Id,s.sectionName,a.sessionId FROM tbladviser as a LEFT JOIN (SELECT Id,sectionName FROM tblsection) as s ON a.sectionId = s.Id WHERE  a.sectionId = '".$_SESSION['viewId']."'AND a.sessionId = '".$activesession."'";
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
                            <strong class="card-title"><h2 align="center">All Student (<?php echo $row['sectionName']; ?>)
                            <?php 
                                }//added end
                            ?></h2></strong>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                            <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
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
                                    $ret=mysqli_query($con,"SELECT tblstudent.firstName, tblstudent.lastName , tblstudent.LRN, tblstudent.Id,tblpromoted.sectionId,tblpromoted.studentId,tblpromoted.sessionId
                                    FROM tblpromoted 
                                    LEFT JOIN tblstudent ON tblstudent.Id= tblpromoted.studentId
                                    WHERE  tblpromoted.sectionId = '".$_SESSION['viewId']."' AND tblpromoted.sessionId = '".$activesession."' ORDER BY tblstudent.lastName");
                                     $cnt=1;
                                    while ($row=mysqli_fetch_array($ret)) {
                                                        ?>
                                <tr>
                                <td><?php echo $cnt;?></td>
                                <td ><?php  echo $row['lastName'];?>, <?php  echo $row['firstName'];?></td>
                                <td ><?php  echo $row['LRN'];?></td>
                                <td ><a href="../superAdmin/card.php?cardid=<?php echo $row['studentId'];?>&viewId=<?php echo $_GET['viewId']?>" title="View Student Card"><i class="las la-info-circle"></i><i><u>View Card</u></i></a></td>
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

</div><!-- .content -->

<div class="clearfix"></div>

</main>
<!-- FOOTER-->
    <?php include 'includes/footer.php';?>
<!-- END OF FOOTER-->

</div><!-- /#right-panel -->

<!-- Right Panel -->

<!-- SCRIPT-->



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