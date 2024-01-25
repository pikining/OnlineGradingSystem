
<?php

    include('../includes/dbconnection.php');
    include('../includes/session.php');

  ?>

<!doctype html>
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include '../includes/title.php';?>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="../assets/img/student-grade.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../assets/css/lib/datatable/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style2.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body>
    <!-- Left Panel -->
    <?php $page="department"; include 'includes/leftMenu.php';?>

   <!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
            <?php include 'includes/header.php';?>
        <!-- /header -->
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Dashboard</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Section</a></li>
                                    <li class="active">View Department</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            
            .container{overflow: hidden}
            .tab{float: left}
            .tab-btn{margin: 50px;}
            button{display:block;margin-bottom: 20px;}
            tr{transition:all .25s ease-in-out}
            tr:hover{background-color: #ddd;}
            
        </style>    
        <div class="content">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                          
                           
                        </div> <!-- .card -->
                    </div><!--/.col-->
               
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"><h2 align="center">Assign to Section</h2></strong>
                            </div>
                            <span style="float: left">
                            <div class="card-body">
                                
                                 <table id="table1" border="1" class="">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>FullName</th>
                                            <th>LRN</th>
                                            <th>Level</th>

                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                            <?php
                    $ret=mysqli_query($con,"SELECT tblstudent.Id, tblstudent.firstName, tblstudent.lastName, tblstudent.middleName,tblstudent.LRN,
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
                    <td><?php echo $row['firstName'].' '.$row['lastName'].' '.$row['middleName'];?></td>
                    <td><?php echo $row['LRN'];?></td>
                    <td><?php echo $row['levelName'];?></td>
                    <td><input type="checkbox" name="check-tab1"></td>
                    </tr>
                    <?php 
                    $cnt=$cnt+1;
                    }?>
                                                                                            
                                </tbody>
                            </table>
                   
            </div>
            </span>
            <span style="float: middle">
            <div class="tab tab-btn">
                <button onclick="tab1_To_tab2();">>>>>></button>
                <button onclick="tab2_To_tab1();"><<<<<</button>
            </div>
            </span>
            <span style="float: left">
            <div class="tab">
                <table id="table2" border="1">
                    <tr>
                        <th>#</th>
                                            <th>FullName</th>
                                            <th>LRN</th>
                                            <th>Level</th>
                                            <th>Actions</th
                    </tr>
                </table>   
            </div>
            </span>
            <script>
            
            function tab1_To_tab2()
            {
                var table1 = document.getElementById("table1"),
                    table2 = document.getElementById("table2"),
                    checkboxes = document.getElementsByName("check-tab1");
            console.log("Val1 = " + checkboxes.length);
                 for(var i = 0; i < checkboxes.length; i++)
                     if(checkboxes[i].checked)
                        {
                            // create new row and cells
                            var newRow = table2.insertRow(table2.length),
                                cell1 = newRow.insertCell(0),
                                cell2 = newRow.insertCell(1),
                                cell3 = newRow.insertCell(2),
                                cell4 = newRow.insertCell(3),
                                cell5 = newRow.insertCell(4);

                            // add values to the cells
                            cell1.innerHTML = table1.rows[i+1].cells[0].innerHTML;
                            cell2.innerHTML = table1.rows[i+1].cells[1].innerHTML;
                            cell3.innerHTML = table1.rows[i+1].cells[2].innerHTML;
                            cell4.innerHTML = table1.rows[i+1].cells[3].innerHTML;
                            cell5.innerHTML = "<input type='checkbox' name='check-tab2'>";
                           
                            // remove the transfered rows from the first table [table1]
                            var index = table1.rows[i+1].rowIndex;
                            table1.deleteRow(index);
                            // we have deleted some rows so the checkboxes.length have changed
                            // so we have to decrement the value of i
                            i--;
                           console.log(checkboxes.length);
                        }
            }
            
            
            function tab2_To_tab1()
            {
                var table1 = document.getElementById("table1"),
                    table2 = document.getElementById("table2"),
                    checkboxes = document.getElementsByName("check-tab2");
            console.log("Val1 = " + checkboxes.length);
                 for(var i = 0; i < checkboxes.length; i++)
                     if(checkboxes[i].checked)
                        {
                            // create new row and cells
                            var newRow = table1 .insertRow(table1.length),
                                cell1 = newRow.insertCell(0),
                                cell2 = newRow.insertCell(1),
                                cell3 = newRow.insertCell(2),
                                cell4 = newRow.insertCell(3),
                                cell5 = newRow.insertCell(4);
                            // add values to the cells
                            cell1.innerHTML = table2.rows[i+1].cells[0].innerHTML;
                            cell2.innerHTML = table2.rows[i+1].cells[1].innerHTML;
                            cell3.innerHTML = table2.rows[i+1].cells[2].innerHTML;
                            cell4.innerHTML = table2.rows[i+1].cells[3].innerHTML;
                            cell5.innerHTML = "<input type='checkbox' name='check-tab1'>";
                           
                            // remove the transfered rows from the second table [table2]
                            var index = table2.rows[i+1].rowIndex;
                            table2.deleteRow(index);
                            // we have deleted some rows so the checkboxes.length have changed
                            // so we have to decrement the value of i
                            i--;
                           console.log(checkboxes.length);
                        }
            }
            
        </script>
                            </div>
                        </div>
                    </div>
<!-- end of datatable -->

            </div>
        </div><!-- .animated -->
    </div><!-- .content -->

    <div class="clearfix"></div>

        <?php include 'includes/footer.php';?>


</div><!-- /#right-panel -->

<!-- Right Panel -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="../assets/js/main.js"></script>

<script src="../assets/js/lib/data-table/datatables.min.js"></script>
    <script src="../assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="../assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="../assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="../assets/js/lib/data-table/jszip.min.js"></script>
    <script src="../assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="../assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="../assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="../assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="../assets/js/init/datatables-init.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
      } );

      // Menu Trigger
      $('#menuToggle').on('click', function(event) {
            var windowWidth = $(window).width();   		 
            if (windowWidth<1010) { 
                $('body').removeClass('open'); 
                if (windowWidth<760){ 
                $('#left-panel').slideToggle(); 
                } else {
                $('#left-panel').toggleClass('open-menu');  
                } 
            } else {
                $('body').toggleClass('open');
                $('#left-panel').removeClass('open-menu');  
            } 
                
            }); 

      
  </script>

</body>
</html>
