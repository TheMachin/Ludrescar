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
    
    function __construct($id, $date_deb, $date_fin, $type_entretien, $vehicule, $technicien) {
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

    function setVehicule($vehicule) {
        $this->vehicule = $vehicule;
    }

    function setTechnicien($technicien) {
        $this->technicien = $technicien;
    }


    
}
