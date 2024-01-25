<?php
session_start();
$get_id = isset($_POST['set_session']) ? trim($_POST['set_session']) : '';

if($get_id == "" OR !is_numeric($get_id)){

}else{
    $_SESSION['global_session'] = $get_id;
}

header('Location: '.$_SERVER['HTTP_REFERER'] );
exit();

?>