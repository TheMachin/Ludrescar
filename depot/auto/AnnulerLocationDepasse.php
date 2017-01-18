<?php
include('../../bdd/bdd.php');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$requete="SELECT id,utilisateur_id FROM locations WHERE etatlocation='Réservé' AND date_fin_prev::date<current_date";
$result= pg_query($bdd,$requete);

while ($row = pg_fetch_row($result)) {
    echo $row[0];
    prevenirClient($row[1]);
    /**/
}

    $requete="UPDATE locations SET etatlocation='Annulé' where date_fin_prev::date<current_date AND etatlocation='Réservé'";
    $result= pg_prepare($bdd,'',$requete);
    $result = pg_execute($bdd, "", array());

function prevenirClient($id){
    //liste opération pour contacter le client par mail ou par SMS
}