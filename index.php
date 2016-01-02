<?php
  include "config.php";
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
     $Price = $SQL->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
     echo "Error: " . $e->getMessage();
  }
  $MostPopular = $Settings["MostPopular"];
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
    <title><?php echo $Settings["SiteName"]." - ".$Settings["Tagline"];?></title>
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
    <div class="products">
      <div class="col-xs-12 col-md-3">
        <div class="panel panel-success">
          <?php if($MostPopular == "CS_16") { ?>
          <div class="cnrflash">
            <div class="cnrflash-inner">
              <span class="cnrflash-label">MOST<br> POPULR</span>
            </div>
          </div>
          <?php } ?>
          <div class="panel-heading">
            <h3 class="panel-title">Counter Strike 1.6</h3>
          </div>
          <div class="panel-body">
            <div class="the-price">
              <h1><?php echo $Price["CS_16"];?>&euro;<span class="subscript">/slot</span></h1>
            </div>
            <table class="table">
              <tr>
                <td>DDoS Protection</td>
              </tr>
              <tr class="active">
                <td>Best Game Panel</td>
              </tr>
              <tr>
                <td>FTP Access</td>
              </tr>
              <tr class="active">
                <td>24/7 Support</td>
              </tr>
              <tr>
                <td>1 Gbps Connection</td>
              </tr>
              <tr class="active">
                <td>99.9% Uptime</td>
              </tr>
            </table>
          </div>
          <div class="panel-footer">
            <a href="order.php?Product=CS_16" class="btn btn-success" role="button">ORDER NOW</a>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-3">
        <div class="panel panel-info">
          <?php if($MostPopular == "SAMP") { ?>
          <div class="cnrflash">
            <div class="cnrflash-inner">
              <span class="cnrflash-label">MOST<br> POPULR</span>
            </div>
          </div>
          <?php } ?>
          <div class="panel-heading">
            <h3 class="panel-title">SA:MP</h3>
          </div>
          <div class="panel-body">
            <div class="the-price">
              <h1><?php echo $Price["SAMP"];?>&euro;<span class="subscript">/slot</span></h1>
            </div>
            <table class="table">
              <tr>
                <td>DDoS Protection</td>
              </tr>
              <tr class="active">
                <td>Best Game Panel</td>
              </tr>
              <tr>
                <td>FTP Access</td>
              </tr>
              <tr class="active">
                <td>24/7 Support</td>
              </tr>
              <tr>
                <td>1 Gbps Connection</td>
              </tr>
              <tr class="active">
                <td>99.9% Uptime</td>
              </tr>
            </table>
          </div>
          <div class="panel-footer">
            <a href="order.php?Product=SAMP" class="btn btn-success" role="button">ORDER NOW</a>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-3">
        <div class="panel panel-success">
          <?php if($MostPopular == "Minecraft") { ?>
          <div class="cnrflash">
            <div class="cnrflash-inner">
              <span class="cnrflash-label">MOST<br> POPULR</span>
            </div>
          </div>
          <?php } ?>
          <div class="panel-heading">
            <h3 class="panel-title">Minecraft</h3>
          </div>
          <div class="panel-body">
            <div class="the-price">
              <h1><?php echo $Price["Minecraft"];?>&euro;<span class="subscript">/slot</span></h1>
            </div>
            <table class="table">
              <tr>
                <td>DDoS Protection</td>
              </tr>
              <tr class="active">
                <td>Best Game Panel</td>
              </tr>
              <tr>
                <td>FTP Access</td>
              </tr>
              <tr class="active">
                <td>24/7 Support</td>
              </tr>
              <tr>
                <td>1 Gbps Connection</td>
              </tr>
              <tr class="active">
                <td>99.9% Uptime</td>
              </tr>
            </table>
          </div>
          <div class="panel-footer">
            <a href="order.php?Product=Minecraft" class="btn btn-success" role="button">ORDER NOW</a>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-3">
        <div class="panel panel-info">
          <?php if($MostPopular == "TS3") { ?>
          <div class="cnrflash">
            <div class="cnrflash-inner">
              <span class="cnrflash-label">MOST<br> POPULR</span>
            </div>
          </div>
          <?php } ?>
          <div class="panel-heading">
            <h3 class="panel-title">Team Speak 3</h3>
          </div>
          <div class="panel-body">
            <div class="the-price">
              <h1><?php echo $Price["TS3"];?>&euro;<span class="subscript">/slot</span></h1>
            </div>
            <table class="table">
              <tr>
                <td>DDoS Protection</td>
              </tr>
              <tr class="active">
                <td>Control Panel</td>
              </tr>
              <tr>
                <td>FTP Access</td>
              </tr>
              <tr class="active">
                <td>24/7 Support</td>
              </tr>
              <tr>
                <td>1 Gbps Connection</td>
              </tr>
              <tr class="active">
                <td>99.9% Uptime</td>
              </tr>
            </table>
          </div>
          <div class="panel-footer">
            <a href="order.php?Product=TS3" class="btn btn-success" role="button">ORDER NOW</a>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
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
