<?php
  session_start();
  include "config.php";
  $Product = $_GET["Product"];
  if($Product == "CS_16") {
    $ProductName = "Counter Strike 1.6 Server";
  } elseif($Product == "SAMP") {
    $ProductName = "GTA San Andreas Multiplayer Server";
  } elseif($Product == "Minecraft") {
    $ProductName = "Minecraft";
  } elseif($Product == "TS3") {
    $ProductName = "Team Speak 3 Server";
  }
  try {
    $SQL = "SELECT * FROM Settings";
    $SQL = $CONN->prepare($SQL);
    $SQL->execute();
    $Settings = $SQL->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  try {
    $SQL = "SELECT * FROM Prices";
    $SQL = $CONN->prepare($SQL);
    $SQL->execute();
    $PriceData = $SQL->fetch(PDO::FETCH_ASSOC);
    $Price = $PriceData[$Product];
    $SlotPacket = $Product."_Pack";
    $SlotPacket = $PriceData[$SlotPacket];
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  if($_SERVER["REQUEST_METHOD"] === "POST") {
    $OrderOK = "1";
    $FirstName = $_POST["FirstName"];
    $LastName = $_POST["LastName"];
    $EmailAddress = $_POST["EmailAddress"];
    $Address = $_POST["Address"];
    $City = $_POST["City"];
    $Country = $_POST["Country"];
    $ServerHostname = $_POST["ServerHostname"];
    $SlotNumber = $_POST["SlotNumber"];
    $Price = $Price * $SlotNumber;
    $Other = $_POST["Other"];
    if($OrderOK == "1") {
      try {
        $SQL = "INSERT INTO Orders (FirstName, LastName, EmailAddress, Address, City, Country, ProductName, ServerHostname, SlotNumber, Price, Other) VALUES (:FirstName, :LastName, :EmailAddress, :Address, :City, :Country, :ProductName, :ServerHostname, :SlotNumber, :Price, :Other)";
        $SQL = $CONN->prepare($SQL);
        $SQL->execute(array("FirstName" => $FirstName, "LastName" => $LastName, "EmailAddress" => $EmailAddress, "Address" => $Address, "City" => $City, "Country" => $Country, "ProductName" => $ProductName, "ServerHostname" => $ServerHostname, "SlotNumber" => $SlotNumber, "Price" => $Price, "Other" => $Other));
        $_SESSION["OrderData"]["FirstName"] = $FirstName;
        $_SESSION["OrderData"]["LastName"] = $LastName;
        $_SESSION["OrderData"]["EmailAddress"] = $EmailAddress;
        $_SESSION["OrderData"]["Address"] = $Address;
        $_SESSION["OrderData"]["City"] = $City;
        $_SESSION["OrderData"]["Country"] = $Country;
        $_SESSION["OrderData"]["ProductName"] = $ProductName;
        $_SESSION["OrderData"]["ServerHostname"] = $ServerHostname;
        $_SESSION["OrderData"]["SlotNumber"] = $SlotNumber;
        $_SESSION["OrderData"]["Price"] = $Price;
        $_SESSION["OrderData"]["Other"] = $Other;
        header("location: ordered.php");
        exit();
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    }
  }
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
    <title><?php echo $Settings["SiteName"]." - Order Server";?></title>
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
          <h3 class="panel-title">Order: <b><?php echo $ProductName;?></b></h3>
        </div>
        <div class="panel-body">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?Product=<?php echo $Product;?>" method="POST">
            <div class="col-md-6">
              <h3>User Info</h3>
              <label>First Name:</label>
              <input type="text" required="true" class="form-control" name="FirstName" maxlength="255">
              <label>Last Name:</label>
              <input type="text" required="true" class="form-control" name="LastName" maxlength="255">
              <label>E-Mail Address:</label>
              <input type="email" required="true" class="form-control" name="EmailAddress" maxlength="255">
              <label>Address:</label>
              <input type="text" class="form-control" name="Address" maxlength="255">
              <label>City:</label>
              <input type="text" required="true" class="form-control" name="City" maxlength="255">
              <label>Country:</label>
              <select class="form-control" name="Country">
                <option value="Serbia">Republic of Serbia</option>
                <option value="Montenegro">Republic of Montenegro</option>
                <option value="Croatia">Republic of Croatia</option>
                <option value="Bosnia and Herzegovina">Republic of Bosnia and Herzegovina</option>
                <option value="Macedonia">Republic of Macedonia</option>
              </select>
            </div>
            <div class="col-md-6">
              <h3>Product Info</h3>
              <label>Product Name:</label>
              <input type="text" class="form-control" disabled="true" value="<?php echo $ProductName;?>">
              <label>Server Hostname:</label>
              <input type="text" required="true" class="form-control" name="ServerHostname" maxlength="255">
              <label>Slot Number:</label>
              <select id="SlotNumber" onchange="CalculatePrice()" class="form-control" name="SlotNumber">
                <option value="0">Choose...</option>
                <?php $SlotPacket = explode(",", $SlotPacket); foreach($SlotPacket as $SlotNumber) { echo '<option value="'.$SlotNumber.'">'.$SlotNumber.' slots</option>'; } ?>
              </select>
              <label>Price:</label>
              <input type="text" id="Price" class="form-control" disabled="true" name="Price" value="0€">
              <label>Other:</label>
              <textarea class="form-control" name="Other" maxlength="510"></textarea>
              <input type="submit" style="margin-top: 15px;" class="btn btn-primary pull-right" value="SUBMIT">
            </div>
          </form>
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
    function CalculatePrice() {
      var SlotNumber = $("#SlotNumber").val();
      var SlotPrice = "<?php echo $Price;?>";
      var Price = SlotPrice * SlotNumber;
      Price  = Price.toFixed(2);
      $("#Price").val(Price+"€");
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
