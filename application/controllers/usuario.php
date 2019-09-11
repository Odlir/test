<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("nusoap_library");
    }

    function index() {
        if ($this->input->get('id') && $this->input->get('token'))
        {
            $data = array(
               'id' => $this->input->get('id'),
               'token' => $this->input->get('token'),
            );
            $this->load->view('inicio', $data);
        }
        else
        {
            $this->load->view('fin');
            // $this->load->view('error');
        }
    }
    
    function validar() {
        /*cargo los modelos*/
        $this->load->model('User_model','userResult');
        $this->load->model('Participante_model','participanteRequest');
        
        //el contenido de $this->config->item se encuentra en application/config/talentos.php
        $this->nusoap_client = new nusoap_client($this->config->item('devolver_participante_url'), TRUE);
        
        if (!preg_match ("/[^0-9]/", $this->input->post('id')))
        // if (strpos("0", $this->input->post('id')) === 0 && !preg_match ("/[^0-9]/", $this->input->post('id')))
        {
            //lleno los $param con los valores del POST 
            $param = array('id' => $this->input->post('id'),
                        'token' => $this->input->post('token'));
            // var_dump($param); //Verificar si el ajax mando los parametros
            //invoca el metodo del ws y se pasan los parametros
            $reponseUser = $this->nusoap_client->call($this->config->item('devolver_participante_metodo'),$param);
            
            if($this->nusoap_client->fault)
            {
                $text = '[devolver_participante_metodo] Error: '.$this->nusoap_client->fault; 
                // print_r($text) para revision de errores
                echo 'false';
                die;
            }
            else
            {
                if ($this->nusoap_client->getError())
                {
                    $text = '[devolver_participante_metodo] Error: '.$this->nusoap_client->getError(); 
                    // print_r($text) para revision de errores
                    echo 'false';
                    die;
                }
                else
                {
                    $user = $reponseUser[$this->config->item('devolver_participante_result')];
                    
                    $this->userResult->cargar($user); //la respuesta json se carga en el objeto $this->userResult
                    // var_dump($this->userResult); //Verificar si hay resultado
                    
                    // se chanca $this->nusoap_client
                    $this->nusoap_client = new nusoap_client($this->config->item('insertar_participante_unico_url'), TRUE);
                    
                    //Parametros que solicita el metodo InsertarParticipanteUnico
                    $this->participanteRequest->cargar($this->userResult);
                    // Se requiere un objeto del tipo objParticipanteBE, el cual esta definido dentro de la clase Participante_model
                    $request['objParticipanteBE'] = $this->participanteRequest->objParticipanteBE; 
                    // var_dump($request); //Verificar si hay resultado
                    
                    //invoca el metodo del ws y se pasan los parametros
                    $reponseParticipante = $this->nusoap_client->call($this->config->item('insertar_participante_unico_metodo'),$request);
                    // var_dump($reponseParticipante); //Verificar si hay resultado
                    
                    if($this->nusoap_client->fault)
                    {
                        $text = '[insertar_participante_unico_metodo] Error: '.$this->nusoap_client->fault; 
                        // print_r($text) para revision de errores
                        echo 'false';
                        die;
                    }
                    else
                    {
                        if ($this->nusoap_client->getError())
                        {
                            $text = '[insertar_participante_unico_metodo] Error: '.$this->nusoap_client->getError(); 
                            // print_r($text) para revision de errores
                            echo 'false';
                            die;
                        }
                        else
                        {
                            $participante = $reponseParticipante[$this->config->item('insertar_participante_unico_result')];
                            // var_dump($participante); //Verificar si hay resultado
                            if ($participante <> 0) 
                            {
                                /*GUARDANDO DATOS EN SESSION*/
                                $this->session->set_userdata('_id', $this->input->post('id'));
                                $this->session->set_userdata('_token', $this->input->post('token'));
                                $this->session->set_userdata('user_id', $participante);
                                $this->session->set_userdata('user_name', $this->userResult->names . ' ' . $this->userResult->surname);
                                $this->session->set_userdata('user_email', $this->userResult->email);
                                $this->session->set_userdata('user_dni', $this->userResult->numberidentity);
                                $this->session->set_userdata('user_sex', $this->userResult->sex);
                                // $this->session->set_userdata('generales', ($this->talentoResult->listaTalentos[1]));
                                // $this->session->set_userdata('especificos', ($this->talentoResult->listaTalentos[2]));
                                // $this->session->set_userdata('virtudes', ($this->talentoResult->listaTalentos[3]));
                                echo 'true';
                                die;
                            }
                            else
                            {
                                echo 'false';
                                die;
                            }
                        }
                    }
                }
            }
        }
        else
        {
            echo 'false';
            die;
        }
    }
}

/* End of file usuario.php */
/* Location: ./application/controllers/usuario.php */