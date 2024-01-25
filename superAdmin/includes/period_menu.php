
<?php
//added 
$query = mysqli_query($con,"SELECT * FROM tbladmin WHERE staffId='".$_SESSION['staffId']."'");
$row = mysqli_fetch_array($query);
$fullName = $row['fullName'];

?>

<input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="logo-details">
                <img src="../assets/img/logo.png" width="40px" height="40px">
                <span class="logo_name"> GRADING SYSTEM </span>
        </div>

            <ul class="nav-links">
                <li>
                    <a href="../superAdmin/listoflevel.php" class="<?php if($page=='dashboard'){ echo 'active'; }?>">
                        <i class="las la-arrow-left"></i>
                        <span class="link_name">Back</span>
                    </a>
                </li>
                <li class="<?php if($page=='performance'){ echo 'active'; }?>">
                    <div class="icon-link">
                        <a href="#" >
                            <i class="las la-clipboard-list"></i>
                            <span class="link_name">Grading Period</span>
                        </a>    
                        <i class="las la-angle-down arrow"></i>
                    </div>
                        <ul class="sub-menu">
                            <li> <a href="../superAdmin/performance.php?period=1&grade=<?php echo $_GET['grade_orig']; ?>"  class="las la-calculator"> 1st Grading Period</a></li>
                            <li> <a href="../superAdmin/performance.php?period=2&grade=<?php echo $_GET['grade_orig']; ?>"  class="las la-calculator"> 2nd Grading Period</a></li>
                            <li> <a href="../superAdmin/performance.php?period=3&grade=<?php echo $_GET['grade_orig']; ?>"  class="las la-calculator"> 3rd Grading Period</a></li>
                            <li> <a href="../superAdmin/performance.php?period=4&grade=<?php echo $_GET['grade_orig']; ?>"  class="las la-calculator"> 4th Grading Period</a></li>
                        </ul>
                </li>
            </ul>
    </div>