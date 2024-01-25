
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');

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
    <!-- Content --><div class="card">
                        <div class="card-body">
                            <h3 align="center"><b>Grade Level</b></h3>
                        </div>
                    </div>

            <div class="content">
                <div class="level">
                        <div class="grade">
                            <div >
                                <h3><b>Grade 1</b></h3>
                                <span><a href="listcard.php?grade=<?php echo base64_encode(1);?>">View Section</a></span>
                            </div><!-- /.card-left -->
                            <div>
                                <span class=" las la-users"></span>
                            </div><!-- /.card-right -->
                        </div>

                        <div class="grade ">
                            <div>
                                <h3><b>Grade 2</b></h3>
                                <span><a href="listcard.php?grade=<?php echo base64_encode(2);?>">View Section</a></span>
                            </div><!-- /.card-left -->
                            <div>
                                <span class=" las la-users"></span>
                            </div><!-- /.card-right -->
                        </div>

                        <div class="grade ">
                            <div>
                                <h3><b>Grade 3</b></h3>
                                <span><a href="listcard.php?grade=<?php echo base64_encode(3);?>">View Section</a></span>
                            </div><!-- /.card-left -->
                            <div>
                                <span class=" las la-users"></span>
                            </div><!-- /.card-right -->
                        </div>

                        <div class="grade ">
                            <div>
                                <h3><b>Grade 4</b></h3>
                                <span><a href="listcard.php?grade=<?php echo base64_encode(4);?>">View Section</a></span>
                            </div><!-- /.card-left -->
                            <div>
                                <span class=" las la-users"></span>
                            </div><!-- /.card-right -->
                        </div>

                        <div class="grade ">
                            <div>
                                <h3><b>Grade 5</b></h3>
                                <span><a href="listcard.php?grade=<?php echo base64_encode(5);?>">View Section</a></span>
                            </div><!-- /.card-left -->
                            <div>
                                <span class=" las la-users"></span>
                            </div><!-- /.card-right -->
                        </div>

                        <div class="grade ">
                            <div>
                                <h3><b>Grade 6</b></h3>
                                <span><a href="listcard.php?grade=<?php echo base64_encode(6);?>">View Section</a></span>
                            </div><!-- /.card-left -->
                            <div>
                                <span class=" las la-users"></span>
                            </div><!-- /.card-right -->
                        </div>
                </div>
            </div>
    <div class="clearfix"></div>
    </main>
    <!-- Footer -->
  <?php include 'includes/footer.php';?>
    <!-- /.site-footer -->
</div>
<!-- /#right-panel -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<!-- <script src="../assets/js/main.js"></script> -->
<script src="../assets/js/main.js"></script>

<!--  Chart js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.bundle.min.js"></script>

<!--Chartist Chart-->
<script src="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartist-plugin-legend@0.6.2/chartist-plugin-legend.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery.flot@0.8.3/jquery.flot.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flot-pie@1.0.0/src/jquery.flot.pie.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flot-spline@0.0.1/js/jquery.flot.spline.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/simpleweather@3.1.0/jquery.simpleWeather.min.js"></script>
<script src="../assets/js/init/weather-init.js"></script>

<script src="https://cdn.jsdelivr.net/npm/moment@2.22.2/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
<script src="../assets/js/init/fullcalendar-init.js"></script>

<!--Local Stuff-->
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
</body>

</html>