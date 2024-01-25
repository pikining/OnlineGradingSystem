
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
                    <div class="card">
                        <div class="card-body">
                            <h3 align="center"><b>Grade Level</b></h3>
                        </div>
                    </div>
            <div class="content">
                <div class="level">
                        <div class="grade">
                            <div >
                                <h3><b>Grade 1</b></h3>
                                <span><a href="performance.php?period=1&grade=<?php echo base64_encode(1);?>">View Section</a></span>
                            </div><!-- /.card-left -->
                            <div>
                                <span class=" las la-users"></span>
                            </div><!-- /.card-right -->
                        </div>

                        <div class="grade ">
                            <div>
                                <h3><b>Grade 2</b></h3>
                                <span><a href="performance.php?period=1&grade=<?php echo base64_encode(2);?>">View Section</a></span>
                            </div><!-- /.card-left -->
                            <div>
                                <span class=" las la-users"></span>
                            </div><!-- /.card-right -->
                        </div>

                        <div class="grade ">
                            <div>
                                <h3><b>Grade 3</b></h3>
                                <span><a href="performance.php?period=1&grade=<?php echo base64_encode(3);?>">View Section</a></span>
                            </div><!-- /.card-left -->
                            <div>
                                <span class=" las la-users"></span>
                            </div><!-- /.card-right -->
                        </div>

                        <div class="grade ">
                            <div>
                                <h3><b>Grade 4</b></h3>
                                <span><a href="performance.php?period=1&grade=<?php echo base64_encode(4);?>">View Section</a></span>
                            </div><!-- /.card-left -->
                            <div>
                                <span class=" las la-users"></span>
                            </div><!-- /.card-right -->
                        </div>

                        <div class="grade ">
                            <div>
                                <h3><b>Grade 5</b></h3>
                                <span><a href="performance.php?period=1&grade=<?php echo base64_encode(5);?>">View Section</a></span>
                            </div><!-- /.card-left -->
                            <div>
                                <span class=" las la-users"></span>
                            </div><!-- /.card-right -->
                        </div>

                        <div class="grade ">
                            <div>
                                <h3><b>Grade 6</b></h3>
                                <span><a href="performance.php?period=1&grade=<?php echo base64_encode(6);?>">View Section</a></span>
                            </div><!-- /.card-left -->
                            <div>
                                <span class=" las la-users"></span>
                            </div><!-- /.card-right -->
                        </div>
                </div>
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