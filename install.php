<?php
  include "config.php";
  try {
    $SQL = "CREATE TABLE IF NOT EXISTS Admins (
      ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      Username VARCHAR(255) NOT NULL,
      Password VARCHAR(255) NOT NULL,
      EmailAddress VARCHAR(255)
    )";

    $CONN->exec($SQL);
    echo "Table Admins created successfully<br/>";
  } catch(PDOException $e) {
    echo $SQL . "<br>" . $e->getMessage();
  }

  try {
    $SQL = "CREATE TABLE IF NOT EXISTS Settings (
      SiteName VARCHAR(255) NOT NULL,
      Tagline VARCHAR(255) NOT NULL,
      Description VARCHAR(255) NOT NULL,
      Keywords VARCHAR(255) NOT NULL,
      AboutUs VARCHAR(1020) NOT NULL,
      MostPopular VARCHAR(255) NOT NULL,
      LastEdit TIMESTAMP
    )";

    $CONN->exec($SQL);
    echo "Table Settings created successfully<br/>";
  } catch(PDOException $e) {
    echo $SQL . "<br>" . $e->getMessage();
  }

  try {
    $SQL = "CREATE TABLE IF NOT EXISTS Prices (
      CS_16 VARCHAR(255) NOT NULL,
      SAMP VARCHAR(255) NOT NULL,
      Minecraft VARCHAR(255) NOT NULL,
      TS3 VARCHAR(255) NOT NULL,
      CS_16_Pack VARCHAR(510) NOT NULL,
      SAMP_Pack VARCHAR(510) NOT NULL,
      Minecraft_Pack VARCHAR(510) NOT NULL,
      TS3_Pack VARCHAR(510) NOT NULL,
      LastEdit TIMESTAMP
    )";

    $CONN->exec($SQL);
    echo "Table Prices created successfully<br/>";
  } catch(PDOException $e) {
    echo $SQL . "<br>" . $e->getMessage();
  }

  try {
    $SQL = "CREATE TABLE IF NOT EXISTS Orders (
      ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      FirstName VARCHAR(255) NOT NULL,
      LastName VARCHAR(255) NOT NULL,
      EmailAddress VARCHAR(255) NOT NULL,
      Address VARCHAR(255) NOT NULL,
      City VARCHAR(255) NOT NULL,
      Country VARCHAR(255) NOT NULL,
      ProductName VARCHAR(255) NOT NULL,
      ServerHostname VARCHAR(255) NOT NULL,
      SlotNumber VARCHAR(255) NOT NULL,
      Price VARCHAR(255) NOT NULL,
      Other VARCHAR(510) NOT NULL,
      OrderDate TIMESTAMP
    )";

    $CONN->exec($SQL);
    echo "Table Orders created successfully<br/>";
  } catch(PDOException $e) {
    echo $SQL . "<br>" . $e->getMessage();
  }

  try {
    $SQL = "SELECT * FROM Admins";
    $SQL = $CONN->prepare($SQL);
    $SQL->execute();
    $AdminsCount = $SQL->rowCount();
  } catch(PDOException $e) {
     echo "Error: " . $e->getMessage();
  }
  try {
    $SQL = "SELECT * FROM Settings";
    $SQL = $CONN->prepare($SQL);
    $SQL->execute();
    $SettingsCount = $SQL->rowCount();
  } catch(PDOException $e) {
     echo "Error: " . $e->getMessage();
  }
  try {
    $SQL = "SELECT * FROM Prices";
    $SQL = $CONN->prepare($SQL);
    $SQL->execute();
    $PricesCount = $SQL->rowCount();
  } catch(PDOException $e) {
     echo "Error: " . $e->getMessage();
  }

  if($AdminsCount == "0") {
    $Username = "Admin";
    $Password = "Password";
    $Password = password_hash($Password, PASSWORD_DEFAULT);
    try {
      $SQL = "INSERT INTO Admins (Username, Password) VALUES (:Username, :Password)";
      $SQL = $CONN->prepare($SQL);
      $SQL->execute(array("Username" => $Username, "Password" => $Password));
    } catch(PDOException $e) {
       echo "Error: " . $e->getMessage();
    }
  }
  if($SettingsCount == "0") {
    try {
      $SQL = "INSERT INTO Settings (SiteName, Tagline, MostPopular) VALUES (:SiteName, :Tagline, :MostPopular)";
      $SQL = $CONN->prepare($SQL);
      $SQL->execute(array("SiteName" => "Mint Game", "Tagline" => "Free Game Hosting Script", "MostPopular" => "CS_16"));
    } catch(PDOException $e) {
       echo "Error: " . $e->getMessage();
    }
  }
  if($PricesCount == "0") {
    try {
      $SQL = "INSERT INTO Prices (CS_16, SAMP, Minecraft, TS3, CS_16_Pack, SAMP_Pack, Minecraft_Pack, TS3_Pack) VALUES (:CS_16, :SAMP, :Minecraft, :TS3, :CS_16_Pack, :SAMP_Pack, :Minecraft_Pack, :TS3_Pack)";
      $SQL = $CONN->prepare($SQL);
      $SQL->execute(array("CS_16" => "0.00", "SAMP" => "0.00", "Minecraft" => "0.00", "TS3" => "0.00", "CS_16_Pack" => "12,14,16,18,20,22,24,26,28,30,32", "SAMP_Pack" => "25,50,100,150,200,250,300,350,450,500", "Minecraft_Pack" => "8,16,24,32,40,48", "TS3_Pack" => "10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100"));
    } catch(PDOException $e) {
       echo "Error: " . $e->getMessage();
    }
  }
?>
