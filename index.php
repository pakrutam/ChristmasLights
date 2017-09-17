<?php include("config.php");?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Christmas Lights Shop</title>
  <meta name="description" content="Christmas Lights Shop">
  <meta name="author" content="SitePoint">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <link rel="stylesheet" href="css/styles.css?v=1.0">

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
  <!-- Latest compiled and minified CSS -->
 <script src="js/jquery-1.10.2.js"></script>
</head>
<script>
$(document).ready(function(){
//Change chr_name colors every 0.5s
  var colors = ['#F1C40F', '#7D3C98', '#F1C40F', '#FFFFFF', '#73C6B6'];
  var colorIndex = 1;
  setInterval(function(){
      $('#chr_name').css('color', colors[colorIndex]);
      if(colorIndex < colors.length)
          colorIndex += 1;
      else
          colorIndex = 1;
  }, 500);

//On Load hide some page DIV
  $("#enterForm").hide();
  $("#left-side-text").hide();
  $("#switch").hide();

//Set some div Css values depending on PC screen
  $('#info').height("100%");
  var window_height = $(window).height();
  $('#switch_order_form').css("top",window_height+"px");
  $('#switch_order_form').css("height",window_height+"px");
  $('#contacts').css("top",window_height+"px");

  var window_top_position = $(window).scrollTop();
  var window_bottom_position = (window_top_position + window_height);

//On Scroll down show switch button
$(window).scroll(function() {
  var scroll = $(window).scrollTop();
    if (scroll > 450) {
      $( "#switch" ).fadeIn( "slow", function() {
      });
    }
});


//on Switch press change backgroud and show some div's
  var light = false;
    $("#switch").click(function(){
      if (light==false){
        $("#enterForm").show();
        $(".Newrecord").hide();
        $('body').css("background-color", "#000000");
        $('body').css("background-image", "url(img/LightOn.png)");
        $('.img_switch').attr('src', 'img/switchON.png');
        light = true;
        var Price = $("#Select_Lenght").val();
        if(Price>0 && Price != NaN){
          $("#left-side-text").show();
        }
      }else{
        $("#enterForm").hide();
        $(".Newrecord").hide();
        $("#left-side-text").hide();
        $('body').css("background-color", "#000000");
        $('body').css("background-image", "url(img/LightOff.png)");
        $('.img_switch').attr('src', 'img/switch.png');
        light = false;
      }
    });
//on windows resize change CSS values
    $(window).on('resize', function(){
        window_height = $(window).height();
        $('#switch_order_form').css("top",window_height+"px");
        $('#contacts').css("top",window_height+"px");
    });

//Depending on Quantity change and show price in round
    $("#Select_Lenght").change(function(){
  var Price = $('#Select_Lenght').val() * 0.75;
      if(Price>0 && Price != NaN){
        $("#left-side-text").show();
        $("#Price").text(Price+" €");
      }else{
        $("#left-side-text").hide();
      }
  });


//ON button Submit check if values are added to form
  $("#Submit").click(function(){
    $("#left-side-text").hide();
    $('body').css("background-image", "url(img/LightOn.png)");
    $('.img_switch').attr('src', 'img/switchON.png');
    light = true;
    var InputName = $.trim($('#InputName').val());
    var InputEmail = $.trim($('#InputEmail').val());
    var InputPhone = $.trim($('#InputPhone').val());

 if (InputName === '') {
     $('#InputName').css({'background-color':'#FFCCCC'});
     return false;
 }
 if (InputEmail === '') {
     $('#InputEmail').css({'background-color':'#FFCCCC'});
     return false;
 }
 if (InputPhone === '') {
     $('#InputPhone').css({'background-color':'#FFCCCC'});
     return false;
 }
  });
});
</script>
<body>

  <div id="info">
    <div class="info_text">
    <div id="chr_name">
      <b>Christmas Lights!</b>
    </div> <br>
    Christmas lights are lights used for decoration in preparation for Christmas and for display throughout the Christmastide. <br>
     <br><br>
    Need help with your holiday decorations this year? <br>
    Our lighting experts are available to help you make your Christmas really shine!
  </div>
      </div>

<div id="switch_order_form">
  <div id="left-side-text">
    <div id ="Price">
      </div>
  <div id="costs">
  </div>
  </div>
<div id="wall">
  <div id="switch">
  <img class="img_switch" src="img/switch.png" height="250" >
</div>
</div>
<div id="enterForm">
  <form action="index.php" method="post" id="Order-form">
    <div class="form-group">
      <input class="form-control" id="InputName" Name="Name"aria-describedby="nameHelp" placeholder="Enter Your Name">
    </div>
    <div class="form-group">
      <input type="email" class="form-control" id="InputEmail" Name="Email" aria-describedby="emailHelp" placeholder="Enter Email">
    </div>
    <div class="form-group">
      <input type="Phone" class="form-control" id="InputPhone" Name="Phone" aria-describedby="emailPhone" placeholder="Enter Phone">
    </div>
    <div class="form-group">
        <label for="Select-lenght">How many meters of lights you need?</label>
        <select class="form-control text-white" Name="Quantity" id="Select_Lenght">
          <option>None</option>
          <option>10</option>
          <option>30</option>
          <option>50</option>
          <option>100</option>
          <option>200</option>
        </select>
      </div>

  <div class="form-group">
    <label for="comment">Comment:</label>
    <textarea class="form-control" rows="5" id="comment" Name="Comment"></textarea>
  </div>

    <button type="submit" class="btn btn-primary gold-background" name="Order" id="Submit">Order Now</button>
  </form>
</div>
</div>
<div id="contacts">
<b> Copyright © 2017. All rights reserved.</b>
</div>
</body>
<?php
//insert values into MYSQL
  if(isset($_POST['Order']))
{

  $Name = mysqli_real_escape_string($conn,$_POST['Name']);
  $Email = mysqli_real_escape_string($conn,$_POST['Email']);
  $Phone = mysqli_real_escape_string($conn,$_POST['Phone']);
  $Quantity = mysqli_real_escape_string($conn,$_POST['Quantity']);
  $Comment = mysqli_real_escape_string($conn,$_POST['Comment']);

  $sql = "INSERT INTO orders (Name, Email, Phone, Quantity, Comment)
    VALUES ('$Name','$Email','$Phone','$Quantity','$Comment')";
    if ($conn->query($sql) === TRUE) {
    echo '<div class="newrecordplace">
    <div class="Newrecord"><b>'.$_POST["Name"].', Thank you for Your order! </b><br/>
    We will contact with you withing 24 hours!
    <br/><br/>
    Christmas Lights team!</div></div>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
    mysqli_close($conn);
}

?>
</html>
