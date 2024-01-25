<?php

    include('../includes/dbconnection.php');

    $fid = intval($_GET['fid']);//gradeId

        $queryss=mysqli_query($con,"select * from tblsection where levelId=".$fid." ORDER BY sectionName ASC");                        
        $countt = mysqli_num_rows($queryss);

        if($countt > 0){                       
        echo '<label for="select" class=" form-control-label">Section</label>
        <select required name="sectionId" onchange="showLecturer(this.value)" class="custom-select form-control">';
        echo'<option value="">--Select Section--</option>';
        while ($row = mysqli_fetch_array($queryss)) {
        echo'<option value="'.$row['Id'].'" >'.$row['sectionName'].'</option>';
        }
        echo '</select>';
        }

?>

