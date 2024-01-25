<?php
 include('../includes/dbconnection.php');
include('../includes/session.php');

$delid = $_GET['delloadid'];

$query = mysqli_query($con,"DELETE FROM tblfacultyload WHERE id='$delid'");

if ($query == TRUE) {

        echo "<script type = \"text/javascript\">
        window.location = (\"facultyload.php\")
        </script>";  
}

else{
    echo "<script type = \"text/javascript\">
        window.location = (\"facultyload.php\")
        </script>";  
}
?>

