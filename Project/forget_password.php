
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" >
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>



  <title>PULSER 2.0</title>

  <!-- Bootstrap Core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom CSS -->
  <link href="custom_css/forget_password_css.css" rel="stylesheet">

</head>

<body>

  <nav class="navbar navbar-fixed-top navbar-default topnav_css" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button id="theButton" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
        </button>
        <a class="navbar-brand" href="index.php"><span id="navbar_brand_span" class="fa fa-home"></span></a>
        <label class="navbar-brand">PULSER 2.0</label>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-left">
          <li><a href="#"><label>產品</label></a></li>
          <li><a href="#"><label>應用程式</label></a></li>
          <li><a href="#"><label>說明</label></a></li>
          <li><a href="#"><label>服務</label></a></li>
          <!--<li><a href="index.php"><label class="fa fa-home"></label></a></li>-->
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="login.php"><label>登入</label></a></li>
          <li><a href="register.php"><label>註冊</label></a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div id="content_padding"></div>

  <div class="content_size">
    <div class="container-fluid">
      <form id="myForm" method="post" action="sent_mail.php">
        <div class="form_inside_padding0"></div>
        <div class="form-group">
          <div class="text-left"><label class="title">重新設置密碼</label></div>
          <div class="form_inside_padding1"></div>
          <label class="formlabel">請輸入你的信箱</label>
          <div class="form_inside_padding"></div>
          <input id="mail_address" type="text" class="form-control input-lg" name="type_mail_address">
          <span id="emsg_error"></span><span class="emsg_mail_error hidden">請填入你的信箱!</span>
          <div class="form_inside_padding1"></div>

          <div class="text-right"><button id="submitBtn" type="submit" class="btn btn-primary">下一步</button></div>

        </div>
        <div class="form_inside_padding2"></div>
      </form>

    </div>
  </div>

</body>
<script>
  /*$(document).ready(function(){
    $('mail_address').focus();
    $('#mail_address').on('keydown keyup keypress', function(){
      $(this).removeClass('input_error');
      $('.emsg_mail_error').addClass('hidden');
      $.post('find_mail.php',{mail_sent:$(this).val()}, function(data){
        if(data.length == 'fuck'){
          document.getElementById('emsg_error').innerHTML = data;
        }else{
          document.getElementById('emsg_error').innerHTML = data;
        }
      });
    });
  });

  $('#myForm').submit(function(){
    if(($('#mail_address').val().length) == 0){
      $('#mail_address').addClass('input_error');
      $('.emsg_mail_error').removeClass('hidden');
      $('.emsg_mail_error').show();
      return false;
    }
  });
  $('#myForm').submit(function(){


    $.post('find_mail.php',{mail_sent:$('#mail_address').val()}, function(data){
     if(data == 'fuck'){
      console.log(data + ' fuck1');
    }else{
      console.log(data + ' fuck2');
      return false;
    }
  });


  });

  */

</script>
<script type="text/javascript" >
  $(document).ready(function(){
   $('#myForm').validate({

    errorElement: 'div',
    rules: {
      type_mail_address: { required: true, 
        email: true, 
        remote: {
          url: "find_mail.php",
          type: "post"
        }
      }
    },
    messages:{
      type_mail_address: {required: '請輸入你的信箱', email:'請輸入有效的信箱', remote:'找不到該信箱'}
    },
    submitHandler: function (form)
    {
      $('#myForm').submit();
    }
  });
 });
</script>

</html>
