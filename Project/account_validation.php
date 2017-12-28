<?php 

require_once('connect_members.php');
if(!empty(trim($_POST['user_register_id']))){
	$sql = "SELECT id FROM members_account WHERE userid = ?";
	if($stmt = mysqli_prepare($link,$sql)){
		mysqli_stmt_bind_param($stmt, 's', $param_userid);
		$param_userid = trim($_POST['user_register_id']);
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);
			if(mysqli_stmt_num_rows($stmt) == 1)
			{
				echo 'false';
			}
			else{
				echo 'true';
			}
		}
	}
	mysqli_stmt_close($stmt);
}
mysqli_close($link);

?>