<?php
 include('../includes/dbconnection.php');
include('../includes/session.php');


$aId = isset($_GET['aId']) ? trim($_GET['aId']) : '';
$viewId = isset($_GET['viewId']) ? trim($_GET['viewId']) : '';
$cardid = isset($_GET['cardid']) ? trim($_GET['cardid']) : '';
$delid = $_GET['delid'];
$query = mysqli_query($con,"DELETE FROM tblattendance WHERE Id='".$delid."'");



if ($query == TRUE) {

        echo "<script type = \"text/javascript\">
        window.location = (\"card.php?viewId=$viewId&aId=$aId&cardid=$cardid\")
        </script>";  
}
else{

    echo "<script type = \"text/javascript\">
    window.location = (\"card.php?viewId=$viewId&aId=$aId&cardid=$cardid\")
    </script>";
}
?>
