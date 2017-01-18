<?php
session_start();
include('../classe/Formulaire.php');
include('../classe/Retour.php');
include('../classe/Location.php');
include('../classe/Vehicule.php');
include('../classe/Type.php');
include('../classe/Station.php');
include('../classe/Statistique.php');
include('../classe/Utilisateur.php');
include('../classe/CompteUtilisateur.php');
include('../classe/Societe.php');
include('../classe/Penalite.php');
include('../../bdd/bdd.php');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//poubelle
$form=new Formulaire(0, "", "", "", "", "Début", "", "");
$retour=new Retour(0, "", $form);
$stats=new Statistique(0, 0, 0, 0, 0, 0, 0);
$station=new Station(0, "", "", 0, $stats);
$type=new Type(0, "", 0, 0);
$vehicule=new Vehicule("", "", "", 0, "", "", 0, "", "", 1, "", $station, $type);
$compteU=new CompteUtilisateur(0, "");
$user=new Utilisateur(0, "", "", "", "", "", "", "", 0, $compteU);
$societe=new Societe(0, "");
$penalite=New Penalite(0, "", 0);
$arrPenalite=new ArrayObject($penalite);
$location=new Location(0, "", "2017-01-10", "", "", "", "", "","", "", $vehicule, $user, $station, $station, $form, $retour, $societe, $arrPenalite);


if(isset($_POST['valid'])){
    if(!empty($_POST['etat'])){
        $etat=$_POST['etat'];
    }else{
        sendError("Erreur traitement formulaire : L'état du véhicule n'a pas été spécifié");
    }
    
    
    
    if(!empty($_POST['km'])){
        $km=$_POST['km'];
    }else{
        sendError("Erreur : Le kilométrage du véhicule n'a pas été spécifié");
    }
    
    if(!empty($_POST['comm'])){
        $comm=$_POST['comm'];
    }else{
        $comm="";
    }
    
    if(!empty($_POST['idLoc'])){
        $idLoc=$_POST['idLoc'];
    }else{
        sendError("Erreur : le formulaire ne fonctionne pas bien, toutes nos excuses.");
    }
    
    if(!empty($_POST['niv'])){
        $niv=$_POST['niv'];
        if($niv=="p"){
            $niv="Plein";
        }else if($niv=="e"){
            $niv="Elevé";
        }else if($niv=="m"){
            $niv="Moitié";
        }else if($niv=="f"){
            $niv="Faible";
        }
    }else{
        sendError("Erreur traitement formulaire : Le niveau de carburant du véhicule n'a pas été spécifié");
    }
    
    
    $location= getLocations($idLoc, $bdd);
    
    $dateDeb=new DateTime($location->getDate_deb());

    $dateNow=new DateTime('now');
    
    if($dateNow<$dateDeb){
        sendError("La location ne peut pas commencer avant la date prévue");
    }
    
    $dateFinPrev=new DateTime($location->getDate_fin_prev());
    
    if($dateNow>$dateFinPrev){
        $location->setEtatLocation("Annulé");
        $location->updateEtat($bdd);
        sendError("La location ne peut pas commencer car vous avez dépassé la date limite de la location.");
    }
    
    $vehicule= getVehicules($location->getVehicule()->getNo_immat(), $bdd);
    if($vehicule->getNb_km()>$km){
        //probleme
        sendError("Erreur : Le kilométrage spécifié ne doit pas être inférieure à celui du véhicule");
    }else{
        $vehicule->setNb_km($km);
        $form->setKm($km);
    }
    
    if($etat==="hs"){
        $vehicule->setEtat("Hors service");
        $form->setEtatVehicule("Hors service");
        $location->setEtatLocation("Annulé");
        //fin de location car véhicule impraticable
        $vehicule->updateEtat($bdd);
        
    }else{
        if($etat==="c"){
            $vehicule->setEtat("Correct");
            $form->setEtatVehicule("Correct");
        }else if($etat==="be"){
            $vehicule->setEtat("Bon état");
            $form->setEtatVehicule("Bon état");
        }
    }
    
    $form->setNiv_carbu($niv);
    $form->setCommentaire($comm);
    $form->setType("Début");
    $vehicule->setCarburant($niv);
    
    //date et heure du moment
    $date=new DateTime();
    $form->setDate($date->format('Y-m-d'));
    $form->setHeure($date->format('H:i:s'));
    
    $form->setId($form->insert($bdd));
    //affectation location voiture, formulaire...
    $location->setFormulaire($form);
    $location->updateForm($bdd);
    $location->setEtatLocation("En cours");
    $location->updateEtat($bdd);
    //maj pour la voiture
    $vehicule->updateEtat($bdd);
    $vehicule->updateNiv($bdd);
    $vehicule->updateKm($bdd);
    
}else{
    sendError("Erreur : Le formulaire n'a pas été validé");
}

    function sendError($msgError){
        $_SESSION['vehiculeDebutError']=$msgError;
        header("location:".  $_SERVER['HTTP_REFERER']); 
        exit(0);
    }
    
    function getVehicules($id,$bdd){
        $requete="SELECT * FROM vehicules where no_immat=$1";
            $result= pg_prepare($bdd,'',$requete);
            $result = pg_execute($bdd, "", array($id));
            $row = pg_fetch_row($result);
            $vehicule=new Vehicule($row[0], $row[12], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], getStations($row[11], $bdd), getTypes($row[10], $bdd));
            return $vehicule;
    }
    
    function getLocations($id,$bdd){
        $compteU=new CompteUtilisateur(0, "");
        $user=new Utilisateur(0, "", "", "", "", "", "", "", 0, $compteU);
        $form=new Formulaire(0, "", "", "", "", "Début", "", "");
        $retour=new Retour(0, "", $form);
        $societe=new Societe(0, "");
        $penalite=New Penalite(0, "retard", 0);
        $arrPenalite=new ArrayObject($penalite);
        $requete="SELECT * FROM locations where id=$1";
        $result= pg_prepare($bdd,'',$requete);
        $result = pg_execute($bdd, "", array($id));
        $row = pg_fetch_row($result);
        $location=new Location($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], getVehicules($row[10], $bdd), $user, getStations($row[14], $bdd), getStations($row[15], $bdd), $form, new Retour(0, NULL, $form), $societe, $arrPenalite);
        return $location;
    }
    
    function getStations($id,$bdd){
            $requete="SELECT * FROM stations where id=$1";
            $result= pg_prepare($bdd,'',$requete);
            $result = pg_execute($bdd, "", array($id));
            while ($row = pg_fetch_row($result)) {
                $station=new Station($row[0], $row[1], $row[2], $row[3], new Statistique($row[4], 0, 0, 0, 0, 0, 0));
            }
            return $station;
    }
    
    function getTypes($id,$bdd){
            $requete="SELECT * FROM types where id=$1";
            $result= pg_prepare($bdd,'',$requete);
            $result = pg_execute($bdd, "", array($id));
            $type=NULL;
            while ($row = pg_fetch_row($result)) {
                $type=new Type($row[0], $row[1], $row[2], $row[3]);
            }
            return $type;
        }
