        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>
                <span>Dashboard</span>
            </h2>

            <div class="user-wrapper">
                <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../img/student.png" width="40px" height="40px" alt="">
                    <div class="user-name">
                        <h4><?php echo $fullName?></h4>
                        <small>
                            <?php
                                $query = mysqli_query($con,"SELECT * FROM tbladmin as a LEFT JOIN (SELECT Id, UserType FROM tbladmintype) as adt ON a.adminTypeId = adt.Id WHERE staffId='".$_SESSION['staffId']."'");
                                while ($row=mysqli_fetch_array($query)) { 
                            ?>
                            <?php echo $row['UserType'];?>
                            <?php }?>
                        </small>
                    </div>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="../student/changePassword.php"><i class="las la-user-circle "></i> My Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../student/logout.php"><i class="las la-sign-out-alt"></i>Logout</a></li>
                </ul>
            </div>
        </header>


        