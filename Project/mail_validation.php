<?php 
require_once('connect_members.php');
if(!(empty(trim($_POST['register_mail'])))){

	$sql = "SELECT id FROM members_account WHERE mail_address = ?";
	if($stmt = mysqli_prepare($link,$sql)){
		mysqli_stmt_bind_param($stmt, 's', $param_mail);
		$param_mail = trim($_POST['register_mail']);
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);
			if(mysqli_stmt_num_rows($stmt) == 1){
				echo 'false';
			}else{
				echo 'true';
			}
		}
	}
	mysqli_stmt_close($stmt);
}
?>