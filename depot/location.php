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
                                    if(!empty($_SESSION['location'])){
                                        echo "<h3>".$_SESSION['location']."</h3>";
                                        unset($_SESSION['location']);
                                    }
                                ?>
        <?php
        // put your code here
            $result = pg_prepare($bdd,"", "SELECT sa.nom, sa.adresse, sd.nom, sd.adresse,v.no_immat,v.modele,v.marque,v.puissance,v.nb_km,v.carburant,t.prix_km,t.prix_jour,l.date_deb,l.heure_deb,l.date_fin_prev,l.heure_fin,l.etatlocation,l.id,l.prix_tot,l.montant_penalite FROM locations l, stations sd, stations sa, vehicules v, types t WHERE utilisateur_id=$1 AND sa.id=l.station_arrivee_id AND sd.id=station_depart_id AND l.vehicule_immat=v.no_immat AND v.type_id=t.id");
            $result = pg_execute($bdd,'',array($utilisateur->getId()));
            if (!$result) {
              echo "Une erreur est survenue.\n";
              exit;
            }
            
        ?>
        <div class='container-fluid'>
                    <table id='tableID' class="table table-bordered table-striped" border='1'>
                        <thead>
                            <tr>
                                <th>Station de départ</th>
                                <th>Adresse de la station</th>
                                <th>Station d'arrivé</th>
                                <th>Adresse de la station</th>
                                <th>Prix total de la location</th>
                                <th>Montant des pénalités</th>
                                <th>Immatriculation</th>
                                <th>Modèle</th>
                                <th>Marque</th>
                                <th>puissance</th>
                                <th>kilométrage</th>
                                <th>Carburant</th>
                                <th>Prix kilométrique du véhicule</th>
                                <th>Prix jour du véhicule</th>
                                <th>Date début de location</th>
                                <th>Heure début de location</th>
                                <th>Date fin de location</th>
                                <th>Heure fin de location</th>
                                <th>Etat location</th>
                                <th>Formulaire</th>
                                <th>Annulation</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = pg_fetch_row($result)){
                            ?>
                            <tr>
                                <td><?php echo $row[0]; ?></td>
                                <td><?php echo $row[1]; ?></td>
                                <td><?php echo $row[2]; ?></td>
                                <td><?php echo $row[3]; ?></td>
                                <td><?php echo $row[18]; ?></td>
                                <td><?php echo $row[19]; ?></td>
                                <td><?php echo $row[4]; ?></td>
                                <td><?php echo $row[5]; ?></td>
                                <td><?php echo $row[6]; ?></td>
                                <td><?php echo $row[7]; ?></td>
                                <td><?php echo $row[8]; ?></td>
                                <td><?php echo $row[9]; ?></td>
                                <td><?php echo $row[10]; ?></td>
                                <td><?php echo $row[11]; ?></td>
                                <td><?php echo $row[12]; ?></td>
                                <td><?php echo $row[13]; ?></td>
                                <td><?php echo $row[14]; ?></td>
                                <td><?php echo $row[15]; ?></td>
                                <td><?php echo $row[16]; ?></td>
                                <?php
                                if($row[16]==="Réservé"){
                                    ?> <td><a href="<?php echo dirname($_SERVER["PHP_SELF"]).'/formEtatLieu.php?id='.$row[17]; ?>">Débuter la location</a></td>
                                    <td><a href="<?php echo dirname($_SERVER["PHP_SELF"]).'/annulerLocation.php?idLoc='.$row[17]; ?>">Annuler la location</a></td><?php
                                }else if($row[16]==="En cours"){
                                    ?> <th><a href="<?php echo dirname($_SERVER["PHP_SELF"]).'/formRendu.php?id='.$row[17]; ?>">Finir la location</a></th>
                                    <td>Annulation impossible</td><?php
                                }else{
                                    echo "<td></td><td></td>";
                                }
                                        
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
            </div>
    </body>
</html>
