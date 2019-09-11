<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Inicio</title>

	<link rel="stylesheet" media="screen" href="assets/css/css.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="all">

	<!--[if lt IE 9]>
	<script src="script/html5shiv.js"></script>
	<![endif]-->

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
    
    #loading {
      width: 100%;
      height: 100%;
      top: 0px;
      left: 0px;
      position: fixed;
      display: block;
      opacity: 0.7;
      background-color: #fff;
      z-index: 99;
      text-align: center;
    }

    #loading-image {
      position: absolute;
      top: 50%;
      left: 50%;
      z-index: 100;
    }


	</style>
    <script type="text/javascript" src="assets/js/jquery-1.11.1.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
        //hide on start
         $('#loading').hide();
         $('#boton').hide();
         $("#error").hide();

        //call function
        do_something();


         function do_something()
         {
          $("#loading").show();

          var request = $.ajax({
          url: "usuario/validar",
          dataType:'json',
          data: {'id':"<?php echo $id;?>",'token':"<?php echo $token;?>"},
          type: "POST"
         });

         request.done(function(msg) {
         $("#loading").hide();
           if (msg == false ) {
           $('#boton').hide();
           $("#error").show();
           }
           else {
           $("#boton").show();
           }
        });

         request.fail(function(jqXHR, textStatus) {
         $("#loading").hide();
           // alert( "Request failed: " + textStatus );
           $("#error").show();
         });
         }

        });
    </script>
</head>
<body>

<div id="container">

<div class="page-wrapper">
    <section class="intro" id="zen-intro">
		<header role="banner">
            <h1></h1>
			<div class="derecha">
                <img src="assets/images/logos/banner_upc.PNG" style="height:auto; max-width:980px;" alt="logo">
			</div>
			<h2></h2>
		</header>

	</section>
    
    <div class="main welcome" id="zen-supporting" role="main">
        <div class="doble">
        </div>
        
		<div class="explanation" id="zen-explanation" role="article">
			<h3></h3>
			<div class="izquierda">
            <img src="assets/images/auxiliares/exclamation.png" style="height:auto; max-width:140px; margin:0px 15px 0px 0px; padding:0px 15px 0px 0px;" alt="advertencia">
			</div>
            <p>Esta secci&oacute;n es exclusiva para postulantes y alumnos de la UPC.</p>
			<p class="thicker">Para continuar haz clic en INICIAR TEST</p>
            
            <div id="loading">
                <img id="loading-image" src="assets/images/ajax-loader.gif" alt="Loading..." />
            </div>
            <div id="boton">
                <a href="formulario" class="boton">iniciar test</a>
            </div>
            <div id="error">
                <p class="error">No se encontraron datos para el participante solicitado. Por favor revisar si los par&aacute;metros suministrados son los correctos.
</p>
            </div>
		</div>

	</div>
    
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>