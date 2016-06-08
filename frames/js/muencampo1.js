
$( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd"});
		
$("#rangoini").change(function() {
    $("#rangofin").val($(this).val());
});


$( "#lote_env_sec" ).focusout(function(){ 
	var value = $( this ).val();			
	recuperarTambores(value)
});


$( "#btnok" ).click(function(){ 
	var ini = $("#rangoini").val();
	var fin = $("#rangofin").val();
	var cant_tambores = fin - ini + 1;
	$("#ctambores").val(cant_tambores);
	for(i = ini; i <=fin; i++){
			$("#tabladeTambores").append('<tr><td class="editar"><input type="text" name="tamb[]" value='+i+'></td><td></td><td><select name="selectfrom" id="select-from"><option>Multiflora</option></select></td><td class="bordetransp"  id="del"><a href="#"><img src="fotos/Trash_Can.png" width="20" height="20"/></a></td></tr>');
		}
	});


// Evento que selecciona la fila y la elimina 
$(document).on("click","#del",function(){
	var parent = $(this).parents().get(0);
	$(parent).remove();
	cant_tambores = $("#ctambores").val();
	cant_tambores = cant_tambores-1;
	$("#cant_tambores").val(cant_tambores);
});

$(document).on("click","#delAll",function(){
	$('#tabladeTambores').find("tr:gt(0)").remove();			
});

$(window).load(function() {
		var mensaje = $("#mensaje").val();
		console.log(mensaje);
		if (mensaje != " "){
		 	$("#dialog").dialog({
			modal: true,
			resizable: false,
			buttons: {
				"Aceptar": function() {
				$(this).dialog("close");
				}
			}
		});
		}
});


	$("#buscar").click(function() {
		$("#dialog_busqueda").dialog({
		modal: true,
		width:500,
		resizable: false,
		buttons: {
			"Aceptar": function() {
				$(this).dialog("close");
			}
		}
	});
});



$(function() {
    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
 
    $( "#productor_search" )
      // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
          event.preventDefault();
        }
      })
      .autocomplete({
        source: function( request, response ) {
          $.getJSON( "includes/search_productor.php", {
            term: extractLast( request.term )
          }, response );
        },
        search: function() {
          // custom minLength
          var term = extractLast( this.value );
          if ( term.length < 2 ) {
            return false;
          }
        },
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {
          var terms = split( this.value );
          // remove the current input
          terms.pop();
          // add the selected item
          terms.push( ui.item.value );
          // add placeholder to get the comma-and-space at the end
          terms.push( "" );
          this.value = terms.join( ", " );
          return false;
        }
      });
      $( "#productor_search" ).on('autocompleteselect',function (e,ui){
      		var respuesta= $(this).val(ui.item.value);
      		$("#selectorproductor").val(respuesta);

      		console.log(respuesta);
      });
});	