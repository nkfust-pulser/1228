
<?php 
require_once('connect_members.php');
$mail_address = '';
if(!empty(trim($_POST['type_mail_address']))){
  $mail_address = trim($_POST['type_mail_address']);
}
$sql = "SELECT id FROM members_account WHERE mail_address =?";
if($stmt = mysqli_prepare($link, $sql)){
  mysqli_stmt_bind_param($stmt,'s',$param_mail);
  $param_mail = $mail_address;
  if(mysqli_stmt_execute($stmt)){
    mysqli_stmt_store_result($stmt);
    if(mysqli_stmt_num_rows($stmt) == 1){
      echo('find you mail');
      header('location:modify_password.php');
    }
    else{
      echo('none');
    }
  } 
}
mysqli_stmt_close($stmt);


mysqli_close($link);



/*require_once('connect_members.php');
$mail_address = '';
if(!empty(trim($_POST['type_mail_address']))){
  $mail_address = trim($_POST['type_mail_address']);
}
$sql = "SELECT id FROM members_account WHERE mail_address =?";
if($stmt = mysqli_prepare($link, $sql)){
  mysqli_stmt_bind_param($stmt,'s',$param_mail);
  $param_mail = $mail_address;
  if(mysqli_stmt_execute($stmt)){
    mysqli_stmt_store_result($stmt);
    if(mysqli_stmt_num_rows($stmt) == 1){
      echo('find you mail');
      session_start();
      $randNumber = rand(1000,9999);
      $_SESSION['rand_number'] = $randNumber;
      sendMail($mail_address, $_SESSION['rand_number']);
      header('location:modify_password.php');
    }
    else{
      echo('none');
    }
  } 
}
mysqli_stmt_close($stmt);

function sendMail($user_mail,$randNumber){
  $to = $user_mail;
  $subject = 'Pulser 2.0 重新設置密碼';
  $body = '請輸入驗證碼: '.$randNumber;
  mail($to, $subject, $body);
}
mysqli_close($link);
*/

?>


