<?php
include('../../classe/Station.php');
include('../../classe/Location.php');
include('../../classe/Vehicule.php');

// requete : on selectionne tout les véhicule disponible de la station (qui ne sont pas reservé ou en location)
// ensuite on affiche les véhicules dispo contenant un bouton pour reserver le véhicule

$vehicule=new Vehicule($no_immat, $marque, $modele, $bn_place, $carburant, $puissance, $nb_km, $etat, $date_mise_serv, $duree_serv, $niv_carbu, $station, $type);

$date=date("d/m/Y");
$heure=date('H:i:s');

if(isset($_POST['valider'])){
    if(!empty($_POST['noImmat'])){
        $no_immat=$_POST['noImmat'];
    }else{
        
    }
    
    if(!empty($_POST['marque'])){
        $marque=$_POST['marque'];
    }else{
        
    }
    
    if(!empty($_POST['modele'])){
        $modele=$_POST['modele'];
    }else{
        
    }
    
    if(!empty($_POST['nbPlace'])){
        $bn_place=$_POST['nbPlace'];
    }else{
        
    }
    
    if(!empty($_POST['carburant'])){
        $carburant=$_POST['carburant'];
    }else{

    }

    if(!empty($_POST['puissance'])){
        $puissance=$_POST['puissance'];
    }else{

    }

    if(!empty($_POST['nbKm'])){
        $nb_km=$_POST['nbKm'];
    }else{

    }

    if(!empty($_POST['etat'])){
        $etat=$_POST['etat'];
    }else{

    }

    if(!empty($_POST['nivCarburant'])){
        $niv_carbu=$_POST['nivCarburant'];
    }else{

    }
    

}else{
    
}

/*
INSERT INTO Vehicule (no_immat, marque, modele, nb_place, carburant, puissance, nb_km, etat, niv_carbu)
VALUES ($vehicule->no_immat, $vehicule->marque, $vehicule->modele, $vehicule->nb_place, $vehicule->carburant, $vehicule->puissance, $vehicule->nb_km, $vehicule->etat, $vehicule->niv_carbu)
*/

?>