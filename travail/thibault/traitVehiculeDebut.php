<?php
session_start();
include('../../classe/Formulaire.php');
include('../../classe/Retour.php');
include('../../classe/Location.php');
include('../../classe/Vehicule.php');
include('../../classe/Type.php');
include('../../classe/Station.php');
include('../../classe/Statistique.php');
include('../../classe/Utilisateur.php');
include('../../classe/CompteUtilisateur.php');
include('../../classe/Societe.php');
include('../../classe/Penalite.php');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$form=new Formulaire("", "", "", "", "", "Début", "", "");
$retour=new Retour(0, "", $form);
$stats=new Statistique(0, 0, 0, 0, 0, 0, 0);
$station=new Station(0, "", "", 0, $stats);
$type=new Type(0, "", 0, 0);
$vehicule=new Vehicule("", "", "", 0, "", "", 0, "", "", 1, "", $station, $type);
$compteU=new CompteUtilisateur(0, "");
$user=new Utilisateur(0, "", "", "", "", "", "", "", 0, $compteU);
$societe=new Societe(0, "");
$penalite=New Penalite(0, "retard", 0);
$arrPenalite=new ArrayObject($penalite);
$location=new Location(0, "", "2017-01-10", "", "", "", "", "","", "", $vehicule, $user, $station, $station, $form, $retour, $societe, $arrPenalite);

$date=date("d/m/Y");
$form->setDate($date);
$heure=date('H:i:s');
$form->setHeure($heure);

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
    
    if(!empty($_POST['niv'])){
        $niv=$_POST['niv'];
    }else{
        sendError("Erreur traitement formulaire : Le niveau de carburant du véhicule n'a pas été spécifié");
    }
    
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
    }else{
        if($etat==="c"){
            $vehicule->setEtat("Correcte");
            $form->setEtatVehicule("Correcte");
        }else if($etat==="be"){
            $vehicule->setEtat("En bon état");
            $form->setEtatVehicule("En bon état");
        }
    }
    
    $form->setNiv_carbu($niv);
    $vehicule->setCarburant($niv);
    
    $location->setVehicule($vehicule);
    $location->setFormulaire($form);
    
}else{
    sendError("Erreur : Le formulaire n'a pas été validé");
}

    function sendError($msgError){
        $_SESSION['vehiculeDebutError']=$msgError;
        header("location:".  $_SERVER['HTTP_REFERER']); 
        exit(0);
    }
    
    function getVehicule($id){
        
    }
    
    function insertFormulaire($form){
        
    }
    
    function updateLocation($loc){
        
    }
    
    function updateVehicule($vehicule){
        
    }
