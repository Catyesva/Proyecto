<?php 
class Mensajeros
{
    private $mensajeros = array();
    function __construct(){
        $mensajeros[] = array('id'=>2,'name'=>'Juan Berrio');
        $mensajeros[] = array('id'=>1,'name'=>'Camilo Berrio');
        $mensajeros[] = array('id'=>3,'name'=>'Miguel Angel Lopez');
        $mensajeros[] = array('id'=>4,'name'=>'Lorena Sanchez');
        $mensajeros[] = array('id'=>5,'name'=>'Liliana Mora');

        $this->mensajeros = $mensajeros;
    }

    function listarMensajero(){
        return json_encode($this->mensajeros);
    }
}