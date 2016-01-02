<?php
  session_start();
  $ROOT = dirname(__FILE__);
  include $ROOT."/../config.php";
  include "includes/session.php";
  try {
    $SQL = "SELECT * FROM Orders ORDER BY ID DESC";
    $SQL = $CONN->prepare($SQL);
    $SQL->execute();
    $OrdersCount = $SQL->rowCount();
    $Orders = $SQL->fetchAll();
  } catch(PDOException $e) {
     echo "Error: " . $e->getMessage();
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mint Game - Admin Orders</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/admin.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="header">
      <div class="content">
        <div class="options">
          <a href="index.php"><img src="../images/Logo.png" alt="Logo"></a>
          <div class="dropdown pull-right">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Options
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
              <li><a href="../" target="_blank"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Site</a></li>
              <div class="divider"></div>
              <li><a href="logout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar">
      <ul>
        <li><a href="home.php"><span>Settings</span></a></li>
        <li><a href="products.php"><span>Products</span></a></li>
        <li class="active last"><a href="orders.php"><span>Orders</span></a></li>
      </ul>
    </div>
    <?php
    if(isset($_SESSION["Success"])) {
      foreach($_SESSION["Success"] as $Message) {
        echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><b>'.$Message.'</b></div>';
      }
      unset($_SESSION["Success"]);
    } elseif(isset($_SESSION["Error"])) {
      foreach($_SESSION["Error"] as $Message) {
        echo '<div class="alert alert-danger" role="alert"><b>'.$Message.'</b></div>';
      }
      unset($_SESSION["Error"]);
    }
    ?>
    <div class="page-content">
      <?php
        if($OrdersCount > "0") {
          foreach($Orders as $Order) {
            $TimeDate = explode(" ", $Order["OrderDate"]);
            $Time = explode(":", $TimeDate["1"]);
            $Time = $Time["0"].":".$Time["1"];
            $Date = explode("-", $TimeDate["0"]);
            $Date = $Date["2"].".".$Date["1"].".".$Date["0"].".";
            $Order["OrderDate"] = $Time." - ".$Date;
      ?>
      <div class="panel panel-success">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo $Order["FirstName"]." ".$Order["LastName"]." - ".$Order["ProductName"];?><a href="#" onclick="ShowOrder(<?php echo $Order["ID"];?>)" class="order-show pull-right"><b>+</b></a></h3>
        </div>
        <div id="Order-<?php echo $Order["ID"];?>" class="none">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>E-Mail Address</th>
                <th>Address</th>
                <th>City</th>
                <th>Country</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $Order["ID"];?></td>
                <td><?php echo $Order["EmailAddress"];?></td>
                <td><?php echo $Order["Address"];?></td>
                <td><?php echo $Order["City"];?></td>
                <td><?php echo $Order["Country"];?></td>
              </tr>
            </tbody>
          </table>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ProductName</th>
                <th>Server Hostname</th>
                <th>Slot Number</th>
                <th>Price</th>
                <th>Order Date</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $Order["ProductName"];?></td>
                <td><?php echo $Order["ServerHostname"];?></td>
                <td><?php echo $Order["SlotNumber"];?> slots</td>
                <td><?php echo $Order["Price"];?>&euro;</td>
                <td><?php echo $Order["OrderDate"];?></td>
              </tr>
            </tbody>
          </table>
          <?php if(!empty($Order["Other"])) { ?>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th><center>Other:</center></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $Order["Other"];?></td>
              </tr>
            </tbody>
          </table>
          <?php } ?>
        </div>
      </div>
      <?php
          }
        }
      ?>
      <div class="message-margin-bottom"></div>
    </div>
    <div class="footer">
      <div class="footer-content">
        <p class="signature">Free Game Hosting Script. Developed By: <a href="http://www.mintnet.org" target="_blank"><b>Miljan Ilić</b></a></p>
      </div>
    </div>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script>
    function ShowOrder(ID) {
        $("#Order-"+ID).slideToggle("slow");
    }
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
