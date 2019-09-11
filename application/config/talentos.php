<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| DevolverParticipante
|--------------------------------------------------------------------------
|
|
*/
$config['devolver_participante_url']	= 'http://talentoswin.eastus2.cloudapp.azure.com/WSJuegoTestTalentosUPC/WSTalentos.asmx?WSDL';
$config['devolver_participante_metodo']	= 'DevolverParticipante';
$config['devolver_participante_result']	= 'DevolverParticipanteResult';


/*
|--------------------------------------------------------------------------
| InsertarParticipanteUnico
|--------------------------------------------------------------------------
|
|
*/
$config['insertar_participante_unico_url']		= 'http://talentoswin.eastus2.cloudapp.azure.com/WSJuegoTestTalentosUPC/WSTalentos.asmx?WSDL';
$config['insertar_participante_unico_metodo']	= 'InsertarParticipanteUnico';
$config['insertar_participante_unico_result']	= 'InsertarParticipanteUnicoResult';


/*
|--------------------------------------------------------------------------
| ListarTalentos
|--------------------------------------------------------------------------
|
|
*/
$config['listar_talentos_url']		= 'http://talentoswin.eastus2.cloudapp.azure.com/WSJuegoTestTalentosUPC/WSTalentos.asmx?WSDL';
$config['listar_talentos_metodo']	= 'ListarTalentos';
$config['listar_talentos_result']	= 'ListarTalentosResult';


/*
|--------------------------------------------------------------------------
| InsertarResultado
|--------------------------------------------------------------------------
|
|
*/
$config['insertar_resultado_url']		= 'http://talentoswin.eastus2.cloudapp.azure.com/WSJuegoTestTalentosUPC/WSTalentos.asmx?WSDL';
$config['insertar_resultado_metodo']	= 'InsertarResultado';
$config['insertar_resultado_result']	= 'InsertarResultadoResult';


/*
|--------------------------------------------------------------------------
| EnviarMailResultado
|--------------------------------------------------------------------------
|
|
*/
$config['enviar_mail_resultado_url']	= 'http://talentoswin.eastus2.cloudapp.azure.com/WSReportesTestTalentosUPC/wsReporte.asmx?WSDL';
$config['enviar_mail_resultado_metodo']	= 'EnviarMailResultado';
//$config['enviar_mail_resultado_result']		= 'ListarTalentosResult';


/*
|--------------------------------------------------------------------------
| Para validar la cantidad de talentos seleccionados en el formulario
|--------------------------------------------------------------------------
|
|
*/
$config['mas_desarrollados_minimo']		= 12;
$config['menos_desarrollados_minimo']	= 6;
$config['mas_desarrollados_maximo']		= 12;
$config['menos_desarrollados_maximo']	= 6;
$config['mas_especificos_minimo']		= 0;
$config['mas_especificos_maximo']		= 3;
$config['menos_especificos_minimo']		= 0;
$config['menos_especificos_maximo']		= 3;
$config['virtudes_minimo']				= 0;
$config['virtudes_maximo']				= 3;


/* End of file talentos.php */
/* Location: ./application/config/talentos.php */