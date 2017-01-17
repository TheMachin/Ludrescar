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
include('../../bdd/bdd.php');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//poubelle
$form=new Formulaire("", "", "", "", "", "Fin", "", "");
$retour=new Retour(0, "", $form);
$stats=new Statistique(0, 0, 0, 0, 0, 0, 0);
$station=new Station(0, "", "", 0, $stats);
$type=new Type(0, "", 0, 0);
$vehicule=new Vehicule("", "", "", 0, "", "", 0, "", "", 1, "", $station, $type);
$compteU=new CompteUtilisateur(0, "");
$user=new Utilisateur(0, "", "", "", "", "", "", "", 0, $compteU);
$societe=new Societe(0, "");
$penalite=New Penalite(0, "Retard", 0);
$arrPenalite=new ArrayObject($penalite);
$location=new Location(0, "", "2017-01-10", "", "", "", "", "","", "", $vehicule, $user, $station, $station, $form, $retour, $societe, $arrPenalite);

$vehicule=$location->getVehicule();





if(isset($_POST['valid'])){
    
    //récupération des valeurs
    if($location->getEtatLocation()==="Terminé" || $location->getEtatLocation()==='Annulé'){
        sendError("Erreur : La location est déjà terminé");
    }
    
    if(!empty($_POST['etat'])){
        $etat=$_POST['etat'];
    }else{
        sendError("Erreur traitement formulaire : L'état du véhicule n'a pas été spécifié");
    }
    
    
    if(!empty($_POST['km'])){
        $km=$_POST['km'];
    }else{
        if($etat!=='v')
            sendError("Erreur traitement formulaire : Le nombre de kilométrage du véhicule n'a pas été spécifié");
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
    
    //formulaire de rendu
    $formR=new Formulaire(0, $etat, $km, $comm, $niv, "Rendu", NULL, NULL);
    
    $vehicule= getVehicules($immat, $bdd);
    $vehicule->setNiv_carbu($niv);
    $location= getLocations($idLoc, $bdd);
    //formulaire de l'état du lieu
    $formE=$location->getFormulaire();
    $arrPenalite=new ArrayObject();
    
    if($vehicule->getNb_km()>$formR->getKm()){
        //probleme
        sendError("Erreur : Le kilométrage spécifié ne doit pas être inférieure à celui du véhicule");
    }else{
        $vehicule->setNb_km($km);
        $form->setKm($km);
    }
    
    //on vérifie l'état du véhicule : S'il est Hors service, on lui inflige une pénalité
    if($etat==="hs"){
        $vehicule->setEtat("Hors service");
        $formR->setEtatVehicule("Hors service");
        $penalite=new Penalite(0, "Hors service", 0);
        $penalite->getBdDByNom($bdd);
        $arrPenalite->append($penalite);
        //pénélité
    }else{
        if($etat==="c"){
            $vehicule->setEtat("Correct");
            $formR->setEtatVehicule("Correct");
        }else if($etat==="be"){
            $vehicule->setEtat("En bon état");
            $formR->setEtatVehicule("En bon état");
        }
    }
    
    
    
    //on vérifie s'il est en retard, on augmente la pénalité par jour de retard
    $datePrevu=new DateTime($location->getDate_fin_prev());
    if($date>$datePrevu){
        //retard
        $nbRetard=$date->diff($datePrevu);
        $penalite=new Penalite(0, "Retard", 0);
        $penalite->getBdDByNom($bdd);
        $nbJourRetard=$nbRetard->format('%a');
        for($i=0;$i<int($nbJourRetard);$i++){
            $arrPenalite->append($penalite);
        }
    }
    
    //on vérifie le niveau de carburant du véhicule
    if($formE->getNiv_carbu()!==$formR->getNiv_carbu()){
        $penalite=new Penalite(0, "Carburant", 0);
        $penalite->getBdDByNom($bdd);
        $arrPenalite->append($penalite);
    }
    
    
    $date=new DateTime();
    $formR->setDate($date->format('d/m/Y'));
    
    $heure=date('H:i:s');
    $formR->setHeure($heure);
    //on insère le formulaire de retour dans la bdd et on récupère son id
    $idFormR=$formR->insert($bdd);
    $formR->setId($idFormR);
    //on insère le retour dans la bdd
    $retour->setDate_rendu($date);
    $retour->setFormulaire($formR);
    $retour->insert($bdd);
    //on met à jour la location dans l abdd
    $location->setRetour($retour);
    $vehicule->setCarburant($niv);
    $location->setVehicule($vehicule);
    $location->setRetour($retour);
    $location= calculMontant($location, $formR);
    $location->setMontant_penalite(calculMontantPenalite($arrPenalite, $location->getPrix_tot()));
    $location->setEtatLocation("Terminé");
    $location->updateFinLocation($bdd);
    //on met à jour la voiture
    $vehicule->updateEtat($bdd);
    $vehicule->updateNiv($bdd);
    $vehicule->updateKm($bdd);
    
    
}else{
    sendError("Erreur : Le formulaire n'a pas été validé");
}

    function sendError($msgError){
        $_SESSION['vehiculeRenduError']=$msgError;
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
        $location=new Location(row[0], $row[0], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], getVehicules($row[10], $bdd), $user, getStations($row[14], $bdd), getStations($row[15], $bdd), getForms($row[13], $bdd), new Retour(0, NULL, $form), $societe, $arrPenalite);
        return $location;
    }
    
    function getForms($id,$bdd){
            $requete="SELECT * FROM formulaires where id=$1";
            $result= pg_prepare($bdd,'',$requete);
            $result = pg_execute($bdd, "", array($id));
            while ($row = pg_fetch_row($result)) {
                $formulaire=new Formulaire($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7]);
            }
            return $formulaire;
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
        
    function calculMontant(Location $location,Formulaire $Rendu){
        //nb km
        $kmParcouru=$Rendu->getKm()-$location->getFormulaire()->$Elieu->getKm();
        //montant voiture km
        $voiture=$location->getVehicule();
        $type=$voiture->getType();
        $montantKmTotal=$type->getPrix_km()*$kmParcouru;
        //montant durée
        $dateDeb=new DateTime($location->getDate_deb());
        $dateFin=new DateTime($Rendu->getDate());
        $nbJour=$dateFin->diff($dateDeb);
        $montantJourTotal=$nbJour*$type->getPrix_jour();
        //ajout prix dans location
        $location->setPrix_duree($montantJourTotal);
        $location->setPrix_km($montantKmTotal);
        $location->setPrix_tot($montantJourTotal+$montantKmTotal);
        return $location;
    }
    
    function calculMontantPenalite(ArrayObject $arrPenalite,$montant){
        //nb km
        $montantPenalite=0;
        foreach ($arrPenalite as $penalite) {
            $montantPenalite=$montantPenalite+($montant*$penalite->getMontant());
        }
        return $montantPenalite;
        
    }