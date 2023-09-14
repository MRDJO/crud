<?php
require_once("./utils/database.php");
require_once("./config/config.php");

//

try {

    $pdo = getDatabaseConnection($config["db_host"],$config["db_name"], $config["db_user"] , $config["db_password"]);

    $sql = 'CREATE TABLE IF NOT EXISTS etudiant(
        matricule int AUTO_INCREMENT PRIMARY KEY,
        nom varchar(255) NOT NULL,
        prenom varchar(255) NOT NULL,
        sexe varchar(10) NOT NULL,
        dateNaissance DATETIME NOT NULL,
        telephone INT(8) NOT NULL
    ); ';

    $pdo->exec($sql);

    echo 'TABLE ETUDIANT CRÉE AVEC SUCCÈS';
} catch (PDOException $e) {
    echo "Une erreur s'est produite $e";
}

