<?php
include('Employe.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Technicien
 *
 * @author machin
 */
class Technicien extends Employe{
    //put your code here
    function getById($id,$bdd){
            $requete="SELECT t.id,t.nom,t.prenom,e.station_id FROM techniciens t, employes e where t.id=$1 AND t.id=e.id";
            $result= pg_prepare($bdd,'',$requete);
            $result = pg_execute($bdd, "", array($id));
            while ($row = pg_fetch_row($result)) {
                
                $techicien=new Technicien($row[0], $row[1], $row[2], Station::getStationByIdStatic($row[3], $bdd), new CompteEmploye(0, NULL));
            }
            return $techicien;
        }
}
?>