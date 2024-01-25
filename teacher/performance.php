
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);

function faculty_load($f_id){
    global $con;

    if(empty($f_id) ){
        return array('error'=>'Invalid Input!');
    }

//check if teacher has access to faculty load
    $section_id = '';
    $subject_id = '';
    $f_id = mysqli_real_escape_string($con, $f_id);
    $sql = "SELECT * FROM tblfacultyload  WHERE id = '".$f_id."'";
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            if($data = mysqli_fetch_assoc($result)){
                $additional_info = $data;
                $section_id = $data['sectionId'];
                $subject_id = $data['subjectId'];
            } 
        }
    }

    if(empty($section_id) OR empty($subject_id)){
        return array('error'=>'No Section Found!');
    }

    $sql = "SELECT Id,sectionName FROM tblsection  WHERE id = '".$section_id."' ";
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            if($data = mysqli_fetch_assoc($result)){
                $additional_info['section'] = $data['sectionName'];
            } 
        }
    }

    $sql = "SELECT Id,subjectTitle FROM tblsubject  WHERE id = '".$subject_id."' ";
    if($result = mysqli_query($con, $sql)){
        $num = mysqli_num_rows($result);
        if($num > 0){
            if($data = mysqli_fetch_assoc($result)){
                $additional_info['subject'] = $data['subjectTitle'];
            } 
        }
    }

    return array('success'=>$additional_info);
}

$section_id = '';
$additional_info = [];
$period = isset($_GET['period']) ? trim($_GET['period']) : '';
if(isset($_GET['viewId'])){

    //check if teacher has access to faculty load
    $additional_info = faculty_load($_GET['viewId']);
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

$grading = array("","1st Grading","2nd Grading", "3rd Grading", "4th Grading");
if(isset($grading[$period])){
    $additional_info['grading'] = $grading[$period];
}else{
    echo "Invalid Period!";
    exit();
}

$student_id = isset($_GET['studentId']) ? $_GET['studentId'] : '';
$submit = isset($_GET['submit'] ) ?  $_GET['submit'] : '';
$viewId = isset($_GET['viewId']) ? $_GET['viewId'] :'';

$default_subject =[];
    $below_data = [];
    $fairly_data = [];
    $satisfactory_data = [];
    $very_data = [];
    $outstanding_data = [];
    //$que = "SELECT Id,subjectTitle, levelId FROM tblsubject LEFT JOIN(SELECT id,subjectId FROM tblfacultyload) as f ON tblsubject.Id = f.subjectId WHERE f.id = '".$viewId."'";
    // $que = "SELECT id,subjectId,s.subjectTitle FROM tblfacultyload) as f LEFT JOIN (SELECT Id,subjectTitle, levelId FROM tblsubject) as s ON f.subjectId = s.Id WHERE f.id = '".$viewId."'";
    // $query = mysqli_query($con, $que);
    // if($query){
    //     while($row = mysqli_fetch_assoc($query)){
    //             $id = $row['id'];
    //             $temp['title'] = $row['subjectTitle'];
    //             $temp['below_75'] = 0;
    //             $temp['75_79'] = 0;
    //             $temp['80_85'] = 0;
    //             $temp['86_89'] = 0;
    //             $temp['90-100'] = 0;
    //             $default_subject[$id] = $temp;
    //     }
    // }
//code for subject per teaching
// $teaching = [];
// $teaching_data =[];
// $que = "SELECT f.id,f.sectionId, f.subjectId,f.sessionId, s.levelId FROM tblfacultyload as f LEFT JOIN (SELECT Id,subjectTitle FROM tblsubject) as s ON f.subjectId = s.Id WHERE f.id = '".$viewId."' AND f.sessionId = '".$_SESSION['global_session']."'";

// $query = mysqli_query($con, $que);
// if($query){
//     while($row = mysqli_fetch_assoc($query)){
//             $id = $row['id'];
//             $teaching[] = $row['id'];
//             $teaching_data[$id] = $row['subjectId'];
//     }
// }

//code for grade
$default_subject = [];
   
$que = "SELECT teachingId,SUM(CASE WHEN grade < 75 THEN 1 ELSE 0 END) AS below_75, SUM(CASE WHEN grade >= 75 AND grade <=79  THEN 1 ELSE 0 END) AS 75_79, SUM(CASE WHEN grade >= 80 AND grade <= 84 THEN 1 ELSE 0 END) AS 80_84, SUM(CASE WHEN grade >=85 AND grade <= 89 THEN 1 ELSE 0 END) AS 85_89, SUM(CASE WHEN grade >=90 AND grade <=100 THEN 1 ELSE 0 END) AS 90_100 FROM tblquartergrade WHERE teachingId='$viewId' AND period ='$period' GROUP BY teachingId";

$query = mysqli_query($con, $que);
if($query){
    while($row = mysqli_fetch_assoc($query)){
            // $tid = $row['teachingId'];
            // if(isset($teaching_data[$tid])){
            //     $sid = $teaching_data[$tid];

                $default_subject[] = $row['below_75'];
                $default_subject[] = $row['75_79'];
                $default_subject[] = $row['80_84'];
                $default_subject[] = $row['85_89'];
                $default_subject[] = $row['90_100'];
            //}
    }
}

$graph_data = json_encode($default_subject);







// $graph_data = array();
// $graph_data[1] = 0;
// $graph_data[2] = 0;
// $graph_data[3] = 0;
// $graph_data[4] = 0;

// if($submit == 'graph' AND (!empty($student_id)) AND (!empty($viewId))){

//     //code get quarter 
//     $query =mysqli_query ($con, "SELECT * FROM tblquartergrade as q WHERE q.teachingId = '".$viewId."' AND q.student_id = '".$student_id."'");
//     if($query){
//         while($row = mysqli_fetch_array($query)){
//                 $period = $row['period'];
//                 $graph_data[$period] =$row['grade'];
//         }
//     }

// // }

// $graph_data = json_encode(array_values($graph_data));






// $student_data = array();
// $sql = "SELECT * FROM tblpromoted  WHERE sectionId = '".mysqli_real_escape_string($con,$additional_info['sectionId'])."'";
// if($result = mysqli_query($con, $sql)){
//     $num = mysqli_num_rows($result);
//     if($num > 0){
//         while($data = mysqli_fetch_assoc($result)){
//             $student_data[]= $data; 
//        } 
//     }
// }



//added ended 
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
    <?php $page="performance"; include 'includes/proficiency_menu.php';?>

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
                                <li class="breadcrumb-item"><a href="#">Proficiency Level</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $additional_info['section'];?></li>
                          </ol>
                        </nav>
                </div>
            </div>

    <div class="content">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Proficiency Level of Section <?php echo $additional_info['section'];?> in <?php echo $additional_info['subject'];?> </h2></strong>
                        </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-4">
                            <form action="performance.php" method="GET">
                        </div>
                        
                        
                        </div>

                        <div class="" >
                        <canvas id="myChart" style="width:100%;min-height:400px;"></canvas>
                        </div>
                    </div>
            </div>
<!-- end of datatable -->


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Below 75', '75 - 79', '80 - 84', '85 - 89', '90 - 100'],
      datasets: [{
        label: 'Grades',
        data: <?php echo $graph_data; ?>,
        borderWidth: 1
      }]
    },
    options: {
      responsive:true,
      scales: {
        y: {
            grace:"1%",
          beginAtZero: true,
          ticks: {
            precision: 0
        }
        }
      }
    }
  });
</script>
 
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
