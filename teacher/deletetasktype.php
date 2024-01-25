<?php
 include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);

$delid = $_GET['deltasktypeid'];
$viewId = $_GET['viewId'];
$query = mysqli_query($con,"DELETE FROM tbltask_type WHERE Id='$delid'");


if ($query === TRUE) {

        echo "<script type = \"text/javascript\">
        window.location = (\"addtasktype.php?viewId=$viewId\")
        </script>";  
}
else{


}

?>

