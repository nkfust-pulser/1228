<?php 
require_once('connect_members.php');
if(!empty(trim($_POST['height']))){
	$sql = 'SELECT user_height FROM users_information WHERE userid = ?';
	if($stmt = mysqli_prepare($link, $sql)){
		mysqli_stmt_bind_param($stmt, 's', $param_userid);
		session_start();
		$param_userid = $_SESSION['userid'];
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);
			if(mysqli_stmt_num_rows($stmt) == 1){
				mysqli_stmt_bind_result($stmt, $param_height);
				if(mysqli_stmt_fetch($stmt)){
					if(trim($_POST['height']) == $param_height){
						echo '1';
					}
					else{
						echo '0';
					}
				}
			}
		}
	}
	mysqli_stmt_close($stmt);
}
?>