
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');
$period = isset($_GET['period']) ? trim($_GET['period']) : 1;
$_GET['grade_orig'] =  isset($_GET['grade']) ? $_GET['grade'] : '';
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

$additional_info = [];

$grading = array("","1st Grading","2nd Grading", "3rd Grading", "4th Grading");
if(isset($grading[$period])){
    $additional_info['grading'] = $grading[$period];
}else{
    echo "Invalid Period!";
    exit();
}

    $default_subject =[];
    $fail_data = [];
    $pass_data = [];
    $que = "SELECT Id,subjectTitle, levelId FROM tblsubject WHERE levelId = '".$_GET['grade']."'";
    $query = mysqli_query($con, $que);
    if($query){
        while($row = mysqli_fetch_assoc($query)){
                $id = $row['Id'];
                $temp['title'] = $row['subjectTitle'];
                $temp['pass'] = 0;
                $temp['fail'] = 0;
                $default_subject[$id] = $temp;
        }
    }

    //code for subject per teaching
    $teaching = [];
    $label_subject =[];
    $teaching_data =[];
    $que = "SELECT f.id,f.sectionId, f.subjectId,f.sessionId,s.subjectTitle, s.levelId FROM tblfacultyload as f LEFT JOIN (SELECT Id,subjectTitle, levelId FROM tblsubject) as s ON f.subjectId = s.Id WHERE s.levelId = '".$_GET['grade']."' AND f.sessionId = '".$activesession."'";

    $query = mysqli_query($con, $que);
    if($query){
        while($row = mysqli_fetch_assoc($query)){
                $id = $row['id'];
                $teaching[] = $row['id'];
                $teaching_data[$id] = $row['subjectId'];
        }
    }

    //code for grade
    $grades = [];
   
    $que = "SELECT teachingId,SUM(CASE WHEN grade >= 75 THEN 1 ELSE 0 END) AS passed, SUM(CASE WHEN grade >= 75 THEN 0 ELSE 1 END) AS failed  FROM tblquartergrade WHERE teachingId IN (".implode(',', $teaching).") AND period ='".$period."' GROUP BY teachingId";
    
    $query = mysqli_query($con, $que);
    if($query){
        while($row = mysqli_fetch_assoc($query)){
                $tid = $row['teachingId'];
                if(isset($teaching_data[$tid])){
                    $sid = $teaching_data[$tid];

                    $default_subject[$sid]['pass'] = $row['passed'];
                    $default_subject[$sid]['fail'] = $row['failed'];
                }
        }
    }

$pass_data =[];
$fail_data =[];
$label_subj = [];

foreach($default_subject as $row){
    $pass_data[] = $row['pass'];
    $fail_data[] = $row['fail'];
    $label_subj[] = $row['title'];
}


$pass_data = json_encode($pass_data);
$fail_data =json_encode($fail_data);
$label_subj = json_encode($label_subj);

$viewId = isset($_GET['viewId']) ? $_GET['viewId'] :'';

$graph_data = array();
$graph_data[1] = 0;
$graph_data[2] = 0;
$graph_data[3] = 0;
$graph_data[4] = 0;


    //code get quarter 
   $query =mysqli_query ($con, "SELECT * FROM tblquartergrade as q LEFT JOIN (SELECT Id, studentId,levelId FROM tblpromoted) as p ON q.student_id = p.studentId LEFT JOIN (SELECT id,subjectId FROM tblfacultyload) as f ON q.teachingId = f.id LEFT JOIN (SELECT Id,subjectTitle FROM tblsubject) as s ON f.subjectId = s.Id WHERE p.levelId = '".$_GET['grade']."'");
    if($query){
        while($row = mysqli_fetch_array($query)){
                $subject = $row ['subjectTitle'];
                $period = $row['period'];
                $graph_data[$period] =$row['grade'];
        }
    }



$graph_data = json_encode(array_values($graph_data));




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
    <?php $page="performance"; include 'includes/period_menu.php';?>

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
                                <li class="breadcrumb-item">Student Performance</li>
                                <li class="breadcrumb-item active" aria-current="page">Grade <?php echo $_GET['grade']; ?></li>
                          </ol>
                        </nav>
                </div>
            </div>

    <div class="content">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center"> Performance of Grade <?php echo $_GET['grade']; ?></h2></strong>
                        </div>
                        <div class="card-body">
                        
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
      labels: <?php echo $label_subj; ?>,
      datasets: [{
        label: 'Passed',
        data: <?php echo $pass_data; ?>,
        borderWidth: 1
      },{
        label: 'Failed',
        data: <?php echo $fail_data; ?>,
        borderWidth: 1
      }
    ]
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
