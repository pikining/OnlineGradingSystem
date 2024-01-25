
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
                    <a href="../teacher/index.php" class="<?php if($page=='dashboard'){ echo 'active'; }?>">
                        <i class="las la-arrow-left"></i>
                        <span class="link_name">Back</span>
                    </a>
                </li>
             <li class="<?php if($page=='grade_book'){ echo 'active'; }?>">
                    <div class="icon-link">
                        <a href="#" >
                            <i class="las la-book"></i>
                            <span class="link_name">Grade Book</span>
                        </a>    
                        <i class="las la-angle-down arrow"></i>
                    </div>
                        <ul class="sub-menu">
                            <li> <a href="../teacher/grade_book.php?period=1&viewId=<?php echo $_GET['viewId']; ?>"  class="las la-book-open"> 1st Grading Period</a></li>
                            <li> <a href="../teacher/grade_book.php?period=2&viewId=<?php echo $_GET['viewId']; ?>"  class="las la-book-open"> 2nd Grading Period</a></li>
                            <li> <a href="../teacher/grade_book.php?period=3&viewId=<?php echo $_GET['viewId']; ?>"  class="las la-book-open"> 3rd Grading Period</a></li>
                            <li> <a href="../teacher/grade_book.php?period=4&viewId=<?php echo $_GET['viewId']; ?>"  class="las la-book-open"> 4th Grading Period</a></li>
                        </ul>
                </li>
                <li>
                    <a href="../teacher/listofstudents.php?viewId=<?php echo $_GET['viewId']; ?>" class="<?php if($page=='listofstudents'){ echo 'active'; }?>">
                        <i class="las la-clipboard-list"></i>
                        <span class="link_name">List of Grades</span>
                    </a>
                </li>      
            <!--    <li>
                    <a href="<?php echo BASE_URL; ?>teacher/addtask.php?viewId=<?php echo $_GET['viewId']; ?>" class="<?php if($page=='add_task'){ echo 'active'; }?>">
                        <i class="las la-plus"></i>
                        <span class="link_name">Add task</span>
                    </a>
                </li>    
                <li>
                    <a href="<?php echo BASE_URL; ?>teacher/addtasktype.php?viewId=<?php echo $_GET['viewId']; ?>" class="<?php if($page=='tasktype'){ echo 'active'; }?>">
                        <i class="las la-plus"></i>
                        <span class="link_name">Add Task Type</span>
                    </a>
                </li>-->
            </ul>
    </div>


  