<?php
 include('../includes/dbconnection.php');
include('../includes/session.php');

$delid = $_GET['delid'];

$query = mysqli_query($con,"DELETE FROM tblstudent WHERE LRN='$delid'");
$query = mysqli_query($con,"DELETE FROM tbladmin WHERE staffId='$delid'");

$query=mysqli_query($con,"SELECT p.Id,p.studentId,p.levelId,p.sectionId,p.sessionId,p.dateCreated,s.Id,s.LRN FROM tblpromoted as p LEFT JOIN (SELECT Id,LRN FROM tblstudent) as s ON p.studentId = s.Id WHERE s.LRN='$delid'");
    $ret=mysqli_fetch_array($query);
echo "SELECT p.Id,p.studentId,p.levelId,p.sectionId,p.sessionId,p.dateCreated,s.Id,s.LRN FROM tblpromoted as p LEFT JOIN (SELECT Id,LRN FROM tblstudent) as s ON p.studentId = s.Id WHERE s.LRN='$delid'";
    if($ret == true){ //Check the LRN
        $query = mysqli_query($con,"DELETE * FROM tblpromoted ");

    }

if ($query == TRUE) {

        echo "<script type = \"text/javascript\">
        window.location = (\"viewStudent.php\")
        </script>";  
}
else{

echo "<script type = \"text/javascript\">
        window.location = (\"createStudent.php\")
        </script>";  

}



?>

