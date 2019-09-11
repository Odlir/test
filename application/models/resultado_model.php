<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class resultado_model extends CI_Model {
    
    var $resultado = NULL;
    /*var $DNI     = '';
    var $CodEvaluacion   = '';
    var $CorreoElectronico =   '';
    var $EsMasivo      = '';
    var $BuzonId    = '';
    var $TalentoId   = '';
    var $Seleccionado        = '';
    var $Puntaje      = '';
    var $Fecha   = '';
    var $Participante_id  = '';
    var $NombreParticipante    = '';
    var $TendenciaId    = '';
    var $TipoDesarrollo = '';
    var $Resultado_id     = '';
    var $Buzon_id    = '';
    var $CantAmarillo     = '';
    var $CantAnaranjado = '';
    var $CantAnaranjado = '';
    var $CantRojo = '';
    var $CantAzul = '';
    var $CantVerde = '';
    var $CantGuinda     = '';*/

    function __construct()
    {
        parent::__construct();
    }
    
    function convertir($datos)
    {
        // var_dump($datos);
        $resultados = array();
        $buzon = '';
        $talento = '';
        $seleccionado = '';
        
        foreach(explode(',', $datos['talentos_mas']) as $id) {
            $buzon .= '1'.',';
        }
        $talento .= $datos['talentos_mas'].',';
        $seleccionado .= $datos['seleccionados_mas'].',';
        
        foreach(explode(',', $datos['talentos_intermedio']) as $id) {
            $buzon .= '2'.',';
            $seleccionado .= '0'.',';
        }
        $talento .= $datos['talentos_intermedio'].',';
        
        foreach(explode(',', $datos['talentos_menos']) as $id) {
            $buzon .= '3'.',';
        }
        $talento .= $datos['talentos_menos'].',';
        $seleccionado .= $datos['seleccionados_menos'].',';
        
        foreach(explode(',',$datos['especificos_mas']) as $id) {
            $buzon .= '4'.',';
            $seleccionado .= '1'.',';
        }
        $talento .= $datos['especificos_mas'].',';
        
        foreach(explode(',',$datos['especificos_menos']) as $id) {
            $buzon .= '6'.',';
            $seleccionado .= '1'.',';
        }
        $talento .= $datos['especificos_menos'].',';
        
        foreach(explode(',',$datos['virtudes']) as $id) {
            $buzon .= '7'.',';
            $seleccionado .= '1'.',';
        }
        $talento .= $datos['virtudes'].',';
        
        $resultados['talento']      = $talento;
        $resultados['buzon']        = $buzon;
        $resultados['seleccionado'] = $seleccionado;
        // var_dump($resultados);
        
        return $resultados;
    }
    
    function cargar($datos)
    {
        $this->resultado = new StdClass();
        $this->resultado->DNI               = $datos['dni'];
        $this->resultado->CodEvaluacion     = $datos['cod_evaluacion'];
        $this->resultado->CorreoElectronico = $datos['correo'];
        $this->resultado->EsMasivo          = 0;
        $this->resultado->BuzonId           = $datos['buzon'];
        $this->resultado->TalentoId         = $datos['talento'];
        $this->resultado->Seleccionado      = $datos['seleccionado'];
        $this->resultado->Puntaje           = 0;
        $this->resultado->Fecha             = date('Y-m-d').'T'.date('H:i:s.u'); // TODO validar formato
        $this->resultado->Participante_id   = $datos['participante_id'];
        $this->resultado->NombreParticipante = $datos['participante_nombre'];
        $this->resultado->TendenciaId       = NULL;
        $this->resultado->TipoDesarrollo    = NULL;
        $this->resultado->Resultado_id      = 0;
        $this->resultado->Buzon_id          = 0;
        $this->resultado->CantAmarillo      = 0;
        $this->resultado->CantAnaranjado    = 0;
        $this->resultado->CantRojo          = 0;
        $this->resultado->CantAzul          = 0;
        $this->resultado->CantVerde         = 0;
        $this->resultado->CantGuinda        = 0;
    }
}