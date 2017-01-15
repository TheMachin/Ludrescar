<?php
include('../classe/Station.php');
include('../classe/Location.php');
include('../classe/Vehicule.php');

// requete : on selectionne tout les véhicule disponible de la station (qui ne sont pas reservé ou en location)
// ensuite on affiche les véhicules dispo contenant un bouton pour reserver le véhicule

$station=new Station($id, $nom, $adresse, $nb_max_v, $statistique);
$location=new Location($id, $date_deb, $date_fin_prev, $prix_duree, $prix_km, $montant_penalite, $prix_tot, $etatLocation, $heure_deb, $heure_fin, $vehicule, $utilisateur, $stationDep, $stationArr, $Formulaire, $retour, $societe, $penalite);
$vehicule=new Vehicule($no_immat, $marque, $modele, $bn_place, $carburant, $puissance, $nb_km, $etat, $date_mise_serv, $duree_serv, $niv_carbu, $station, $type);

$date=date("d/m/Y");
$heure=date('H:i:s');

if(isset($_POST['valid'])){
    if(!empty($_POST['station'])){
        $station=$_POST['station'];
    }else{
        
    }
    
    if(!empty($_POST['dateDeb'])){
        $dateDeb=$_POST['dateDeb'];
    }else{
        
    }
    
    if(!empty($_POST['hDeb'])){
        $hDeb=$_POST['hDeb'];
    }else{
        
    }
    
    if(!empty($_POST['dateRet'])){
        $dateRet=$_POST['dateRet'];
    }else{
        
    }
    
    if(!empty($_POST['hRet'])){
        $hRet=$_POST['hRet'];
    }else{

    }
    

}else{
    
}
//liaison station vehicule, on boucle tant que non vide pour afficher chaque véhicule dispo
?>