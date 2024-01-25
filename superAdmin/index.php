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

$countAllStudent = 0;
    $countAllStudent1 = 0;
    $session_id = array('','');
    
    
    $query = mysqli_query($con, "SELECT * FROM `tblsession` WHERE Id <= '".$activesession."'  ORDER BY Id DESC LIMIT 2");
   // echo "SELECT * FROM `tblsession` WHERE Id <= '".$activesession."'  ORDER BY Id DESC LIMIT 2";
    //echo "SELECT * FROM `tblsession` ORDER BY  isActive DESC, Id ASC LIMIT 2";
    if($query){
        $count = mysqli_num_rows($query);
        if($count > 0){
            $count = 0;
            while($row = mysqli_fetch_assoc($query)){
    
                $session_id[$count] = $row['Id'];
                $count++;
            }
    
        }
    }
    
    //get previous
    $query = mysqli_query($con, "SELECT COUNT(studentId) as count FROM `tblpromoted` WHERE sessionId = '".$session_id[1]."'");
   // echo "SELECT COUNT(studentId) as count FROM `tblpromoted` WHERE sessionId = '".$session_id[1]."'";
    if($query){
        $count = mysqli_num_rows($query);
        if($count > 0){
            $count = 0;
            if($row = mysqli_fetch_assoc($query)){
                $countAllStudent = $row['count'];
            }
    
        }
    }
    
    
    //get previous
    $query = mysqli_query($con, "SELECT COUNT(studentId) as count FROM `tblpromoted` WHERE sessionId = '".$session_id[0]."'");
   // echo "SELECT COUNT(studentId) as count FROM `tblpromoted` WHERE sessionId = '".$session_id[0]."'";
    if($query){
        $count = mysqli_num_rows($query);
        if($count > 0){
            $count = 0;
            if($row = mysqli_fetch_assoc($query)){
                $countAllStudent1 = $row['count'];
            }
    
        }
    }
    
    // ADDED
//     $default_subject =[];
//     $below_data = [];
//     $fairly_data = [];
//     $satisfactory_data = [];
//     $very_data = [];
//     $outstanding_data = [];
   
// $que = "SELECT sessionId,SUM(CASE WHEN levelId == 1 THEN 1 ELSE 0 END) AS g1, SUM(CASE WHEN levelId == 2 THEN 1 ELSE 0 END) AS g2, SUM(CASE WHEN levelId == 3 THEN 1 ELSE 0 END) AS g3, SUM(CASE WHEN levelId ==4 THEN 1 ELSE 0 END) AS g4, SUM(CASE WHEN levelId ==5 THEN 1 ELSE 0 END) AS g5, SUM(CASE WHEN levelId ==6 THEN 1 ELSE 0 END) AS g6 FROM tblpromoted WHERE sessionId = '$activesession'";

// $query = mysqli_query($con, $que);
// if($query){
//     while($row = mysqli_fetch_assoc($query)){
//             // $tid = $row['teachingId'];
//             // if(isset($teaching_data[$tid])){
//             //     $sid = $teaching_data[$tid];

//                 $default_subject[] = $row['g1'];
//                 $default_subject[] = $row['g2'];
//                 $default_subject[] = $row['g3'];
//                 $default_subject[] = $row['g4'];
//                 $default_subject[] = $row['g5'];
//                  $default_subject[] = $row['g6'];
//             //}
//     }
// }

// $graph_data = json_encode($default_subject);



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
    

<?php $page="dashboard"; include 'includes/leftMenu.php';?>

    
    <div class="main-content">
        
    <?php include 'includes/header.php';?>
        <main>
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1><?php echo $countAllStudent;?></h1>
                        <span>Previous Enrolled Students</span>
                    </div>
                    <div>
                        <span class=" las la-users"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <h1><?php echo $countAllStudent1;?></h1>
                        <span>Current Enrolled Students</span>
                    </div>
                    <div>
                        <span class=" las la-users"></span>
                    </div>
                </div>
            </div>
                      <br><br><br>             
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h3 align="center">
                            <marquee direction="left">Current School Year: <?php 
                                $result = mysqli_query($con, 'SELECT (sessionName) AS sessname FROM tblsession WHERE isActive = 1'); 
                                $row = mysqli_fetch_assoc($result); 
                                $sum = $row['sessname'];
                                 echo $sum;
                            ?></marquee>
                        </h3>
                    </div>
                </div>
            </div>
  <!--          <div class="" >
                        <canvas id="myChart" style="width:100%;min-height:400px;"></canvas>
                        </div>
            
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'],
      datasets: [{
        label: 'Grades',
        data: <?php echo $graph_data; ?>,
        borderWidth: 1
      }]
    },
    opt
  });
</script>-->
        </main>
    <!-- FOOTER-->
        <?php include 'includes/footer.php';?>
    <!-- END OF FOOTER-->
    </div>
<!-- END OF BODY-->



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

