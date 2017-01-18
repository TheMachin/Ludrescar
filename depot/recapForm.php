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

if(empty($_SESSION['location'])){
    header('Location:index.php');
    exit(0);
}

$location= unserialize($_SESSION['location']);
unset($_SESSION['location']);
//$location=new Location($id, $date_deb, $date_fin_prev, $prix_duree, $prix_km, $montant_penalite, $prix_tot, $etatLocation, $heure_deb, $heure_fin, $vehicule, $utilisateur, $stationDep, $stationArr, $Formulaire, $retour, $societe, $penalite);
$vehicule=$location->getVehicule();
//$vehicule=new Vehicule($no_immat, $marque, $modele, $bn_place, $carburant, $puissance, $nb_km, $etat, $date_mise_serv, $duree_serv, $niv_carbu, $station, $type);
$type=$vehicule->getType();
//$type=new Type($id, $nom, $prix_km, $prix_jour);
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Récapitulation du formulaire</title>
    </head>
    <body>
        <h3>Récapitulation du formulaire</h3>
        <div>
            <label>
                La location est maintenant "<?php echo $location->getEtatLocation(); ?>"
            </label>
            <br>
            <label>
                Véhicule loué : <?php echo $vehicule->getMarque()." ".$vehicule->getModele(); ?>
            </label>
            <br>
            <label>
                L'état du véhicule : <?php echo $vehicule->getEtat(); ?>
            </label>
            <br>
            <label>
                Prix kilométrique : <?php echo $type->getPrix_km(); ?>€. Prix par jour de la voiture : <?php echo $type->getPrix_jour(); ?>€
            </label>
            <br>
            <label>
                Montant des pénalités : <?php echo $location->getMontant_penalite(); ?>€
            </label>
            <br>
            <label>
                Prix total de la location : <?php echo $location->getPrix_tot(); ?>€
            </label>
            <br>
        </div>
        <div>
            <a href="<?php echo dirname($_SERVER["PHP_SELF"]).'/location.php'; ?>">Mes locations</a>
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
