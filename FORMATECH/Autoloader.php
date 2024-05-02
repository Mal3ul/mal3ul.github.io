<?php

class Autoloader
{

    public static function register()
    {
        spl_autoload_register(['Autoloader','autoload']); 
    }

    public static function autoload($nom_classe){
        require "../classes/".$nom_classe.'.php';
    }   
}