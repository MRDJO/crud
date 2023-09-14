<?php

  require_once("./utils/database.php");
  require_once("./config/config.php");
  require_once("./controllers/EtudiantController.php");

  $pdo = getDatabaseConnection($config["db_host"],$config["db_name"], $config["db_user"] , $config["db_password"]);

  $etudiantController = new EtudiantController($pdo);

  if($_SERVER["REQUEST_METHOD"] === "GET"){
    $uri = $_SERVER["REQUEST_URI"];
    echo $uri;
  }else if($_SERVER["REQUEST_METHOD"] === "POST"){
    echo 'parfait';
  }else if ($_SERVER["REQUEST_METHOD"] === "DELETE"){
    echo 'on est en delete ';
  }else if($_SERVER["REQUEST_METHOD"] === "PUT"){
    echo 'on est en put ';
  }

?>