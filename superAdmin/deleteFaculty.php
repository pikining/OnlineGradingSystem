<?php
 include('../includes/dbconnection.php');
include('../includes/session.php');

$delid = $_GET['delid'];

$query = mysqli_query($con,"DELETE FROM tblfaculty WHERE Id='$delid'");
$query = mysqli_query($con,"DELETE FROM tbladmin WHERE userId='$delid'");

if ($query == TRUE) {

        echo "<script type = \"text/javascript\">
        window.location = (\"viewFaculty.php\")
        </script>";  
}

else{
    echo "<script type = \"text/javascript\">
        window.location = (\"createFaculty.php\")
        </script>";  
}
?>

