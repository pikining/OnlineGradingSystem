<?php 

require_once '../includes/dbconnection.php';

	if(isset($_POST['levelId'])) {
		$levelId = $_POST['levelId'];
		$query = mysqli_query($con,"SELECT * FROM tblsection WHERE levelId = '".$levelId."'");
                     
			$count = mysqli_num_rows($query);
			if($count > 0){                       
				echo ' <select  name="sectionId" class="form-select">';
				echo'<option value="" >Select Section</option>';
				while ($row = mysqli_fetch_array($query)) {
					echo'<option value="'.$row['Id'].'" >'.$row['sectionName'].'</option>';
				}
				echo '</select>';
			}

	}


 ?>