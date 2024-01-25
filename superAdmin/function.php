<?php
$conn = mysqli_connect("localhost", "root", "", "data");

if(isset($_POST["action"])){
  // Choose a function depends on value of $_POST["action"]
  if($_POST["action"] == "delete"){
    delete();
  }
}

function delete(){
  global $con;

  $id = $_POST["id"];

  $rows = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tb_data WHERE id = $id"));


  mysqli_query($con, "DELETE FROM tb_data WHERE id = $id");
  echo 1;
}
