
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');
$_GET['grade'] =  isset($_GET['grade']) ? base64_decode($_GET['grade']) : '';

$activesession ="";
    $query=mysqli_query($con,"SELECT * FROM tblsession WHERE IsActive = 1");
    if($row = mysqli_fetch_assoc($query)){
    if($row){
        //$add_info = student_load_section($row['sectionId'],$_SESSION['global_session']);
        $activesession = $row['Id'];
    }
}
if(!is_numeric($_GET['grade'])){
    $_GET['grade'] ='0';
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
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h3 align="center"><b>Grade <?php echo $_GET['grade']; ?></b></h3>
                    </div>
                </div>
                
                <?php 
                    $sql_query = "SELECT a.sectionId,a.teacherId,a.sessionId,s.Id,ad.Id,s.sectionName,ad.staffId,ad.fullName FROM tbladviser as a LEFT JOIN (SELECT Id,sectionName,levelId FROM tblsection) as s ON a.sectionId = s.Id LEFT JOIN (SELECT Id,fullName,staffId FROM tbladmin) as ad ON a.teacherId = ad.Id WHERE a.sessionId = '".$activesession."' AND s.levelId='".$_GET['grade']."' ORDER by s.Id ASC";
                    $query=mysqli_query($con,$sql_query);
                
                        while ($row=mysqli_fetch_array($query)) {
                ?>     
                
                <div class="col-sm-6 col-lg-4">
                    <div class="card ">
                        <div class="card-body">
                            <div class="section-handled">     
                                <h2><?php echo $row['sectionName'];?></h2><h5>Adviser: <u><?php echo $row['fullName'];?></u></h5>
                                <a href="listofstudent.php?viewId=<?php echo $row['sectionId'];?>" title="View Section Details"><i class="las la-info-circle"></i><i><u>View Section</u></i></a>
                            </div><!-- /.card-left -->
                        </div>
                    </div>
                </div>
                <?php 
                    }
                ?>
                </div>

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