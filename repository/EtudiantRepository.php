<?php

require_once("./config/config.php");


class EtudiantRepository{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllEtudiant()
    {
        $sql = "SELECT * FROM etudiant ORDER BY matricule DESC ";
        
        try {
            $result = $this->pdo->query($sql);

            $etudiants = [];

            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                $etudiant = new Etudiant($row["matricule"], $row["nom"],$row["prenom"], $row["sexe"], $row["dateNaissance"], $row["telephone"]);
                $etudiants[] = $etudiant;
            }
            return $etudiants;
        } catch (PDOException $e) {
            echo "Une erreur s'est produite lors de la récupération de la liste des étudiants".$e->getMessage();
            return [];       
        }
       

    }

    public function getEtudiantById($id)
    {

        $sql = "SELECT * FROM etudiant WHERE matricule = :id";

        try {
            $query = $this->pdo->prepare($sql);
            $query->bindParam(":id", $id, PDO::PARAM_INT);
            $query->execute();

            $data = $query->fetch(PDO::FETCH_ASSOC) ;

            

            return new Etudiant($data["matricule"], $data["nom"], $data["prenom"],$data["sexe"] ,$data["dateNaissance"], $data["telephone"]);
        } catch (PDOException $e) {
            echo "Une erreur s'est produite  ".$e->getMessage();
        }

    }


    public function createEtudiant(Etudiant $etudiant){

        $req = "

            INSERT INTO etudiant(nom, prenom, sexe, dateNaissance, telephone) VALUES (:nom, :prenom , :sexe , :dateNaissance , :telephone)

        ";
        try {

            $nom = $etudiant->getNom();
            $prenom = $etudiant->getPrenom();
            $sexe = $etudiant->getSexe();
            $dateNaissance = $etudiant->getDateNaissance();
            $telephone = $etudiant->getTelephone();

            $sql = $this->pdo->prepare($req);
            $sql->bindParam(":nom", $nom, PDO::PARAM_STR);
            $sql->bindParam(":prenom", $prenom, PDO::PARAM_STR);
            $sql->bindParam(":sexe", $sexe, PDO::PARAM_STR);
            $sql->bindParam(":dateNaissance", $dateNaissance, PDO::PARAM_STR);
            $sql->bindParam(":telephone", $telephone, PDO::PARAM_INT);
            $sql->execute();

            $userId = $this->pdo->lastInsertId();

            return $userId;

        } catch (PDOException $e) {
            echo "Une erreur s'est produite  ".$e->getMessage();
        }

    }


    public function deleteEtudiant($id): bool
    {
        $sql = "DELETE FROM etudiant WHERE matricule = :id";

        try {
            $query = $this->pdo->prepare($sql);
            $query->bindParam(":id", $id, PDO::PARAM_INT);
            $query->execute();
            if($query->rowCount() === 1){
                return true;
            }else{
                return false;
            }

        } catch (PDOException $e) {
            echo "Une erreur s'est produite  ".$e->getMessage();
            return false;
        }
    }


    public function updateEtudiant($id, $data)
    {
        $sql = "UPDATE etudiant SET ";

        $updatesColumns = [];

        foreach ($data as $key => $value) {
            $sql .= " $key = :$key, ";
            $updatesColumns[":$key"] = $value;
        }

        $sql = substr($sql, 0, -2); // Supprime la virgule finale

        $sql .= " WHERE matricule = :id";

        try {
            $query = $this->pdo->prepare($sql);
            
            // Liez les paramètres aux valeurs correspondantes en utilisant bindValue
            foreach ($updatesColumns as $key => $value) {
                $query->bindValue($key, $value);
            }
            
            $query->bindParam(":id", $id, PDO::PARAM_INT);
            
            $query->execute();

            return $this->getEtudiantById($id);
        } catch (PDOException $e) {
            echo "Une erreur s'est produite " . $e->getMessage();
        }
    }

    
}
