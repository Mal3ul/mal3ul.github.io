<?php
class Session {
    private $id;
    private $batiment;
    private $nom;
    private $capacite;
    //private $sessions[];
    
    public function __construct($id, $batiment, $nom, $capacite){
        $this->id = $id;
        $this->batiment = $batiment;
        $this->nom = $nom;
        $this->capacite = $capacite;
    }
}
?>