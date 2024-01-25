<?php    
  include('../includes/dbconnection.php');
  include('../includes/session.php');

  $cpassword=$_REQUEST['currentpassword'];
  $newpassword=$_REQUEST['newpassword'];

  $query=mysqli_query($con,"select * from tbladmin where staffId='$staffId' and staffpass='$cpassword'");
  $row=mysqli_fetch_array($query);
  if($row > 0){
  $ret=mysqli_query($con,"update tbladmin set staffpass='$newpassword' where staffId='$staffId'");

    echo json_encode('success');
    } else {

    echo json_encode('error');
  }


?>