
<?php
//added 
include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);


$section_id = '';
$additional_info = [];
if(isset($_GET['viewId'])){

    //check if teacher has access to faculty load
    $additional_info = faculty_load_info($_GET['viewId'],$_SESSION['Id']);
    //[success] => Array ( [id] => 8 [teacherId] => 7 [sectionId] => 24 [subjectId] => 27 [sessionId] => 1 [dateCreated] => 2022 [section] => 4- Makulit [subject] => English )

}else{
    echo "PAGE NOT FOUND!";
    exit();
}

if(!isset($additional_info['success'])){
    echo "SECTION PAGE NOT FOUND!";
    exit();
}

$additional_info = $additional_info['success'];



$grade_data = array();
$grade_data[1] = 0;
$grade_data[2] = 0;
$grade_data[3] = 0;
$grade_data[4] = 0;

$student_data = array();
$sql = "SELECT * FROM tblpromoted as p  LEFT JOIN (SELECT Id, firstName, lastName FROM tblstudent) as s ON p.studentId = s.Id WHERE p.sectionId = '".mysqli_real_escape_string($con,$additional_info['sectionId'])."' AND p.sessionId = '".$_SESSION['global_session']."'";
if($result = mysqli_query($con, $sql)){
    $num = mysqli_num_rows($result);
    if($num > 0){
        while($data = mysqli_fetch_assoc($result)){
            $student_data[]= $data;
       } 
    }
}

$grade_data = array();
$grade_data[1] = 0;
$grade_data[2] = 0;
$grade_data[3] = 0;
$grade_data[4] = 0;
$query =mysqli_query ($con, "SELECT * FROM tblquartergrade as q  LEFT JOIN (SELECT Id,studentId FROM tblpromoted) as p ON q.student_id = p.studentId LEFT JOIN (SELECT Id,firstName, lastName FROM tblstudent) as s ON p.studentId = s.Id WHERE q.teachingId = '".$viewId."'");
    if($query){
        while($row = mysqli_fetch_array($query)){
                $period = $row['period'];
                $grade_data[$period] =$row['grade'];

                if(empty($row['grade'])){};
        }
    }

   
//added ended
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include '../includes/title.php';?>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link  rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../style.css">

</head>

<body>
<?php $page="listofstudents"; include 'includes/Custom_menu.php';?>

    
    <div class="main-content">
        
    <?php include 'includes/header.php';?>
    
    <main>

    
        <div class="card-head">
            <div class="page-title">
                <h2>Subject Handled</h2>
            </div>
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">List of Grades</a></li>
                        <li class="breadcrumb-item"><?php echo $additional_info['section'];?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $additional_info['subject'];?></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="content">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title"><h2 align="center">List of Grades in <?php echo $additional_info['subject'];?></h2></strong>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>FullName</th>
                                    <th>1st Grading</th>
                                    <th>2nd Grading</th>
                                    <th>3rd Grading</th>
                                    <th>4th Grading</th>
                                    <th>Final Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    
                                            $grade_data = array();
                                        $query =mysqli_query ($con, "SELECT * FROM tblquartergrade as q  LEFT JOIN (SELECT Id,studentId FROM tblpromoted) as p ON q.student_id = p.studentId LEFT JOIN (SELECT Id,firstName, lastName FROM tblstudent) as s ON p.studentId = s.Id WHERE q.teachingId = '".$_GET['viewId']."'");
                                        while ($row=mysqli_fetch_array($query)) {
                                            $period = $row['period'];
                                            $student_id = $row['student_id'];
                                            if(!isset($grade_data[$student_id])){
                                                $grade_data[$student_id] =[];
                                                $grade_data[$student_id]['name'] = $row['lastName'].', '.$row['firstName'];
                                            }
                                            
                                            $grade_data[$student_id][$period] = $row['grade'];



                                        }
                                    
                                    foreach($grade_data as $row){
                                    $final_grade = 0;
                                    $final_grade = ($row[1] + $row[2] + $row[3] + $row[4])/4;
                                ?> 
                                <tr>
                                    <td> <?php  echo $row['name'];?></td>
                                    <td ><?php  echo $row[1];?></td>
                                    <td ><?php  echo $row[2];?></td>
                                    <td ><?php  echo $row[3];?></td>
                                    <td ><?php  echo $row[4];?></td>
                                    <td id = "finalgrade"><?php echo $final_grade;?></td>
                                </tr>
                                <?php
                                    $cnt=$cnt+1;
                                         } //added end
                                
                                //ended
                                ?>                                            
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
