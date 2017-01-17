<?php
    session_start();
    include('../../bdd/bdd.php');
    include('../classe/Utilisateur.php');
    
    $utilisateur= unserialize($_SESSION['utilisateur']);
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
        <title></title>
    </head>
    <body>
        <h1>Liste des locations</h1>
        
        <?php
        // put your code here
            $result = pg_prepare($bdd,"", "SELECT sa.nom, sa.adresse, sd.nom, sd.adresse,v.no_immat,v.modele,v.marque,v.puissance,v.nb_km,v.carburant,t.prix_km,t.prix_jour,l.date_deb,l.heure_deb,l.date_fin_prev,l.heure_fin,l.etatlocation FROM locations l, stations sd, stations sa, vehicules v, types t WHERE utilisateur_id=$1 AND sa.id=l.station_arrivee_id AND sd.id=station_depart_id AND l.vehicule_immat=v.no_immat AND v.type_id=t.id");
            $result = pg_execute($bdd,'',array($utilisateur->getId()));
            if (!$result) {
              echo "Une erreur est survenue.\n";
              exit;
            }
            while ($row = pg_fetch_row($result)) {
                $station=new Station($row[0], $row[1], $row[2], $row[3], new Statistique($row[4], 0, 0, 0, 0, 0, 0));
            }
        ?>
        <div class='container-fluid'>
                    <label>Nombre de lignes : <?php echo count($tab); ?></label>
                    <table id='tableID' class="table table-bordered table-striped" border='1'>
                        <thead>
                            <tr>
                                <th>Station de départ</th>
                                <th>Adresse de la station</th>
                                <th>Station d'arrivé</th>
                                <th>Adresse de la station</th>
                                <th>Immatriculation</th>
                                <th>Modèle</th>
                                <th>Marque</th>
                                <th>puissance</th>
                                <th>kilométrage</th>
                                <th>Carburant</th>
                                <th>Prix kilométrique</th>
                                <th>Prix jour</th>
                                <th>Date début de location</th>
                                <th>Heure début de location</th>
                                <th>Date fin de location</th>
                                <th>Heure fin de location</th>
                                <th>Formulaire</th>
                                
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
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
            </div>
    </body>
</html>
