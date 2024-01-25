<?php
 include('../includes/dbconnection.php');
include('../includes/session.php');


$aId = isset($_GET['aId']) ? trim($_GET['aId']) : '';
$viewId = isset($_GET['viewId']) ? trim($_GET['viewId']) : '';
$delid = $_GET['delid'];
$query = mysqli_query($con,"DELETE FROM tblpromoted WHERE Id='$delid'");



if ($query == TRUE) {

        echo "<script type = \"text/javascript\">
        window.location = (\"promote.php?viewId=$viewId&aId=$aId\")
        </script>";  
}
else{


}
?>

