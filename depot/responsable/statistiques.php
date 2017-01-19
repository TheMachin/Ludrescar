
<?php
include('../../classe/Statistique.php');
session_start();
$bdd=NULL;
if(isset($_SESSION['co'])){
    if(!empty($_SESSION['login']) && !empty($_SESSION['mdp'])){
        $login=$_SESSION['login'];
        $mdp=$_SESSION['mdp'];
        $bdd= pg_connect("host=localhost port=5432 dbname=ludrescar user=".$login." password=".$mdp,PGSQL_CONNECT_FORCE_NEW);
    }else{
        header('Location:../index_employe.php');
    }
}else{
    header('Location:../index_employe.php');
}


$requete="SELECT nom From stations";
$result=pg_query($bdd,$requete);
$listStation=array();
while ($row = pg_fetch_row($result)) {
    $listStation[]=$row[0];
}
var_dump($listStation);

$requete="SELECT st.nb_location,st.nb_incident,st.nb_penalite,st.nb_entretien,st.montant_penalite,st.montant_total,st.nb_annulation,s.nom FROM stations s, statistiques st WHERE s.statistique_id=st.id";
$result=pg_query($bdd,$requete);
$tabStats=array();
while ($row = pg_fetch_row($result)) {
    $statistique=new Statistique(0, $row[0],$row[2],$row[3],$row[4],$row[5],$row[6]);
    $statistique->setNb_incident($row[1]);
    $tabStats[$row[7]]=$statistique;
}

$requete="SELECT COUNT(v.no_immat),s.nom FROM vehicules v, stations s WHERE s.id=v.station_id GROUP BY s.id";
$result=pg_query($bdd,$requete);
$tabVehiculeByStation=array();
$nbVehiculeTot=0;
while ($row = pg_fetch_row($result)) {
    $tabVehiculeByStation[$row[1]]=$row[0];
    $nbVehiculeTot=$nbVehiculeTot+$row[0];
}

$requete="SELECT COUNT(v.no_immat),s.nom FROM vehicules v, stations s WHERE s.id=v.station_id GROUP BY s.id";
$result=pg_query($bdd,$requete);
$tabVehiculeByStation=array();
$nbVehiculeTot=0;
while ($row = pg_fetch_row($result)) {
    $tabVehiculeByStation[$row[1]]=$row[0];
    $nbVehiculeTot=$nbVehiculeTot+$row[0];
}

$requete="SELECT COUNT(l.id),t.nom FROM vehicules v, types t, locations l WHERE l.vehicule_immat=v.no_immat AND v.type_id=t.id GROUP BY t.id";
$result=pg_query($bdd,$requete);
$nbType=array();
while ($row = pg_fetch_row($result)) {
    $nbType[]=[$row[1],$row[0]];
}

$requete="SELECT COUNT(e.id), t.nom,t.prenom FROM entretiens e, techniciens t WHERE e.technicien_id=t.id GROUP BY t.id";
$result=pg_query($bdd,$requete);
$nbEntretien=array();
while ($row = pg_fetch_row($result)) {
    $nbEntretien[]=[$row[1],$row[2],$row[0]];
}

$requete="SELECT COUNT(h.id), s.nom FROM stations s, histstationvehicules h WHERE h.station_id=s.id GROUP BY s.id";
$result=pg_query($bdd,$requete);
$deplacementByStation=array();
while ($row = pg_fetch_row($result)) {
    $deplacementByStation[$row[1]]=$row[0];
}


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
        <h3>Nombre de véhicule totale <?php echo $nbVehiculeTot;?></h3>
        <h3>Information par station</h3>
        <table  border='1'>
            <thead>
                <th>Nom Station</th>
                <th>Nombre de véhicule</th>
                <th>Chiffre d'affaire de la station</th>
                <th>Nombre de location</th>
                <th>Nombre de pénalités infligées</th>
                <th>Pourcentage d'incident</th>
                <th>Nombre d'entretiens cumulé des véhicules</th>
                <th>Nombre d'annulation de location</th>
                <th>Nombre de transfert</th>
            </thead>
            <tbody>
        <?php
            for($i=0;$i<count($listStation);$i++){
                $statistique=$tabStats[$listStation[$i]];
                ?>
                <tr>
                    <td><?php echo $listStation[$i]; ?></td>
                    <td><?php echo $tabVehiculeByStation[$listStation[$i]];?></td>
                    <td><?php echo $statistique->getMontant_total(); ?>€</td>
                    <td><?php echo $statistique->getNb_location(); ?></td>
                    <td><?php echo $statistique->getNb_penalite(); ?></td>
                    <td><?php echo round(($statistique->getNb_incident()/$nbVehiculeTot)*100,2); ?>%</td>
                    <td><?php echo $statistique->getNb_entretien(); ?></td>
                    <td><?php echo $statistique->getNb_annulation(); ?></td>
                    <td><?php echo $deplacementByStation[$listStation[$i]]; ?></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
        </table>
        
        <br>
        <h3>Nombre de locations en fonction du type de véhicule</h3>
        <table  border='1'>
            <thead>
                <th>Type de véhicule</th>
                <th>Nombre de fois loué</th>
            </thead>
            <tbody>
        <?php
            for($i=0;$i<count($nbType);$i++){
                ?>
                <tr>
                    <td><?php echo $nbType[$i][0]; ?></td>
                    <td><?php echo $nbType[$i][1]; ?></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
        </table>
        <br>
        <h3>Nombre d'entretien par technicien</h3>
        <table  border='1'>
            <thead>
                <th>Nom technicien</th>
                <th>Prénom technicien</th>
                <th>Nombre d'entretien</th>
            </thead>
            <tbody>
        <?php
            for($i=0;$i<count($nbEntretien);$i++){
                ?>
                <tr>
                    <td><?php echo $nbEntretien[$i][0]; ?></td>
                    <td><?php echo $nbEntretien[$i][1]; ?></td>
                    <td><?php echo $nbEntretien[$i][2]; ?></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
        </table>
    </body>
</html>
