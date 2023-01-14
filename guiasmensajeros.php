<?php 
session_start();
class guiasMensajeros
{

    function setvalues($data){
        if(!isset($_SESSION['data']))$_SESSION['data'] = array();
        if(array_key_exists($data['idmensajero'],$_SESSION['data'])) {
            array_push($_SESSION['data'][$data['idmensajero']]['guias'],$data['idguia']);       
        }else{
            $this->iniciarData($data);
        }
    }
    function iniciarData($data){
        $guias[]=$data['idguia'];
        $array = array('idmensajero'=>$data['idmensajero'],'guias'=>$guias);
        $_SESSION['data'][$data['idmensajero']]=$array;
    }

    function generartxt($guias){
        $archivo= 'ASIGNACION_'.date('YmdHi').'.txt';
        $file = fopen($archivo, "w");
        fwrite($file, 'GUIA'. PHP_EOL);        
        foreach ($guias as $guia) {
            fwrite($file,$guia. PHP_EOL);
        }
        fclose($file);
        return $archivo;
    }

}


$menj = new guiasMensajeros();
if($_REQUEST['op']==1){
    $rutaArchivo = '';
    $mensajeros = $menj->setvalues($_REQUEST);
}elseif($_REQUEST['op']==3){
    session_destroy();
}else{
    $data = $_SESSION['data'][$_REQUEST['idmensajero']]['guias'];
    $rutaArchivo = $menj->generartxt($data);
}

$totalguias = count($_SESSION['data'][$_REQUEST['idmensajero']]['guias']);
$response= array('totalguias'=>$totalguias,'status'=>'OK','rutaArchivo'=>$rutaArchivo);
echo json_encode($response);