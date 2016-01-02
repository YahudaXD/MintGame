<?php
  session_start();
  $ROOT = dirname(__FILE__);
  include $ROOT."/../config.php";
  include "includes/session.php";
  if($_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($_POST["ProductPrices"])) {
      $CS_16 = $_POST["CS_16"];
      $SAMP = $_POST["SAMP"];
      $Minecraft = $_POST["Minecraft"];
      $TS3 = $_POST["TS3"];
      $MostPopular = $_POST["MostPopular"];
      try {
        $SQL = "UPDATE Prices SET CS_16 = :CS_16, SAMP = :SAMP, Minecraft = :Minecraft, TS3 = :TS3";
        $SQL = $CONN->prepare($SQL);
        $SQL->execute(array("CS_16" => $CS_16, "SAMP" => $SAMP, "Minecraft" => $Minecraft, "TS3" => $TS3));
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      try {
        $SQL = "UPDATE Settings SET MostPopular = :MostPopular";
        $SQL = $CONN->prepare($SQL);
        $SQL->execute(array("MostPopular" => $MostPopular));
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      $_SESSION["Success"][] = "Product settings are successfully updated!";
      header("location: products.php");
      exit();
    } elseif(isset($_POST["ProductPacks"])) {
      $CS_16_Pack = $_POST["CS_16_Pack"];
      $SAMP_Pack = $_POST["SAMP_Pack"];
      $Minecraft_Pack = $_POST["Minecraft_Pack"];
      $TS3_Pack = $_POST["TS3_Pack"];
      $MostPopular = $_POST["MostPopular"];
      try {
        $SQL = "UPDATE Prices SET CS_16_Pack = :CS_16_Pack, SAMP_Pack = :SAMP_Pack, Minecraft_Pack = :Minecraft_Pack, TS3_Pack = :TS3_Pack";
        $SQL = $CONN->prepare($SQL);
        $SQL->execute(array("CS_16_Pack" => $CS_16_Pack, "SAMP_Pack" => $SAMP_Pack, "Minecraft_Pack" => $Minecraft_Pack, "TS3_Pack" => $TS3_Pack));
        $_SESSION["Success"][] = "Product settings are successfully updated!";
        header("location: products.php");
        exit();
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    }
  }
  try {
    $SQL = "SELECT MostPopular FROM Settings";
    $SQL = $CONN->prepare($SQL);
    $SQL->execute();
    $MostPopular = $SQL->fetch(PDO::FETCH_ASSOC)["MostPopular"];
  } catch(PDOException $e) {
     echo "Error: " . $e->getMessage();
  }
  try {
    $SQL = "SELECT * FROM Prices";
    $SQL = $CONN->prepare($SQL);
    $SQL->execute();
    $PriceData = $SQL->fetch(PDO::FETCH_ASSOC);
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
    <title>Mint Game - Admin Products</title>
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
        <li class="active"><a href="products.php"><span>Products</span></a></li>
        <li class="last"><a href="orders.php"><span>Orders</span></a></li>
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
      <div class="col-md-6">
        <h3>Product Prices</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          <label>Counter Strike 1.6 Price:</label>
          <div class="input-group">
            <span class="input-group-addon">
              MP: <input type="radio" <?php if($MostPopular == "CS_16") { echo 'checked="true" '; } ?>name="MostPopular" value="CS_16">
            </span>
            <input type="text" class="form-control" name="CS_16" value="<?php echo $PriceData["CS_16"];?>" maxlength="255">
            <span class="input-group-addon">&euro;</span>
          </div>
          <label>San Andreas Multiplayer Price:</label>
          <div class="input-group">
            <span class="input-group-addon">
              MP: <input type="radio" <?php if($MostPopular == "SAMP") { echo 'checked="true" '; } ?>name="MostPopular" value="SAMP">
            </span>
            <input type="text" class="form-control" name="SAMP" value="<?php echo $PriceData["SAMP"];?>" maxlength="255">
            <span class="input-group-addon">&euro;</span>
          </div>
          <label>Minecraft Price:</label>
          <div class="input-group">
            <span class="input-group-addon">
              MP: <input type="radio" <?php if($MostPopular == "Minecraft") { echo 'checked="true" '; } ?>name="MostPopular" value="Minecraft">
            </span>
            <input type="text" class="form-control" name="Minecraft" value="<?php echo $PriceData["Minecraft"];?>" maxlength="255">
            <span class="input-group-addon">&euro;</span>
          </div>
          <label>Team Speak 3 Price:</label>
          <div class="input-group">
            <span class="input-group-addon">
              MP: <input type="radio" <?php if($MostPopular == "TS3") { echo 'checked="true" '; } ?>name="MostPopular" value="TS3">
            </span>
            <input type="text" class="form-control" name="TS3" value="<?php echo $PriceData["TS3"];?>" maxlength="255">
            <span class="input-group-addon">&euro;</span>
          </div>
          <input type="submit" style="margin-bottom: 20px" class="btn btn-success pull-right" name="ProductPrices" value="Save Changes">
        </form>
      </div>
      <div class="col-md-6">
        <h3>Product Packs</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          <label>Counter Strike 1.6 Slot Packs:</label>
          <input type="text" class="form-control" name="CS_16_Pack" value="<?php echo $PriceData["CS_16_Pack"];?>" maxlength="510">
          <label>SA:MP Slot Packs:</label>
          <input type="text" class="form-control" name="SAMP_Pack" value="<?php echo $PriceData["SAMP_Pack"];?>" maxlength="510">
          <label>Minecraft:</label>
          <input type="text" class="form-control" name="Minecraft_Pack" value="<?php echo $PriceData["Minecraft_Pack"];?>" maxlength="510">
          <label>Team Speak 3 Slot Packs:</label>
          <input type="text" class="form-control" name="TS3_Pack" value="<?php echo $PriceData["TS3_Pack"];?>" maxlength="510">
          <input type="submit" style="margin-bottom: 20px" class="btn btn-success pull-right" name="ProductPacks" value="Save Changes">
        </form>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="footer">
      <div class="footer-content">
        <p class="signature">Free Game Hosting Script. Developed By: <a href="http://www.mintnet.org" target="_blank"><b>Miljan Ilić</b></a></p>
      </div>
    </div>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
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
