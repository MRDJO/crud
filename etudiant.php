<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once("./utils/database.php");
  require_once("./config/config.php");
  require_once("./models/Etudiant.php");
  require_once("./controllers/EtudiantController.php");

  $pdo = getDatabaseConnection($config["db_host"],$config["db_name"], $config["db_user"] , $config["db_password"]);

  $etudiantController = new EtudiantController($pdo);
  
  header('Access-Control-Allow-Methods: GET, POST');

  if($_SERVER["REQUEST_METHOD"] === "GET"){
    $uri = $_SERVER["REQUEST_URI"];

    if(isset($_GET["id"])){
      $etudiantController->getEtudiantById($_GET["id"]);
      return;
    }
    
    $etudiantController->getAll();
    
  }else if($_SERVER["REQUEST_METHOD"] === "POST"){

    $data = json_decode(file_get_contents('php://input'), true);


    if(!isset($data["nom"])){
      http_response_code(400); 
      echo json_encode(["error" cc=> "Champ 'nom' manquant dans le corps de la requête."]);
      return;
    }

    if(!isset($data["prenom"])){
      http_response_code(400); 
      echo json_encode(["error" => "Champ 'prenom' manquant dans le corps de la requête."]);
      return;
    }

    if(!isset($data["sexe"])){
      http_response_code(400); 
      echo json_encode(["error" => "Champ 'sexe' manquant dans le corps de la requête."]);
      return;
    }

    if(!isset($data["dateNaissance"])){
      http_response_code(400); 
      echo json_encode(["error" => "Champ 'dateNaissance' manquant dans le corps de la requête."]);
      return;
    }

    if(!isset($data["telephone"])){
      http_response_code(400); 
      echo json_encode(["error" => "Champ 'telephone' manquant dans le corps de la requête."]);
      return;
    }

    $etudiantController->create(new Etudiant(0, $data["nom"], $data["prenom"], $data["sexe"], $data["dateNaissance"], $data["telephone"]));

  }else if ($_SERVER["REQUEST_METHOD"] === "DELETE"){
    if(isset($_GET["id"])){
      $etudiantController->deleteEtudiant($_GET["id"]);
    }
  }else if($_SERVER["REQUEST_METHOD"] === "PUT"){
    if(isset($_GET["id"])){
      $data = json_decode(file_get_contents('php://input'), true);
      $etudiantController->updateEtudiant($_GET["id"], $data); 
    }
  }

?>
