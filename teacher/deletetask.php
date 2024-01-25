<?php
 include('../includes/dbconnection.php');
include('../includes/session.php');
error_reporting(0);

$delid = $_GET['deltaskid'];
$viewId = $_GET['viewId'];
$query = mysqli_query($con,"DELETE FROM tbltask WHERE Id='$delid'");


if ($query === TRUE) {

        echo "<script type = \"text/javascript\">
        window.location = (\"addtask.php?viewId=$viewId\")
        </script>";  
}
else{


}

?>

