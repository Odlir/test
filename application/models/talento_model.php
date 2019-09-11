<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Talento_model extends CI_Model {
    
    var $TalentoBE  = NULL;
    var $listaTalentos  = array();
    /*var $idTalento  = '';
    var $nombre     = '';
    var $descripcion    = '';
    var $TipoTalento    = '';   // 1: General, 2: Especifico, 3: Virtud
    var $idTendencia    = '';
    var $nombreTendencia    = '';
    var $colorTendencia     = '';
    var $idColor    = '';
    var $example    = '';   // url de la espalda
    var $image      = '';   // url de la imagen
    var $seleccionado   = '';
    var $puntaje    = '';
    var $ordenInsercion = '';*/

    function __construct()
    {
        parent::__construct();
    }
    
    function cargar($row)
    {
        
        if(count($row['TalentoBE']) > 0 && is_array($row['TalentoBE'])) {
            foreach($row['TalentoBE'] as $index => $arr){
                $this->TalentoBE = new StdClass();
                foreach($arr as $key => $val){
                    if ($key == 'Image' || $key == 'Example') 
                    {
                        //para caputar solo el nombre de la imagen
                        $val = array_pop(explode('/',$val)); 
                    }
                    // $this->TalentoBE->$key = $val;
                    $this->TalentoBE->$key = utf8_encode($val);
                }
                $tipo = (isset($this->TalentoBE->TipoTalento) ? $this->TalentoBE->TipoTalento : 0);
                $this->listaTalentos[$tipo][$index] = $this->TalentoBE;
            }
        }
    }
    
    function filtrar ($talentos, $nombres)
    {
        $lista = array();
        foreach($talentos as $index => $obj){
            if (in_array($obj->Descripcion, $nombres)) {
                // var_dump($obj);
                $lista[$index] = $obj;
            }
        }
        // var_dump($lista);
        return $lista;
    }
    
    function filtrar_id ($talentos, $ids)
    {
        $lista = array();
        $arrayIds = explode(',', $ids);
        foreach($talentos as $index => $obj){
            if (in_array($obj->IdTalento, $arrayIds)) {
                // var_dump($obj);
                $lista[$index] = $obj;
            }
        }
        // var_dump($lista);
        return $lista;
    }
    
    function excluir_id ($talentos, $ids)
    {
        $lista = array();
        $arrayIds = explode(',', $ids);
        foreach($talentos as $index => $obj){
            if (!in_array($obj->IdTalento, $arrayIds)) {
                // var_dump($obj);
                $lista[$index] = $obj;
            }
        }
        // var_dump($lista);
        return $lista;
    }
    
    function convertir($mas, $intermedios, $menos)
    {
        $mas_id = '';
        $intermedios_id = '';
        $menos_id = '';
        
        foreach($mas as $key => $obj){
            $mas_id .= $obj->IdTalento.',';
        }
        
        foreach($intermedios as $key => $obj){
            $intermedios_id .= $obj->IdTalento.',';
        }
        
        foreach($menos as $key => $obj){
            $menos_id .= $obj->IdTalento.',';
        }
        
        // return array(trim($mas_id,','), trim($intermedios_id,','), trim($menos_id,','));
        return array($mas_id, $intermedios_id, $menos_id);
    }
    
    function seleccionados($talentos, $seleccion)
    {
        $seleccionados = '';
        $arrayTalentos = explode(',', trim($talentos,','));
        $arraySeleccion = explode(',', $seleccion);

        foreach($arrayTalentos as $talento_id){
            if (in_array($talento_id, $arraySeleccion)){
                $seleccionados .= '1'.',';
            } else {
                $seleccionados .= '0'.',';
            }
        }
        
        return trim($seleccionados,',');
    }
    
}