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
    

}else{
    
}


/*
DELETE FROM Vehicule
WHERE no_immat = $vehicule->no_immat
*/
?>

