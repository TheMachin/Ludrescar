<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Entretien
 *
 * @author machin
 */
class Entretien {
    //put your code here
    private $id;
    private $date_deb;
    private $date_fin;
    private $type_entretien;
    private $vehicule;
    private $technicien;
    
    function __construct($id, $date_deb, $date_fin, $type_entretien, Vehicule $vehicule, Technicien $technicien) {
        $this->id = $id;
        $this->date_deb = $date_deb;
        $this->date_fin = $date_fin;
        $this->type_entretien = $type_entretien;
        $this->vehicule = $vehicule;
        $this->technicien = $technicien;
    }
    
    function getId() {
        return $this->id;
    }

    function getDate_deb() {
        return $this->date_deb;
    }

    function getDate_fin() {
        return $this->date_fin;
    }

    function getType_entretien() {
        return $this->type_entretien;
    }

    function getVehicule() {
        return $this->vehicule;
    }

    function getTechnicien() {
        return $this->technicien;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDate_deb($date_deb) {
        $this->date_deb = $date_deb;
    }

    function setDate_fin($date_fin) {
        $this->date_fin = $date_fin;
    }

    function setType_entretien($type_entretien) {
        $this->type_entretien = $type_entretien;
    }

    function setVehicule(Vehicule $vehicule) {
        $this->vehicule = $vehicule;
    }

    function setTechnicien(Technicien $technicien) {
        $this->technicien = $technicien;
    }

    function insert($bdd){
        $requete="INSERT INTO entretiens(date_deb,date_fin,type_entretien,technicien_id,vehicule_immat) VALUES($1,$2,$3,$4,$5)";
        $result= pg_prepare($bdd,'',$requete);
        $result = pg_execute($bdd, "", array($this->date_deb,$this->date_fin,$this->type_entretien,$this->technicien->getId(),$this->vehicule->getNo_immat()));
    }
    
    function insertTrans($bdd){
        $requete="INSERT INTO entretiens(date_deb,date_fin,type_entretien,technicien_id,vehicule_immat) VALUES($1,$2,$3,$4,$5)";
        $result= pg_prepare($bdd,'',$requete);
        $result = pg_execute($bdd, "", array($this->date_deb,$this->date_fin,$this->type_entretien,$this->technicien->getId(),$this->vehicule->getNo_immat()));
        return $result;
    }
    
}
?>