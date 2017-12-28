<?php
session_start();
if(empty($_SESSION['login_userid'])){
  session_destroy();
  header('Location:login.php');
  exit(); 
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

          <div class="main_page_content panel-footer">
            <label>更新密碼成功!</label>
          </div>


        </div>
      </div>
    </div>
  </body>
  </html>