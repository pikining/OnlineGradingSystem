<?php 
	require 'DbConnect.php';

	if(isset($_POST['aid'])) {
		$db = new DbConnect;
		$conn = $db->connect();
		$tblsubject = array();
		if(empty($_POST['aid'])){
			echo json_encode($tblsubject);
			exit();
		}
		$sql_query = "SELECT sub.Id,sec.levelId,sub.subjectTitle FROM tblsection as sec INNER JOIN (SELECT Id,levelId,subjectTitle FROM tblsubject) as sub ON sec.levelId = sub.levelId WHERE sec.Id = '".$_POST['aid']."'";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$tblsubject = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($tblsubject);
		

	}

	function loadlevel2() {
		$db = new DbConnect;
		$conn = $db->connect();

		$stmt = $conn->prepare("SELECT * FROM tbllevel");
		$stmt->execute();
		$tbllevel = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $tbllevel;
	}
	
	
 ?>
 