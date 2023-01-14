<?php 
class Mensajeros
{
    private $mensajeros = array();
    function __construct(){
        $mensajeros[] = array('id'=>2,'name'=>'Juan Berrio');
        $mensajeros[] = array('id'=>1,'name'=>'Camilo berrio');
        $this->mensajeros = $mensajeros;
    }

    function listarMensajero(){
        return json_encode($this->mensajeros);
    }
}