<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formulario extends CI_Controller {

    protected $generales;
    protected $especificos;
    protected $virtudes;
    
    protected $mas_desarrollados;
    protected $intermedios;
    protected $menos_desarrollados;
    
    function __construct() {
        parent::__construct();
        $this->load->library("nusoap_library");
    }
    
	/**
	 * Index Page for this controller.
	 *
	 */
	public function index()
	{
        // var_dump($this->session->all_userdata());
        if ($this->session->userdata('_token') && $this->session->userdata('_id'))
        {
            
            if (empty($this->generales) || empty($this->especificos) || empty($this->virtudes))
            {
                $this->cargar();
            }
            
            // var_dump($this->generales);
            $data = array (
                           'saludo'=> $this->saludo(),
                           'generales' => $this->generales,
                           'mas_desarrollados_minimo' => $this->config->item('mas_desarrollados_minimo'),
                           'menos_desarrollados_minimo' => $this->config->item('menos_desarrollados_minimo'),
                           );
            $this->load->view('general', $data);
        }
        else
        {
            $this->load->view('error');
        }
	}
    
    /**
	 * Funcion para obtener el saludo al usuario.
	 *
	 */
    function saludo()
    {
        $saludo = 'Bienvenido';
        $nombre = $this->session->userdata('user_name');
        $sexo = $this->session->userdata('user_sex');
        if (strtoupper ($sexo) == 'F')
        {
            $saludo = 'Bienvenida';
        }
        
        return $saludo . ' ' . $nombre;
    }
    
	/**
	 * Cerrar session y redirigir.
	 *
	 */
    public function cerrar()
    {
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect('/usuario','refresh');
    }
    
	/**
	 * Funcion para mostrar mostrar modales.
	 *
	 */
    function mostrar_ventana() 
    {
        $ventana = $this->input->post('ventana');
        $data = array ('msg' => $this->input->post('msg'));
        if ($ventana == 'modal') {
            echo $this->load->view('modal', $data, TRUE);
        }
        else
        {
            echo $this->load->view($ventana, '', TRUE);
        }
    }
    
	/**
	 * Funcion principal para la seleccion de los talentos.
	 *
	 */
    public function revisar()
    {
        $this->load->model('Talento_model','talentoResult');
        // var_dump($this->session->all_userdata());
        if (empty($this->generales) || empty($this->especificos) || empty($this->virtudes))
        {
            $this->cargar();
        }
        // var_dump($this->generales);
        
        switch ($this->input->post('pagina')) {
            case "general":
                $mas        = $this->input->post('mas');
                $intermedio = $this->input->post('intermedio');
                $menos      = $this->input->post('menos');
                
                /*arrays con nombres*/
                // var_dump($mas);
                $arrayMas           = explode(',', $mas);
                $arrayIntermedio    = explode(',', $intermedio);
                $arrayMenos         = explode(',', $menos);
                
                $this->mas_desarrollados    = $this->talentoResult->filtrar($this->generales, $arrayMas);
                $this->intermedios          = $this->talentoResult->filtrar($this->generales, $arrayIntermedio);
                $this->menos_desarrollados  = $this->talentoResult->filtrar($this->generales, $arrayMenos);
                
                $resultados = $this->talentoResult->convertir($this->mas_desarrollados,$this->intermedios,$this->menos_desarrollados);
                
                $this->session->set_userdata('talentos_mas', $resultados[0]);
                $this->session->set_userdata('talentos_intermedio', $resultados[1]);
                $this->session->set_userdata('talentos_menos', $resultados[2]);
                // $this->session->set_userdata('seleccionado', $this->especificos);
                
                // var_dump($arrayMas);
                if (count($arrayMas) > $this->config->item('mas_desarrollados_maximo'))
                {
                    $data = array (
                           'saludo'=> $this->saludo(),
                           'mas_desarrollados'=>$this->mas_desarrollados,
                           'mas_desarrollados_maximo'=>$this->config->item('mas_desarrollados_maximo'),
                           );
                    $this->load->view('desarrollados_mas', $data);
                }
                elseif (count($arrayMenos) > $this->config->item('menos_desarrollados_maximo'))
                {
                    $this->session->set_userdata('seleccionados_mas', '1,1,1,1,1,1,1,1,1,1,1,1'); //solo tiene 12, se setea en 1 a todos 
                    $data = array (
                           'saludo'=> $this->saludo(),
                           'menos_desarrollados'=>$this->menos_desarrollados,
                           'menos_desarrollados_maximo'=>$this->config->item('menos_desarrollados_maximo'),
                           );
                    $this->load->view('desarrollados_menos', $data);
                }
                else
                {
                    $this->session->set_userdata('seleccionados_mas', '1,1,1,1,1,1,1,1,1,1,1,1');//solo tiene 12, se setea en 1 a todos
                    $this->session->set_userdata('seleccionados_menos', '1,1,1,1,1,1');//solo tiene 6, se setea en 1 a todos
                    $data = array (
                           'saludo'=> $this->saludo(),
                           'especificos'=>$this->especificos,
                           'mas_especificos_minimo'=>$this->config->item('mas_especificos_minimo'),
                           'mas_especificos_maximo'=>$this->config->item('mas_especificos_maximo'),
                           );
                    $this->load->view('especificos_mas', $data);
                }
                
                break;
                
            case "desarrollados_mas":
                
                $mas = $this->input->post('mas');
                
                /*array con IdTalento*/
                // var_dump($mas);
                $arrayMenos = explode(',', trim($this->session->userdata('talentos_menos'),','));
                
                $this->menos_desarrollados = $this->talentoResult->filtrar_id($this->generales, $this->session->userdata('talentos_menos'));
                
                $resultados = $this->talentoResult->seleccionados($this->session->userdata('talentos_mas'), $mas);
                $this->session->set_userdata('seleccionados_mas', $resultados);
                
                // var_dump(count($arrayMenos));
                if (count($arrayMenos) > $this->config->item('menos_desarrollados_maximo'))
                {
                    
                    $data = array (
                           'saludo'=> $this->saludo(),
                           'menos_desarrollados'=>$this->menos_desarrollados,
                           'menos_desarrollados_maximo'=>$this->config->item('menos_desarrollados_maximo'),
                           );
                    $this->load->view('desarrollados_menos', $data);
                }
                else
                {
                    $this->session->set_userdata('seleccionados_menos', '1,1,1,1,1,1');//solo tiene 6, se setea en 1 a todos
                    $data = array (
                           'saludo'=> $this->saludo(),
                           'especificos'=>$this->especificos,
                           'mas_especificos_minimo'=>$this->config->item('mas_especificos_minimo'),
                           'mas_especificos_maximo'=>$this->config->item('mas_especificos_maximo'),
                           );
                    $this->load->view('especificos_mas', $data);
                }
                
                break;
            case "desarrollados_menos":
                
                $menos = $this->input->post('menos');
                
                /*array con IdTalento*/
                // var_dump($menos);
                
                $resultados = $this->talentoResult->seleccionados($this->session->userdata('talentos_menos'), $menos);
                $this->session->set_userdata('seleccionados_menos', $resultados);
                
                $data = array (
                       'saludo'=> $this->saludo(),
                       'especificos'=>$this->especificos,
                       'mas_especificos_minimo'=>$this->config->item('mas_especificos_minimo'),
                       'mas_especificos_maximo'=>$this->config->item('mas_especificos_maximo'),
                       );
                $this->load->view('especificos_mas', $data);
                
                break;
            case "especificos_mas":
                
                $mas = $this->input->post('mas');
                
                /*array con IdTalento*/
                // var_dump($mas);
                
                $especificos_menos = $this->talentoResult->excluir_id($this->especificos, $mas);
                
                $this->session->set_userdata('especificos_mas', $mas);
                
                $data = array (
                       'saludo'=> $this->saludo(),
                       'especificos'=>$especificos_menos,
                       'menos_especificos_minimo'=>$this->config->item('menos_especificos_minimo'),
                       'menos_especificos_maximo'=>$this->config->item('menos_especificos_maximo'),
                       );
                $this->load->view('especificos_menos', $data);
                
                break;
            case "especificos_menos":
                
                $menos = $this->input->post('menos');
                
                /*array con IdTalento*/
                // var_dump($menos);
                $this->session->set_userdata('especificos_menos', $menos);
                
                $data = array (
                       'saludo'=> $this->saludo(),
                       'virtudes'=>$this->virtudes,
                       'virtudes_minimo'=>$this->config->item('virtudes_minimo'),
                       'virtudes_maximo'=>$this->config->item('virtudes_maximo')
                       );
                $this->load->view('virtudes', $data);
                
                break;
            case "virtudes":
                
                $virtudes = $this->input->post('virtudes');
                
                $this->session->set_userdata('virtudes', $virtudes);
                
                $datos = array();
                $salida = array();
                $resultado = FALSE;
                
                $datos['dni'] = $this->session->userdata('user_dni');
                $datos['cod_evaluacion'] = $this->session->userdata('_id');
                $datos['correo'] = $this->session->userdata('user_email');
                
                $datos['participante_id'] = $this->session->userdata('user_id');
                $datos['participante_nombre'] = $this->session->userdata('user_name');
                
                $salida = $this->convertir_datos();
                
                $datos['buzon'] = $salida['buzon'];
                $datos['talento'] = $salida['talento'];
                $datos['seleccionado'] = $salida['seleccionado'];
                // var_dump($datos);
                $this->insertar_resultado($datos);
                
                /*envio*/
                // if (envio_mail($this->session->userdata('_id'), $this->session->userdata('_token')))
                $resultado = $this->envio_mail($this->session->userdata('_id'), $this->session->userdata('_token'));
                if ($resultado)
                {
                    $this->session->sess_destroy();
                    $this->load->view('agradecimiento');
                }
                else
                {
                    $this->load->view('fin');
                }
                break;
            default:
                // var_dump($this->session->all_userdata());
                $this->load->view('fin');
        }
	}
    
	/**
	 * Funcion que convertir la informacion de la session en la entrada para insertar resultado.
	 *
	 */
    function convertir_datos()
    {
        $this->load->model('Resultado_model','resultadoRequest');
        $entrada    = array();
        // $salida     = array();
        
        $entrada['talentos_mas']        = trim($this->session->userdata('talentos_mas'), ',');
        $entrada['talentos_intermedio'] = trim($this->session->userdata('talentos_intermedio'), ',');
        $entrada['talentos_menos']      = trim($this->session->userdata('talentos_menos'), ',');
        $entrada['seleccionados_mas']   = $this->session->userdata('seleccionados_mas');
        $entrada['seleccionados_menos'] = $this->session->userdata('seleccionados_menos');
        $entrada['especificos_mas']     = $this->session->userdata('especificos_mas');
        $entrada['especificos_menos']   = $this->session->userdata('especificos_menos');
        $entrada['virtudes']            = $this->session->userdata('virtudes');
        
        return $this->resultadoRequest->convertir($entrada);
    }
    
	/**
	 * Funcion que llama al WS insertar resultado.
	 *
	 */
    function insertar_resultado($datos)
    {
        $this->load->model('Resultado_model','resultadoRequest');
        $this->nusoap_client = new nusoap_client($this->config->item('insertar_resultado_url'), TRUE);
        
        $this->resultadoRequest->cargar($datos);
        $request['resultado'] = $this->resultadoRequest->resultado; 
        $reponse = $this->nusoap_client->call($this->config->item('insertar_resultado_metodo'), $request);
        
        if($this->nusoap_client->fault)
        {
            $text = '[insertar_resultado_metodo] Error: '.$this->nusoap_client->fault; 
            // print_r($text) para revision de errores
            // $this->load->view('error');
            return false;
        }
        else
        {
            if ($this->nusoap_client->getError())
            {
                $text = '[insertar_resultado_metodo] Error: '.$this->nusoap_client->getError(); 
                // print_r($text) para revision de errores
                // $this->load->view('error');
                return false;
            }
            else
            {
                $resultado = $reponse[$this->config->item('insertar_resultado_result')];
                // var_dump($talento); //Verificar si hay resultado
                
                return ($resultado > 0);
            }
        }
    }
    
	/**
	 * Funcion que llama al WS envio mail.
	 *
	 */
    function envio_mail($id, $token)
    {
        $param = array('CodEvaluacion' => $id,
                       'token' => $token);
                       
        $this->nusoap_client = new nusoap_client($this->config->item('enviar_mail_resultado_url'), TRUE);
        $reponse = $this->nusoap_client->call($this->config->item('enviar_mail_resultado_metodo'), $param);
        
        if($this->nusoap_client->fault)
        {
            $text = '[enviar_mail_resultado_metodo] Error: '.$this->nusoap_client->fault; 
            // print_r($text) para revision de errores
            // $this->load->view('error');
            return false;
        }
        else
        {
            if ($this->nusoap_client->getError())
            {
                $text = '[enviar_mail_resultado_metodo] Error: '.$this->nusoap_client->getError(); 
                // print_r($text) para revision de errores
                // $this->load->view('error');
                return false;
            }
            else
            {
                return true;
            }
        }
    }
    
	/**
	 * Funcion para cargar los talentos.
	 *
	 */
    function cargar()
    {
        $this->load->model('Talento_model','talentoResult');
        
        $this->nusoap_client = new nusoap_client($this->config->item('listar_talentos_url'), TRUE);
        $reponseTalentos = $this->nusoap_client->call($this->config->item('listar_talentos_metodo'));
        
        if($this->nusoap_client->fault)
        {
            $text = '[listar_talentos_metodo] Error: '.$this->nusoap_client->fault; 
            // print_r($text) para revision de errores
            $this->load->view('error');
        }
        else
        {
            if ($this->nusoap_client->getError())
            {
                $text = '[listar_talentos_metodo] Error: '.$this->nusoap_client->getError(); 
                // print_r($text) para revision de errores
                $this->load->view('error');
            }
            else
            {
                $talento = $reponseTalentos[$this->config->item('listar_talentos_result')];
                // var_dump($talento); //Verificar si hay resultado
                
                $this->talentoResult->cargar($talento);
                // var_dump($this->talentoResult->listaTalentos); //Verificar si hay resultado
                // var_dump(json_encode($this->talentoResult->listaTalentos[1])); //Verificar si hay resultado
                $this->generales = $this->talentoResult->listaTalentos[1];
                $this->especificos = $this->talentoResult->listaTalentos[2];
                $this->virtudes = $this->talentoResult->listaTalentos[3];
                
            }
        }
    }
    
}

/* End of file formulario.php */
/* Location: ./application/controllers/formulario.php */