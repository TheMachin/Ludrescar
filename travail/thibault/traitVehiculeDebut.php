<?php
include('../../classe/Formulaire.php');
include('../../classe/Location.php');
include('../../classe/Vehicule.php');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$location=new Location($id, $date_deb, $date_fin_prev, $prix_duree, $prix_km, $montant_penalite, $prix_tot, $etatLocation, $heure_deb, $heure_fin, $vehicule, $utilisateur, $stationDep, $stationArr, $Formulaire, $retour, $societe, $penalite);
$vehicule=new Vehicule($no_immat, $marque, $modele, $bn_place, $carburant, $puissance, $nb_km, $etat, $date_mise_serv, $duree_serv, $niv_carbu, $station, $type);
$vehicule=$location->getVehicule();
$form=new Formulaire($id, $etatVehicule, $km, $commentaire, $niv_carbu, "Début", $heure, $date);

$date=date("d/m/Y");
$form->setDate($date);
$heure=date('H:i:s');
$form->setHeure($heure);

if(isset($_POST['valid'])){
    if(!empty($_POST['etat'])){
        $etat=$_POST['etat'];
    }else{
        
    }
    
    if(!empty($_POST['km'])){
        $km=$_POST['km'];
    }else{
        
    }
    
    if(!empty($_POST['comm'])){
        $comm=$_POST['comm'];
    }else{
        
    }
    
    if(!empty($_POST['niv'])){
        $niv=$_POST['niv'];
    }else{
        
    }
    
    if($vehicule->getNb_km()<$km){
        //probleme
    }else{
        $vehicule->setNb_km($km);
        $form->setKm($km);
    }
    
    if($etat==="hs"){
        $vehicule->setEtat("Hors service");
        $form->setEtatVehicule("Hors service");
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
    
}
