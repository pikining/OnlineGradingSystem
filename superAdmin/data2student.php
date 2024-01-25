<?php 
	require 'DbConnect.php';

	if(isset($_POST['aid'])) {
		$db = new DbConnect;
		$conn = $db->connect();

		$stmt = $conn->prepare("SELECT sectionName FROM tblsection WHERE levelId = " . $_POST['aid']);
		$stmt->execute();
		$tblsection = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($tblsection);
		

	}

	function loadlevel() {
		$db = new DbConnect; 
		$conn = $db->connect();

		$stmt = $conn->prepare("SELECT * FROM tbllevel");
		$stmt->execute();
		$tbllevel = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $tbllevel;
	}
	
	
 ?>
 