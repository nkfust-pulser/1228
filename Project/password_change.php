<?php
session_start();
if(empty($_SESSION['login_userid'])){
  session_destroy();
  header('Location:login.php');
  exit(); 
}

$oldpassword = $newpassword = $newpassword_confirmation = $oldpassword_err = $newpassword_err = $newpassword_confirmation_err = '';
require_once('connect_members.php');
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  if(empty(trim($_POST['oldpassword']))){
    $oldpassword_err = '請輸入舊有密碼';
  }
  else{
    $oldpassword = trim($_POST['oldpassword']);
  }
  if(empty(trim($_POST['newpassword']))){
    $newpassword_err = '請輸入新密碼';
  }
  else if(strlen(trim($_POST['newpassword'])) < 6){
    $newpassword_err = '請輸入你的密碼';
  }
  else{
    $newpassword = trim($_POST['newpassword']);
  }

  if(empty(trim($_POST['newpassword_confirmation']))){
    $newpassword_confirmation_err = '請輸入新密碼確認';
  }
  else{
    $newpassword_confirmation = trim($_POST['newpassword_confirmation']);
    if(strlen($newpassword) != strlen($newpassword_confirmation)){
      $newpassword_confirmation_err = '輸入的密碼長度不同';
    }
    if($newpassword != $newpassword_confirmation){
      $newpassword_confirmation_err = '輸入的密碼不同';
    }
  }
  if(empty($oldpassword_err) && empty($newpassword_err) && empty($newpassword_confirmation_err)){
    $sql = "SELECT password FROM members_account WHERE userid = ?";
    if($stmt = mysqli_prepare($link, $sql)){
      mysqli_stmt_bind_param($stmt, 's', $param_userid);
      $param_userid = $_SESSION['login_userid'];
      if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1){
          mysqli_stmt_bind_result($stmt, $hashed_password);
          if(mysqli_stmt_fetch($stmt)){
            if(password_verify($oldpassword, $hashed_password)){

              $sql2 = "UPDATE members_account SET password = ? WHERE userid = ?";
              if($stmt2 = mysqli_prepare($link, $sql2)){
                mysqli_stmt_bind_param($stmt2,'ss',$param_password, $param_userid2);
                $param_userid2 = $_SESSION['login_userid'];
                $param_password = password_hash($newpassword, PASSWORD_DEFAULT);
                if(mysqli_stmt_execute($stmt2)){
                  header('location:password_change_success.php');
                }
              }
              mysqli_stmt_close($stmt2);
            }
            else{
              $oldpassword_err = '舊有密碼輸入錯誤';
            }
          }
        }
        else{
          $oldpasword_err = '找不到此密碼的帳號';
        }
      }
    }
    mysqli_stmt_close($stmt);
  }

}
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/jquery.js"></script>

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
  <!-- Custom CSS -->
  <link href="custom_css/profile_css.css" rel="stylesheet">
  <title>PULSER 2.0</title>

</head>


<body>
  <div>
    <nav class="navbar navbar-fixed-top navbar-default topnav_css" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button id="theButton" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
          <a class="navbar-brand" href="index.php"><span class="fa fa-home"></span></a>
          <label class="navbar-brand">PULSER 2.0</label>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav navbar-right">

            <li><a href="dash4.php"><i class="fa fa-tachometer" aria-hidden="true"></i><label>圖型面板</label></a>
            </li>
            <li>
              <a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog" aria-hidden="true"></i><label><?php echo($_SESSION['login_userid']. " " .($_SESSION['user_real_name']));?></label>
              </a>
              <ul class="dropdown-menu">
                <li><a href="profile.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>個人資訊修改</a></li>
                <li><a href="#"><i class="fa fa-lock" aria-hidden="true"></i>隱私與安全</a></li>
                <li><a href="#"><i class="fa fa-mobile" aria-hidden="true"></i>裝置設定</a></li>
                <li><a href="#"><i class="fa fa-book" aria-hidden="true"></i>說明</a></li>
                <li><a href="#"><i class="fa fa-users" aria-hidden="true"></i>關於我們</a></li>
                <li><a href="#"><i class="fa fa-phone-square" aria-hidden="true"></i>聯絡我們</a></li>
              </ul>
            </li>
            <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i><label>登出</label></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="content_padding"></div>



    <div class="container">
      <div id="page_wrapper">
        <div class="panel">

          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-12 text-left heading_padding">
                <div class="heading_title">
                  <label>修改密碼</label>
                </div>
              </div>
            </div>
          </div>

          
          <div class="main_page_content panel-footer">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <div class="row">
                <div class="col-md-5 form-group <?php echo (!empty($oldpassword_err)) ? "has-error" : ''; ?>">
                  <label>舊有密碼</label>
                  <input class="form-control" type="password" name="oldpassword">
                  <span class="help-block"><?php echo $oldpassword_err; ?></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 form-group <?php echo (!empty($newpassword_err)) ? "has-error" : ''; ?>">
                  <label>新密碼</label>
                  <input class="form-control" type="password" name="newpassword">
                  <span class="help-block"><?php echo $newpassword_err; ?></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 form-group <?php echo (!empty($oldpassword_confirmation_err)) ? "has-error" : ''; ?>">
                  <label>新密碼確認</label>
                  <input class="form-control" type="password" name="newpassword_confirmation">
                  <span class="help-block"><?php echo $newpassword_confirmation_err; ?></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-10 form-group">
                  <input type="hidden" name="refer" value=" <?php echo (isset($_GET['refer'])) ?$_GET['refer']:'password_change.php';?>">
                  <button type="submit" class="btn submitButton">確認</button>
                </div>
              </div>
            </form>
          </div>


        </div>
      </div>
    </div>
  </body>
  </html>
