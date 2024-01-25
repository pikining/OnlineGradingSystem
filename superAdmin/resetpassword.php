
<?php

include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);

if(isset($_POST['submit'])){

 $alertStyle ="";
  $statusMsg="";

$userId=$_POST['userId'];
$staffpass=$_POST['staffpass'];

$phone_no ="";
$query =mysqli_query($con,"SELECT a.Id,a.userId,s.guardiannum,s.Id FROM tbladmin as a LEFT JOIN (SELECT Id,guardiannum FROM tblstudent) as s ON a.userId = s.Id WHERE a.Id='$_POST[userId]'");
if($row = mysqli_fetch_assoc($query)){
    if($row){
        //$add_info = student_load_section($row['sectionId'],$_SESSION['global_session']);
        $phone_no = $row['guardiannum'];
    }
}
$query=mysqli_query($con,"UPDATE tbladmin SET staffpass='$staffpass' WHERE Id='$_POST[userId]'");

    if($query){
        $alertStyle ="alert alert-success";
        $statusMsg="Password Successfully Reset!";
       
    }
    else {

        $alertStyle ="alert alert-danger";
        $statusMsg="An Error Occurred!";
    }
}



//$authKey = "YOUR_AUTH_KEY";

// Also add muliple mobile numbers, separated by comma
//$phoneNumber = $phone_no;

// route4 sender id should be 6 characters long.
//$senderId = "YOUR_SENDER_ID";

// Your message to send
//$message = urlencode($_POST['staffpass']);

// POST parameters
//$fields = array(
  //  "sender_id" => $senderId,
    //"message" => $message,
    //"language" => "english",
    //"route" => "p",
    //"numbers" => $phoneNumber,
//);

//$curl = curl_init();

//curl_setopt_array($curl, array(
  //CURLOPT_URL => "YOUR_GATEWAY_URL",
  //CURLOPT_RETURNTRANSFER => true,
  //CURLOPT_ENCODING => "",
  //CURLOPT_MAXREDIRS => 10,
  //CURLOPT_TIMEOUT => 30,
  //CURLOPT_SSL_VERIFYHOST => 0,
  //CURLOPT_SSL_VERIFYPEER => 0,
  //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  //CURLOPT_CUSTOMREQUEST => "POST",
  //CURLOPT_POSTFIELDS => json_encode($fields),
  //CURLOPT_HTTPHEADER => array(
    //"authorization: ".$authKey,
    //"accept: */*",
    //"cache-control: no-cache",
    //"content-type: application/json"
  //),
//));

//$response = curl_exec($curl);
//$err = curl_error($curl);

//curl_close($curl);

//if ($err) {
  //echo "cURL Error #:" . $err;
//} else {
 // echo $response;
//}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.css" integrity="sha512-pZE3NzBgokXUM9YLBGQIw99omcxiRdkMhZkz0o7g0VjC0tCFlBUqbcLKUuX8+jfsZgiZNIWFiLuZpLxXoxi53w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <!-- Left Panel -->
    <?php $page="password"; include 'includes/leftMenu.php';?>

   <!-- /#left-panel -->

<div class="main-content">


        <!-- Header-->
            <?php include 'includes/header.php';?>
        <!-- /header -->
        <main>

            
            <div class="content">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Reset User Password</h2></strong>
                        </div>
                        <div class="card-body">
                            <!-- Credit Card -->
                                <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>
                                    <form method="Post" action="">
                                    <div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="x_card_code" class="control-label mb-1">User Name</label>
                                                    <?php 
                                                        echo ' <select id="user_sel" name="userId" class="form-select">';
                                                        $query=mysqli_query($con,"SELECT * FROM tbladmin");                                        
                                                        $count = mysqli_num_rows($query);
                                    
                                                        if($count > 0){       
                                                            $found = false;
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                    if( $row['adminTypeId'] == 1) { continue; }
                                                                $select = ($user_id == $row['Id']) ? "selected" : '';
                                                                $found = ($user_id == $row['Id']) ? true : $found ;
                                                                echo'<option value="'.$row['Id'].'"  '.$select.'>'.$row['fullName'].' </option>';
                                                            }
                                                        }
                                                        $select = (!$found) ? "selected" : '';
                                                        echo'<option value="" '.$select.'>Select User</option>';
                                                        echo '</select>';

                                                        
                                                    ?>   
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1">New Password</label>
                                                    <input id="" name="staffpass" type="text" class="form-control cc-exp" value="" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="">
                                                </div>
                                            </div>
                                        </div> 
                                        
                                        <button type="submit" name="submit" class="btn">Reset Password</button>
                                    </div>
                                    </form>
                                </div>
                    </div> <!-- .card -->
                </div><!--/.col-->
           

            
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
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    ></script>
    <script>
       // Menu Trigger
       $("#user_sel").selectize({});
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
