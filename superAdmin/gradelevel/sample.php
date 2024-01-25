 <?php   include('../../includes/dbconnection.php');?>

<table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                           
                                    <tbody>
                                      
                            <?php
        $ret=mysqli_query($con,"SELECT tblsection.Id, tblsection.sectionName, tbllevel.levelName
        from tblsection
        INNER JOIN tbllevel ON tbllevel.Id = tblsection.levelId");

        while ($row=mysqli_fetch_array($ret)) {
                            ?>
               

              <?php echo $row['sectionName'];?>
             <?php echo $row['levelName'];?>
 
               
                <?php 

                }?>
                                                                                
                                    </tbody>
                                </table>

                                <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-flat-color-5">
                            <div class="card-body">
                                <div>
                                <?php $query=mysqli_query($con,"SELECT tblfaculty.fid, tblfaculty.lname, tblfaculty.fname, tblfaculty.mname, tblsection.sectionName from tblfaculty INNER JOIN tblsection on tblsection.Id = tblfaculty.section where tblfaculty.levelId='1'");
                                    while ($row=mysqli_fetch_array($query)) {
             
               ?>                       
                                    <p class="text-light mt-1 m-0"><h2><?php echo $row['sectionName'];?></h2><h5>Adviser: <u><?php echo ucwords($row['lname'].', '.$row['fname']);?></u></h5><h5>Faculty ID: <u><?php echo strtoupper($row['fid']);?></u></h5></p><?php 

                }?>
                                </div><!-- /.card-left -->

                            

                            </div>

                        </div>
                    </div>