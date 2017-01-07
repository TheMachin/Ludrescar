<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Location
 *
 * @author machin
 */
class Location {
    //put your code here
    private $id;
    private $date_deb;
    private $date_fin_prev;
    private $prix_duree;
    private $prix_km;
    private $montant_penalite;
    private $prix_tot;
    private $etatLocation;
    private $heure_deb;
    private $heure_fin;
    private $vehicule;
    private $utilisateur;
    private $stationDep;
    private $stationArr;
    private $Formulaire;
    private $retour;
    private $societe;
    private $penalite;

    function __construct($id, $date_deb, $date_fin_prev, $prix_duree, $prix_km, $montant_penalite, $prix_tot, $etatLocation, $heure_deb, $heure_fin, Vehicule $vehicule, Utilisateur $utilisateur, Station $stationDep, Station $stationArr, Formulaire $Formulaire, Retour $retour, Societe $societe, ArrayObject $penalite) {
        $this->id = $id;
        $this->date_deb = $date_deb;
        $this->date_fin_prev = $date_fin_prev;
        $this->prix_duree = $prix_duree;
        $this->prix_km = $prix_km;
        $this->montant_penalite = $montant_penalite;
        $this->prix_tot = $prix_tot;
        $this->etatLocation = $etatLocation;
        $this->heure_deb = $heure_deb;
        $this->heure_fin = $heure_fin;
        $this->vehicule = $vehicule;
        $this->utilisateur = $utilisateur;
        $this->stationDep = $stationDep;
        $this->stationArr = $stationArr;
        $this->Formulaire = $Formulaire;
        $this->retour = $retour;
        $this->societe = $societe;
        $this->penalite = $penalite;
    }
    
    function getId() {
        return $this->id;
    }

    function getDate_deb() {
        return $this->date_deb;
    }

    function getDate_fin_prev() {
        return $this->date_fin_prev;
    }

    function getPrix_duree() {
        return $this->prix_duree;
    }

    function getPrix_km() {
        return $this->prix_km;
    }

    function getMontant_penalite() {
        return $this->montant_penalite;
    }

    function getPrix_tot() {
        return $this->prix_tot;
    }

    function getEtatLocation() {
        return $this->etatLocation;
    }

    function getHeure_deb() {
        return $this->heure_deb;
    }

    function getHeure_fin() {
        return $this->heure_fin;
    }

    function getVehicule() {
        return $this->vehicule;
    }

    function getUtilisateur() {
        return $this->utilisateur;
    }

    function getStationDep() {
        return $this->stationDep;
    }

    function getStationArr() {
        return $this->stationArr;
    }

    function getFormulaire() {
        return $this->Formulaire;
    }

    function getRetour() {
        return $this->retour;
    }

    function getSociete() {
        return $this->societe;
    }

    function getPenalite() {
        return $this->penalite;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDate_deb($date_deb) {
        $this->date_deb = $date_deb;
    }

    function setDate_fin_prev($date_fin_prev) {
        $this->date_fin_prev = $date_fin_prev;
    }

    function setPrix_duree($prix_duree) {
        $this->prix_duree = $prix_duree;
    }

    function setPrix_km($prix_km) {
        $this->prix_km = $prix_km;
    }

    function setMontant_penalite($montant_penalite) {
        $this->montant_penalite = $montant_penalite;
    }

    function setPrix_tot($prix_tot) {
        $this->prix_tot = $prix_tot;
    }

    function setEtatLocation($etatLocation) {
        $this->etatLocation = $etatLocation;
    }

    function setHeure_deb($heure_deb) {
        $this->heure_deb = $heure_deb;
    }

    function setHeure_fin($heure_fin) {
        $this->heure_fin = $heure_fin;
    }

    function setVehicule(Vehicule $vehicule) {
        $this->vehicule = $vehicule;
    }

    function setUtilisateur(Utilisateur $utilisateur) {
        $this->utilisateur = $utilisateur;
    }

    function setStationDep(Station $stationDep) {
        $this->stationDep = $stationDep;
    }

    function setStationArr(Station $stationArr) {
        $this->stationArr = $stationArr;
    }

    function setFormulaire(Formulaire $Formulaire) {
        $this->Formulaire = $Formulaire;
    }

    function setRetour(Retour $retour) {
        $this->retour = $retour;
    }

    function setSociete(Societe $societe) {
        $this->societe = $societe;
    }

    function setPenalite(ArrayObject $penalite) {
        $this->penalite = $penalite;
    }



    
}
