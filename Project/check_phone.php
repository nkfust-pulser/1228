<?php 
require_once('connect_members.php');
if(!empty(trim($_POST['phone']))){
	$sql = "SELECT user_phone FROM users_information WHERE user_phone =?";
	if($stmt = mysqli_prepare($link, $sql)){
		mysqli_stmt_bind_param($stmt, 's', $param_phone);
		$param_phone = trim($_POST['phone']);
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);
			if(mysqli_stmt_num_rows($stmt) == 1){
				session_start();
				if($_SESSION['user_phone'] == trim($_POST['phone'])){
					echo '00';
				}
				else{
					echo '1';
				}
			}
			else{
				echo '0';
			}
		}
	}
	mysqli_stmt_close($stmt);
}
?>