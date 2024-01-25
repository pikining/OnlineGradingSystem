<?php
 include('../includes/dbconnection.php');
include('../includes/session.php');

$delid = $_GET['delid'];
$viewId = isset($_GET['viewId']) ? trim($_GET['viewId']) : '';
$query = mysqli_query($con,"DELETE FROM tblstudent WHERE Id='$delid'");
$query = mysqli_query($con,"DELETE FROM tbladmin WHERE userId='$delid'");
$query = mysqli_query($con,"DELETE FROM tblpromoted WHERE studentId='$delid'");



if ($query == TRUE) {

        echo "<script type = \"text/javascript\">
        window.location = (\"viewstudent.php?viewId=$viewId\")
        </script>";  
}
else{


}
?>

