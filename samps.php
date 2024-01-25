<?php 
include('includes/dbconnection.php');?>

<!DOCTYPE html>
<html>
    <head>
        <title>Transfer Rows Between Two HTML Table</title>
        <meta charset="windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <style>
            
            .container{overflow: hidden}
            .tab{float: left}
            .tab-btn{margin: 50px;}
            button{display:block;margin-bottom: 20px;}
            tr{transition:all .25s ease-in-out}
            tr:hover{background-color: #ddd;}
            
        </style>    
    </head>
    <body>
        
        <div class="container">
            
            <div class="tab">
            
                    <table id="table1" border="1" class="table table-hover table-striped table-bordered">
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
                    <td><?php echo $row['lname'].' '.$row['fname'].' '.$row['mname'];?></td>
                    <td><?php echo $row['sessionName'];?></td>
                    <td><?php echo $row['dateCreated'];?></td>
                    <td><input type="checkbox" name="check-tab1"></td>
                    </tr>
                    <?php 
                    $cnt=$cnt+1;
                    }?>
                                                                                            
                                </tbody>
                            </table>
                   
            </div>
            
            <div class="tab tab-btn">
                <button onclick="tab1_To_tab2();">>>>>></button>
                <button onclick="tab2_To_tab1();"><<<<<</button>
            </div>
            
            <div class="tab">
                <table id="table2" border="1">
                    <tr>
                        <th>#</th>
                                            <th>FullName</th>
                                            <th>LRN</th>
                                            <th>Level</th>
                                            <th>Faculty</th>
                                            <th>Session</th>
                                            <th>Date Created</th>
                                            <th>Actions</th
                    </tr>
                </table>   
            </div>
        </div>
        
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
                                cell5 = newRow.insertCell(4),
                                cell6 = newRow.insertCell(5),
                                cell7 = newRow.insertCell(6),
                                cell8 = newRow.insertCell(7);
                            // add values to the cells
                            cell1.innerHTML = table1.rows[i+1].cells[0].innerHTML;
                            cell2.innerHTML = table1.rows[i+1].cells[1].innerHTML;
                            cell3.innerHTML = table1.rows[i+1].cells[2].innerHTML;
                            cell4.innerHTML = table1.rows[i+1].cells[3].innerHTML;
                            cell5.innerHTML = table1.rows[i+1].cells[4].innerHTML;
                            cell6.innerHTML = table1.rows[i+1].cells[5].innerHTML;
                            cell7.innerHTML = table1.rows[i+1].cells[6].innerHTML;
                            cell8.innerHTML = "<input type='checkbox' name='check-tab2'>";
                           
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
                                cell5 = newRow.insertCell(4),
                                cell6 = newRow.insertCell(5),
                                cell7 = newRow.insertCell(6),
                                cell8 = newRow.insertCell(7);
                            // add values to the cells
                            cell1.innerHTML = table2.rows[i+1].cells[0].innerHTML;
                            cell2.innerHTML = table2.rows[i+1].cells[1].innerHTML;
                            cell3.innerHTML = table2.rows[i+1].cells[2].innerHTML;
                            cell4.innerHTML = table2.rows[i+1].cells[3].innerHTML;
                            cell5.innerHTML = table2.rows[i+1].cells[4].innerHTML;
                            cell6.innerHTML = table2.rows[i+1].cells[5].innerHTML;
                            cell7.innerHTML = table2.rows[i+1].cells[6].innerHTML;
                            cell8.innerHTML = "<input type='checkbox' name='check-tab1'>";
                           
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
        
    </body>
</html>