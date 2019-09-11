<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/logos/favicon.png">
	<title>Inicio</title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/preload.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/css.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/image-picker.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jcarousel.responsive.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery-ui.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="all">

	<!--[if lt IE 9]>
	<script src="<?php echo base_url();?>script/html5shiv.js"></script>
	<![endif]-->
    
    <script> 
    var $buoop = {vs:{i:7,f:15,o:12,s:5},c:2}; 
    function $buo_f(){ 
     var e = document.createElement("script"); 
     e.src = "//browser-update.org/update.js"; 
     document.body.appendChild(e);
    };
    try {document.addEventListener("DOMContentLoaded", $buo_f,false)}
    catch(e){window.attachEvent("onload", $buo_f)}
    </script>

    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui-1.11.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.jcarousel.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/image-picker.js"></script>
    
    
</head>
<body>
<div id="container">
    <div class="page-wrapper">
        <section class="intro" id="zen-intro">
            <header role="banner">
                <h1></h1>
                <div class="derecha">
                    <img src="<?php echo base_url();?>assets/images/logos/banner_upc.PNG" style="height:auto; max-width:980px;" alt="logo">
                </div>
                <h2></h2>
            </header>

        </section>
        <div id="hide-with-script">
            <h1>La p&aacute;gina que est&aacute;s viendo requiere para su funcionamiento el uso de JavaScript. Si lo has deshabilitado intencionadamente, por favor vuelve a activarlo.</h1>
        </div>
        <div class="main welcome" id="zen-supporting" role="main">
            <div class="doble">
                <p></p>
            </div>
            
            <div class="explanation" id="zen-explanation" role="article">
                <h3></h3>
                <div class="izquierda">
                    <img src="<?php echo base_url();?>assets/images/auxiliares/exclamation.png" style="height:auto; max-width:140px; margin:0px 15px 0px 0px; padding:0px 15px 0px 0px;" alt="advertencia">
                </div>
                <p>Esta secci&oacute;n es exclusiva para postulantes y alumnos de la UPC.</p>
                <p class="thicker">Para continuar haz clic en INICIAR TEST</p>
                
                <div id="loading" class="oculto">
                    <img id="loading-image" src="<?php echo base_url();?>assets/images/ajax-loader.gif" alt="Loading..." />
                </div>
                <!--<div id="boton" class="oculto">-->
                <div>
                    <a href="formulario" class="boton">iniciar test</a>
                </div>
                
                <img id="load" class="oculto" src="<?php echo base_url();?>assets/images/ajax-loader.gif" alt="Loading..." />
                
                <div id="error" class="oculto">
                    <p class="error">No se encontraron datos para el participante solicitado. Por favor revisar si los par&aacute;metros suministrados son los correctos.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#hide-with-script").css("display", "none");
    //hide on start
    // $('#loading').hide();
    $("#loading").show();
    // $('#boton').hide();
    // $("#error").hide();
    
    validar();
    
    function validar() {
        var request = $.ajax({
        url: "usuario/validar",
        dataType:'json',
        data: {'id':"<?php echo $id;?>",'token':"<?php echo $token;?>"},
        type: "POST"
        });

        request.done(function(msg) {
            $("#loading").hide();
            if (msg == false ) {
                $("#boton").hide();
                $("#error").show();
            } else {
                $("#boton").show();
            }
        });

        request.fail(function(jqXHR, textStatus) {
            $("#loading").hide();
            $("#error").show();
        });
    }

    $(".boton").click(function(ev){
        $("#load").show();
        $("#boton").hide();
        var page = $(this).attr('href');

        $.ajax({
            type: "POST",
            url: page,
            success: function(a) {
                $("#load").hide();
                $('#container').html(a);
            }
        });

        return false;
    });
});

</script>

</body>
</html>