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
        <title>Liste des véhicules en cours de transfert</title>
    </head>
    <body>
        <?php
        // put your code here
            $result = pg_query($bdd, "SELECT * FROM vehicules where etat='Transfert'");
            if (!$result) {
              echo "Une erreur est survenue.\n";
              exit;
            }

            $tab = pg_fetch_all($result);
            
            $tab=getAllVehicule($tab,$bdd);
            ?>
            <div class='container-fluid'>
                    <label>Nombre de lignes : <?php echo count($tab); ?></label>
                    <table id='tableID' class="table table-bordered table-striped" border='1'>
                        <thead>
                            <tr>
                                <th>Immatriculation</th>
                                <th>Marque</th>
                                <th>Modèle</th>
                                <th>nombre de place</th>
                                <th>puissance</th>
                                <th>kilométrage</th>
                                <th>Etat</th>
                                <th>Date mise en service</th>
                                <th>Durée du service</th>
                                <th>niveau de carburant</th>
                                <th>Nom du type</th>
                                <th>Prix kilométrique</th>
                                <th>Prix jour</th>
                                <th>Transfert vers la station</th>
                                <th>Adresse de la station</th>
                                <th>Fin du transfert</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($tab as $row){
                            //$vehicule=new Vehicule($no_immat, $marque, $modele, $bn_place, $carburant, $puissance, $nb_km, $etat, $date_mise_serv, $duree_serv, $niv_carbu, $station, $type)
                            $vehicule =$row;
                            ?>
                            <tr>
                                <th><?php echo $vehicule->getNo_immat() ?></th>
                                <th><?php echo $vehicule->getMarque() ?></th>
                                <th><?php echo $vehicule->getModele() ?></th>
                                <th><?php echo $vehicule->getBn_place() ?></th>
                                <th><?php echo $vehicule->getPuissance() ?></th>
                                <th><?php echo $vehicule->getNb_km() ?></th>
                                <th><?php echo $vehicule->getEtat() ?></th>
                                <th><?php echo $vehicule->getDate_mise_serv() ?></th>
                                <th><?php echo $vehicule->getDuree_serv() ?></th>
                                <th><?php echo $vehicule->getNiv_carbu() ?></th>
                                <th><?php echo $vehicule->getType()->getNom() ?></th>
                                <th><?php echo $vehicule->getType()->getPrix_km() ?></th>
                                <th><?php echo $vehicule->getType()->getPrix_jour() ?></th>
                                <th><?php echo $vehicule->getStation()->getNom() ?></th>
                                <th><?php echo $vehicule->getStation()->getAdresse() ?></th>
                                <th></th>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
            </div>
    </body>
</html>

<?php
        function getAllVehicule($tab,$bdd){
            $array=array();
            foreach($tab as $row){
                $vehicule=new Vehicule($row['no_immat'], $row['marque'], $row['modele'], $row['nb_place'], $row['carburant'], $row['puissance'], $row['nb_km'], $row['etat'], $row['date_mise_serv'], $row['duree_serv'], $row['niv_carbu'], getStation($row['station_id'],$bdd), getTypes($row['type_id'],$bdd));
                $array[]=$vehicule;
            }
            return $array;
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
        
        function getStation($id,$bdd){
            $requete="SELECT * FROM stations where id=$1";
            $result= pg_prepare($bdd,'',$requete);
            $result = pg_execute($bdd, "", array($id));
            while ($row = pg_fetch_row($result)) {
                $station=new Station($row[0], $row[1], $row[2], $row[3], new Statistique($row[4], 0, 0, 0, 0, 0, 0));
            }
            return $station;
        }
        
        
        
?>