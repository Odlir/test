<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
    
    var $id     = '';
    var $code   = '';
    var $numberidentity =   '';
    var $names      = '';
    var $surname    = '';
    var $lastname   = '';
    var $sex        = '';
    var $email      = '';
    var $birthday   = '';
    var $email_information  = '';
    var $company    = '';
    var $headquarter    = '';
    var $organizationalunit = '';
    var $charge     = '';
    var $faculty    = '';
    var $career     = '';
    var $course     = '';
    var $section    = '';

    function __construct()
    {
        parent::__construct();
    }
    
    function cargar($cadena)
   {
   // ejemplo $cadena
   // string '{"user":{"id":7021,"code":"99999958","numberidentity":"00000001","names":"Luis","surname":"Gutierrez","lastname":null,"sex":"m","email":"luisgj7@gmail.com","birthday":{"date":"1992-03-07 00:00:00","timezone_type":3,"timezone":"UTC"},"email_information":null,"company":"ANA ARRIETA","headquarter":"Prueba","organizationalunit":null,"charge":null,"faculty":null,"career":null,"course":null,"section":null}}' (length=404)
    
        // var_dump(json_decode($cadena,TRUE));
        $row = json_decode($cadena,TRUE);
        if(count($row) > 0 && is_array($row)) {
            foreach($row['user'] as $key => $val){
                $this->$key = (isset($val) ? $val : "");
            }
        }
   }
}