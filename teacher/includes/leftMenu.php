
<?php
$query = mysqli_query($con,"SELECT * FROM tbladmin WHERE staffId='".$_SESSION['staffId']."'");
$row = mysqli_fetch_array($query);
$fullName = $row['fullName'];

?>

<input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="logo-details">
                <img src="../assets/img/logo.png" width="50px" height="50px">
                <span class="logo_name"> GRADING SYSTEM </span>
        </div>

            <ul class="nav-links">
                <li>
                    <a href="../teacher/index.php" class="<?php if($page=='dashboard'){ echo 'active'; }?>">
                        <i class="las la-home"></i>
                        <span class="link_name">Dashboard</span>
                    </a>
                </li>
            <!--    <li class="<?php if($page=='studentrank'){ echo 'active'; }?>">
                    <div class="icon-link">
                        <a href="#" >
                            <i class="las la-star"></i>
                            <span class="link_name">Student Ranking</span>
                        </a>    
                        <i class="las la-angle-down arrow"></i>
                    </div>
                        <ul class="sub-menu">
                            <?php //added
                                $sql_query = "SELECT *, fl.id as fload_id FROM tblfacultyload as fl LEFT JOIN (SELECT Id,sectionName FROM tblsection) as sec ON fl.sectionId = sec.Id LEFT JOIN (SELECT Id,subjectTitle FROM tblsubject) as sub ON fl.subjectId = sub.Id LEFT JOIN (SELECT Id,fid FROM tblfaculty) as f ON fl.teacherId = f.Id WHERE fl.teacherId ='".$_SESSION['Id']."'AND fl.sessionId = '".$_SESSION['global_session']."'";
                                $query=mysqli_query($con,$sql_query);
                                while ($row=mysqli_fetch_array($query)) {
                            ?>     
                            <li> <a href="<?php echo BASE_URL; ?>teacher/studentrank.php?period=1&viewId=<?php echo $row['fload_id']; ?> " style="color: #187bcd;" class="lar la-chart-bar"> <?php echo $row['sectionName'];?> (<?php echo $row['subjectTitle'];?>)</a></li>
                            <?php 
                                }//added end
                            ?>
                        </ul>
                </li>-->
            <!--    <li class="<?php if($page=='performance'){ echo 'active'; }?>">
                    <div class="icon-link">
                        <a href="#" >
                            <i class="lar la-chart-bar"></i>
                            <span class="link_name">Proficiency Level</span>
                        </a>
                            <i class="las la-angle-down arrow"></i>
                    </div>
                        <ul class="sub-menu">
                            <?php //added 
                                $sql_query = "SELECT *, fl.id as fload_id FROM tblfacultyload as fl LEFT JOIN (SELECT Id,sectionName FROM tblsection) as sec ON fl.sectionId = sec.Id LEFT JOIN (SELECT Id,subjectTitle FROM tblsubject) as sub ON fl.subjectId = sub.Id LEFT JOIN (SELECT Id,fid FROM tblfaculty) as f ON fl.teacherId = f.Id WHERE fl.teacherId ='".$_SESSION['Id']."'AND fl.sessionId = '".$_SESSION['global_session']."'";
                                $query=mysqli_query($con,$sql_query);
                                while ($row=mysqli_fetch_array($query)) {
                            ?>     
                            <li> <a href="<?php echo BASE_URL; ?>teacher/performance.php?viewId=<?php echo $row['fload_id']; ?> "  class="las la-chart-bar"> <?php echo $row['sectionName'];?> (<?php echo $row['subjectTitle'];?>)</a></li>
                            <?php 
                                }//added end
                            ?>
                        </ul>
                </li>-->
                <li>
                    <a  href="#" data-bs-toggle="modal" data-bs-target="#setFiscalYear" class="<?php if($page=='year'){ echo 'active'; }?>">
                        <i class="las la-book"></i>
                        <span class="link_name">Set School Year</span>
                    </a>
                </li>


            </ul>
    </div>


<div class="modal fade" id="setFiscalYear" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Set School Year</h5>
      </div>
      <div class="modal-body">
      <form class="fiscal-form" action="../setsession.php" id="fiscal-form" method="POST" >
        
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                        <label for="x_card_code" class="control-label mb-1">School Year</label>
                    <?php 
                    $query=mysqli_query($con,"select * from tblsession ORDER BY id ASC");                        
                    $count = mysqli_num_rows($query);
                    if($count > 0){                       
                        echo ' <select required name="set_session" id="set_session" class="form-select">';
                        echo'<option value="">Select School Year</option>';
                        while ($row = mysqli_fetch_array($query)) {
                        echo'<option value="'.$row['Id'].'" >'.$row['sessionName'].'</option>';
                            }
                                echo '</select>';
                            }
                ?>   
                </div>
            </div>
        </div>
        <div>
                        
        </div>
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="send" id="send">Set</button>
      </div>
     </form>
    </div>
  </div>
</div>
        

    <script>
    
    var fiscal = $('#fiscal-popup')
    var button = $('#set_fy_btn')
        $(document).ready(function () {
        $("#fiscal-form").on("submit", function () {
            e.preventDefault();

        var valid = true;
        
        var fiscal = $("#set_session").val();

        if (fiscal == "") {
            $("#set_session").html("required.");
            $("#set_session").addClass("input-error");
            return;
        }
        return valid;
    });
});

    </script>