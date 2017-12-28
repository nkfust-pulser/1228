<?php 
require_once('connect_members.php');
if(!empty(trim($_POST['user_real_name']))){
	$sql = "SELECT username FROM users_information WHERE username = ?";
	if($stmt = mysqli_prepare($link, $sql)){
		mysqli_stmt_bind_param($stmt, 's', $param_username);
		$param_username = trim($_POST['user_real_name']);
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);
			if(mysqli_stmt_num_rows($stmt) == 1){
				echo 'true';
			}
			else{
				echo 'false';
			}
		}
	}
	mysqli_stmt_close($stmt);
}
?>