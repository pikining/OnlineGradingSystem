<?php
//added
include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);


$section_id = '';
$additional_info = [];
$period = isset($_GET['period']) ? trim($_GET['period']) : '';

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



if(isset($_POST['submit'])){

 $alertStyle ="";
$statusMsg="";

$title= isset($_POST['title'])  ? trim($_POST['title']) : '';
$percent= isset($_POST['percent'])  ? trim($_POST['percent']) : '';

if(empty($title)){
    $alertStyle ="alert alert-danger";    
    $statusMsg="Title is required field";
}

if(empty($title)){
    $alertStyle ="alert alert-danger";    
    $statusMsg="Percent is required field";
}

$query=mysqli_query($con,"SELECT * from tbltask_type WHERE title ='".mysqli_real_escape_string($con,$title)."', percent='".mysqli_real_escape_string($con,$percent)."', teachingId='".$additional_info['id']."'");
$ret=mysqli_fetch_array($query);
if($ret > 0){

  $alertStyle ="alert alert-danger";    
  $statusMsg="This Task Type already exist!";

}
else{

$sql = "INSERT INTO tbltask_type (title,percent,teachingId) VALUES ('".mysqli_real_escape_string($con,$title)."','".mysqli_real_escape_string($con,$percent)."','".mysqli_real_escape_string($con,$additional_info['id'])."')";
$query=mysqli_query($con,$sql);

if ($query) {

  $alertStyle ="alert alert-success";
  $statusMsg="Task Type Added Successfully!";
}
else
{
  $alertStyle ="alert alert-danger";
  $statusMsg="An error Occurred!";
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
    <?php $page="tasktype"; include 'includes/Custom_menu.php';?>

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
                                <li class="breadcrumb-item"><a href="#">Task Type</a></li>
                                <li class="breadcrumb-item"><a href="#"><?php echo $additional_info['section'];?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $additional_info['subject'];?></li>
                          </ol>
                        </nav>
                </div>
            </div>

    <div class="content">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Add Task Type</h2></strong>
                        </div>
                        <div class="card-body">
                                <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>
                                <form method="Post" action="">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Title</label>
                                                    <input id="" name="title" type="text" class="form-control cc-exp" value="" Required data-val="true" data-val-required="Please enter title" data-val-cc-exp="Please enter title" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">Percent (1-100)</label>
                                                    <input id="" name="percent" type="text" class="form-control cc-exp" value="" Required data-val="true" data-val-required="Please enter percent" data-val-cc-exp="Please enter percent" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="submit" class="btn ">Add</button>                                        
                                </form>
                        </div>
                    </div>

                <br><br>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"><h2 align="center">Task Type</h2></strong>
                            </div>
                            <div class="card-body">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type Title</th>
                                            <th>Percentage</th>
                                            <th>Action</th>                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                        <?php
                                            $ret=mysqli_query($con,"SELECT * FROM tbltask_type  WHERE tbltask_type.teachingId ='".$_GET['viewId']."'");
                                            $cnt=1;
                                            while ($row=mysqli_fetch_array($ret)) {
                                        ?>
                                        <tr>
                                        <td><?php echo $cnt;?></td>
                                        <td><?php  echo $row['title'];?></td>
                                        <td><?php  echo $row['percent'];?></td>
                                        <td><a href="edittasktype.php?edittasktypeid=<?php echo $row['id'];?>&viewId=<?php echo $_GET['viewId']; ?>" title="Edit Task Type"><i class="las la-edit"></i></a>
                                        <a class="delete" data-href="deletetasktype.php?deltasktypeid=<?php echo $row['id'];?>&viewId=<?php echo $_GET['viewId']; ?>" title="Delete Task ype"><i class="las la-trash-alt"></i></a></td>
                                        </tr>
                                        <?php 
                                        $cnt=$cnt+1;
                                        }?>
                                                                                
                                    </tbody>
                                </table>
                            </div>
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
