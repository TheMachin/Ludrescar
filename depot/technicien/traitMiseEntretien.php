<?php
include('../../classe/Vehicule.php');
include('../../classe/Entretien.php');

include('../../classe/Technicien.php');
include('../../classe/CompteEmploye.php');
include('../../classe/Statistique.php');
include('../../classe/Station.php');
include('../../classe/Type.php');
session_start();
$bdd=NULL;
if(isset($_SESSION['co'])){
    if(!empty($_SESSION['login']) && !empty($_SESSION['mdp'])){
        $login=$_SESSION['login'];
        $mdp=$_SESSION['mdp'];
        $bdd= pg_connect("host=localhost port=5432 dbname=ludrescar user=".$login." password=".$mdp,PGSQL_CONNECT_FORCE_NEW);
        if(!empty($_SESSION['idT'])){
            $idT=$_SESSION['idT'];
        }else{
            echo "Nop";
            exit(0);
        }
    }else{
        header('Location:../index_employe.php');
    }
}else{
    header('Location:../index_employe.php');
}




$technicien=new Technicien($idT, "Siesta", "Pedro", new Station(15, "La station", "ché pas", 15, new Statistique(0, 0, 0, 0, 0, 0, 0)), new CompteEmploye(33, ""));
$technicien->getById($idT, $bdd);
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
        pg_query($bdd,"BEGIN") or die('Could not start transaction\n');
        $req1=$entretien->insertTrans($bdd);
        $req2=$vehicule->updateEtatTrans($bdd);
        if($req1 and $req2){
            pg_query($bdd,'COMMIT') or die('Transaction commit failed\n');
            sendError("Le véhicule a bien été mis en entretien");
        }else{
            pg_query($bdd,"ROLLBACK") or die('Transaction rollback failed\n ');
            sendError("Le véhicule a bien été mis en entretien");
        }
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
    pg_query($bdd,"BEGIN") or die('Could not start transaction\n');
    $req1=$vehicule->updateEtatTrans($bdd);
    if($req1){
        pg_query($bdd,'COMMIT') or die('Transaction commit failed\n');
        sendError("Le véhicule est disponible et son état est : Bon état");
    }else{
        pg_query($bdd,"ROLLBACK") or die('Transaction rollback failed\n ');
        sendError("Le véhicule n'a pas pu sortir de l'entretien (vérifier vos droits ou contacter votre responsable");
    }
    
}else{
    sendError("Erreur du formulaire : Veuillez recommencer");
}

    function sendError($msgError){
        $_SESSION['entretienMise']=$msgError;
        header("location:".  $_SERVER['HTTP_REFERER']); 
        exit(0);
    }

    function verifEtatVehicule($immat,$bdd){
        
        $requete="SELECT * FROM locations WHERE vehicule_immat=$1 AND etatlocation!='Annulé' AND etatlocation!='Terminé'";
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
            }else if($row[0]==="Supprimé"){
                return "Le véhicule ne peut pas être transféré car il est supprimé";
            }else if($row[0]==="Fin de service"){
                return "Le véhicule ne peut pas être transféré car il est en fin de servicet";
            }else{
                return NULL;
            }
        }else{
            return "Le véhicule ne peut pas être transféré car une location est en cours ou une location a été réservée";
        }
    }
    
