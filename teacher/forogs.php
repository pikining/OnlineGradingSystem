<?php 
session_start();
$connect = mysqli_connect("localhost", "root", "", "resultgrading");

if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_Id");
		if(!in_array($_GET["Id"], $item_array_id))
		{
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'item_id'			=>	$_GET["Id"],
				'item_stname'		=>	$_POST["hidden_stname"],
				'item_lrn'			=>	$_POST["hidden_lrn"],
				'item_levelname'	=>	$_POST["hidden_levelname"],
				'item_fcname'		=>	$_POST["hidden_fcname"],
				'item_sesname'		=>	$_POST["hidden_sesname"],
				'item_datecre'		=>	$_POST["hidden_datecre"]
		
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
		}
		else
		{
			echo '<script>alert("Item Already Added")</script>';
		}
	}
	else
	{
		$item_array = array(
			'item_id'				=>	$_GET["Id"],
				'item_stname'		=>	$_POST["hidden_stname"],
				'item_lrn'			=>	$_POST["hidden_lrn"],
				'item_levelname'	=>	$_POST["hidden_levelname"],
				'item_fcname'		=>	$_POST["hidden_fcname"],
				'item_sesname'		=>	$_POST["hidden_sesname"],
				'item_datecre'		=>	$_POST["hidden_datecre"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}

if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["item_Id"] == $_GET["Id"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Item Removed")</script>';
				echo '<script>window.location="forogs.php"</script>';
			}
		}
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Webslesson Demo | Simple PHP Mysql Shopping Cart</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<br />
			<br />
		
			<br /><br />
			
			<div class="col-md-4">
				<form method="post" action="forogs.php?action=add&Id=<?php echo $row["Id"]; ?>">
					<table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                    <thead>
                                       <tr>
                                            <th>#</th>
                                            <th>FullName</th>
                                            <th>LRN</th>
                                            <th>Level</th>
                                            <th>Faculty</th>
                                            <th>Session</th>
                                            <th>Date Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                    $ret=mysqli_query($connect,"SELECT tblstudent.Id, tblstudent.firstName, tblstudent.lastName, tblstudent.middleName,tblstudent.LRN,
                    tblstudent.dateCreated, tbllevel.levelName,tblfaculty.lname,tblsession.sessionName,tblfaculty.fname,tblfaculty.mname
                    from tblstudent
                    INNER JOIN tbllevel ON tbllevel.Id = tblstudent.levelId
                    INNER JOIN tblsession ON tblsession.Id = tblstudent.sessionId
                    INNER JOIN tblfaculty ON tblfaculty.Id = tblstudent.facultyId");
                    $cnt=1;
                    while ($row=mysqli_fetch_array($ret)) {
                                        ?>
                    
                <tr>
                    <td><?php echo $cnt;?></td>
                    <td name="hidden_stname"><?php echo $row['firstName'].' '.$row['lastName'].' '.$row['middleName'];?></td>
                    <td name="hidden_lrn"><?php echo $row['LRN'];?></td>
                    <td name="hidden_levelname"><?php echo $row['levelName'];?></td>
                    <td name="hidden_fcname"><?php echo $row['lname'].' '.$row['fname'].' '.$row['mname'];?></td>
                    <td name="hidden_sesname"><?php echo $row['sessionName'];?></td>
                    <td name="hidden_datecre"><?php echo $row['dateCreated'];?></td>
                	<td><input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Section" /></td>
                </tr>
                               <?php 
                $cnt=$cnt+1;
                }?>                                        
                                    </tbody>
                                </table>
				</form>
			</div>
			
                         
			<div style="clear:both"></div>
			<br />
			<h3>Section Details</h3>
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
                                   
                                            <th>FullName</th>
                                            <th>LRN</th>
                                            <th>Level</th>
                                            <th>Faculty</th>
                                            <th>Session</th>
                                            <th>Date Created</th>
                                            <th>Actions</th>
                                        </tr>
					<?php
					if(!empty($_SESSION["shopping_cart"]))
					{
						$total = 0;
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
					?>
					<tr>
						<td><?php echo $values["item_stname"]; ?></td>
						<td><?php echo $values["item_lrn"]; ?></td>
						<td>$ <?php echo $values["item_levelname"]; ?></td>
						.<td><?php echo $values["item_fcname"]; ?></td>
						<td><?php echo $values["item_sesname"]; ?></td>
						<td>$ <?php echo $values["item_datecre"]; ?></td>
						<td><a href="forogs.php?action=delete&Id=<?php echo $values["item_Id"]; ?>"><span class="text-danger">Remove</span></a></td>
					</tr>
					<?php
							$total = $total + ($values["item_quantity"] * $values["item_price"]);
						}
					?>
					<tr>
						<td colspan="8" align="center"><input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Section" /></td>
						
					</tr>
					<?php
					}
					?>
						
				</table>
			</div>
		</div>
	</div>
	<br />
	</body>
</html>

<?php
//If you have use Older PHP Version, Please Uncomment this function for removing error 

/*function array_column($array, $column_name)
{
	$output = array();
	foreach($array as $keys => $values)
	{
		$output[] = $values[$column_name];
	}
	return $output;
}*/
?>