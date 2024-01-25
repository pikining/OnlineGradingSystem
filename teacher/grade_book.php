
<?php
//added 
include('../includes/dbconnection.php');
include('../includes/session.php');

require_once "compute_grade.php";

$section_id = '';
$additional_info = [];
$period = isset($_GET['period']) ? trim($_GET['period']) : '';
if(isset($_GET['viewId'])){

    //check if teacher has access to faculty load
    $additional_info = faculty_load_info($_GET['viewId'],$_SESSION['Id']);
    //[success] => Array ( [id] => 8 [teacherId] => 7 [sectionId] => 24 [subjectId] => 27 [sessionId] => 1 [dateCreated] => 2022 [section] => 4- Makulit [subject] => English )

}else{
    echo "PAGE NOT FOUND!";
    exit();
}

if(!isset($additional_info['success'])){
    echo "SECTION PAGE NOT FOUND!";
    exit();
}

$additional_info = $additional_info['success'];

$grading = array("","1st Grading","2nd Grading", "3rd Grading", "4th Grading");
if(isset($grading[$period])){
    $additional_info['grading'] = $grading[$period];
}else{
    echo "Invalid Period!";
    exit();
}

$role_id = 4;
$table_data = collect_grade($additional_info['id'],$period,$role_id);

$percent_equivalent =array();
$select_rating = "SELECT * FROM tbltask_type WHERE teachingId = '".$additional_info['id']."' ";
$result = mysqli_query($con,$select_rating);			
if($result){
	$num_student = mysqli_num_rows($result);
	if($num_student != 0){
		while($data_percent  = mysqli_fetch_assoc($result)){
			$id = $data_percent['Id'];		
			$percent_equivalent[$id] = array('id'=>$data_percent['Id'],'title'=>$data_percent['title'],'percent'=>$data_percent['percent']);
		}
	}
	mysqli_free_result($result);
}


$quarter_grade =array();
$select_rating = "SELECT * FROM tblquartergrade WHERE teachingId = '".$additional_info['id']."' AND period = '".$period."' ";
$result = mysqli_query($con,$select_rating);			
if($result){
	$num_student = mysqli_num_rows($result);
	if($num_student != 0){
		while($data  = mysqli_fetch_assoc($result)){
	
            $val = array();
            $val['id'] = $data['student_id'];       
            $val['quarter_grade'] = $data['grade'];
            $val['remarks'] = $data['remarks'];
			array_push($quarter_grade,$val);
		}
	}
	mysqli_free_result($result);
}

//ended

?>

<!doctype html>
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php include '../includes/title.php';?>
<meta name="description" content="Ela Admin - HTML5 Admin Template">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
<link rel="shortcut icon" href="../assets/img/student-grade.png" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link  rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
<link rel="stylesheet" href="../assets/css/cs-skin-elastic.css">
<link rel="stylesheet" href="../style.css">

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->



</head>

<body>
<!-- Left Panel -->
<style>
.tabulator .tabulator-header .tabulator-col .tabulator-col-content .tabulator-col-title{
	white-space: normal!important;
	text-overflow: clip!important;
}
</style>
<?php $page="grade_book"; include 'includes/Custom_menu.php';?>

<!-- /#left-panel -->

<!-- Left Panel -->

<!-- Right Panel -->

<div class="main-content">

    <!-- Header-->
        <?php include 'includes/header.php';?>
    <!-- /header -->
    <!-- Header-->
<main>

            <div class="card-head">
                <div class="page-title">
                    <h2><?php echo $additional_info['grading']; ?></h2>
                </div>
                <div class="page-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item">Grade Book</li>
                                <li class="breadcrumb-item"><?php echo $additional_info['section'];?></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $additional_info['subject'];?></li>
                          </ol>
                        </nav>
                </div>
            </div>

    <div class="content">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><h2 align="center">Students</h2></strong>
                        </div>
                        <div class="card-body">
                        <div  class="table-bordered  " id="table_project"> </div>
                    </div>
                </div>
<!-- end of datatable -->

    </div><!-- .content -->

    <div class="clearfix"></div>
</main>
    <?php include 'includes/footer.php';?>


</div><!-- /#right-panel -->

<!-- Right Panel -->

<!-- Scripts --> 

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>


<script src="../assets/js/main.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabulator/4.9.3/css/tabulator.min.css" integrity="sha512-qXb7/N44R94029hvbV06tyEl1P3TCwCbyPsIUl61D6W8mRCFbCPsRYOVJbCUaEzlwUvg7JJSLsglThYs7zNoZw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/tabulator/4.9.3/js/tabulator.min.js" integrity="sha512-N/WbW5rCM/O+/QpzuqYXkInRdSfFu6txbJcbQioBywGXDiF1XCJY2LXVKIGjNFUMS4P79mtf9pDu5ViXaa+BnA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
(function(){

//table_data
var table_project ="";
var period = <?php echo "'".$period."';\r\n"; ?>
table_project = <?php echo json_encode($table_data['table_array']);?>;
table_project = Object.values(table_project);
var quarter_grade = <?php echo json_encode($quarter_grade);?>;

var percent_equivalent = <?php echo json_encode($percent_equivalent,JSON_NUMERIC_CHECK)."\r\n"; ?>;
percent_equivalent = Object.values(percent_equivalent);

var class_id = <?php echo empty($id) ? 0: $id; ?>;
function dl_score_display(value, data, type, params, column, row){

	var data_value = value;
	var return_val =0;
	var total = 0;

	total = (typeof data_value.total !== 'undefined') ? data_value.total : 0;
	return_val =  data_value.grade + " / " + total;
	
	return  return_val;
}

function score_display_print(value, data, type, params, column){

	var data_value = value;
	var return_val =0;
	var total = 0;
	
	total = (typeof data_value.total !== 'undefined') ? data_value.total : 0;
	return_val =  data_value.grade + " / " + total;
	
	return  return_val;
}

function score_display (cell, formatterParams,onRendered){

	var data_value = cell.getValue()
	var return_val =0;
	var total = 0;
	
		
	total = (typeof data_value.total !== 'undefined') ? data_value.total : 0;
	return_val =  data_value.grade + " / " + total;

	
	return  return_val;
}

function isEditable (cell) {
		return true;
	
}

function search_index(array, key, prop){
    // Optional, but fallback to key['name'] if not selected
    prop = (typeof prop === 'undefined') ? 'id' : prop;    
	
    for (var i=0; i < array.length; i++) {
        if (array[i][prop] === key) {
            return array[i];
        }
    }

}

function custom_validator(cell, value, parameters){
	
	var grade = (typeof value.grade !== 'undefined') ? value.grade : 0;
	var total = (typeof value.total !== 'undefined') ? value.total : 0;
	
	if (grade === "" || grade === null || typeof grade === "undefined") {
		return false;
	}	
	
	if(/^[0-9]+$/.test(grade)){
		if(parseInt(grade) <= total  && parseInt(grade) >= 0){
			return true;
		}
	}
	return false;

}

function headerMenu_grade(component, e){
    var menu = [];

	var icon = document.createElement("i");
	icon.classList.add("fas");
	icon.classList.add("d");
	
	//build label
	var label = document.createElement("span");
	var title = document.createElement("span");

	title.textContent = 'Remove ';

	label.appendChild(icon);
	label.appendChild(title);

	//create menu item
	menu.push({
		label:label,
		action:function(e,column){	
            Swal.fire({
                title: 'Are you sure to remove this?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                if (result.isConfirmed) {

                    $.post("../teacher/ajax_save_input.php",{action:'DELETE_TASK',id:column.getField(),teachingId:<?php echo $_GET['viewId']; ?>, } , 
                    function(returnedData){
                        var obj = returnedData;//JSON.parse(returnedData);
                            if(obj.result == "success"){
                                success_notif("Successfully Remove!");
                                setTimeout(function(){ window.location.reload() }, 1500);
                            }else{
                                warning_notif("Error: "+obj.errors);	
                            }
                    }).fail(function(){
                        warning_notif("Error Encounter");
                    });

                }
                })

		}
	});


   return menu;
}


function custom_editor(cell, onRendered, success, cancel, editorParams){
				//create and style input
			var cellValue = cell.getValue();
			
			var temp_data = JSON.parse(JSON.stringify(cell.getValue())),
			grade =  typeof cellValue !== "undefined" ? cellValue.grade : ""; 
			div = document.createElement("div");
			span = document.createElement("span");
			input = document.createElement("input");
			
			
			if(cellValue.grade_type != "CUSTOM"){
				return ;
			}
			
			input.setAttribute("type", editorParams.search ? "search" : "text");

			input.style.padding = "4px";
			input.style.width = "50%";
			
			//input.classList.add("float-left");
			input.style.boxSizing = "border-box";
			

			div.style.width = "100%";
			div.style.height = "100%";
			
			span.style.height ="100%";
			span.style.width ="50%";
			span.innerHTML = " / " + cellValue.total;
					

			if (editorParams.elementAttributes && _typeof(editorParams.elementAttributes) == "object") {
				for (var key in editorParams.elementAttributes) {
					if (key.charAt(0) == "+") {
						key = key.slice(1);
						input.setAttribute(key, input.getAttribute(key) + editorParams.elementAttributes["+" + key]);
					} else {
						input.setAttribute(key, editorParams.elementAttributes[key]);
					}
				}
			}
			
			input.value = grade;
		
			onRendered(function () {
				input.focus({ preventScroll: true });
				input.style.height = "100%";
			});

			function onChange(e) {
				if ((grade === null || typeof grade === "undefined") && input.value !== "" || input.value != grade) {
					temp_data.grade = input.value;
					if (success(temp_data)) {
						cellValue = temp_data; 
					}
				} else {
					cancel();
				}
			}

			//submit new value on blur or change
			input.addEventListener("change", onChange);
			input.addEventListener("blur", onChange);

			//submit new value on enter
			input.addEventListener("keydown", function (e) {
				switch (e.keyCode) {
					// case 9:
					case 13:
						onChange(e);
						break;

					case 27:
						cancel();
						break;

					case 35:
					case 36:
						e.stopPropagation();
						break;
				}
			});

			if (editorParams.mask) {
				this.table.modules.edit.maskInput(input, editorParams);
			}
			
			div.appendChild(input);
			div.appendChild(span);
			
			return div;
			
}

    var table_columns = [
		//{title:"Student ID",width:100, field:"student_id_text", titlePrint:"Student ID", sorter:"string",frozen:true,headerFilter:"input",},
		{title:"Name",width:380, field:"student_name", titlePrint:"Name", sorter:"string",frozen:true,headerFilter:"input",},
	
    
    <?php
        foreach($table_data['table_header'][$period] as $columns){
            echo "{\r\n";
            echo 'title:"'.$columns['title'].'",headerHozAlign:"center", columns:['."\r\n";
            foreach($columns as $index=>$column){
                if($index == "title") continue;
                $add_text_edit ="";
            
                if($column['mark']==0){
                    $add_text_edit = 'headerMenu:headerMenu_grade,headerHozAlign:"center",editor:custom_editor,editable:isEditable,editorParams:{verticalNavigation:"table",},validator:[{type:custom_validator,parameters:{}}],';
                    
                    echo '{title:"'.$column['title'].'",width:80, field:"'.$index.'",headerSort:false,sorter:"number",hozAlign:"center",'.$add_text_edit.'formatter:score_display,accessorPrint:score_display_print, accessorPrintParams:{},accessorDownload:dl_score_display,accessorDownloadParams:{},},'."\r\n";
                }else{
                    echo '{title:"'.$column['title'].'",width:80, field:"'.$index.'",headerHozAlign:"center",headerSort:false,sorter:"number",hozAlign:"center",},'."\r\n";
                }
                    
            }
            
            echo "]},\r\n";
        }
    
    ?>		

   <?php
	//echo '{title:"Initial Grade",width:100, field:"initial_grade",headerHozAlign:"center",headerSort:false,sorter:"number",hozAlign:"center",headerVertical:false,},';
	echo '{title:"Quarterly Grade",width:200,validator:["required", "max:100","min:60","integer"], field:"quarter_grade",headerHozAlign:"center",headerSort:false,sorter:"number",hozAlign:"center",editor:\'input\',editable:isEditable,headerVertical:false,},';
	?>];

    var table_for_project = new Tabulator("#table_project", {
	printAsHtml:true,
	//data: table_project,
    height:"auto",
    headerFilterPlaceholder:"",
    layout:"fitDataFill",
    placeholder:"No Data Found",
    movableColumns:true,
	selectable:false,
	printConfig:{
        columnGroups:true, 
        rowGroups:true,
		formatCells:false,
    },

	initialSort:[
        {column:"student_name", dir:"asc"},
    ],
	columns:table_columns,
	cellEdited: Func_cellEdited,

});

 table_for_project.setData(table_project);


 <?php 
if(!empty($quarter_grade)){ ?>
	table_for_project.updateData(quarter_grade)
	.then(function(){

	})
	.catch(function(error){
		console.warn('Error in replacing data');
	});
<?php } ?>

function Func_cellEdited(cell){
		
        var cols = cell.getColumn(true);
        var field  = cell.getField();
        var value = cell.getValue();
        var computed = 0;
        
        if(field == 'quarter_grade'){
            let data = cell.getData();
            

            $.post("../teacher/ajax_save_input.php",{action:'SAVE_QUARTER',grade:value,student_id:data.student_id,term:period,teachingId:<?php echo $_GET['viewId']; ?>, } , 
                function(returnedData){
                    var obj = returnedData;//JSON.parse(returnedData);
                        if(obj.result == "success"){
                            success_notif("Successfully Saved!");
                        }else{
                            warning_notif("Error: "+obj.errors);	
                        }
                }).fail(function(){
                      warning_notif("Error Encounter");
                });

            return;
        }


        var student_id  = value.id_user;
        var class_exam_id  = value.class_exam_id; //taskId
        var grade  = value.grade;
        var term = value.term;
        var success =false;

        var group_cols = cols.getParentColumn().getDefinition().columns;

        var isFound = (field.indexOf("custom_") !=-1) ? true: false; //true
        if(isFound){
            if(typeof cell.getData()[field] !== 'undefined' ){
                $.post("../teacher/ajax_save_input.php",{action:'SAVE_GRADE',id: class_exam_id,grade:grade,student_id:student_id,term:term,teachingId:<?php echo $_GET['viewId']; ?>, } , 
                function(returnedData){
                    
                        var obj = returnedData;//JSON.parse(returnedData);
                        if(obj.result == "success"){
                            
                            success_notif("Successfully Saved!");	
                            let row_data = cell.getData();
       

                            var percentage = 0;
                            var percent_id = row_data[field].percent_id;

                            
                            percent_equivalent.forEach(function(row){
                                if(row.id == percent_id){
                                    percentage = parseInt(row.percent);
                                }
                            });

    
                            var sub_total = 0; 
                            var ps_total = 0;
                            var wa_total = 0; 
                            var counter = 0;
                            group_cols.forEach(function(column){
                                if(column.title == 'Total' || column.title == 'PS' || column.title == 'WA') {
                                    row_data[column.field] = 0;
                                }else{
                                    counter++;
                                    ps_total += (row_data[column.field].grade / row_data[column.field].total)*100;  
                                    sub_total +=  parseInt(row_data[column.field].grade); 
                                }                  
                            });

                            ps_total = Math.round(ps_total/counter);
                            wa_total = (ps_total)*(percentage/100);
                            wa_total = (Math.round(wa_total * 100) / 100).toFixed(2);;
                            
                            var update_field = {};
                            group_cols.forEach(function(column){
                                if(column.title == 'Total'){
                                    row_data[column.field] = sub_total;
                                    update_field[column.field] = sub_total;
                                } else if (column.title == 'PS'){
                                    row_data[column.field] = ps_total;
                                    update_field[column.field] = ps_total;
                                }else if (column.title == 'WA') {
                                    row_data[column.field] = wa_total;
                                    update_field[column.field] = wa_total;
                                }                  
                            });


                            let initial_grade = 0;
                            for (var property in row_data) {
                                if (!row_data.hasOwnProperty(property)) continue;

                                if(property.indexOf('wa_total') !== -1){
                                   initial_grade += parseFloat(row_data[property]);
                                }
                            }
                            

                            update_field['id'] = cell.getData().id;
                            update_field['initial_grade'] = initial_grade;


                            var update_data =[update_field];
                            table_for_project.updateData(update_data); 

                    
                        }else{
                            warning_notif("Error: "+obj.errors);					
                        }
                }).fail(function(){
                      warning_notif("Error Encounter");
                });
            }
        }
    }
    

})();


function success_notif(msg){

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'success',
        title: msg
    });
}

function warning_notif(msg){
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'warning',
        title: msg
    });
}

</script>
<script type="text/javascript">
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

<script>
    let arrow = document.querySelectorAll(".arrow");
    console.log(arrow);
    for (var i = 0; i < arrow.length; i++){
        arrow[i].addEventListener("click", (e)=>{
        let arrowParent = e.target.parentElement.parentElement
            arrowParent.classList.toggle("showMenu");
        });
    }

    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".la-bars");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click",()=>{
        sidebar.classList.toggle("close");
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
