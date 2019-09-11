
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
        <div id="popup" style="display: none" title="Test de Talentos"></div>
        <div class="main agradecimiento" id="zen-supporting" role="main">
            
            <div class="explanation" id="zen-explanation" role="article">
                <h3></h3>
                
                
                <p class="thicker">Gracias por completar el Test de Talentos</p>
                <p>Por favor haz click en el boton Cerrar Test para grabar tus resultados</p>
                
                <div id="boton">
                    <a href="<?php echo site_url("formulario/cerrar");?>" class="boton">Cerrar Test</a>
                </div>
                
                <div>
                    <p>El test de talentos es una herramienta para el conocimiento personal.</p>
                    <p>La informacion relativa a esta herramienta es confidencial.</p>
                    <p>Revisa tu correo electr&oacute;nico por que en breve recibir&aacute;s tus resultados.</p>
                </div>
                
                <div>
                    <p>UPC</p>
                </div>
                
                <a href="#" class="mi_popup">Referencias bibliogr&aacute;ficas</a>
                
            </div>
        </div>
        
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
      
        // mostrando el popup en el evento click del link
        $(".mi_popup").on("click", function(ev)
        {
            ev.preventDefault();
            $.post('<?php echo site_url()."formulario/mostrar_ventana/"; ?>', {ventana:"referencias"},
            function(data){
                $("#popup").html(data); 
                $("#popup").dialog( "open" );
            });
			return false;
        });
    });
    
    </script>
