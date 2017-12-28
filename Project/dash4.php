<?php
session_start();
if(empty($_SESSION['login_userid'])){
    session_destroy();
    header("Location:index.php");
    exit();
}
require_once("connect_members.php");
$sql = "SELECT measure_time FROM peaks WHERE measure_time = ?";
if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, 's', $param_time);
    $param_time = $_SESSION['latest_date'];
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 0){
            $temps = array_fill(0, 12, 0);
            $theData = $_SESSION['theData'];
            $indexes = explode(" ", $theData[1]);
            $numbers = explode(" ",$theData[2]);
            $values = explode(" ",$theData[3]);

            foreach($numbers as $key => $vals){
                $temps[$key] = $vals;
            }
            foreach($values as $key => $vals){
                $temps[$key] = $temps[$key].'-'.$vals;
            }
            
            $date = date('Y-m-d H:i:s');
            $sql2 = "INSERT INTO peaks (userid, measure_time, firstPeaks, secondPeaks, thirdPeaks, fourthPeaks, fifthPeaks, sixthPeaks, seventhPeaks, eighthPeaks, ninthPeaks, tenthPeaks, eleventhPeaks, twelvethPeaks) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            if($stmt2 = mysqli_prepare($link, $sql2)){
                mysqli_stmt_bind_param($stmt2, 'ssssssssssssss', $param_userid, $param_datetime, $param_peak1, $param_peak2, $param_peak3, $param_peak4, $param_peak5, $param_peak6, $param_peak7, $param_peak8, $param_peak9, $param_peak10, $param_peak11, $param_peak12);
                $param_userid = $_SESSION['login_userid'];
                $param_datetime = $_SESSION['latest_date'];
                $param_peak1 = $temps[0];
                $param_peak2 = $temps[1];
                $param_peak3 = $temps[2];
                $param_peak4 = $temps[3];
                $param_peak5 = $temps[4];
                $param_peak6 = $temps[5];
                $param_peak7 = $temps[6];
                $param_peak8 = $temps[7];
                $param_peak9 = $temps[8];
                $param_peak10 = $temps[9];
                $param_peak11 = $temps[10];
                $param_peak12 = $temps[11];
                if(mysqli_stmt_execute($stmt2)){
                }
                else{
                }
            }
            mysqli_stmt_close($stmt2);
        }
    }
}
mysqli_stmt_close($stmt);

$temps = array_fill(0, 12, 0);
$theData = $_SESSION['theData'];
$values = explode(" ",$theData[3]);

foreach($values as $key => $vals){
    $temps[$key] = $vals;
}
$base1 = $temps[0];
$health = array_fill(0, 12, 0);
/*liver*/
$health[0] = '你的心聲脈值約是'.round($base1,2);
if(round($temps[1]/$base1,1) > 3.5){
    $health[1] = '你的肝聲脈值約是心的'.round($temps[1]/$base1,1).'倍，可能有肝炎(充血)或癌症。';
}
else if(round($temps[1]/$base1,1) < 3.5){
    $health[1] = '你的肝聲脈值約是心的'.round($temps[1]/$base1,1).'倍，可能是肝的血管阻塞。';
}
else{
    $health[1] = '你的肝聲脈值約是心的'.round($temps[1]/$base1,1).'倍。';
}
/*kidney*/
/*under-usual*/
if(round(($temps[2]/$base1),1) >= 4.5 && round(($temps[2]/$base1),1) < 5.0){
    $health[2] = '正在休息嗎?你的腎聲脈值是正常值，約是心的'.round(($temps[2]/$base1),1).'倍';
}
else if(round(($temps[2]/$base1),1) == 3.5){
    $health[2] = '正在做運動嗎?腎的聲脈值約是心的'.round(($temps[2]/$base1),1).'倍';

}else if(round(($temps[2]/$base1),1) < 3.5){
    $health[2] = '你正在洗腎嗎?還是剛運動完休息呢?你的腎聲脈值約是'.round(($temps[2]/$base1),1).'倍';
}
else{
    $health[2] = '你的腎聲脈值約是心的'.round(($temps[2]/$base1),1).'倍';
}

if(round(($temps[3]/$base1),1) >= 3.1 && round($temps[3]/$base1,1) <= 3.5){
    $health[3] = '脾聲脈值為正常值，約是心的'.round(($temps[3]/$base1),1).'倍';
}
else if(round(($temps[3]/$base1),1) >= 2.9 && round(($temps[3]/$base1),1) < 3.1){
    $health[3] = '你可能感冒了，脾聲脈值約是心的'.round(($temps[3]/$base1),1).'倍';
}
else if(round($temps[3]/$base1,1) > 1.9 && round($temps[3]/$base1,1) < 2.1){
    $health[3] = '你可能先天性免疫系統失調，脾聲脈值約是心的'.round(($temps[3]/$base1),1).'倍';
}
else{
    $health[3] = '你的脾聲脈值約是心的'.round($temps[3]/$base1,1).'倍';
}

if(round($temps[4]/$base1,1) >= 3.5){
    $health[4] = '現在在練氣功?你的肺聲脈值約是心的'.round($temps[4]/$base1,1).'倍';
}
else if(round($temps[4]/$base1,1) == 3.5){
    $health[4] = '你的肺聲脈值約是心的'.round($temps[4]/$base1,1).'倍';
}
else{
    $health[4] = '你肺聲脈值約是心的'.round($temps[4]/$base1,1).'倍';
}

if(round($temps[5]/$base1,1) > 1 ){
    $health[5] = '你正在吃東西跟喝水，胃聲脈值約是心的'.round($temps[5]/$base1,1).'倍';
}
else if(round($temps[4]/$base1,1) == 1){
    $health[5] = '你的胃脈聲值為正常值，約是心的'.round($temps[5]/$base1,1).'倍';
}
else{
    $health[5] = '你的胃脈聲值是心的'.round($temps[5]/$base1,1).'倍';
}


if(round($temps[6]/$base1,1) >= 2){
    $health[6] = '你常做科研嗎?你經常使用你的大腦。你的大腦聲脈值是心的'.round($temps[6]/$base1,1).'倍';
}
else if(round($temps[6]/$base1,1) == 1){
    $health[6] = '你的大腦聲脈為正常值，約是心的'.round($temps[6]/$base1,1).'倍';
}
else if(round($temps[6]/$base1,1) >= 0.2 && round($temps[6]/$base1,1) <= 0.3){
    $health[6] = '你的大腦聲脈值是心的'.round($temps[6]/$base1,1).'倍，可能患有憂鬱症或是患有情緒障礙等疾病';
}
else{
    $health[6] = '你的大腦聲脈值約是心的'.round($temps[6]/$base1,1).'倍';
}

if(round($temps[7]/$base1,1) > 1){
    $health[7] = '你可能膀胱發炎或者是膀胱積尿過大，膀胱聲脈值約是心的'.round($temps[7]/$base1,1).'倍';
}
else if(round($temps[7]/$base1,1) == 1){
    $health[7] = '你的膀胱聲脈值為正常值，約是心的'.round($temps[7]/$base1,1).'倍';
}
else{
    $health[7] = '你膀胱聲脈值約是心的'.round($temps[7]/$base1,1).'倍';
}


if(round($temps[8]/$base1,1) > 1){
    $health[8] = '你的大腸可能發炎，大腸的聲脈值約是心的'.round($temps[8]/$base1,1).'倍';
}
else if(round($temps[8]/$base1,1) == 1){
    $health[8] = '你的大腸聲脈值為正常值，約是心的'.round($temps[8]/$base1,1).'倍';
}
else{
    $health[8] = '你的大腸聲脈值約是心的'.round($temps[8]/$base1,1).'倍';
}

if(round($temps[9]/$base1,1) > 1){
    $health[9] = '你的小腸可能發炎，小腸的聲脈值約是心的'.round($temps[9]/$base1,1).'倍';
}
else if(round($temps[9]/$base1,1) == 1){
    $health[9] = '你的小腸聲脈值為正常值，約是心的'.round($temps[9]/$base1,1).'倍';
}
else{
    $health[9] = '你的小腸聲脈值約是心的'.round($temps[9]/$base1,1).'倍';
}

if(round($temps[10]/$base1,1) == 1){
    $health[10] = '你的三焦聲脈值為正常值，約是心的'.round($temps[10]/$base1,1).'倍';
}
else{
    $health[10] = '你的三焦聲脈值約是心的'.round($temps[10]/$base1,1).'倍';
}
$health[11] = '心包經:不太了解此生理功能';

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>

    <style>
    path {stroke-width: 4;fill: none;}
    .axis {shape-rendering: crispEdges;}
    .x.axis line {stroke: lightgrey;}
    .x.axis .minor {stroke-opacity: .5;}
    .x.axis path {display: none;}
    .y.axis line, .y.axis path {fill: none;stroke: #000;stroke-width: 1;}
</style>

<title>Dashboard 4.0</title>

<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="custom_css/dash4_top_nav.css" rel="stylesheet">
<link href="custom_css/dash4_css.css" rel="stylesheet">
<link href="custom_css/custom_sidebar.css" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Custom Fonts -->

</head>

<body>
    <!-- sidebar and topnav -->
    <div id="wrapper">
        <div class="overlay"></div>
        <!-- Sidebar -->
        <nav id="sidebar">
          <div class="sidebar-header">
            <div class="text-right"><h2>PULSER 2.0</h2></div>
            <div id="dismiss"><span class="glyphicon glyphicon-remove"></span></div></div>
            <ul class="list-unstyled components">
                <li class="active"><a href="dash4.php"><label>Dashboard</label></a></li>
                <div class="sidebar_inside_padding1"></div>
                <li><a href="date_map1.php"><span class="glyphicon glyphicon-th-list"></span>紀錄搜尋</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-user"></span>社群</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-book"></span>說明</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-info-sign"></span>關於我們</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-earphone"></span>聯絡我們</a></li>
            </ul>
            <ul class="list-unstyled CTAs">
                <li><a href="index.php"><span class="glyphicon glyphicon-home"></span>首頁</a></li>
                <li><a href="profile.php"><span class="glyphicon glyphicon-cog"></span>個人資訊設定</a></li>
            </ul>
        </nav>
        <!--Sidebar-->
        <div style="height:5px;background: #000;"></div>
        <!-- top-nav -->
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid" id="navbar-container">
                <div class="navbar-header">
                    <button id="theButton" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="glyphicon glyphicon-chevron-down"></span> 
                    </button>
                    <a class="navbar-brand"><i id="sidebarCollapse" class="fa fa-bars" aria-hidden="true"></i></a>
                    <a id="homepage" class="navbar-brand" href="index.php"><i class="fa fa-home" aria-hidden="true"></i><label>PULSER 2.0</label></a>

                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                 <ul class="nav navbar-nav navbar-right">
                    <li><a href="profile.php"><i class="fa fa-user-circle-o" aria-hidden="true"></i><?php echo($_SESSION['login_userid']);?></a></li>
                    <li><a href="logout.php"><i id="sign_out_i" class="fa fa-sign-out" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
        <!--<ul class="nav navbar-nav navbar-left">
            <li>
                <a href="index.php">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    <label>PULSER 2.0</label>
                </a>
            </li>
            <li class="menu"><a><i id="sidebarCollapse" class="fa fa-bars" aria-hidden="true"></i></a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="profile.php"><i class="fa fa-user-circle-o" aria-hidden="true"></i><?php echo($_SESSION['login_userid']);?></a></li>
            <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
        </ul>-->

        <!-- top-nav -->
    </div>
    <!-- sidebar and topnav -->
    <!-- page-wrapper -->
    <div id="page-wrapper">
        <div style="height:20px;"></div>
        <!--row of dashboard4.0-->
        <div class="row">
            <div style="height:20px;"></div>
            <div class="container-fluid text-center">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <div>
                                    <label style="font-size: 26px;">Dashboard</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <label style="font-size:20px;">最近測量:<?php echo $health[rand(0,11)];?></label>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div style="height:20px;"></div>
        </div>

        <!--4panel-row-->
        <div class="row">
            <!--red_panel-->
            <div class="col-lg-3 col-md-3 col-xs-12">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12 text-right">
                                <div>
                                    <span class="glyphicon glyphicon-grain"></span><label>生理</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">
                            <div>身高</div>
                            <div>體重</div>
                        </span>
                        <span class="pull-right">
                            <div><?php echo($_SESSION['user_height']);?>公分</div>
                            <div><?php echo($_SESSION['user_weight']);?>公斤</div>
                        </span>
                        <div class="clearfix"></div>
                    </div>

                </div>
            </div>
            <!--red_panel-->
            <!--primary_panel-->
            <div class="col-lg-3 col-md-3 col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12 text-right">
                                <div><span class="glyphicon glyphicon-zoom-in"></span><label>測量</label></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">
                            <div>最近脈搏測量</div>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!--primary_panel-->
            <!--yellow_panel-->
            <div class="col-lg-3 col-md-3 col-xs-12">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12 text-right">
                                <div><span class="glyphicon glyphicon-tint"></span><label>健康值</label></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">
                            <div><span class="glyphicon glyphicon-warning-sign"></span><label>危險</label></div>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!--yellow_panel-->
            <!--green_panel-->
            <div class="col-lg-3 col-md-3 col-xs-12">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12 text-right">
                                <div><span class="glyphicon glyphicon-equalizer"></span><label>建議</label></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">
                            <div>醫師建議</div>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!--green_panel-->
        </div>
        <!--4panel-row-->


        <div style="height:40px;"></div>
        <div class="table-responsive" style="font-size: 18px;"> 
            <table class="table table-striped table-inverse">
               <thead class="thead-inverse">
                <tr><th>身體器官</th><th>測量數值</th></tr>
            </thead>
            <tbody>
              <tr><td>心</td><td><?php echo $health[0]?></td></tr>
              <tr><td>肝</td><td><?php echo $health[1]?></td></tr>
              <tr><td>腎</td><td><?php echo $health[2]?></td></tr>
              <tr><td>脾</td><td><?php echo $health[3]?></td></tr>
              <tr><td>肺</td><td><?php echo $health[4]?></td></tr>
              <tr><td>胃</td><td><?php echo $health[5]?></td></tr>
              <tr><td>大腦</td><td><?php echo $health[6]?></td></tr>
              <tr><td>膀胱</td><td><?php echo $health[7]?></td></tr>
              <tr><td>大腸</td><td><?php echo $health[8]?></td></tr>
              <tr><td>小腸</td><td><?php echo $health[9]?></td></tr>
              <tr><td>三焦</td><td><?php echo $health[10]?></td></tr>
              <tr><td>心包經</td><td><?php echo $health[11]?></td></tr>
          </tbody>
      </table>
  </div>
  <!--RAW-->
  <div class="dash4_map">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-bar-chart-o fa-fw"></i>
                <label class="dash4_map_label">原始圖型</label>
            </h3>
        </div>
        <div class="panel-body">
            <div id="container_raw" class="svg-container"></div>
        </div>
    </div>

    <!--RAW-->
    <div class="dash4_map_spacewhite"></div>
    <!--FFT-->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-bar-chart-o fa-fw"></i>
                <label class="dash4_map_label">FFT圖型</label>
            </h3>
        </div>
        <div class="panel-body">
            <div id="container_fft" class="svg-container"></div>
        </div>
    </div>
    <!--FFT-->
    <div class="dash4_map_spacewhite"></div>
    <!--FFT-PeakLoad-->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-bar-chart-o fa-fw"></i>
                <label class="dash4_map_label">FFT-30圖型</label>
            </h3>
        </div>
        <div class="panel-body">
            <div id="container_fft30" class="svg-container"></div>
        </div>
    </div>
    <!--FFT-PeakLoad-->

    <div class="dash4_map_spacewhite"></div>

    <!-- table -->

    <!-- table -->


</div>
<!-- page-wrapper-container-fluid -->
<div style="height:40px;"></div>

</div>
<!-- page-wrapper -->



<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type='text/javascript'></script>

<!--custom_javascript-->

<script src="js/raw.js"></script>
<script src="js/fft.js"></script>
<script src="js/fft_30.js"></script>
<script src="js/today_date.js"></script>
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
      $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });

      $('#dismiss, .overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.overlay').fadeOut();
    });

      $('#sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.overlay').fadeIn();
        $('.collapse.in').toggleClass('in');
    });
  });
</script>
<script>
    $(document).ready(function(){
        document.getElementById('#table-peaks').attr("preserveAspectRatio", "xMinYMin meet").attr("viewBox", "0 0 1300 500");
    });
</script>
</body>

</html>

