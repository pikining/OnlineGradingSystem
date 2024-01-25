
<?php

    include('../includes/dbconnection.php');
    include('../includes/session.php');

    $additional_info = [];
    $period = isset($_GET['period']) ? trim($_GET['period']) : 1;
    if(isset($_GET['viewId'])){

        $_SESSION['viewId'] = $_GET['viewId'];
        $sql_query = "SELECT * FROM tblfacultyload WHERE id='".$_GET['viewId']."'";
        $query = mysqli_query($con,$sql_query);
       
    }

$grading = array("","1st Grading","2nd Grading", "3rd Grading", "4th Grading");
if(isset($grading[$period])){
    $additional_info['grading'] = $grading[$period];
}else{
    echo "Invalid Period!";
    exit();
}

$student_data = array();
$sql = "SELECT st.firstName,st.lastName,q.grade FROM tblstudent as st LEFT JOIN (SELECT studentId FROM tblpromoted) as p ON st.Id = p.studentId LEFT JOIN (SELECT student_id,period,grade,teachingId FROM tblquartergrade) as q ON st.Id = q.student_id WHERE q.teachingId = '".$_SESSION['viewId']."' AND q.period = '".$period."' ORDER BY q.grade DESC";

if($result = mysqli_query($con, $sql)){
    $num = mysqli_num_rows($result);
    if($num > 0){
        while($data = mysqli_fetch_assoc($result)){
            $student_data[]= $data;
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
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>style.css">

</head>
<body>
    <!-- Left Panel -->
    <?php $page="topstud"; include 'includes/Topstud_menu.php';?>

   <!-- /#left-panel -->

<div class="main-content">


        <!-- Header-->
            <?php include 'includes/header.php';?>
        <!-- /header -->
        <main>
            <div class="card-head">
                <div class="page-title">
                    <h2><?php echo $additional_info['grading']; ?></h2>
                </div>
                <div class="page-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Top Students</li>
                          </ol>
                        </nav>
                </div>
            </div>

        <div class="content">
                        <div class="card">
                            <div class="card-header">
                                <?php //added
                                    $sql_query = "SELECT * FROM tblfacultyload as f LEFT JOIN (SELECT Id,subjectTitle FROM tblsubject) as s ON f.subjectId = s.Id WHERE f.id='".$_GET['viewId']."'";
                                    $query=mysqli_query($con,$sql_query);
                                    while ($row=mysqli_fetch_array($query)) {
                                ?> 
                                <strong class="card-title"><h2 align="center">Top Student in <?php echo $row['subjectTitle']; ?></h2></strong>
                                <?php 
                                    }//added end
                                ?>            
                            </div>
                            <div class="table-responsive">
                                <table id="" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>TOP </th>
                                            <th>Name</th>
                                            <th>GRADE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                    <?php 
                                            //added 
                                        if(!empty($student_data)){
                                            $cnt = 1;
                                            foreach($student_data as $row){
                                    ?> 
                                        
                                    <tr>
                                        <td><?php echo $cnt;?></td>
                                        <td><?php echo $row['firstName'].' '.$row['lastName'];?></td>
                                        <td> <?php  echo $row['grade'];?></td>
                                    </tr>
                                    <?php 
                                    $cnt=$cnt+1;
                                    }}?>
                                                                                            
                                </tbody>
                            </table>
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
