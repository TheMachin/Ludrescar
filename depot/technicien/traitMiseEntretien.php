<?php
include('../../classe/Vehicule.php');
include('../../classe/Entretien.php');
include('../../bdd/bdd.php');
include('../../classe/Technicien.php');
include('../../classe/CompteEmploye.php');
include('../../classe/Statistique.php');
include('../../classe/Station.php');
include('../../classe/Type.php');
session_start();

$technicien=new Technicien(33, "Siesta", "Pedro", new Station(15, "La station", "ché pas", 15, new Statistique(0, 0, 0, 0, 0, 0, 0)), new CompteEmploye(33, ""));
$station=$technicien->getStation();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['valid'])){
    unset($_POST['valid']);
    if(!empty($_POST['immat'])){
        $immat=$_POST['immat'];
    }else{
        sendError("L'immatriculation du véhicule est introuvable");
    }
    
    
    
    if(!empty($_POST['deb'])){
        $deb=$_POST['deb'];
    }else{
        sendError("La date du début de l'entretien n'a pas été renseigné");
    }
    
    if(!empty($_POST['end'])){
        $end=$_POST['end'];
    }else{
        sendError("La date de fin de l'entretien n'a pas été renseigné");
    }
    
    if(!empty($_POST['type'])){
        $typeE=$_POST['type'];
    }else{
        sendError("Le type de l'entretien n'a pas été indiqué");
    }
    
    
    
    //chercher valeur véhicule + technicien
    //Vérifier si véhicule peut etre entretenu
    $vehicule=new Vehicule($immat, NULL, NULL, 0, NULL, 0, 0,NULL, NULL, 0, NULL, $station, new Type(0, NULL, 0, 0));
    $entretien=new Entretien(0, $deb, $end, $typeE, $vehicule, $technicien);
    
    $etat= verifEtatVehicule($vehicule->getNo_immat(), $bdd);
    if($etat==NULL){
        $vehicule->setEtat("En réparation");
        $entretien->setVehicule($vehicule);
        $entretien->insert($bdd);
        $vehicule->updateEtat($bdd);
        
        sendError("Le véhicule a bien été mis en entretien");
        
    }else{
        sendError($etat);
    }
    
    //insérer entretien dans la bdd
    
}else if(isset($_POST['validFin'])){
    unset($_POST['validFin']);
    if(!empty($_POST['immat'])){
        $immat=$_POST['immat'];
    }else{
        sendError("L'immatriculation du véhicule est introuvable");
    }
    
    $vehicule=new Vehicule($immat, NULL, NULL, 0, NULL, 0, 0, "Bon état",NULL, 0, NULL, $station, new Type(0, NULL, 0, 0));
    $vehicule->updateEtat($bdd);
    
    sendError("Le véhicule est disponible et son état est : Bon état");
    
}else{
    sendError("Erreur du formulaire : Veuillez recommencer");
}

    function sendError($msgError){
        $_SESSION['entretienMise']=$msgError;
        header("location:".  $_SERVER['HTTP_REFERER']); 
        exit(0);
    }

    function verifEtatVehicule($immat,$bdd){
        
        $requete="SELECT * FROM locations WHERE vehicule_immat=$1 AND (etatlocation='Annulé' OR etatlocation='Terminé')";
        $result= pg_prepare($bdd,'',$requete);
        $result = pg_execute($bdd, "", array($immat));
        $count= pg_num_rows($result);
        if($count==0){
            $requete="SELECT etat FROM vehicules where no_immat=$1";
            $result= pg_prepare($bdd,'',$requete);
            $result = pg_execute($bdd, "", array($immat));
            $row = pg_fetch_row($result);

            if($row[0]==="Hors service"){
                return "Le véhicule ne peut pas être transféré car il est hors service";
            }else if($row[0]==="En réparation"){
                return "Le véhicule ne peut pas être transféré car il est en entretien";
            }else if($row[0]==="Transfert"){
                return "Le véhicule ne peut pas être transféré car il est en cours de transfert";
            }else{
                return NULL;
            }
        }else{
            return "Le véhicule ne peut pas être transféré car une location est en cours ou une location a été réservée";
        }
    }