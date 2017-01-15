<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Statistique
 *
 * @author machin
 */
class Statistique {
    //put your code here
    private $id;
    private $nb_location;
    private $nb_penalite;
    private $nb_entretien;
    private $montant_penalite;
    private $montant_total;
    private $nb_annulation;
    
    function __construct($id, $nb_location, $nb_penalite, $nb_entretien, $montant_penalite, $montant_total, $nb_annulation) {
        $this->id = $id;
        $this->nb_location = $nb_location;
        $this->nb_penalite = $nb_penalite;
        $this->nb_entretien = $nb_entretien;
        $this->montant_penalite = $montant_penalite;
        $this->montant_total = $montant_total;
        $this->nb_annulation = $nb_annulation;
    }

    function getId() {
        return $this->id;
    }

    function getNb_location() {
        return $this->nb_location;
    }

    function getNb_penalite() {
        return $this->nb_penalite;
    }

    function getNb_entretien() {
        return $this->nb_entretien;
    }

    function getMontant_penalite() {
        return $this->montant_penalite;
    }

    function getMontant_total() {
        return $this->montant_total;
    }

    function getNb_annulation() {
        return $this->nb_annulation;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNb_location($nb_location) {
        $this->nb_location = $nb_location;
    }

    function setNb_penalite($nb_penalite) {
        $this->nb_penalite = $nb_penalite;
    }

    function setNb_entretien($nb_entretien) {
        $this->nb_entretien = $nb_entretien;
    }

    function setMontant_penalite($montant_penalite) {
        $this->montant_penalite = $montant_penalite;
    }

    function setMontant_total($montant_total) {
        $this->montant_total = $montant_total;
    }

    function setNb_annulation($nb_annulation) {
        $this->nb_annulation = $nb_annulation;
    }

    
    
}
?>