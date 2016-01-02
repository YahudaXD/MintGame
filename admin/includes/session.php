<?php
  $AdminCheck = $_SESSION["LoginAdmin"]["ID"];
  try {
    $SQL = "SELECT * FROM Admins WHERE ID = :ID";
    $SQL = $CONN->prepare($SQL);
    $SQL->execute(array("ID" => $AdminCheck));
    $Result = $SQL->fetch(PDO::FETCH_ASSOC);
    $LoginSession = $Result["Username"];
    if(!isset($LoginSession)){
      $CONN = null;
      header("location: index.php");
      exit();
    }
  } catch(PDOException $e) {
     echo "Error: " . $e->getMessage();
  }
?>
