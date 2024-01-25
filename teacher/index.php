
<?php
//added
    include('../includes/dbconnection.php');
    include('../includes/session.php');


$Id = $_SESSION['Id'];
$query = mysqli_query($con, "SELECT * FROM `tblsession` ORDER BY  Id ASC");
if($query){
    $count = mysqli_num_rows($query);
    if($count > 0){
        $count = 0;
        while($row = mysqli_fetch_assoc($query)){

            if($row['Id'] == $_SESSION['global_session']){
                $session_id[0] = $row['Id'];
                $session_text = $row['sessionName']; 
                break;
            }
            $session_id[1] = $row['Id'];
        }

    }
}


$query = mysqli_query($con,"SELECT * FROM tbladmin WHERE staffId='".$_SESSION['staffId']."'");
        $row = mysqli_fetch_array($query)

        
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
            <div class="row">
                <!--added-->
                <div class="card">
                    <div class="card-body">
                        <h3 align="center"><b>Subject's Handled</b></h3>
                    </div>
                </div>


                    <?php 
                    //added
                    $sql_query = "SELECT *, fl.id as fload_id FROM tblfacultyload as fl LEFT JOIN (SELECT Id,sectionName FROM tblsection) as sec ON fl.sectionId = sec.Id LEFT JOIN (SELECT Id,subjectTitle FROM tblsubject) as sub ON fl.subjectId = sub.Id LEFT JOIN (SELECT Id,fid FROM tblfaculty) as f ON fl.teacherId = f.Id WHERE fl.teacherId ='".$_SESSION['Id']."' AND fl.sessionId = '".$_SESSION['global_session']."'";
                    
                    $query=mysqli_query($con,$sql_query);
                   
                        while ($row=mysqli_fetch_array($query)) {
                    ?>     

                <div class="col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="section-handled">       
                                <h2><?php echo $row['subjectTitle'];?></h2><h5>Section: <u><?php echo $row['sectionName'];?></u></h5><!-- Log on to codeastro.com for more projects! -->
                                <a href="listofstudents.php?viewId=<?php echo $row['fload_id'];?>" title="View Section Details"><i class="las la-info-circle"></i><i><u>View Section</u></i></a>
                            </div><!-- /.card-left -->
                        </div>

                    </div>
                </div>
                <?php 
                    }//added end
                ?>
                
                
                <!--added
                For Advisee-->
                <?php
                 $sql_query = "SELECT a.Id as aId,a.sectionId,a.teacherId,a.sessionId, s.Id, s.sectionName FROM tbladviser as a LEFT JOIN (SELECT Id,sectionName FROM tblsection) as s ON a.sectionId = s.Id WHERE a.teacherId ='".$_SESSION['Id']."' AND a.sessionId = '".$_SESSION['global_session']."'";
                 $query=mysqli_query($con,$sql_query);
                 while ($row=mysqli_fetch_array($query)) {
                        if ($row['teacherId']== $_SESSION['Id']) {
                ?>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 align="center"><b>Advisory Class</b></h3>
                        </div>  
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                <div class="advisee">
                    <div class="card ">
                        <div class="card-body">
                            
                                              
                                <p class="text-light mt-1 m-0"><h2><?php echo $row['sectionName'];?></h2></p><!-- Log on to codeastro.com for more projects! -->
                                <a href="advisee.php?viewId=<?php echo $row['Id'];?>&aId=<?php echo $row['aId'];?>" title="View Section Details"><i class="las la-info-circle"></i><i><u>View Section</u></i></a>
                            </div><!-- /.card-left -->
                        </div>

                    </div>
                </div>
                <?php 
                    }}//added end
                ?>
        </div>
           
                <!-- /Widgets -->
                <!--  Traffic  -->
                    <div class="row">
                        <div class="card">
                            <div class="year">
                            <div class="card-body">
                                <h3 align="center"><marquee direction="left">Current Session: <?php 
                                echo $session_text;
                                ?></marquee></h3>
                            </div>
                            </div>
                        </div>
                    </div>
            
        <!-- /.content -->
        <div class="clearfix"></div>
    </main>
    <!-- FOOTER-->
        <?php include 'includes/footer.php';?>
    <!-- END OF FOOTER-->
</div>
    <!-- /#right-panel -->


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