
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
            <p>Agrupando <span class="rojo">mis talentos</span></p>
        </div>
        
		<div id="loading">
            <img id="loading-image" src="<?php echo base_url();?>assets/images/ajax-loader.gif" alt="Loading..." />
        </div>
		
		<div class="form" id="zen-form" role="article">
            <p class="aclaracion">Arrastra las tarjetas a los buzones de abajo seleccionando los talentos seg&uacute;n te identifiquen.</p>
            
            <div class="continuar">
                <a id="continuar" href="#" class="derecha" >Continuar &rsaquo;&rsaquo;</a>
            </div>
            
            <div id="wrapper" class="jcarousel-wrapper">
                <div id="resumen">
                    <input id="cantidad" readonly="readonly"/> clasificados de <?php echo count($generales); ?>
                </div>
                <div id="carousel" class="jcarousel">
                    <ul id="galeria">
                        
                        <?php foreach ($generales as $row => $value): ?>
                        <li>
                            <img class="galeria" src="<?php echo base_url();?>assets/images/talentos/front400/<?php echo $value->Image; ?>" alt="<?php echo ($value->Descripcion); ?>" data-back="<?php echo base_url();?>assets/images/talentos/back400/<?php echo $value->Example; ?>" data-front="<?php echo base_url();?>assets/images/talentos/front400/<?php echo $value->Image; ?>"/>
                        </li>
                        <?php endforeach ?>
                    </ul>
                    
                </div>
                
                <input class="show" type="image" src="<?php echo base_url();?>assets/images/ver30x30.png">
                
                <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
                <a href="#" class="jcarousel-control-next">&rsaquo;</a>
                
            </div>
            
            <form id="formulario" method="post" accept-charset="utf-8" >
                <input type="hidden" name="pagina" value="general" />
                <input type="hidden" name="mas" value="" />
                <input type="hidden" name="intermedio" value="" />
                <input type="hidden" name="menos" value="" />
                <input type="submit" value="Continuar" />
            </form>
                
            <div>
                <div id="mas" class="ui-widget-content ui-state-default buzones">
                    <h4 class="buzones-header">(+) Talento m&aacute;s desarrollado</h4>
                    <div class="ui-widget-content">
                        <ol class="connectedSortable">
                            
                        </ol>
                    </div>
                </div>
                    
                <div id="intermedio" class="ui-widget-content ui-state-default buzones">
                    <h4 class="buzones-header">Talento Intermedio</h4>
                    <div class="ui-widget-content">
                        <ol class="connectedSortable">
                            
                        </ol>
                    </div>

                </div>
                
                <div id="menos" class="ui-widget-content ui-state-default buzones">
                    <h4 class="buzones-header">(-) Talento menos desarrollado</h4>
                    <div class="ui-widget-content">
                        <ol class="connectedSortable">
                            
                        </ol>
                    </div>
                </div>
            </div>
		</div>
        
	</div>
    
    <aside class="sidebar" role="complementary">
		<div class="wrapper">
			<div class="design-selection" id="design-selection">
				<nav role="navigation">
					<ul>
                        <li class="activa">Agrupando mis talentos</li>
                        <li>Eligiendo mis talentos</li>
                        <li>Eligiendo mis talentos espec&iacute;ficos</li>
                        <li>Eligiendo mis virtudes m&aacute;s importantes</li>
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

$(function() {
    var jcarousel = $('.jcarousel');

    jcarousel
    // Bind _before_ carousel initialization
        .on('jcarousel:targetin', 'li', function() {
            $(this).addClass('active');
        })
        .on('jcarousel:targetout', 'li', function() {
            $(this).removeClass('active');
        })
        .jcarousel({
            // center: true,
            wrap: 'circular'
        });

    $('.jcarousel-control-prev')
        .jcarouselControl({
            target: '-=1'
        });

    $('.jcarousel-control-next')
        .jcarouselControl({
            target: '+=1'
        });

    $('.jcarousel-pagination')
        .on('jcarouselpagination:active', 'a', function() {
            $(this).addClass('active');
        })
        .on('jcarouselpagination:inactive', 'a', function() {
            $(this).removeClass('active');
        })
        .on('click', function(e) {
            e.preventDefault();
        })
        .jcarouselPagination({
            perPage: 1,
            item: function(page) {
                return '<a href="#' + page + '">' + page + '</a>';
            }
        });

    $("#loading").hide();
	
    $('.show').click(function(){
        var box = $('#galeria').children(".active"), target = '';
        
        if (box.find('img').attr('src')==box.find('img').data('back')) {
            target = box.find('img').data('front');
        } else {
            target = box.find('img').data('back');
            
        }
        box.find('img').attr('src', target);
    });

    $( ".galeria" ).draggable({
        revert: "invalid", // when not dropped, the item will revert back to its initial position
        opacity:'0.5', 
        helper: function(event, ui) {
          return $(this).clone().appendTo('body').addClass('miniatura').show();
        },
        cursor: "move",
        start: function (event, ui) {
             contents = $(this).attr('alt');
        },
        drag: function(event,ui){
            ui.position.top += $(this).parent().scrollTop() + ($(this).parent().height()*0.30);
            ui.position.left += $(this).parent().scrollLeft() + ($(this).parent().width()*0.20);
        }
    });
    
    $( "#mas ol, #intermedio ol, #menos ol" ).droppable({
        accept: "img",
        hoverClass: "ui-state-hover",
        tolerance: "pointer",
        drop: function( event, ui ) {
            $( "<li></li>" ).text( contents ).appendTo( this );
            deleteImage( );
        }
    });

    $( "#mas ol, #intermedio ol, #menos ol" ).sortable({
        connectWith: ".connectedSortable"
    }).disableSelection();
    
    $('#continuar').click(function() {
        $("#formulario").submit();
		return false;
    });

    $("form").submit(function (event ) {
        if($("#mas li").length < <?php echo $mas_desarrollados_minimo ?>) {
            event.preventDefault();
            $.post('<?php echo site_url()."formulario/mostrar_ventana/"; ?>', {ventana:"modal",msg:'El buz\u00F3n "Talentos m\u00E1s desarrollados debe contener un m\u00EDnimo de <?php echo $mas_desarrollados_minimo ?> talentos" '},
            function(data){
                $("#popup").html(data); 
                $("#popup").dialog( "open" );
            });
            return false;
        } 
        if($("#menos li").length < <?php echo $menos_desarrollados_minimo ?>) {
            event.preventDefault();
            $.post('<?php echo site_url()."formulario/mostrar_ventana/"; ?>', {ventana:"modal",msg:'El buz\u00F3n "Talentos menos desarrollados debe contener un m\u00EDnimo de <?php echo $menos_desarrollados_minimo ?> talentos" '},
            function(data){
                $("#popup").html(data); 
                $("#popup").dialog( "open" );
            });
            return false;
        } 
        var talentosMas = [];
        var talentosIntermedio = [];
        var talentosMenos = [];

        $("#mas ol li").each(function() { talentosMas.push($(this).text()) });
        $("#intermedio ol li").each(function() { talentosIntermedio.push($(this).text()) });
        $("#menos ol li").each(function() { talentosMenos.push($(this).text()) });
        
        $( "input[name='mas']" ).val( talentosMas.join(','));
        $( "input[name='intermedio']" ).val( talentosIntermedio.join(','));
        $( "input[name='menos']" ).val( talentosMenos.join(','));
        
        event.preventDefault();
        $("#loading").show();
        var formData = $("#formulario").serializeArray();
        $.ajax({
               type: "POST",
               url: "formulario/revisar",
               data: formData,
               success: function(resp) {
                $('#container').html(resp);
                $("#loading").hide();
             }
           });
        
    }); 

    $('input[type="submit"]').hide();
    $('.continuar').hide();
    
});
    
function deleteImage( ) {
    var item = $('.jcarousel').jcarousel('target');
    item.remove();
    $('.jcarousel').jcarousel('reload');
    conteo();
}

function conteo() {
    var count = $("#galeria li").length;
    var total = <?php echo count($generales); ?>;
    $("#cantidad").val(total - count);
    
    if (count <= 0) {
        // alert('Has terminado de clasificar los talentos. Si estas seguro de tus respuestas, haz click en CONTINUAR.'); 
        $.post('<?php echo site_url()."formulario/mostrar_ventana/"; ?>', {ventana:"modal",msg:'Has terminado de clasificar los talentos. Si estas seguro de tus respuestas, haz click en CONTINUAR.'},
            function(data){
                $("#popup").html(data); 
                $("#popup").dialog( "open" );
            });
            
        $('#wrapper').hide();
        $('.continuar').show();
    }
}

conteo();

</script>
