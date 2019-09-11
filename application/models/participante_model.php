<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participante_model extends CI_Model {
    
    var $objParticipanteBE = NULL;

    function __construct()
    {
        parent::__construct();
    }
    
    function cargar($user)
    {
        //$user tiene la estructura del user_model
        
        $this->objParticipanteBE = new StdClass();
        /*$this->objParticipanteBE->ParticipanteId = '0';
        $this->objParticipanteBE->DNI = '99999958';
        $this->objParticipanteBE->Nombres = 'Luis';
        $this->objParticipanteBE->ApellidoPaterno = 'Gutierrez';
        $this->objParticipanteBE->ApellidoMaterno = '';
        $this->objParticipanteBE->FechaNacimiento = '';//aca hay logica
        $this->objParticipanteBE->Sexo = 'f';
        $this->objParticipanteBE->CorreoElectronico = 'luisgj7@gmail.com';
        $this->objParticipanteBE->Institucion = 'ANA ARRIETA';
        $this->objParticipanteBE->NivelInstruccion = '';
        $this->objParticipanteBE->Cargo = '';
        $this->objParticipanteBE->CodigoEvaluacion = '7021';*/
        
        $this->objParticipanteBE->ParticipanteId = $user->id;
        $this->objParticipanteBE->DNI = $user->numberidentity;
        $this->objParticipanteBE->Nombres = $user->names;
        $this->objParticipanteBE->ApellidoPaterno = $user->surname;
        $this->objParticipanteBE->ApellidoMaterno = $user->lastname;
        $this->objParticipanteBE->FechaNacimiento = (isset($user->birthday['date']) ? $user->birthday['date'] : '');
        $this->objParticipanteBE->Sexo = $user->sex;
        $this->objParticipanteBE->CorreoElectronico = $user->email;
        $this->objParticipanteBE->Institucion = $user->company;
        $this->objParticipanteBE->NivelInstruccion = $user->charge;
        $this->objParticipanteBE->Cargo = $user->charge;
        $this->objParticipanteBE->CodigoEvaluacion = $user->id;
        
    }
}