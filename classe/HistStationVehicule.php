<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HistStationVehicule
 *
 * @author machin
 */
class HistStationVehicule {
    //put your code here
    private $id;
    private $date;
    private $description;
    private $station;
    private $vehicule;
    
    function __construct($id, $date, $description, Station $station, Vehicule $vehicule) {
        $this->id = $id;
        $this->date = $date;
        $this->description = $description;
        $this->station = $station;
        $this->vehicule = $vehicule;
    }
    
    function getId() {
        return $this->id;
    }

    function getDate() {
        return $this->date;
    }

    function getDescription() {
        return $this->description;
    }

    function getStation() {
        return $this->station;
    }

    function getVehicule() {
        return $this->vehicule;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setStation(Station $station) {
        $this->station = $station;
    }

    function setVehicule(Vehicule $vehicule) {
        $this->vehicule = $vehicule;
    }



}
