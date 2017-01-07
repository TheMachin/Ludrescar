<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Vehicule
 *
 * @author machin
 */
class Vehicule {
    //put your code here
    private $no_immat;
    private $marque;
    private $modele;
    private $bn_place;
    private $carburant;
    private $puissance;
    private $nb_km;
    private $etat;
    private $date_mise_serv;
    private $duree_serv;
    private $niv_carbu;
    private $station;
    private $type;
    
    function __construct($no_immat, $marque, $modele, $bn_place, $carburant, $puissance, $nb_km, $etat, $date_mise_serv, $duree_serv, $niv_carbu, Station $station, Type $type) {
        $this->no_immat = $no_immat;
        $this->marque = $marque;
        $this->modele = $modele;
        $this->bn_place = $bn_place;
        $this->carburant = $carburant;
        $this->puissance = $puissance;
        $this->nb_km = $nb_km;
        $this->etat = $etat;
        $this->date_mise_serv = $date_mise_serv;
        $this->duree_serv = $duree_serv;
        $this->niv_carbu = $niv_carbu;
        $this->station = $station;
        $this->type = $type;
    }

        function getNo_immat() {
        return $this->no_immat;
    }

    function getMarque() {
        return $this->marque;
    }

    function getModele() {
        return $this->modele;
    }

    function getBn_place() {
        return $this->bn_place;
    }

    function getCarburant() {
        return $this->carburant;
    }

    function getPuissance() {
        return $this->puissance;
    }

    function getNb_km() {
        return $this->nb_km;
    }

    function getEtat() {
        return $this->etat;
    }

    function getDate_mise_serv() {
        return $this->date_mise_serv;
    }

    function getDuree_serv() {
        return $this->duree_serv;
    }

    function getNiv_carbu() {
        return $this->niv_carbu;
    }

    function getStation() {
        return $this->station;
    }

    function setNo_immat($no_immat) {
        $this->no_immat = $no_immat;
    }

    function setMarque($marque) {
        $this->marque = $marque;
    }

    function setModele($modele) {
        $this->modele = $modele;
    }

    function setBn_place($bn_place) {
        $this->bn_place = $bn_place;
    }

    function setCarburant($carburant) {
        $this->carburant = $carburant;
    }

    function setPuissance($puissance) {
        $this->puissance = $puissance;
    }

    function setNb_km($nb_km) {
        $this->nb_km = $nb_km;
    }

    function setEtat($etat) {
        $this->etat = $etat;
    }

    function setDate_mise_serv($date_mise_serv) {
        $this->date_mise_serv = $date_mise_serv;
    }

    function setDuree_serv($duree_serv) {
        $this->duree_serv = $duree_serv;
    }

    function setNiv_carbu($niv_carbu) {
        $this->niv_carbu = $niv_carbu;
    }

    function setStation(Station $station) {
        $this->station = $station;
    }

    function getType() {
        return $this->type;
    }

    function setType(Type $type) {
        $this->type = $type;
    }


    
}
