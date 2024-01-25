
<?php
//added 
include('../includes/dbconnection.php');
include('../includes/session.php');

require_once "../teacher/compute_grade.php";

$section_id = '';
$additional_info = [];
$period = isset($_GET['period']) ? trim($_GET['period']) : 1;

if(isset($_GET['viewId'])){

    //check if teacher has access to faculty load
    $additional_info = student_load_info($_GET['viewId'],$_SESSION['adminTypeId']);
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

$role_id = $_SESSION['adminTypeId'];
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
<link rel="stylesheet" href="<?php echo BASE_URL; ?>style.css">


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
<?php $page="listofscores"; 
include 'includes/Quarter_menu.php';?>

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
                                <li class="breadcrumb-item"><a href="#">Grade Book</a></li>
                                <li class="breadcrumb-item"><a href="#"><?php echo $additional_info['section'];?></a></li>
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
		return false;
	
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

    var table_columns = [
		//{title:"Student ID",width:100, field:"student_id_text", titlePrint:"Student ID", sorter:"string",frozen:true,headerFilter:"input",},
		{title:"Name",width:180, field:"student_name", titlePrint:"Name", sorter:"string",frozen:true,headerFilter:"input",},
	
    
    <?php
        foreach($table_data['table_header'][$period] as $columns){
            echo "{\r\n";
            echo 'title:"'.$columns['title'].'",headerHozAlign:"center", columns:['."\r\n";
            foreach($columns as $index=>$column){
                if($index == "title") continue;
                $add_text_edit ="";
            
                if($column['mark']==0){
                   
                    echo '{title:"'.$column['title'].'",width:80,headerHozAlign:"center", field:"'.$index.'",headerSort:false,sorter:"number",hozAlign:"center",'.$add_text_edit.'formatter:score_display,accessorPrint:score_display_print, accessorPrintParams:{},accessorDownload:dl_score_display,accessorDownloadParams:{},},'."\r\n";
                }else{
                    echo '{title:"'.$column['title'].'",width:80, field:"'.$index.'",headerHozAlign:"center",headerSort:false,sorter:"number",hozAlign:"center",},'."\r\n";
                }
                    
            }
            
            echo "]},\r\n";
        }
    
    ?>		

   <?php
	echo '{title:"Initial Grade",width:100, field:"initial_grade",headerHozAlign:"center",headerSort:false,sorter:"number",hozAlign:"center",headerVertical:false,},';
	echo '{title:"Quarterly Grade",width:100,validator:["required", "max:100","min:0","integer"], field:"quarter_grade",headerHozAlign:"center",headerSort:false,sorter:"number",hozAlign:"center",headerVertical:false,},';
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

})();

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
