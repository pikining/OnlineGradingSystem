
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');
$additional_info = [];
if(isset($_GET['viewId'])){

    //check if teacher has access to faculty load
    $additional_info = student_load_info($_GET['viewId'],$_SESSION['adminTypeId']);
    //[success] => Array ( [id] => 8 [teacherId] => 7 [sectionId] => 24 [subjectId] => 27 [sessionId] => 1 [dateCreated] => 2022 [section] => 4- Makulit [subject] => English )

}else{
    echo "PAGE NOT FOUND!";
    exit();
}

if(!isset($additional_info['success'])){
    echo "SECTION PAGE NOT FOUND!";
    exit();
}

$viewId = isset($_GET['viewId']) ? $_GET['viewId'] :'';

$graph_data = array();
$graph_data[1] = 0;
$graph_data[2] = 0;
$graph_data[3] = 0;
$graph_data[4] = 0;


    //code get quarter 
   /* $query =mysqli_query ($con, "SELECT * FROM tblquartergrade as q LEFT JOIN (SELECT Id,LRN FROM tblstudent) as s ON q.student_id = s.Id WHERE q.teachingId = '".$viewId."' AND s.LRN = '".$_SESSION['staffId']."'");
    if($query){
        while($row = mysqli_fetch_array($query)){
                $period = $row['period'];
                $graph_data[$period] =$row['grade'];
        }
    }*/

    $query =mysqli_query ($con, "SELECT * FROM tblgrading as g LEFT JOIN (SELECT Id,LRN FROM tblstudent) as s ON g.studentId = s.Id LEFT JOIN (SELECT Id, gradingperiod, teachingId FROM tbltask) as t ON g.taskId = t.Id WHERE t.teachingId = '".$viewId."' AND s.LRN = '".$_SESSION['staffId']."'");
    if($query){
        while($row = mysqli_fetch_array($query)){
                $period = $row['gradingperiod'];
                $graph_data[$period] =$row['score'];
        }
    }

$graph_data = json_encode(array_values($graph_data));

if(!isset($additional_info['success'])){
    echo "SECTION PAGE NOT FOUND!";
    exit();
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
    <?php $page="performance"; include 'includes/leftMenu.php';?>

   <!-- /#left-panel -->

<div class="main-content">


        <!-- Header-->
            <?php include 'includes/header.php';?>
        <!-- /header -->
        <main>
            <div class="card-head">
                <div class="page-title">
                    <h2></h2>
                </div>
                <div class="page-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Performance</li>
                          </ol>
                        </nav>
                </div>
            </div>

    <div class="content">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center"> Performance</h2></strong>
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
      labels: ['1st Grading', '2nd Grading', '3rd Grading', '4th Grading'],
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
          beginAtZero: true
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
