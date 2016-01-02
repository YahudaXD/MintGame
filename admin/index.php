<?php
  session_start();
  $ROOT = dirname(__FILE__);
  include $ROOT."/../config.php";
  if(isset($_SESSION["LoginAdmin"])) {
    header("location: home.php");
    exit();
  }
  if($_SERVER["REQUEST_METHOD"] === "POST") {
    $Username = $_POST["Username"];
    $Password = $_POST["Password"];
    try {
       $SQL = "SELECT ID, Password FROM Admins WHERE Username = :Username";
       $SQL = $CONN->prepare($SQL);
       $SQL->execute(array("Username" => $Username));
       $CountRows = $SQL->rowCount();
       $Result = $SQL->fetch(PDO::FETCH_ASSOC);
       $ID = $Result["ID"];
       $PasswordCheck = $Result["Password"];
       if($CountRows == "1" && password_verify($Password, $PasswordCheck)) {
         $_SESSION["LoginAdmin"]["ID"] = $ID;
         $CONN = null;
         header("location: home.php");
         exit();
       } else {
         $_SESSION["Error"][] = "You have entered wrong data!";
         $CONN = null;
         header("location: index.php");
         exit();
       }
    } catch(PDOException $e) {
       echo "Error: " . $e->getMessage();
    }
  }
  $CONN = null;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mint Game - Admin Login</title>
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
        </div>
      </div>
    </div>
    <div class="login">
      <div class="content">
        <h2>LOGIN</h2>
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          <label>Username:</label>
          <input type="text" class="form-control" name="Username">
          <label>Password:</label>
          <input type="password" class="form-control" name="Password">
          <input type="submit" class="btn btn-success" value="LOGIN">
        </form>
      </div>
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
