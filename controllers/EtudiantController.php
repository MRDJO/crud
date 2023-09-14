<?php

require_once("./repository/EtudiantRepository.php");


class EtudiantController{

    private $etudiantRepository;

    public function __construct($pdo)
    {
        $this->etudiantRepository = new EtudiantRepository($pdo);
    }

    public function getAll(){
        $etudiants = $this->etudiantRepository->getAllEtudiant();
        $response = [];
        foreach($etudiants as $etudiant){
            $response[] = [
                "matricule"=>$etudiant->getMatricule(),
                "nom"=>$etudiant->getNom(),
                "prenom"=>$etudiant->getPrenom(),
                "sexe"=>$etudiant->getSexe(),
                "dateNaissance"=>$etudiant->getDateNaissance(),
                "telephone"=>$etudiant->getTelephone()
            ];
        }
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        http_response_code(200);
        echo json_encode($response);
    }

    public function create(Etudiant $etudiant){
        $id = $this->etudiantRepository->createEtudiant($etudiant);
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST');
        http_response_code(201); 

        $etudiant = $this->etudiantRepository->getEtudiantById($id);

        $response = [
            "message" => "L'étudiant a été créer avec succès",
            'etudiant'=> [
                "matricule"=>$etudiant->getMatricule(),
                "nom"=>$etudiant->getNom(),
                "prenom"=>$etudiant->getPrenom(),
                "sexe"=>$etudiant->getSexe(),
                "dateNaissance"=>$etudiant->getDateNaissance(),
                "telephone"=>$etudiant->getTelephone()
            ]
        ];

        header('Access-Control-Allow-Origin: *');
        echo json_encode($response);
       
    }


    public function getEtudiantById(int $id){
        $etudiant = $this->etudiantRepository->getEtudiantById($id);
        header('Content-Type: application/json');
        http_response_code(200);

        $response = [
            "matricule"=>$etudiant->getMatricule(),
            "nom"=>$etudiant->getNom(),
            "prenom"=>$etudiant->getPrenom(),
            "sexe"=>$etudiant->getSexe(),
            "dateNaissance"=>$etudiant->getDateNaissance(),
            "telephone"=>$etudiant->getTelephone()
        ];

        header('Access-Control-Allow-Origin: *');
        echo json_encode($response);
    }

    public function deleteEtudiant(int $id)
    {
    
        $result = $this->etudiantRepository->deleteEtudiant($id);

        if($result){
            http_response_code(204);
        }else{
            header('Content-Type: application/json');
            http_response_code(500);
            $response = [
                "message"=>"L'étudiant $id n'existe pas "
            ];
            echo json_encode($response);
        }
    }

    public function updateEtudiant(int $id, $data){

        $result = $this->etudiantRepository->updateEtudiant($id, $data);
        header('Content-Type: application/json');
        http_response_code(200);

        $response = [
            "matricule"=>$result->getMatricule(),
            "nom"=>$result->getNom(),
            "prenom"=>$result->getPrenom(),
            "sexe"=>$result->getSexe(),
            "dateNaissance"=>$result->getDateNaissance(),
            "telephone"=>$result->getTelephone()
        ];

        echo json_encode($response);

    }
}
