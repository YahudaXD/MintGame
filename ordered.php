<?php
  session_start();
  include "config.php";
  if(!isset($_SESSION["OrderData"])) {
    header("location: index.php");
    exit();
  }
  try {
    $SQL = "SELECT * FROM Settings";
    $SQL = $CONN->prepare($SQL);
    $SQL->execute();
    $Settings = $SQL->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $OrderData = $_SESSION["OrderData"];
  unset($_SESSION["OrderData"]);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $Settings["Description"];?>">
    <meta name="keywords" content="<?php echo $Settings["Keywords"];?>">
    <meta name="author" content="Miljan Ilić">
    <title><?php echo $Settings["SiteName"]." - Order Success";?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="header">
      <div class="header-content">
        <div class="logo">
          <a href="index.php"><span class="glyphicon glyphicon-send" aria-hidden="true"></span></a>
        </div>
      </div>
    </div>
    <div class="order">
      <div class="panel panel-success">
        <div class="panel-heading">
          <h3 class="panel-title">Order Completed</h3>
        </div>
        <div style="padding-top: 15px" class="panel-body">
          <div class="col-md-12">
            <p>You have successfully ordered <b><?php echo $OrderData["ProductName"];?></b>. You will receive an email with informations how to complete payment. If you did not received an email check the SPAM folder of your Inbox!</p>
          </div>
          <div class="col-md-6">
            <h3>User Info</h3>
            <ul>
              <li>Name: <b><?php echo $OrderData["FirstName"];?> <?php echo $OrderData["LastName"];?></b></li>
              <li>E-Mail Address: <b><?php echo $OrderData["EmailAddress"];?></b></li>
              <li>Address: <b><?php echo $OrderData["Address"];?></b></li>
              <li>City: <b><?php echo $OrderData["City"];?></b></li>
              <li>Country: <b><?php echo $OrderData["Country"];?></b></li>
            </ul>
          </div>
          <div class="col-md-6">
            <h3>Product Info</h3>
            <ul>
              <li>Product Name: <b><?php echo $OrderData["ProductName"];?></b></li>
              <li>Hostname: <b><?php echo $OrderData["ServerHostname"];?></b></li>
              <li>Slot Number: <b><?php echo $OrderData["SlotNumber"];?> slots</b></li>
              <li>Price: <b><?php echo $OrderData["Price"];?>&euro;</b></li>
              <li>Other: <b><?php echo $OrderData["Other"];?></b></li>
            </ul>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <div class="footer">
      <div class="footer-content">
        <p class="signature">Free Game Hosting Script. Developed By: <a href="http://www.mintnet.org" target="_blank"><b>Miljan Ilić</b></a></p>
      </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
    var FooterHeight = 0,
    FooterTop = 0,
    $Footer = $(".footer");
    PositionFooter();
    function PositionFooter() {
      FooterHeight = $Footer.height();
      FooterTop = ($(window).scrollTop()+$(window).height()-FooterHeight)+"px";
      if ( ($(document.body).height()+FooterHeight) < $(window).height()) {
        $Footer.css({
          position: "absolute"
        }).css({
          top: FooterTop
        })
      } else {
        $footer.css({
          position: "static"
        })
      }
    }
    $(window).resize(function() {
      PositionFooter();
    });
    $(window).scroll(function() {
      PositionFooter();
    });
    </script>
  </body>
</html>
