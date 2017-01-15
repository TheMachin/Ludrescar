<?php
include('../../classe/Vehicule.php');
include('../../classe/Technicien.php');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['valid'])){
    
    if(!empty($_POST['immat'])){
        $immat=$_POST['immat'];
    }else{
        
    }
    
    if(!empty($_POST['t'])){
        $t=$_POST['t'];
    }else{
        
    }
    
    if(!empty($_POST['deb'])){
        $deb=$_POST['deb'];
    }else{
        
    }
    
    if(!empty($_POST['end'])){
        $end=$_POST['end'];
    }else{
        
    }
    
    if(!empty($_POST['type'])){
        $typeE=$_POST['type'];
    }else{
        
    }
    
    $vehicule=new Vehicule($immat, $marque, $modele, $bn_place, $carburant, $puissance, $nb_km, $etat, $date_mise_serv, $duree_serv, $niv_carbu, $station, $type);
    $technicien=new Technicien($t, $nom, $prenom, $station, $compteE);
    
    //chercher valeur véhicule + technicien
    //Vérifier si véhicule peut etre entretenu
    
    $entretien=new Entretien($id, $deb, $end, $typeE, $vehicule, $technicien);
    
    //insérer entretien dans la bdd
    
}else{
    
}

    function verifEtatVehicule($vehicule,$bdd){
        $result= pg_prepare($bdd,"verifEtatVoiture",'SELECT ');
    }
    
    function insertEntretien($entretien,$bdd){
        
    }
    
    function updateVehicule($vehicule,$bdd){
        
    }
    
    function getTechnicien($id,$bdd){
        
    }
    
    function getVehicule($immat,$bdd){
        
    }