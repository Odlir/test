
<div class="page-wrapper">
    <section class="intro" id="zen-intro">
		<header role="banner">
            <h1>
                <div class="cabecera"><?php echo $saludo;?>&nbsp;&nbsp;
                    <a class="zen-validate-css" title="Cerrar Ses&iacute;on" href="<?php echo site_url("formulario/cerrar");?>">Cerrar Sesi&oacute;n</a>
                </div>
            </h1>
			<div class="derecha">
                <img src="<?php echo base_url();?>assets/images/logos/banner_upc.PNG" style="height:auto; max-width:980px;" alt="logo">
			</div>
			<h2></h2>
		</header>

	</section>
    <div id="popup" style="display: none" title="Test de Talentos"></div>
    <div class="main supporting" id="zen-supporting" role="main">
        <div class="doble">
            <p>Eligiendo <span class="rojo">mis virtudes mas importantes</span></p>
        </div>
        
		<div class="form" id="zen-form" role="article">
			<h3></h3>

            <p>Elige tres (<?php echo $virtudes_maximo; ?>) de las siguientes virtudes, aquellas que consideres mas importantes.</p>
            
            <div class="continuar">
                <a id="continuar" href="#" class="derecha" >Continuar &rsaquo;&rsaquo;</a>
            </div>
            
            <form id="formulario" method="post" accept-charset="utf-8" >
                <input type="hidden" name="pagina" value="virtudes" />
                <input type="hidden" name="virtudes" value="" />
                <input type="submit" value="Continuar" />
            </form>
            
			<div id="loading">
                <img id="loading-image" src="<?php echo base_url();?>assets/images/ajax-loader.gif" alt="Loading..." />
            </div>
			
            <select multiple="multiple" class="image-picker show-html" data-limit=<?php echo $virtudes_maximo; ?>>
                <?php foreach ($virtudes as $row => $value): ?>
                <option data-img-src="<?php echo base_url();?>assets/images/talentos/front400/<?php echo $value->Image; ?>" value="<?php echo $value->IdTalento; ?>"><?php echo $value->Descripcion; ?></option>
                <?php endforeach ?>
            </select>
            <div id="resumen">
                <div class="izquierda"><input id="cantidad" readonly="readonly"/> seleccionado de <?php echo $virtudes_maximo; ?></div>
                <div class="derecha">Total: <?php echo count($virtudes); ?></div>
            </div>
		</div>

	</div>
    
    <aside class="sidebar" role="complementary">
		<div class="wrapper">
			<div class="design-selection" id="design-selection">
				<nav role="navigation">
					<ul>
                        <li>Agrupando mis talentos</li>
                        <li>Eligiendo mis talentos</li>
                        <li>Eligiendo mis talentos espec&iacute;ficos</li>
                        <li class="activa">Eligiendo mis virtudes m&aacute;s importantes</li>
					</ul>
				</nav>
			</div>
		</div>
	</aside>
    
</div>
<script type="text/javascript">
    
    $(document).ready(function() {
        // definiendo las propiedades del popup
        $("#popup").dialog({
            autoOpen: false,
            //height: 550,
            width: 650,
            modal: true,
            resizable: false,
            dialogClass: 'referencias-dialog',
            buttons : {
                    "Ok" : function() {
                        $(this).dialog("close");
                    }
                }
        });
    });

    $('#continuar').click(function() {
        $("#formulario").submit();
		return false;
    });
    
    $("select").imagepicker({
    })

    $( "select" ).change(function() {
        var count = $("select option:selected").length;
        $("#cantidad").val(count);
        if (count == <?php echo $virtudes_maximo; ?>) {
            $.post('<?php echo site_url()."formulario/mostrar_ventana/"; ?>', {ventana:"modal",msg:'Has terminado de elegir tus <?php echo $virtudes_maximo; ?> virtudes. Si est\u00E1s seguro de tus respuestas, haz click en CONTINUAR.'},
            function(data){
                $("#popup").html(data); 
                $("#popup").dialog( "open" );
            });
            $('.continuar').show();
        } else {
            $('.continuar').hide();
        }
    })
    .trigger( "change" );

    $(function() {
        $("#loading").hide();
        $("form").submit(function (event ) {
            
            $("select").data('picker');
            
            $( "input[name='virtudes']" ).val( $("select").data('picker').selected_values());
             
             event.preventDefault();
            $("#loading").show();
            $.post('formulario/revisar',$(this).serialize(),function(resp){
                $("#loading").hide();
                $('#container').html(resp);
            });
            
        }); 

        $('input[type="submit"]').hide();
        
    });
</script>
