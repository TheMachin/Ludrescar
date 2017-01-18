<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Station
 *
 * @author machin
 */
class Station {
    //put your code here
    private $id;
    private $nom;
    private $adresse;
    private $nb_max_v;
    private $statistique;
    
    function __construct($id, $nom, $adresse, $nb_max_v, Statistique $statistique) {
        $this->id = $id;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->nb_max_v = $nb_max_v;
        $this->statistique = $statistique;
    }

        function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getAdresse() {
        return $this->adresse;
    }

    function getNb_max_v() {
        return $this->nb_max_v;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    function setNb_max_v($nb_max_v) {
        $this->nb_max_v = $nb_max_v;
    }

    function getStatistique() {
        return $this->statistique;
    }

    function setStatistique(Statistique $statistique) {
        $this->statistique = $statistique;
    }

        
    public function __toString() {
        
    }
    
    function getStationById($id,$bdd){
            $requete="SELECT * FROM stations where id=$1";
            $result= pg_prepare($bdd,'',$requete);
            $result = pg_execute($bdd, "", array($id));
            while ($row = pg_fetch_row($result)) {
                $station=new Station($row[0], $row[1], $row[2], $row[3], new Statistique($row[4], 0, 0, 0, 0, 0, 0));
            }
            return $station;
        }
        
        static function getStationByIdStatic($id,$bdd){
            $requete="SELECT * FROM stations where id=$1";
            $result= pg_prepare($bdd,'',$requete);
            $result = pg_execute($bdd, "", array($id));
            while ($row = pg_fetch_row($result)) {
                $station=new Station($row[0], $row[1], $row[2], $row[3], new Statistique($row[4], 0, 0, 0, 0, 0, 0));
            }
            return $station;
        }

}
?>