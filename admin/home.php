<?php
  session_start();
  $ROOT = dirname(__FILE__);
  include $ROOT."/../config.php";
  include "includes/session.php";
  if($_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($_POST["GeneralSettings"])) {
      $SiteName = $_POST["SiteName"];
      $Tagline = $_POST["Tagline"];
      $Description = $_POST["Description"];
      $Keywords = $_POST["Keywords"];
      $AboutUs = $_POST["AboutUs"];
      try {
        $SQL = "UPDATE Settings SET SiteName = :SiteName, Tagline = :Tagline, Description = :Description, Keywords = :Keywords, AboutUs = :AboutUs";
        $SQL = $CONN->prepare($SQL);
        $SQL->execute(array("SiteName" => $SiteName, "Tagline" => $Tagline, "Description" => $Description, "Keywords" => $Keywords, "AboutUs" => $AboutUs));
        $_SESSION["Success"][] = "Site settings are successfully updated!";
        header("location: home.php");
        exit();
      } catch(PDOException $e) {
         echo "Error: " . $e->getMessage();
      }
    } elseif(isset($_POST["ProfileSettings"])) {
      $Username = $_POST["Username"];
      $Password = $_POST["Password"];
      $EmailAddress = $_POST["EmailAddress"];
      $Password = password_hash($Password, PASSWORD_DEFAULT);
      try {
        $SQL = "UPDATE Admins SET Username = :Username, Password = :Password, EmailAddress = :EmailAddress WHERE ID = :ID";
        $SQL = $CONN->prepare($SQL);
        $SQL->execute(array("Username" => $Username, "Password" => $Password, "EmailAddress" => $EmailAddress, "ID" => $AdminCheck));
        $_SESSION["Success"][] = "Profile settings are successfully updated!";
        header("location: home.php");
        exit();
      } catch(PDOException $e) {
         echo "Error: " . $e->getMessage();
      }
    }
  }
  try {
    $SQL = "SELECT * FROM Settings";
    $SQL = $CONN->prepare($SQL);
    $SQL->execute();
    $GeneralData = $SQL->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
     echo "Error:: " . $e->getMessage();
  }
  try {
    $SQL = "SELECT * FROM Admins WHERE ID = :ID";
    $SQL = $CONN->prepare($SQL);
    $SQL->execute(array("ID" => $AdminCheck));
    $ProfileData = $SQL->fetch(PDO::FETCH_ASSOC);
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
    <title>Mint Game - Admin Settings</title>
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
        <li class="active"><a href="home.php"><span>Settings</span></a></li>
        <li><a href="products.php"><span>Products</span></a></li>
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
      <div class="col-sm-7 col-md-7 col-lg-7">
        <h3>General</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          <label>Site Name:</label>
          <input type="text" required class="form-control" name="SiteName" value="<?php echo $GeneralData["SiteName"];?>" maxlength="255">
          <label>Tagline:</label>
          <input type="text" class="form-control" name="Tagline" value="<?php echo $GeneralData["Tagline"];?>" maxlength="255">
          <label>Description:</label>
          <input type="text" class="form-control" name="Description" value="<?php echo $GeneralData["Description"];?>" maxlength="255">
          <label>Keywords:</label>
          <input type="text" class="form-control" name="Keywords" value="<?php echo $GeneralData["Keywords"];?>" maxlength="255">
          <label>About Us:</label>
          <textarea class="form-control" name="AboutUs" maxlength="1020"><?php echo $GeneralData["AboutUs"];?></textarea>
          <input type="submit" class="btn btn-success" name="GeneralSettings" value="Save Changes">
        </form>
      </div>
      <div class="col-sm-5 col-md-5 col-lg-5">
        <h3>Your profile</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          <label>Username:</label>
          <input type="text" readonly class="form-control" name="Username" value="<?php echo $ProfileData["Username"];?>">
          <label>Password:</label>
          <input type="password" required class="form-control" name="Password">
          <label>E Mail Address:</label>
          <input type="email" required class="form-control" name="EmailAddress" value="<?php echo $ProfileData["EmailAddress"];?>" maxlength="255">
          <input type="submit" class="btn btn-success" name="ProfileSettings" value="Save Changes">
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
