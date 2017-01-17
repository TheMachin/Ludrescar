<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CompteEmploye
 *
 * @author machin
 */
class CompteEmploye {
    //put your code here
    private $id;
    private $login;
    
    function __construct($id, $login) {
        $this->id = $id;
        $this->login = $login;
    }
    
    function getId() {
        return $this->id;
    }

    function getLogin() {
        return $this->login;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLogin($login) {
        $this->login = $login;
    }



}
?>