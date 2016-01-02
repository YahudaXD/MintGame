<?php
  $ServerName = "localhost";
  $Username = "root";
  $Password = "";
  $DataBase = "GameHosting";

  try {
    $CONN = new PDO("mysql:host=$ServerName; dbname=$DataBase", $Username, $Password);
    $CONN->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
?>
