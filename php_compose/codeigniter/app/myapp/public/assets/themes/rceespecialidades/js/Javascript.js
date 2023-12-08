/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of javascript
 *
 * @author nicolas.villagra
 */

 mueveReloj();
 
 var impresion = null;
$(function() {
    
    $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '<Ant',
                nextText: 'Sig>',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
                };
                $.datepicker.setDefaults($.datepicker.regional['es']);
               $(function () {
               $("#fecha").datepicker();
               });
    loaddatos();
    $( "#rcePopUp" ).dialog({ //popup editar cita
                autoOpen: false,
		modal: true,
                position: top,
		height: $(window).height()+10,
                width: $(window).width(),
		hide: "scale",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
    $( "#historialclinico" ).dialog({ //popup ver historial clinico
                autoOpen: false,
		modal: true,
		height: 600,
		width: 530,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: true,
                closeOnEscape: false
    });
    $("#JpromtF").dialog({ //popup firma digital
               autoOpen: false,
               modal: true,
               height: 228,
               width: 450,
               hide: "scale",
               show: "fold",
               resizable: false,
               draggable: false,
               closeOnEscape: false,
               dialogClass: 'no-close'
        });
        
     $("#JpromtF2").dialog({ //popup firma digital
               autoOpen: false,
               modal: true,
               height: 228,
               width: 450,
               hide: "scale",
               show: "fold",
               resizable: false,
               draggable: false,
               closeOnEscape: false,
               dialogClass: 'no-close'
        });  
        
     $("#JpromtF3").dialog({ //popup firma digital
               autoOpen: false,
               modal: true,
               height: 228,
               width: 450,
               hide: "scale",
               show: "fold",
               resizable: false,
               draggable: false,
               closeOnEscape: false,
               dialogClass: 'no-close'
        });
        
     $("#JConfirm1").dialog({ //
               autoOpen: false,
               modal: true,
               height: 180,
               width: 450,
               hide: "scale",
               show: "fold",
               resizable: false,
               draggable: false,
               closeOnEscape: false,
               dialogClass: 'no-close'
        });

    $( "#verdatopaciente" ).dialog({ //popup ver datos de paciente
                autoOpen: false,
		modal: true,
		height: $(window).height()-15,
		width: 610,
		hide: "fold",
		show: "fold",
//		resizable: false,
//		draggable: false,
                closeOnEscape: false,
                position: { my: 'right', at: 'right+150' }
    });
    
    $( "#certificados" ).dialog({ //popup ver certificados
                autoOpen: false,
		modal: true,
		height: 265,
		width: 653,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
    
    $( "#refycref" ).dialog({ //popup referencia y contrareferencia
                autoOpen: false,
		modal: true,
		height: $(window).height()-10,
		width: 953,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
    
    $( "#datosurgencia" ).dialog({ //datos urgencia
                autoOpen: false,
		modal: true,
		height: $(window).height()-10,
		width: 953,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
    
    $( "#cie10" ).dialog({ //popup cie10
                autoOpen: false,
		modal: true,
		height: 416,
		width: 650,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
    
    $( "#establecimiento" ).dialog({ //popup establecimiento
                autoOpen: false,
		modal: true,
		height: 416,
		width: 650,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
    
     $( "#solicitaexamen" ).dialog({ //popup solicitud de examen
                autoOpen: false,
		modal: true,
		height: $(window).height()+10,
		width: $(window).width()-25,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
    
    $( "#bges" ).dialog({ //popup busqueda de diag ges
                autoOpen: false,
		modal: true,
		height: 416,
		width: 650,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
    
    $( "#creareceta" ).dialog({ //popup busqueda de diag ges
                autoOpen: false,
		modal: true,
		height: 416,
		width: 1000,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
    
    $( "#interconsulta" ).dialog({ //popup interconsulta
                autoOpen: false,
		modal: true,
		height: 730,
		width: 850,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
      
    $( "#exlaboratorio" ).dialog({ 
                autoOpen: false,
		modal: true,
		height: 700,
		width: 1035,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
    
    $( "#exmicrobiologico" ).dialog({ 
                autoOpen: false,
		modal: true,
		height: 700,
		width: 1030,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
    
     $( "#exbioquimico" ).dialog({
                autoOpen: false,
		modal: true,
		height: 820,
		width: 750,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
    
      $( "#exhormonales" ).dialog({
                autoOpen: false,
		modal: true,
		height: 820,
		width: 750,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
    
    $( "#selectexamen").dialog({
                autoOpen: false,
		modal: true,
		height: 220,
		width: 450,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
    
    $( "#datosgyo" ).dialog({ //
                autoOpen: false,
		modal: true,
                position: { my: "top", at: "top", of: "#rcePopUp"  },
		height: $(window).height()-10,
		width: 953,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: false,
                closeOnEscape: false
    });
    
    $( "#historialgineobs" ).dialog({ //
                autoOpen: false,
		modal: true,
		height: 350,
		width: 530,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: true,
                closeOnEscape: false
    });
    
    $( "#detallegineobs" ).dialog({ //
                autoOpen: false,
		modal: true,
		height: 550,
		width: 953,
		hide: "fold",
		show: "fold",
		resizable: false,
		draggable: true,
                closeOnEscape: false
    });
  });

function rayardiag(valtd){ //rayardiag diagnostico en autocomplete
        var str = valtd;
        var res = str.split("diag_");
        $('#tachado_' + res[1]).val('1');
        var res1 = "diagb_"+res[1];
        $('#' + res1).addClass('tach');
        $('#' + valtd + "xremove").remove();
        var restaurar = '<td id='+ valtd + 'xreponer><a href="javascript:;" onclick="restdiagnostico(\''+ valtd + '\'\)">Restaurar</a></td>';
        $('#' + valtd + "xagregar").append(restaurar); 
        document.getElementById("diagb_" + +res[1]).style.width = "441px";
        creaselectdiag();
}

function rayaractividad(valtdact){//rayar actividad de autocomplete
        var str = valtdact;
        var res = str.split("actv_");
        $('#tachadoactv_' + res[1]).val('1');
        var res1 = "actv1_"+res[1];
        $('#' + res1).addClass('tach');
        $('#' + valtdact + "xremoveactv").remove();
        var restauraractv = '<td id='+ valtdact + 'xreponeractv style=" width: 80px;"><a href="javascript:;" onclick="restactividad(\''+ valtdact + '\'\)">Restaurar</a></td>';
        $('#' + valtdact + "xagregaractv").append(restauraractv);
}

function rayarprocedimientos(valtdproc){ //rayar procedimientos
        var str = valtdproc;
        var res = str.split("proced_");
        $('#tachadoproced_' + res[1]).val('1');
        var res1 = "procedb_"+res[1];
        $('#' + res1).addClass('tach');
        $('#' + valtdproc + "xremoveproced").remove();
        var restaurarproced = '<td id='+ valtdproc + 'xreponerproced><a href="javascript:;" onclick="restprocedimiento(\''+ valtdproc + '\'\)">Restaurar</a></td>';
        $('#' + valtdproc + "xagregarproced").append(restaurarproced);
}

function restdiagnostico(valtd){ // Restaurar diagnostico
        var str = valtd;
        var res = str.split("diag_");
        $('#tachado_' + res[1]).val('0');
        var res1 = "diagb_"+res[1];
        $('#' + res1).removeClass('tach');
        $('#' + valtd + "xreponer").remove();
        var agregaremov = '<td id='+ valtd + 'xremove style="width:20px"><a onclick="rayardiag(\''+ valtd + '\'\);"><img src="ext/RCEESPECIALIDADES/img/borrar.gif" /></a></td>';
        $('#' + valtd + "xagregar").append(agregaremov);
        document.getElementById("diagb_" + +res[1]).style.width = "481px";
        creaselectdiag();
}

function restactividad(valtdact){ // Restaurar actividad
        var str = valtdact;
        var res = str.split("actv_");
        $('#tachadoactv_' + res[1]).val('0');
        var res1 = "actv1_" + res[1];
        $('#' + res1).removeClass('tach');
        $('#' + valtdact + "xreponeractv").remove();
        var agregaractv = '<td id='+ valtdact + 'xremoveactv style=" width: 80px;"><a onclick="rayaractividad(\''+ valtdact + '\'\);"><img src="ext/RCEESPECIALIDADES/img/borrar.gif" /></a></td>';
        $('#' + valtdact + "xagregaractv").append(agregaractv);
}

function restprocedimiento(valtdproced){ // Restaurar procedimiento
        var str = valtdproced;
        var res = str.split("proced_");
        $('#tachadoproced_' + res[1]).val('0');
        var res1 = "procedb_"+res[1];
        $('#' + res1).removeClass('tach');
        $('#' + valtdproced + "xreponerproced").remove();
        var agregarproced = '<td id='+ valtdproced + 'xremoveproced><a onclick="rayarprocedimientos(\''+ valtdproced + '\'\);"><img src="ext/RCEESPECIALIDADES/img/borrar.gif" /></a></td>';
        $('#' + valtdproced + "xagregarproced").append(agregarproced);
}
 function anular(e) {
          tecla = (document.all) ? e.keyCode : e.which;
          return (tecla != 13);
     }
     
function autocomplet() { //Autocomplete diagnostico
    
//    $(document).bind('keydown',function(i){ // presionar boton enter
//      if ( i.which === 13 ) {
//        return false;
//      };
//});

    if($('#completediagnostico').val() === ''){ //Esconder desplegado cuando este vacio
        $('#muestralista').hide('fast');
    }else{
        $('#muestralista').show('fast');
    }
         if($("#todos").is(':checked')) { //Comprobar tipo de busqueda
        var frecuencia = 'N' //Todos 
        }else if($("#usofrecuente").is(':checked')) {
        frecuencia = 'S' //Uso Frecuente
        }
	var min_length = 1; // minimo de caracteres para autocomplete
	var keyword = $('#completediagnostico').val();
        keyword = keyword.toLowerCase();
                keyword = keyword.replace(new RegExp("ñ"), "\enie");
        
        
        var sexo = document.getElementById ("sexo").innerText;
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ext/RCEESPECIALIDADES/class/autocomplet.php',
			type: 'POST',
			data: {keyword:keyword, sexo:sexo, frecuencia:frecuencia},
			success:function(data){
				$('#resultdiagnostico').show();
				$('#resultdiagnostico').html(data);
			}
		});
	} else {
		$('#resultdiagnostico').hide();
	}
}

function autocompletact(){ //Autocomplete actividades
    if($('#completeactividades').val() === ''){//Esconder desplegado cuando este vacio
        $('#muestralistaact').hide('fast');
    }else{
        $('#muestralistaact').show('fast');
    }
	var min_length = 1; // minimo de caracteres para autocomplete
	var keyword1 = $('#completeactividades').val();
//        var sexo = document.getElementById ("sexo").innerText;
	if (keyword1.length >= min_length) {
		$.ajax({
			url: 'ext/RCEESPECIALIDADES/class/autocompletactividades.php',
			type: 'POST',
			data: {keyword1:keyword1},
			success:function(data){
				$('#resultactividades').show();
				$('#resultactividades').html(data);
			}
		});
	} else {
		$('#resultactividades').hide();
	}
}

function autocompletproced(){ //Autocomplete procedimientos
      if($('#completeprocedimientos').val() === ''){//Esconder desplegado cuando este vacio
        $('#muestralistaproced').hide('fast');
    }else{
        $('#muestralistaproced').show('fast');
    }
	var min_length = 1; // minimo de caracteres para autocomplete
	var keyword2 = $('#completeprocedimientos').val();
//        var sexo = document.getElementById ("sexo").innerText;
	if (keyword2.length >= min_length) {
		$.ajax({
			url: 'ext/RCEESPECIALIDADES/class/autocompletprocedimientos.php',
			type: 'POST',
			data: {keyword2:keyword2},
			success:function(data){
				$('#resultprocedimientos').show();
				$('#resultprocedimientos').html(data);
			}
		});
	} else {
		$('#resultprocedimientos').hide();
	}
}

function set_item(id,texto,ges,codges,cie10) { //LLenado de autocomplete diagnostico
    var comprueba = 0;
    var tach = 0;
    document.getElementById('divavisoges').style.display = "none"; //Mensaje GES
    $('[id^=diagb_]').each(function() {
        iddiag  	   = $(this).attr('id');
		iddiag         = iddiag.replace('diagb_', '');
      if (id==iddiag){
          comprueba = 1;
      }
         });
    if(comprueba == 1){
        jAlert("El diagnostico ya se encuentra asignado", "Error");
        document.getElementById('muestralista').style.display = "none";
    }else{
        document.getElementById("id1").style.width = "500px";
        document.getElementById('muestralista').style.display = "none";
    var txt1 = '<tr class="formulario"><td style="font-size:10px;" id="diagb_'+ id +'">' + texto +' </td><td id="diag_'+ id +'xagregar" style="width:20px;"><td id="diag_'+ id +'xremove" style="width:20px;"><a onclick="rayardiag(\'diag_'+ id + '\'\);"><img src="ext/RCEESPECIALIDADES/img/borrar.gif" /></a>\n\
</td><input id="txtdiag_'+ id +'" value="' + texto +'" type="hidden">\n\
<input type="hidden" id="tachado_'+ id +'" value='+tach+'>\n\
<input type="hidden" id="codcie10_'+ id +'" value='+cie10+'></td></tr>';
    $("#id1").append(txt1);  
    $('#resultdiagnostico').hide();
    $('#completediagnostico').val('');
    
    creaselectdiag();//llenar el select option de destino ***
    if(ges == 1){
        document.getElementById('id2').style.display = "";
        document.getElementById('AreaDescDiagno').style.display = "none";
        document.getElementById('divavisoges').style.display = "";//Mensaje GES
        document.getElementById("dps").style.width = "140px";
        document.getElementById("dsps").style.width = "120px";
        document.getElementById("id2").style.width = "100%";
        
        var funcion = "llenatabges";
        var variables={"id":id, "texto":texto}
		var id="guardarce";
		ajax_rceespecialidades(variables,id, funcion);
          }     
    }
}

function agregagesnuevo(COD_PROBLEMAGES){
    var comprueba = 0;
     $('[id^=ges_]').each(function() {
        idges 	   = $(this).attr('id');
		idges         = idges.replace('ges_', '');
      if (COD_PROBLEMAGES==idges){
          comprueba = 1;
      }
         });
    if(comprueba == 1){
        jAlert("El Problema GES ya se encuentra asignado", "Error");
    }else{
        var funcion = 'agregagesnuevo';
           var variables={"COD_PROBLEMAGES":COD_PROBLEMAGES}
		var id="guardarce";
		ajax_rceespecialidades(variables,id, funcion);
            }
}

function set_itemactividades(id,texto) { //LLenado de autocomplete diagnostico
    var compruebaact = 0;
    var tachactv = 0;
    $('[id^=actv1_]').each(function() {
        idactv  	   = $(this).attr('id');
		idactv         = idactv.replace('actv1_', '');
      if (id==idactv){
          compruebaact = 1;
      }
         });
         
    if(compruebaact == 1){
        jAlert("La Actividad ya se encuentra asignada", "Error");
        document.getElementById('muestralistaact').style.display = "none";
    }else{
       document.getElementById("id1").style.width = "500px";
       document.getElementById('muestralistaact').style.display = "none";
    var txt1 = '<tr class="formulario"><td style="font-size:10px; width: 1000px;" id="actv1_'+ id +'">' + texto +' </td><td style="width: 100px;"><input type="text" style="width: 25px;" id="numcant_'+ id + '\" size="4" value="1" placeholder="cant."></td><td style="width: 100px;"><input type="text" id="\observ_'+ id + '\" size="25" value="" placeholder="Observacion"></td><td id="actv_'+ id +'xagregaractv" style="width:80px;"><td id="actv_'+ id +'xremoveactv" style="width:80px;"><a onclick="rayaractividad(\'actv_'+ id + '\'\);"><img src="ext/RCEESPECIALIDADES/img/borrar.gif" style="margin-right: 10px;" /></a>\n\
</td><input id="txtactv_'+ id +'" value="' + texto +'" type="hidden">\n\
<input type="hidden" id="tachadoactv_'+ id +'" value='+tachactv+'></td></tr>';
    $("#muestractv").append(txt1);  
    $('#resultactividades').hide();
    $('#completeactividades').val('');
    }
}

function set_itemprocedimientos(id,texto) { //LLenado de autocomplete diagnostico
    var compruebaproced = 0; 
    var tachaproced = 0;
    $('[id^=procedb_]').each(function() {
        proced  	   = $(this).attr('id');
		proced         = proced.replace('procedb_', '');
      if (id==proced){
          compruebaproced = 1;
      }
         });
         
    if(compruebaproced === 1){
        jAlert("El Procedimiento ya se encuentra asignado", "Error");
        document.getElementById('muestralistaproced').style.display = "none";
    }else{
        document.getElementById("procedimientos1").style.width = "500px";
        document.getElementById('muestralistaproced').style.display = "none";
    var txt1 = '<tr class="formulario"><td style="font-size:10px; width: 1000px;" id="procedb_'+ id +'">' + texto +' </td><td id="proced_'+ id +'xagregarproced"><td id="proced_'+ id +'xremoveproced" style="width: 40px;"><a onclick="rayarprocedimientos(\'proced_'+ id + '\'\);"><img src="ext/RCEESPECIALIDADES/img/borrar.gif" /></a>\n\
    </td><input id="txtproced_'+ id +'" value="' + texto +'" type="hidden">\n\
    <input type="hidden" id="tachadoproced_'+ id +'" value='+tachaproced+'></td></tr>';
    $("#procedimientos1").append(txt1);  
    $('#resultprocedimientos').hide();
    $('#completeprocedimientos').val('');
    }
}

function eliminaValorGES(id, idborrado){ //Eliminar Valores de GES 
    var borrar = id.parentNode.parentNode;
	var row = borrar.rowIndex;
	var nodo = borrar.parentNode; 
	nodo.deleteRow(row);
        var verificar = document.getElementById("id2").rows.length;
        if (verificar == 1){ //Comprobar si no existen valores en la tabla para ocultar
        document.getElementById('id2').style.display = "none";
        document.getElementById('AreaDescDiagno').style.display = "";    
        }
        var funcion = "eliminages";
        var variables={"idborrado":idborrado}
		var id="consultadiag";
		ajax_rceespecialidades(variables,id, funcion);
}

function llenaestges(cod_estadoges, des_estadoges, id){ //Llena estado GES
    var result = '<option value=' + cod_estadoges + '>' + des_estadoges + '</option>'
    $("#Estado" + id).append(result); 
}

function llenasubproblemages(COD_SUBPROBLEMAGES, DES_SUBPROBLEMAGES, id){
    
    var result1 = '<option value="' + COD_SUBPROBLEMAGES + '">' + DES_SUBPROBLEMAGES + '</option>' 
    $("#sub-problema" + id).append(result1); 
}

function llenadesges(id, des_problemages, COD_PROBLEMAGES){ //LLena Descripcion GES
        var txt2 = '<tr id="'+ id +'"><td style="font-size:10px;" id="ges_'+ id +'">' + des_problemages +' &nbsp;</td>\n\
        <td style="font-size:10px;"><select name="sub-problema" id="sub-problema'+ id +'" style="width:100%;"></select></td>\n\
        <td style="font-size:10px;"><select name="Estado" id="Estado'+ id +'" style="width:100%;"></select></td>\n\
        <td style="font-size:10px; text-align: center;"><a href="#" onclick="eliminaValorGES(this, '+ id +');">Eliminar</a></td>\n\
         <input id="txtges_'+ id +'" value="' + COD_PROBLEMAGES +'" type="hidden"></tr>';
        $("#id2").append(txt2); 
}

function abrirges(){//Abrir tabla ges
        document.getElementById('id2').style.display = "";
        document.getElementById('AreaDescDiagno').style.display = "none";
        document.getElementById("dps").style.width = "140px";
        document.getElementById("dsps").style.width = "120px";
        document.getElementById("id2").style.width = "100%";
}

function marcarestadoges(codestadoges, id){
    $('#Estado' + id).val(codestadoges);//Marcar el estado GES
}

function marcarsubproblema(id, codsubproblemages){
    $('#sub-problema' + id).val(codsubproblemages);//Marcar el subproblema GES
}

function cargapopup(val,val2, val3, val4){
    
    $("#rcePopUp").dialog('open');
    document.body.style['overflow-y'] = 'hidden';
    document.body.style['overflow-x'] = 'hidden';
    var codpolic = $('#nom_poli').val();
    var codpoli = codpolic.split(",");
    codpoli = codpoli[0];

    var polivalue = document.getElementById("nom_poli");
    var policlinico = polivalue.options[polivalue.selectedIndex].text;// Capturar policlinico seleccionado
    
    var valor1 = $('#nom_poli').val();
    var valor = $('#fechas').val();
    
    var res = valor1.split(",");
    var codespeci = res[0];
    var codpromed = res[1];
    
    var funcion = 'abreatencion';
    var variables={"val":val, "val2":val2, "val3":val3, "policlinico":policlinico, "codespeci":codespeci, "codpromed":codpromed, "val4":val4, "codpoli":codpoli}
    $(document).bind('keydown',function(i){ //Mensaje al presionar boton escape  
        if ($("#rcePopUp").is(":visible")){//si el popup esta open tomo la tecla ESC 
      if ( i.which === 27 ) {
        cancelar();
      };
      }});

    var id="rcePopUp";
    ajax_rceespecialidades(variables,id, funcion);
}

function certificados(){//popup certificados 
    $('#todos').focus();
    $("#certificados").dialog('open');
    
    var variables={"funcion": 12}
    var id="certificados";
    ajax_rceespecialidades(variables,id);
}

function historialclinico(nfichae){ //Ver Historial clinico del paciente
    $('#todos').focus();
    $("#historialclinico").dialog('open');
    $('#result').html('');
    $('#numFichaE').val(nfichae);
    $('#btBusqHis').attr('href', '#ui-id-2')
    buscar();
}

function loaddatos(){
    
        var funcion = "inicio"
	var variables={}
		var id="consultadatos";
		ajax_rceespecialidades(variables,id, funcion);
};

function cerrarformcomplete(){
    document.getElementById('muestralista').style.display = "none"; //Cierre desplegar complete diagnostico
    $("#completediagnostico").val('');//borro el contenido dentro del textbox 
}

function busquedaenter(event, segundovalor){//busca diagnosticos con descripcion (textarea)
    var asd = '';
     var x = event.which || event.keyCode;
             var uno = 1;
     if(x == 13 || segundovalor == 13){//si el usuario presiona enter tomo el valor de X si no tomo el segundovalor que simula un enter con onblur
    var text = document.getElementById("textAreaDiagnoEspeci").value;
    var words = text.split("\n");
    for(var i = 0; i<words.length; i++){

    var aLineas = document.getElementById("textAreaDiagnoEspeci").value.split('\n');
	 var numlinea = aLineas.length - parseInt(uno);//le resto 1 porque empieza a contar desde 1 y no de 0

        if(numlinea == i){
            
        var a = words[i];
        
        agregaradiag(a);
        
        if(words[i] == ''){
                var valorpasa = parseInt(numlinea)-parseInt(uno);//le resto 1 a la linea para llegar a la actual
        $("#numlineadiag").val(valorpasa);
        
       
        a = text.split("\n");
        for(i=0;i<a.length;i++){
            var aaa = a[i];
           if(aaa == ''){
               
           }else{
            asd +=  a[i] + '\n';
        }
        }
        
        $("#textAreaDiagnoEspeci").val(asd);
        
            }else{
        var valorpasa = parseInt(numlinea)+parseInt(uno);//le sumo 1 a la linea para llegar a la actual
        $("#numlineadiag").val(valorpasa);
        }
        
        if(segundovalor != 13){
               var valorpasa = parseInt(numlinea)-parseInt(uno);//le resto 1 a la linea para llegar a la actual
        $("#numlineadiag").val(valorpasa);
        }
    }else{
        
    }
  }
 }
}

function cerrarformactividades(){
    document.getElementById('muestralistaact').style.display = "none"; //Cierre desplegar complete actividades
}

function cerrarformprocedimientos(){
    document.getElementById('muestralistaproced').style.display = "none"; //Cierre desplegar complete procedimientos
}

function buscardatos(){//Buscar datos de los policlinicos
     document.getElementById("consultadatos3").innerHTML="";
    var valor = $('#fechas').val();
    
    if(valor != 0){
        var funcion = 'buscarpolixfecha';
    	var variables={"valor":valor}
		var id="consultadatos333";
		ajax_rceespecialidades(variables,id, funcion);
            }
}

function buscardato1(){//Generar la tabla de los pacientes con cita
    
    var valor1 = $('#nom_poli').val();
    
    if(valor1 === '0'){//Select es = a Seleccione
       document.getElementById('despliegepoli').style.display = "none";	
    }else{
    var valor = $('#fechas').val();
    var res = valor1.split(",");
    var codespeci = res[0];
    var codpromed = res[1];
    var tipoagenda = res[2];
     var funcion = 'buscarpacxpoli';
    	var variables={"valor1":valor1, "valor":valor, "codespeci":codespeci, "codpromed":codpromed, "tipoagenda":tipoagenda}
		var id="consultadatos3";
		ajax_rceespecialidades(variables,id, funcion);
            }
}

function validaciones(){
      if (document.getElementById('tcierreclinico').value == "0" ) { //Validación Select option Tipo cierre clinico
                document.getElementById('tcierreclinico').focus()
                jAlert("Por favor Seleccione una opción en: Tipo de Cierre Clínico", "Información");
                return false;
        };
           if (document.getElementById('descierreclinico').value == "0" ) { //Validación Select option Destino
                document.getElementById('descierreclinico').focus()
                jAlert("Por favor Seleccione una opción en: Destino", "Información");
                return false;
        };
         if (document.getElementById('cboTiempoControl').value == "0" ) { //Validación Select option en Tiempo Control
                document.getElementById('cboTiempoControl').focus()
                jAlert("Por favor Seleccione una opción en: Tiempo Control", "Información");
                return false;
        };
        if (document.getElementById('descierreclinico').value == "10" ) {//Comprobar si campo destino es igual a "Trasladado o Derivado a".
                if (document.getElementById('cboFormaLlegadaCierre').value == "0" ) { //Validación Select option en Medio de Traslado
                document.getElementById('cboFormaLlegadaCierre').focus()
                jAlert("Por favor Seleccione una opción en: Medio de Traslado", "Información");
                return false;
        };
    };

}

function compruebaselectdestino(val){
    
   if(val == 2){ 
       var valorselect = document.getElementById('descierreclinico1').value;
   }else if(val == 1){
       var valorselect = document.getElementById('descierreclinico').value;
   }
   
   $('#selectTiempoControl').val(-1);
   if (valorselect == 5){//otra especialidad
   document.getElementById('cboTiempoControl').style.display = "none";
   document.getElementById('tiempocontroldias').style.display = "none";
   creaselectdiag();
   $('#estabdestin').removeAttr('disabled');
   $('#estabdestin').val(0);
   }else{
   document.getElementById('cboTiempoControl').style.display = "none";
   document.getElementById('tiempocontroldias').style.display = "none";
   }
   
   if (valorselect == 9){
       document.getElementById('cboTiempoControl').style.display = "";
   document.getElementById('tiempocontroldias').style.display = "none";
   }
   
   if (valorselect == 4){
   document.getElementById('cboTiempoControl').style.display = "none";
   $('#estabdestin').removeAttr('disabled');
   $('#estabdestin').val(0);
   }
   
   if (valorselect == 4.5){
   document.getElementById('cboTiempoControl').style.display = "none";
   $('#estabdestin').attr('disabled', 'disabled');
   var estab = $('#codestaborigen').val();
   $('#estabdestin').val(estab);
   }
}


function checkestabselec(){
    var estab = $('#codestaborigen').val();
    var tiporef = $('#tipodrefycref').val();
    var descierreclinico1 = $('#descierreclinico1').val();
    
    if(tiporef == 3){
        if(descierreclinico1 == 4){
            var estabselect = $('#estabdestin').val();
            
            if(estab == estabselect){
                jAlert("El Establecimiento de destino, no puede ser igual al establecimiento de Origen", "Advertencia");
                $('#estabdestin').val(0);
            } 
        }else if(descierreclinico1 == 4.5){
            $('#estabdestin').val(estab);
        }else if(descierreclinico1 == 5){
            var estabselect = $('#estabdestin').val();
            
            if(estab == estabselect){
                jAlert("El Establecimiento de destino, no puede ser igual al establecimiento de Origen", "Advertencia");
                $('#estabdestin').val(0);
            }
        }
    }
}

function compruebatiempcontrol(){
       var valorselect = document.getElementById('selectTiempoControl').value
       
       if(valorselect == '-30'){
           document.getElementById('tiempocontroldias').style.display = "";
       }else{
           document.getElementById('tiempocontroldias').style.display = "none";
       }
}

function mueveReloj(){ 
//   	var momentoActual = new Date() ;
//   	var hora = momentoActual.getHours() ;
//   	var minuto = momentoActual.getMinutes() ;
//
//        if(minuto <= 9){
//            minuto = "0" + minuto;
//        }
////        switch (new Date().getMinutes()) {
////            case 1: case 2:case 3:case 4:
////            case 5:case 6:case 7: case 8: case 9:
////                 minuto = "0" + minuto;
////                 break;
////        }
//   	var horaImprimible = hora + ":" + minuto ;
//
//   	$("#hora").html(horaImprimible);
//        $("#hora0").html(horaImprimible);
////        $("#txtHoraCierre").val(horaImprimible);
//        $("#Hora").val(horaImprimible);
//   	setTimeout("mueveReloj()",1000) 
}

function cancelar(){
    
    jConfirm('Con esta acción perderá la información que no haya sido guardada. \n ¿Está Seguro de Cerrar el Registro de Atención?', 'Confirmación', function(r) {
        if(r){
               $('#rcePopUp').dialog('close'); //Cerrar popup rces
               document.body.style['overflow-y'] = '';
               document.body.style['overflow-x'] = '';
               buscardato1();
               
    	var variables={"funcion": 63}
		var id="guardarce";
		ajax_rceespecialidades(variables,id); 
        } 
    });

}

function cancelarconfirm(){
    $('#rcePopUp').dialog('close'); //Cerrar popup rces
    $('#JConfirm1').dialog('close');
               document.body.style['overflow-y'] = '';
               document.body.style['overflow-x'] = '';
               buscardato1();
               
    	var variables={"funcion": 63}
		var id="guardarce";
		ajax_rceespecialidades(variables,id); 
}

function grabaResp(val){ //Grabar solicitar firma simple
        $("#resConfim").val('');
        $("#JpromtF").dialog("open");
        $("#JpromtMensaje").html('Con esta acci&oacute;n se proceder&aacute; a enviar respuesta a la solicitud.<br /><br />&iquest;Est&aacute; seguro de continuar?');
        $("#JpromtBtn").html('<input class="btnPop"  type="button" value="ACEPTAR" onclick="grabaRespConfs('+val+');"><input type="hidden" id="varConfirm" value="2">');
   
   $('#resConfim').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        
            grabaRespConfs(val);
    }
});

}
function tdanamexamfs(textAreaAnamnesis, textAreaExamen, exyevaluacion, textAreaDiagnoEspeci, textAreaDiagnoOtros, indiplantrat, txtmottvconsulta, txtfectratamiento){
    
    textAreaAnamnesis = textAreaAnamnesis.replace(new RegExp("\aajj","g"), "\n");
    textAreaExamen = textAreaExamen.replace(new RegExp("\aajj","g"), "\n");
    exyevaluacion = exyevaluacion.replace(new RegExp("\aajj","g"), "\n");
    textAreaDiagnoEspeci = textAreaDiagnoEspeci.replace(new RegExp("\aajj","g"), "\n");
    textAreaDiagnoOtros = textAreaDiagnoOtros.replace(new RegExp("\aajj","g"), "\n");
    indiplantrat = indiplantrat.replace(new RegExp("\aajj","g"), "\n");
    txtmottvconsulta = txtmottvconsulta.replace(new RegExp("\aajj","g"), "\n");
    txtfectratamiento = txtfectratamiento.replace(new RegExp("\aajj","g"), "\n");
    
    $('#textAreaAnamnesis').val(textAreaAnamnesis);
    $('#textAreaExamen').val(textAreaExamen);
    $('#exyevaluacion').val(exyevaluacion);
    $('#textAreaDiagnoEspeci').val(textAreaDiagnoEspeci);
    $('#textAreaDiagnoOtros').val(textAreaDiagnoOtros);
    $('#indiplantrat').val(indiplantrat);
    $('#txtmottvconsulta').val(txtmottvconsulta);
    $('#txtfectratamiento').val(txtfectratamiento);
    
}

function grabaRespConfs(val){   
    
    
    var r = $('#resConfim').val();
    	var variables={"funcion": 11, "r":r, "val":val}
		var id="guardarce";
		ajax_rceespecialidades(variables,id);
}

function validacionrce(val){
    $("#diascontrolfff").removeClass('errores');
    $("#pertinenciacierre").removeClass('errores');
    $("#motivopertinencia").removeClass('errores');
    
    var error = 0;
    var errores = '';
    var tipoconsulta = $('#hiddentipconsulta').val();//1 control - 2 interconsulta
    
    
    if(tipoconsulta == 2){
    if($("#pertinenciaSI").is(':checked')) { //Comprobar Radiobutton Pertinencia
        var pertinencia = 1 //1 = SI
        }else if($("#pertinenciaNO").is(':checked')){
        var pertinencia = 0 //0 = NO   
        }else{
        var pertinencia = 2 // No marca
        }
    }

    if(pertinencia == 2){
            error = 1;
            errores += '- Debe especificar la pertinencia\n';
            $("#pertinenciacierre").addClass('errores');
    }
    
    if(pertinencia == 0){
        var motpert = $('#motivonopertinencia').val();
        
        if(motpert == 0){
            error = 1;
            errores += '- Debe especificar el motivo de la pertinencia\n';
            $("#motivopertinencia").addClass('errores');
        }
    }
    
     var tcontrol = $('#selectTiempoControl').val(); // Captura el tiempo de control
     var diascontrol = $('#diascontrolfff').val();//Dias de control si especifica en tcontrol -30 dias
     if(tcontrol == -30){
         if (diascontrol == ''){
             error = 1;
             errores += '- Debe especificar los dias de control\n';
             $("#diascontrolfff").addClass('errores');
         }
         
         if (diascontrol == 0){
             error = 1;
             errores += '- Debe especificar un día válido\n';
             $("#diascontrolfff").addClass('errores');
         }
     }
     
     
     
     if(error == 0){
        grabaResp(val); 
     }else{
         jAlert(errores, "Listado de Errores");
     }
     
}

function grabar(rut){
    $('#JpromtF').dialog('close');
    
    var arrdiag = new Array();
    $('[id^=diagb_]').each(function() {  //Obtener valores de Diagnostico
        
		var objProducto = new Object();

		objProducto.iddiag  	     =    $(this).attr('id');

		objProducto.iddiag           =    objProducto.iddiag.replace('diagb_', '');
                
                objProducto.txtdiagnostico   =    $("#txtdiag_" + objProducto.iddiag).val();
                
                objProducto.txtcie10   =    $("#codcie10_" + objProducto.iddiag).val();
                
                objProducto.clase        =     document.getElementById("tachado_" + objProducto.iddiag).value;
                
                arrdiag.push(objProducto);	     
    });
    
    var arrpges = new Array();
    $('[id^=ges_]').each(function() {  //Obtener valores de Problema GES
        
		var objProducto = new Object();
		
		objProducto.idges  	  =     $(this).attr('id');
                
		objProducto.idges         =     objProducto.idges.replace('ges_', '');
                
                objProducto.txtpges       =     $("#txtges_" + objProducto.idges).val();
                
                objProducto.estado        =     document.getElementById("Estado" + objProducto.idges).value;
                
                objProducto.subproblema   =     document.getElementById("sub-problema" + objProducto.idges).value;
                
                objProducto.desges        =     $("#txtges_" + objProducto.idges).val();
                
                arrpges.push(objProducto);          
               
    });
    
//      var arractv = new Array();
//    $('[id^=actv1_]').each(function() {  //Obtener valores de Actividades
//        
//		var objProductoactv = new Object();
//		
//		objProductoactv.idactv         =    $(this).attr('id');
//                
//		objProductoactv.idactv         =    objProductoactv.idactv.replace('actv1_', '');
//                
//                objProductoactv.txtactividad   =    $("#txtactv_" + objProductoactv.idactv).val();
//                
//                objProductoactv.cant           =    $("#numcant_" + objProductoactv.idactv).val();
//
//                objProductoactv.observ         =    $("#observ_" + objProductoactv.idactv).val();
//                
//                objProductoactv.claseactv      =     document.getElementById("tachadoactv_" + objProductoactv.idactv).value;
//                
//                arractv.push(objProductoactv);	     
//    });
//    
//    var arraproced = new Array();
//    $('[id^=procedb_]').each(function() {  //Obtener valores de Procedimientos
//        
//		var objProductoproced = new Object();
//		
//		objProductoproced.idaproced  	   =    $(this).attr('id');
//                
//		objProductoproced.idaproced        =    objProductoproced.idaproced.replace('procedb_', '');
//                
//                objProductoproced.txtproced        =    $("#txtproced_" + objProductoproced.idaproced).val();
//                
//                objProductoproced.claseproced      =     document.getElementById("tachadoproced_" + objProductoproced.idaproced).value;
//               
//                arraproced.push(objProductoproced);	     
//    });
    
    var des_anamnesis = $('#textAreaAnamnesis').val(); //Obtener valores de Anamnesis
    var des_examenfisico = $('#textAreaExamen').val();// Obtener valores de Examen Fisico
    var exayevaluacion = $('#exyevaluacion').val();// Obtener textarea Exámenes y Evaluación
    var diagdeespeci = $('#textAreaDiagnoEspeci').val(); // textarea Diagnóstico de especialidad
    var otrosdiag = $('#textAreaDiagnoOtros').val();// textarea Otros diagnosticos
    var indiplantrat = $('#indiplantrat').val();// textarea Indicaciones / Plan de Tratamiento
    var motivoconsultaopc = $('#txtmottvconsulta').val();//Motivo Consulta (Opcional)
    
 // <---------------------------------------- COMPROBACION DATOS INTERCONSULTA -----------------------------------------> //
    
     if($("#alta").is(':checked')) { //Comprobar checked Alta
        var alta = 0 //0 = SI
        }else{
            var alta = 1 //1 = NO
        }
            
    if($("#derviaaps").is(':checked')) { //Comprobar checked Deriva APS
        var derviaaps = 0 //0 = SI
    }else{
        var derviaaps = 1 //1 = NO
    }
    
    if($("#confirma").is(':checked')) { //Comprobar Radiobutton Diagnóstico Interconsulta
        var confdiagno = 1 //Confirma 
        }else if($("#descarta").is(':checked')) {
        var confdiagno = 2 //Descarta
        }else if($("#enestudio").is(':checked')) {
        var confdiagno = 3  //En estudio
        }else if($("#entratamiento").is(':checked')) {
        var confdiagno = 4  //En tratamiento  
        }else{
            var confdiagno = 0  // Vacio
        }
        
    if($("#pertinenciaSI").is(':checked')) { //Comprobar Radiobutton Pertinencia
        var pertinencia = 1 //1 = SI
        }else if($("#pertinenciaNO").is(':checked')){
        var pertinencia = 0 //0 = NO   
        }else{
        var pertinencia = 2 // No aplica (CONTROL)
        }
    
    motpert = 0;
    if(pertinencia == 0){//Indica que no es pertinente y debe indicar el motivo
        var motpert = $('#motivonopertinencia').val();
    }    
    
    if($("#atendido").is(':checked')) { //Comprobar checked Atendido
        var atendido = 'S'//S = SI
    }else{
        var atendido = 'N'//N = NO
    }
    // <---------------------------------------- COMPROBACION DATOS INTERCONSULTA ----------------------------------------->//
    
     var fecinitrat = $('#txtfectratamiento').val();
     var cierrecli = $('#descierreclinico').val(); // Capturar Tipo Cierre Clínico
     
     var especidestino = '';
     var selectcie10motivo = '';
     
     if(cierrecli == 5){
         especidestino = $('#especidestino').val();
         selectcie10motivo = $('#selectcie10motivo').val();
     }
     
     var tcontrol = $('#selectTiempoControl').val(); // Captura el tiempo de control
     var diascontrol = $('#diascontrolfff').val();//Dias de control si especifica en tcontrol -30 dias
    
     if(diascontrol == ''){
         diascontrol = 0;
     }
     
     var funcion = "grabar";
      var variables={"funcion": 9,"arrdiag": arrdiag, "des_anamnesis": des_anamnesis, "des_examenfisico":des_examenfisico, "arrpges":arrpges, "confdiagno":confdiagno, "pertinencia":pertinencia, 
      "cierrecli":cierrecli, "alta":alta, "derviaaps":derviaaps, "exayevaluacion":exayevaluacion, "rut":rut,
      "diagdeespeci":diagdeespeci, "otrosdiag":otrosdiag, "indiplantrat":indiplantrat, "motivoconsultaopc":motivoconsultaopc, "fecinitrat":fecinitrat, "especidestino":especidestino, "selectcie10motivo":selectcie10motivo,
      "tcontrol":tcontrol, "diascontrol":diascontrol, "motpert":motpert};
        var id="consultadiag";

    ajax_rceespecialidades(variables, id, funcion); 
}

function compruebacontraref(){
    if($("#contraSI").is(':checked')) {
       document.getElementById('contra').style.display = ""; 
    }else if($("#contraNO").is(':checked')){
       document.getElementById('contra').style.display = "none";
    }
}

function validardatoic(){
    if($("#alta").is(':checked')) { //Comprobar checked Alta
        var alta = 1 //1 = SI
        }else{
            var alta = 0 //0 = NO
        }
        
    if($("#derviaaps").is(':checked')) { //Comprobar checked Deriva APS
        var derviaaps = 1 //1 = SI
    }else{
        var derviaaps = 0 //0 = NO
    }
    
    if($("#confirma").is(':checked')) { //Comprobar Radiobutton Diagnóstico Interconsulta
        var confdiagno = 1 //Confirma 
        }else if($("#descarta").is(':checked')) {
        var confdiagno = 2 //Descarta
        }else if($("#enestudio").is(':checked')) {
        var confdiagno = 3  //En estudio
        }else if($("#entratamiento").is(':checked')) {
        var confdiagno = 4  //En tratamiento  
        }
        
    if($("#pertinencia").is(':checked')) { //Comprobar checked Pertinencia
        var pertinencia = 1 //1 = SI
        }else{
        var pertinencia = 2 //2 = NO   
        }
    
    if($("#addp").is(':checked')) { //Comprobar checked Atención dentro del plazo
        var addp = 1//1 = SI
    }else{
        var addp = 2//2 = NO
    }
    
    if($("#atendido").is(':checked')) { //Comprobar checked Atendido
        var atendido = 'S'//S = SI
    }else{
        var atendido = 'N'//N = NO
    }
     
}

function ValidaFirma(){
     jPrompt('Con esta acci&oacute;n se proceder&aacute; a realizar la impresi&oacute;n de la Ficha Cl&iacute;nica.<br /><br />&iquest;Est&aacute; seguro de continuar?','', 'Confirmaci\u00f3n', function (r) {
                if (r) {

                var variables={"funcion": 8,"clave": r};
                var id="clave";
                
                ajax_rceespecialidades(variables, id);
                
                }
            });
}

function traedatosrce(){
    
    var funcion = "traedatosrce";
    var variables={}
		var id="traedatos";
		ajax_rceespecialidades(variables,id, funcion);
}

function traediagnostico(iddiag, desdiagnostico, cie10){
    var tach = 0;
    var txt1 = '<tr class="formulario"><td style="font-size:10px; width: 481px;" id="diagb_'+ iddiag +'">' + desdiagnostico +' </td><td id="diag_'+ iddiag +'xagregar" style="width:20px;"><td id="diag_'+ iddiag +'xremove" style="width: 20px;"><a onclick="rayardiag(\'diag_'+ iddiag + '\'\);"><img src="ext/RCEESPECIALIDADES/img/borrar.gif" /></a>\n\
</td><input id="txtdiag_'+ iddiag +'" value="' + desdiagnostico +'" type="hidden">\n\
<input type="hidden" id="tachado_'+ iddiag +'" value='+tach+'> \n\
<input type="hidden" id="codcie10_'+ iddiag +'" value='+cie10+'></td></tr>';
    $("#id1").append(txt1); 
}

function traeactividades(idactv, desactv, num, observacion){
    var tachactv = 0;
    var txt1 = '<tr class="formulario"><td style="font-size:10px; width: 1000px;" id="actv1_'+ idactv +'">' + desactv +' </td><td style="width: 100px;"><input type="text" id="numcant_'+ idactv + '\" size="4" value="1" placeholder="cant." style="width: 30px;"></td><td style="width: 100px;"><input type="text" id="\observ_'+ idactv + '\" size="25" value="" placeholder="Observacion"></td><td id="actv_'+ idactv +'xagregaractv" style="width: 100px;"><td id="actv_'+ idactv +'xremoveactv" style="width: 50px;"><a onclick="rayaractividad(\'actv_'+ idactv + '\'\);"><img src="ext/RCEESPECIALIDADES/img/borrar.gif" style="margin-right: 10px;" /></a>\n\
</td><input id="txtactv_'+ idactv +'" value="' + desactv +'" type="hidden">\n\
<input type="hidden" id="tachadoactv_'+ idactv +'" value='+tachactv+'></td></tr>';
    $("#muestractv").append(txt1); 
    $("#observ_" + idactv).val(observacion);
    $("#numcant_" + idactv).val(num);
}

function traeprocedimientos(codprocedi, desprocedimiento){
    var tachaproced = 0;
     var txt1 = '<tr class="formulario"><td style="font-size:10px; width: 1000px;" id="procedb_'+ codprocedi +'">' + desprocedimiento +' </td><td id="proced_'+ codprocedi +'xagregarproced"><td id="proced_'+ codprocedi +'xremoveproced" style="width: 50px;"><a onclick="rayarprocedimientos(\'proced_'+ codprocedi + '\'\);"><img src="ext/RCEESPECIALIDADES/img/borrar.gif" /></a>\n\
    </td><input id="txtproced_'+ codprocedi +'" value="' + desprocedimiento +'" type="hidden">\n\
    <input type="hidden" id="tachadoproced_'+ codprocedi +'" value='+tachaproced+'></td></tr>';
    $("#procedimientos1").append(txt1); 
}

function traedatosic(confdiagnos, pertinente, dentroplazo){ // TRAE DATOS INTERCONSULTA
    
   if(confdiagnos == 1){ // Diagnostico es = confirma
       $("#confirma").prop("checked", "checked");
   }else if(confdiagnos == 2){ // Diagnostico es = descarta
       $("#descarta").prop("checked", "checked");
   }else if(confdiagnos == 3){//Diagnostico es = en estudio
       $("#enestudio").prop("checked", "checked");
   }else if(confdiagnos == 4){//Diagnostico es = en tratamiento
       $("#entratamiento").prop("checked", "checked");
   }
   
   if(pertinente == 1){ // TRAE Pertinencia
       $("#pertinenciaSI").prop("checked", "checked"); // Pertinencia = si
   }else if(pertinente == 2){
       $("#pertinenciaNO").prop("checked", "checked");// Pertinencia = no
   }
   
   if(dentroplazo == 1){//TRAE Atención dentro del plazo
       $("#addpSI").prop("checked", "checked");// Atención dentro del plazo = si
   }else if(dentroplazo == 2){
       $("#addpNO").prop("checked", "checked");// Atención dentro del plazo = no
   }
}

function traecierreatencion(EA_ID_ESTADOATENCION, CA_NUMDIASSOBRECUPO, CA_PERTINENCIA, CA_TIEMPOCONTROL){
    
    $('#selectTiempoControl').val(CA_TIEMPOCONTROL);//Marcar tiempo control
    $('#descierreclinico').val(EA_ID_ESTADOATENCION);//Marcar Tipo Cierre Clínico
    $('#diascontrolfff').val(CA_NUMDIASSOBRECUPO);//Dias control
    
    if(CA_PERTINENCIA == 1){//Comprobar Alta
        $("#pertinenciaSI").prop("checked", "checked"); //pertinencia es = SI
    }else if(CA_PERTINENCIA == 0){
        $("#pertinenciaNO").prop("checked", "checked");//pertinencia es = no
    }
    
     if(CA_TIEMPOCONTROL == '-30'){
           document.getElementById('tiempocontroldias').style.display = "";
       }else{
           document.getElementById('tiempocontroldias').style.display = "none";
       }
   
}

function marcatipocierrexdefecto(){
     $('#tcierreclinico').val(1); //con atencion
}

///////////////////////////////////////REF & CREF///////////////////////////////////////
function compruebarefycref(){
    $('#todos').focus();
    var variables={"funcion": 12.9}
    var id="consultadiag";
    ajax_rceespecialidades(variables,id);
}
function refycref(tiporef, interpara, motivo, icdesde){ //HTML Referencia y Contraref
    $('#todos').focus();
    $("#refycref").dialog('open');
    
    if(tiporef == 1){
        $('#ui-id-7').html("Interconsulta de Exámenes");
    }else if(tiporef == 2){
        $('#ui-id-7').html("Interconsulta de Procedimientos");
    }else if(tiporef == 3){
        $('#ui-id-7').html("Interconsulta de Derivación");
    }
   
    var variables={"funcion": 13, "tiporef":tiporef, "interpara":interpara, "motivo":motivo, "icdesde":icdesde, "tiporef":tiporef}
    var id="refycref";
    ajax_rceespecialidades(variables,id);
}

function marcaopcrefycref(tiporef, interpara, motivo, icdesde){
    
    $('#cboTipoic').val(interpara);//Marca interconsulta para
    motivos(motivo);

    $('#cbomotivo').val(motivo); //Marca Motivo
    
    $('#cboDestinoic').val(icdesde); //La I.C. va desde un
    poliorigen();
    
    var anamnesis = $('#textAreaAnamnesis').val();
    $('#txtHipodiag').val(anamnesis);
    
    var exyevaluacion = $('#exyevaluacion').val();
    $('#txtExamenes').val(exyevaluacion);
    
    var textAreaDiagnoEspeci = $('#textAreaDiagnoEspeci').val();
    $('#txtDesDiagno').val(textAreaDiagnoEspeci);
    $('#txtFundadiag').val(textAreaDiagnoEspeci);
    
    if(tiporef == 3){
        document.getElementById('tipdirevacionref').style.display = "";
    }
    
    if(tiporef == 3){
        document.getElementById('tdimgteledermat').style.display = "";
    }
}

function cierraformrefcref(){
    $("#refycref").dialog('close');
}
function motivos(opccref){//Consulta trae motivos segun interconsulta
    
    var interpara = $('#cboTipoic').val();
    
    var variables={"funcion": 14, "interpara":interpara, "opccref":opccref}
    var id="cargarefycref";
    ajax_rceespecialidades(variables,id);
}

function llenamotivos(value, opcion){ // Llena select option motivos
  
    var result = '<option value=' + value + '>' + opcion + '</option>'
    $("#cbomotivo").append(result); 
     
}

function poliorigen(){//Consultas Policlínico o servicio clínico de origen
    
    var iconsulta = document.getElementById('cboDestinoic').selectedIndex;
    var motivo = $('#cbomotivo').val();
    var variables={"funcion": 15, "motivo":motivo, "iconsulta":iconsulta}
    var id="cargarefycref";
    ajax_rceespecialidades(variables,id);
}

function optionseleccioneorigen(){ // Llenar select option seleccione
    var result1 = '<option value=0>Seleccione</option>'
    $("#cboPoliproce").append(result1);
}
function llenapoliorigen(codigo, nombre){ //Llena select option Policlínico o servicio clínico de origen	
    
    var result = '<option value=' + codigo + '>' + codigo + ' - ' + nombre + '</option>'
    $("#cboPoliproce").append(result); 
}

function buscarnomestable(){ //buscar nombre de establecimiento
    
    var codestab = $('#txtEstablref').val();
    if(codestab != ''){
    var variables={"funcion": 16, "codestab":codestab}
    var id="cargarefycref";
    ajax_rceespecialidades(variables,id);
    }
}

function buscarnomestable2(){ //buscar nombre de establecimiento
    
    var codestab = $('#txtEstablref').val();
    if(codestab != ''){
    var variables={"funcion": 16, "codestab":codestab}
    var id="cargacestabs";
    ajax_rceespecialidades(variables,id);
    }
}

function cargaespdestino(){//consulta especialidad de destino
    
    var variables={"funcion": 17}
    var id="cargarefycref";
    ajax_rceespecialidades(variables,id);
}

function llenaespdestino(value, opcion){ // Llenar especialidad de destino
 
    var result = '<option value=' + value + '>' + value + ' - ' + opcion + '</option>'
    $("#cboEspecialidaD").append(result); 
}

function buscaPoliservuniref(){ //Policlínico, servicio clínico, examen, procedimiento o procedimiento quirúrgico de destino
    
    var error = '0';
    var tipoic = $("#cboTipoic").val();
    var motivoic = $("#cbomotivo").val();
    var destinoic = $("#cboDestinoic").val();
    var especref = $("#cboEspecialidaD").val();
    
    $("#cb_polixespc option[value=0]").attr("selected",true);
    
    if (tipoic == "0") {
		jAlert("Debe Indicar el Tipo de Interconsulta", "Error");
                error = '1';
	}
	if (destinoic == "-1") {
		jAlert("Debe Indicar el Destino de la Interconsulta", "Error");
                error = '1';
	}
	if (especref == "") {
		jAlert("Debe Indicar la Especialidad de Destino", "Error");
                error = '1';
	}
        
    if(error == 0){    
    var variables={"funcion": 18, "tipoic":tipoic, "motivoic":motivoic, "destinoic":destinoic, "especref":especref}
    var id="cargarefycref";
    ajax_rceespecialidades(variables,id);
    }
}

function llenaPoliservuniref(value, opcion){ // LLenar select option Policlínico, servicio clínico, examen, procedimiento o procedimiento quirúrgico de destino
    
    var result = '<option value=' + value + '>' + value + ' - ' + opcion + '</option>'
    $("#cb_polixespc").append(result); 
}

function optionseleccionePoliservuniref(){
    
    var result1 = '<option value=0>Seleccione</option>'
    $("#cb_polixespc").append(result1);
}

function busquedacie10(){//abre popup y html busqueda cie10
    
    $("#cie10").dialog('open');
    
    var variables={"funcion": 19}
    var id="cie10";
    ajax_rceespecialidades(variables,id);
}

function buscarcie10xnomxcod(){
    
    var buscarpor= $("#cboBuscar10").val(); //select option buscar por
    var ordernarpor = $("#cboOrdenar10").val(); //select option ordernar por
    var txtcie10= $("#txtBuscar10").val(); // campo txt ingreso de busqueda
    var error = 0;
    var erroress = '';
    $('#txtBuscar10').removeClass('errores');
    
    if(txtcie10 == ''){
        error = 1;
        erroress += '- Debe especificar un valor de busqueda\n';
        $('#txtBuscar10').addClass('errores');
    }
    
    if(error == 0){
    var variables={"funcion": 20, "buscarpor":buscarpor, "ordernarpor":ordernarpor, "txtcie10":txtcie10}
    var id="busquedacie10";
    ajax_rceespecialidades(variables,id);
    }else{
        jAlert(erroress, "Listado de errores");
    }
}

function pasarvalorcie10(cod_diagno, nom_diagno){//pasar valores seleccionados de la tabla a los campos de cie10
    
    document.getElementById("txtcodcie1").value = cod_diagno;
    document.getElementById("lblCie10").value = nom_diagno;
    
    $("#cie10").dialog('close');
}

function buscarestablecimiento(){//abrir popup y cargar html buscar establecimiento
    $("#establecimiento").dialog('open');
    
    var variables={"funcion": 21}
    var id="establecimiento";
    ajax_rceespecialidades(variables,id);
}

function buscarestblxnomxcod(){
    
    var buscarporestb = $("#cboBuscar").val(); //select option buscar por
    var ordernarporestb = $("#cboOrdenar").val(); //select option ordernar por
    var txtestb = $("#txtBuscar").val(); // campo txt ingreso de busqueda
    
    var variables={"funcion": 22, "buscarporestb":buscarporestb, "ordernarporestb":ordernarporestb, "txtestb":txtestb}
    var id="busquedaestabl";
    ajax_rceespecialidades(variables,id);
}

function pasarvalorestablecimiento(cod_empresa, nom_empresa){//paso los valores seleccionados de la tabla
    
    document.getElementById("txtEstablref").value = cod_empresa;
    document.getElementById("lblEstablref").value = nom_empresa;
    
    $("#establecimiento").dialog('close');
}

function buscarcie10xcodigo(){ //buscar cie10 x codigo
    
    var codigocie = $('#txtcodcie1').val();
    if(codigocie != ''){
    var variables={"funcion": 23, "codigocie":codigocie}
    var id="cargarefycref";
    ajax_rceespecialidades(variables,id);
    }
}

function traediagnosticorefcref(){//Trae diagnosticos
    
    var variables={"funcion": 24}
    var id="cargadediag";
    ajax_rceespecialidades(variables,id);
}

function llenadiagrefcref(iddiagno, desdiagnostico){

    document.getElementById("txtFundadiag").value = desdiagnostico;
    document.getElementById("txtDesDiagno").value = desdiagnostico;
}

function imprimeinformekinesico(numcorrel, codempresa, clavetemp, codpromed, codespeci){
    
     if(impresion != null){
        impresion.close()
    }
    
    var anchura = screen.width ;
    var altura = screen.height ;
    var opciones = 'top=0,left=0,toolbar=0,location=0,directories=0, status=0,menubar=0,scrollbars=0,resizable=0' +
    ',width=' + anchura +
    ',height=' + altura ;
    
    impresion = window.open('ext/RCEESPECIALIDADES/class/informekinesico.php?ncorrel=' + numcorrel + '&cempresa=' + codempresa + '&codpromed=' + codpromed + '&codespeci=' + codespeci + '&i=' + clavetemp,'Impresión de Informe Kinésico',opciones) ; 
}

function compruebaimprime(){
    
    if($("#informekinesicoSI").is(':checked')) {
        var valkinesico = 1;
    }else{
        var valkinesico = 0;
    }

    ImprimeDoc(valkinesico);
}

function ImprimeDoc(valkinesico){ //Grabar solicitar firma simple
        $("#resConfim").val('');
        $("#JpromtF").dialog("open");
        $("#JpromtMensaje").html('Con esta acci&oacute;n se proceder&aacute; a enviar respuesta a la solicitud.<br /><br />&iquest;Est&aacute; seguro de continuar?');
        $("#JpromtBtn").html('<input class="btnPop"  type="button" value="ACEPTAR" onclick="grabaRespConfsdoc('+ valkinesico +');"><input type="hidden" id="varConfirm" value="2">');
   
   $('#resConfim').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        
            grabaRespConfsdoc(valkinesico);
    }
});

}

function grabaRespConfsdoc(valkinesico){   
 
    var res = $('#resConfim').val();
    	var variables={"funcion": 25, "res":res, "valkinesico":valkinesico}
		var id="guardarce";
		ajax_rceespecialidades(variables,id);
}

function buscargesrefycref(){//cargar html tabla buscar ges
    var cboIndges = $('#cboIndges').val();
    
    if(cboIndges == '0'){//ges no
        jAlert("Debe indicar que Es una I.C. por G.E.S", "Error");
        $('#cboIndges').addClass('errores');
    }else if(cboIndges == '1'){//ges si
    $("#bges").dialog('open');
    var variables={"funcion": 28}
    var id="bges";
    ajax_rceespecialidades(variables,id);
    }
}   

function buscargesxnomxcod(){//Buscar ges por nombre o codigo
    
    var buscarporges = $("#cboBuscarG").val(); //select option buscar por
    var ordernarporges = $("#cboOrdenarG").val(); //select option ordernar por
    var txtges = $("#txtBuscarG").val(); // campo txt ingreso de busqueda
    
    var variables={"funcion": 29, "buscarporges":buscarporges, "ordernarporges":ordernarporges, "txtges":txtges}
    var id="busquedages";
    ajax_rceespecialidades(variables,id);
}

 function pasarvaloresges($cod_ges, des_ges){//paso los valores seleccionados de la tabla
    
    document.getElementById("txtPatGes").value = $cod_ges;
    document.getElementById("lblPatges").value = des_ges;
    
    $("#bges").dialog('close');
}

function revisaPatGes(){
    var cboIndges = $('#cboIndges').val();
    
    if(cboIndges == '0'){//ges no
        document.getElementById("txtPatGes").disabled = true;
        document.getElementById("txtPatGes").value = '';
        document.getElementById("lblPatges").value = '';
    }else if(cboIndges == '1'){//ges si
        document.getElementById("txtPatGes").disabled = false;
        $('#cboIndges').removeClass('errores');
    }
}

function buscargesxcod(){ //buscar nombre de establecimiento
    
    document.getElementById("txtPatGes").disabled = false;
    var txtPatGes = $('#txtPatGes').val();
    if(txtPatGes != ''){
    var variables={"funcion": 30, "txtPatGes":txtPatGes}
    var id="cargarefycref";
    ajax_rceespecialidades(variables,id);
    }
}
function chequeaimagen(){//Desplegar Imagen Tele Dermatología
    
    var especialidaddes = document.getElementById('cboEspecialidaD').value;
    var cb_polixespc = document.getElementById('cb_polixespc').value;
    document.getElementById('tabareaimagen1').style.display = "none";
    document.getElementById('divareaimagen1').style.display = "none";
   tipoic= $("#cboTipoic").val();
            motivoic= $("#cbomotivo").val();
            destinoic= $("#cboDestinoic").val();
            especref= $("#cboEspecialidaD").val(); 
            error = "";

            if (tipoic == "-1") {
                    error += ' - Debe Indicar el Tipo de Interconsulta.\n';
            }else if (tipoic != "1"){
                    error += ' - Solo Aplica a Interconsultas para Consulta Medica.\n';
            }
            if (destinoic == "-1") {
                    error += ' - Debe Indicar el Destino de la Interconsulta.\n';
            }
            if (especref == "") {
                    error += ' - Debe Indicar la Especialidad de Destino.\n';
            }
                                            if ($("#cb_polixespc").val()=='TELD01')
                                            {
                                                if($("#chkImgTele").is(':checked')){
                                                    document.getElementById('tabareaimagen1').style.display = "block";
                                                    document.getElementById('divareaimagen1').style.display = "block";
                                                }}else{
                                                    error += '- Debe Seleccionar el Poli de Teledermatologia';
                                            }
                    if (error != ''){jAlert(error,'Listado errores');$("#chkImgTele").prop("checked", "");}
    }
    
function imagentelederma(){ //funcion para guardar la imagen de tele dermatologia
    var ruta;
   $('#tablaimagenes tr').each(function(index, element){
    ruta = $(element).find("td").eq(4).html()
    
    alert(ruta);
});
}

function grabarefycreffirmas(){ //Grabar solicitar firma simple
 var errores = '0';
    var error = '';
    motivoic= $("#cbomotivo").val(); //Capturo el motivo
    destinoic= $("#cboDestinoic").val();//Capturo el destino
    especref= $("#cboEspecialidaD").val(); //Especialidad de Destino
    codigocie = $('#selectcie10motivo').val(); //Codigo CIE10
    desfundadiag = $('#txtFundadiag').val();//Fundamentos del diagnóstico y derivación de acuerdo a criterios y protocolos
    desdiagno = $('#txtDesDiagno').val();//Sospecha diagnóstica clara y específica concerniente a la especialidad
    estabdestino = $('#estabdestin').val();//Establecimiento de destino
    polixespc = $('#cb_polixespc').val();//Policlínico, servicio clínico, examen, procedimiento o procedimiento quirúrgico de destino
    interpara = $('#cboTipoic').val();//Interconsulta para
    cboDestinoic = $('#cboDestinoic').val();//La I.C. va desde un
    cboPoliproce = $('#cboPoliproce').val();//Policlínico o servicio clínico de origen
    txtHipodiag = $('#txtHipodiag').val();//Resumen Historia Bio-Psico-Social
    txtFecrecepcion = $('#txtFecrecepcion').val();//Fecha solicitud interconsulta
    txtEspprocexa = $('#txtEspprocexa').val();//Especificación de Examen, Procedimiento o Procedimiento Quirúrgico
    txtExamenes = $('#txtExamenes').val();//Exámenes realizados y/o tratamientos intentados
    cboIndges = $('#cboIndges').val();//¿Es una I.C. por G.E.S?
    numfolio = $('#numfolio').val();//Capturar el numero de folio
    txtPatGes = $('#txtPatGes').val();//Caputar pat Ges
    
        $("#cbomotivo").removeClass('errores');
        $("#cboDestinoic").removeClass('errores');
        $("#cboEspecialidaD").removeClass('errores');
        $('#selectcie10motivo').removeClass('errores');                         ///////Remover la clase de errores para volver a comprobar
        $('#txtFundadiag').removeClass('errores');
        $('#txtDesDiagno').removeClass('errores');
        $('#estabdestino').removeClass('errores');
        $('#cb_polixespc').removeClass('errores');
        $('#cboTipoic').removeClass('errores');
        $('#cboDestinoic').removeClass('errores');
        $('#cboPoliproce').removeClass('errores');
        $('#txtHipodiag').removeClass('errores');
        $('#txtFecrecepcion').removeClass('errores');
        $('#cboIndges').removeClass('errores');
        $('#txtPatGes').removeClass('errores');
        
    if(motivoic == '0'){
        error += ' - Debe completar un motivo.\n';
        $("#cbomotivo").addClass('errores');
        errores = '1';
    }
    
    if(destinoic == '-1'){
        error += ' - Debe Indicar el Destino de la Interconsulta.\n';
        $("#cboDestinoic").addClass('errores');
        errores = '1';
    }
    
    if(especref == '0'){
        error += ' - Debe Seleccionar una Especialidad de Destino.\n';
        $("#cboEspecialidaD").addClass('errores');
        errores = '1';
    }
    
    if(codigocie == 0){
        error += ' - Debe seleccionar el Diagnóstico CIE 10.\n';
        $('#selectcie10motivo').addClass('errores'); 
        errores = '1';
    }
    
    if(desfundadiag == ''){
        error += ' - Debe ingresar los fundamentos del diagnóstico.\n';
        $('#txtFundadiag').addClass('errores');
        errores = '1';
    }
    
    if(desdiagno == ''){
        error += ' - Debe ingresar la descripción del diagnóstico.\n';
        $('#txtDesDiagno').addClass('errores');
        errores = '1';
    }
    
    if(estabdestino == 0){
        error += ' - Debe seleccionar el establecimiento de destino.\n';
        $('#estabdestin').addClass('errores');
        errores = '1';
    }
    
    if(polixespc == '0'){
        error += ' - Debe ingresar el policlínico de destino.\n';
        $('#cb_polixespc').addClass('errores');
        errores = '1';
    }
    
    if(interpara == '0'){
        error += ' - Debe especificar para que es la I.C.\n';
        $('#cboTipoic').addClass('errores');
        errores = '1';
    }
    
    if(cboDestinoic == '-1'){
        error += ' - Debe especificar procedencia de la I.C.\n';
        $('#cboDestinoic').addClass('errores');
        errores = '1';
    }
    
    if(cboPoliproce == '-1'){
        error += ' - Debe ingresar el policlínico o servicio clínico de origen.\n';
        $('#cboPoliproce').addClass('errores');
        errores = '1';
    }
    
    if(txtHipodiag == ''){
        error += ' - Debe ingresar el resumen de la historia clínica.\n';
        $('#txtHipodiag').addClass('errores');
        errores = '1';
    }
    
    if(txtFecrecepcion == ''){
        error += ' - Debe ingresar la fecha de recepción.\n';
        $('#txtFecrecepcion').addClass('errores');
        errores = '1';
    }
       
    if(cboIndges == '0'){//ges no
        
    }else if(cboIndges == '1'){//ges si
        txtPatGes = $('#txtPatGes').val();
        
        if(txtPatGes == ''){
        error += ' - Debe especificar la patología GES.\n';
        $('#txtPatGes').addClass('errores');
        errores = '1';
        }
    }
    
    if($("#chkImgTele").is(':checked')){
        imageninter = '1';//si imagen
    }else{
        imageninter = '2';//no
    }

    if(error == 0){
        $("#resConfim").val('');
        $("#JpromtF").dialog("open");
        $("#JpromtMensaje").html('Con esta acci&oacute;n se proceder&aacute; a enviar respuesta a la solicitud.<br /><br />&iquest;Est&aacute; seguro de continuar?');
        $("#JpromtBtn").html('<input class="btnPop"  type="button" value="ACEPTAR" onclick="grabarrefycrefconf();"><input type="hidden" id="varConfirm" value="2">');
   
   $('#resConfim').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        
            grabarrefycrefconf();
    }
});
    }else{
             jAlert(error, "Listado de Errores");
         }
}

function grabarrefycrefconf(){   
    
    
    var r = $('#resConfim').val();
    	var variables={"funcion": 41, "r":r}
		var id="cargarefycref";
		ajax_rceespecialidades(variables,id);
}

function grabarrefycref(rutgraba){
    var errores = '0';
    var error = '';
    motivoic= $("#cbomotivo").val(); //Capturo el motivo
    destinoic= $("#cboDestinoic").val();//Capturo el destino
    especref= $("#cboEspecialidaD").val(); //Especialidad de Destino
    codigocie = $('#selectcie10motivo').val(); //Codigo CIE10
    desfundadiag = $('#txtFundadiag').val();//Fundamentos del diagnóstico y derivación de acuerdo a criterios y protocolos
    desdiagno = $('#txtDesDiagno').val();//Sospecha diagnóstica clara y específica concerniente a la especialidad
    estabdestino = $('#estabdestin').val();//Establecimiento de destino
    polixespc = $('#cb_polixespc').val();//Policlínico, servicio clínico, examen, procedimiento o procedimiento quirúrgico de destino
    interpara = $('#cboTipoic').val();//Interconsulta para
    cboDestinoic = $('#cboDestinoic').val();//La I.C. va desde un
    cboPoliproce = $('#cboPoliproce').val();//Policlínico o servicio clínico de origen
    txtHipodiag = $('#txtHipodiag').val();//Resumen Historia Bio-Psico-Social
    txtFecrecepcion = $('#txtFecrecepcion').val();//Fecha solicitud interconsulta
    txtEspprocexa = $('#txtEspprocexa').val();//Especificación de Examen, Procedimiento o Procedimiento Quirúrgico
    txtExamenes = $('#txtExamenes').val();//Exámenes realizados y/o tratamientos intentados
    cboIndges = $('#cboIndges').val();//¿Es una I.C. por G.E.S?
    numfolio = $('#numfolio').val();//Capturar el numero de folio
    txtPatGes = $('#txtPatGes').val();//Caputar pat Ges
    
        $("#cbomotivo").removeClass('errores');
        $("#cboDestinoic").removeClass('errores');
        $("#cboEspecialidaD").removeClass('errores');
        $('#txtcodcie1').removeClass('errores');                         ///////Remover la clase de errores para volver a comprobar
        $('#txtFundadiag').removeClass('errores');
        $('#txtDesDiagno').removeClass('errores');
        $('#estabdestin').removeClass('errores');
        $('#cb_polixespc').removeClass('errores');
        $('#cboTipoic').removeClass('errores');
        $('#cboDestinoic').removeClass('errores');
        $('#cboPoliproce').removeClass('errores');
        $('#txtHipodiag').removeClass('errores');
        $('#txtFecrecepcion').removeClass('errores');
        $('#cboIndges').removeClass('errores');
        $('#txtPatGes').removeClass('errores');
        
    if($("#chkImgTele").is(':checked')){
        imageninter = '1';//si imagen
    }else{
        imageninter = '2';//no
    }
    
    if(errores == '0'){
    var variables={"funcion": 27, "motivoic":motivoic, "destinoic":destinoic, "especref":especref, "codigocie":codigocie, "desfundadiag":desfundadiag, "desdiagno":desdiagno, 
    "estabdestino":estabdestino, "polixespc":polixespc, "interpara":interpara, "cboDestinoic":cboDestinoic, "cboPoliproce":cboPoliproce, "txtHipodiag":txtHipodiag, 
    "txtFecrecepcion":txtFecrecepcion, "txtEspprocexa":txtEspprocexa, "txtExamenes":txtExamenes, "cboIndges":cboIndges, "numfolio":numfolio, "txtPatGes":txtPatGes, "imageninter":imageninter, "rutgraba":rutgraba}
    var id="cargarefycref";
    ajax_rceespecialidades(variables,id);
    }else{
        jAlert(error,'Listado errores');
    }
}

function cambiarruta(){
    numfolio = $('#numfolio').val();//Capturar el numero de folio
    var variables={"funcion": 27.5, "numfolio":numfolio}
    var id="cargarefycref";
    ajax_rceespecialidades(variables,id);
}
///////////////////////////////////////REF & CREF///////////////////////////////////////

//////////////////////////////////SOLICITAR EXAMENES///////////////////////////////////
function compruebasolexamen(){
    $('#todos').focus();
    var variables={"funcion": 25.9}
		var id="consultadiag";
		ajax_rceespecialidades(variables,id);
}

function solicitaexamen(desdiagnostico){
    $("#solicitaexamen").dialog('open');
    var variables={"funcion": 26, "desdiagnostico":desdiagnostico}
		var id="solicitaexamen";
		ajax_rceespecialidades(variables,id);
}

function cerrarexamen(){
    $("#solicitaexamen").dialog('close');
}


function sumaexamen(idexamen, desexamen){//Sumar los examenes con checkbox checked
var desexamen1 = $('#examen'+idexamen).val();
var valortd = $('#numtrtd').val();
var uno = 1;
var numsuma = $("#numeroexamenes").html(); 

if($("#checkbox"+idexamen).is(':checked')) {
    numsuma = parseInt(numsuma)+parseInt(uno);
    $('#numeroexamenes').html(numsuma); 
}else{
    numsuma = parseInt(numsuma)-parseInt(uno);
    $('#numeroexamenes').html(numsuma); 
}

if(valortd == 1){
    if($("#checkbox"+idexamen).is(':checked')) {
    var txt = '<tr class="formulario" id="trexa_'+idexamen+'">\n\
           <td>'+desexamen1+'</td>\n\
          <td><img src="ext/RCEESPECIALIDADES/img/borrar.gif" onclick="eliminaexamen(this, '+idexamen+')">\n\
          <input type="hidden" id="ocultoexamen_'+idexamen+'" value="'+idexamen+'"></td>';
$("#tablaexamen2").append(txt); 
document.getElementById("numtrtd").value='2';}
else{
$('#trexa_'+idexamen).remove();
}
}else if(valortd == 2){
    if($("#checkbox"+idexamen).is(':checked')) {
    var txt = '<tr class="formulario" id="trexa_'+idexamen+'"><td>'+desexamen1+'</td>\n\
          <td><img src="ext/RCEESPECIALIDADES/img/borrar.gif" onclick="eliminaexamen(this, '+idexamen+')">\n\
        <input type="hidden" id="ocultoexamen_'+idexamen+'" value="'+idexamen+'"></td>\n\
          </tr>';
$("#tablaexamen1").append(txt); 
document.getElementById("numtrtd").value='1';
}else{
    $('#trexa_'+idexamen).remove();
}
}

}

function eliminaexamen(id, idexamen){
        var borrar = id.parentNode.parentNode;
	var row = borrar.rowIndex;
	var nodo = borrar.parentNode; 
	nodo.deleteRow(row);
        document.getElementById("checkbox"+idexamen).checked = false;
   var uno = 1;     
   var numsuma = $("#numeroexamenes").html(); 

if($("#checkbox"+idexamen).is(':checked')) {
    numsuma = parseInt(numsuma)+parseInt(uno);
    $('#numeroexamenes').html(numsuma); 
}else{
    numsuma = parseInt(numsuma)-parseInt(uno);
    $('#numeroexamenes').html(numsuma); 
}     
}
function llenadiagsolexamenes(desdiagnostico){
    var diag = '<b>' + desdiagnostico + '</b>';
    $('#diagexamenes').append(diag); //Agregar diagnostico a los examanes
}

function guardarsolexamenes(rutgrabado, nomoprofregistra){
    var comprueba = 0;//Variable para comprobar si no seleccion un examen
    
    var strrutgrab = rutgrabado.split("-");
    rutgrabado = strrutgrab[0];

       var arrexamen = new Array();
    $('[id^=trexa_]').each(function() {  //Obtener valores de Diagnostico
        
		var objProducto = new Object();
                
                objProducto.idexamen  	  =     $(this).attr('id');
                
		objProducto.idexamen         =     objProducto.idexamen.replace('trexa_', '');
                
//                objProducto.idexamen2   =    $("#ocultoexamen_" + objProducto.idexamen).val();
                
                arrexamen.push(objProducto);
                
                comprueba = 1;
    });

    if(comprueba == 1){
     var variables={"funcion": 31, "arrexamen":arrexamen, "rutgrabado":rutgrabado, "nomoprofregistra":nomoprofregistra}
		var id="completexamen";
		ajax_rceespecialidades(variables,id);
            }else{
                jAlert("No ha ingresado solicitudes de exámenes,\n favor ingrese solicitudes para poder guardar", "Error al intentar guardar");
                $("#JpromtF").dialog("close");
            }
}

function firmaguardaexamenes(){ //Grabar solicitar examenes
        $("#resConfim").val('');
        $("#JpromtF").dialog("open");
        $("#JpromtMensaje").html('Con esta acci&oacute;n se proceder&aacute; a enviar respuesta a la solicitud.<br /><br />&iquest;Est&aacute; seguro de continuar?');
        $("#JpromtBtn").html('<input class="btnPop"  type="button" value="ACEPTAR" onclick="grabaRespConfexamenes();"><input type="hidden" id="varConfirm" value="2">');
   
   $('#resConfim').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        
            grabaRespConfexamenes();
    }
});

}

function grabaRespConfexamenes(){   
 
    var res = $('#resConfim').val();
    	var variables={"funcion": 32, "res":res}
		var id="guardarce";
		ajax_rceespecialidades(variables,id);
}

function solicitaimprimeexamen(){

    	var variables={"funcion": 33}
		var id="guardarce";
		ajax_rceespecialidades(variables,id);
}

function imprimirexamen(numcorrel, codempresa, clavetemp, codpromed, codespeci){
    
     if(impresion != null){
        impresion.close()
    }
    
    var anchura = screen.width ;
    var altura = screen.height ;
    var opciones = 'top=0,left=0,toolbar=0,location=0,directories=0, status=0,menubar=0,scrollbars=0,resizable=0' +
    ',width=' + anchura +
    ',height=' + altura ;
    
    impresion = window.open('ext/RCEESPECIALIDADES/class/imprimeexamenes.php?ncorrel=' + numcorrel + '&cempresa=' + codempresa + '&codpromed=' + codpromed + '&codespeci=' + codespeci + '&i=' + clavetemp,'Impresión de Informe Examenes',opciones) ; 
}
//////////////////////////////////SOLICITAR EXAMENES///////////////////////////////////

function compruebaimpresion(numcorrel){
    
    var polivalue = document.getElementById("nom_poli");
    var policlinico = polivalue.options[polivalue.selectedIndex].text;// Capturar policlinico seleccionado
    
    var valor1 = $('#nom_poli').val();
    var fechaseleccionada = $('#fechas').val();
    
    var res = valor1.split(",");
    var codespeci = res[0];
    var codpromed = res[1];
    var variables={"funcion": 34, "numcorrel":numcorrel, "codespeci":codespeci, "codpromed":codpromed, "fechaseleccionada":fechaseleccionada}
		var id="imprimir2";
		ajax_rceespecialidades(variables,id);
}

function imprimeatencion(cod_estab, numcorrela, fecha, codpromed, codespeci, pass){
    
    if(impresion != null){
        impresion.close()
    }
   
var anchura = screen.width ;
    var altura = screen.height ;
    var opciones = 'top=0,left=0,toolbar=0,location=0,directories=0, status=0,menubar=0,scrollbars=0,resizable=0' +
    ',width=' + anchura +
    ',height=' + altura;
    
    impresion = window.open('ext/RCEESPECIALIDADES/class/imprimeresultados.php?ncorrel=' + numcorrela + '&cempresa=' + cod_estab + '&codpromed=' + codpromed + '&fech=' + fecha + '&i=' + pass + '&codespeci=' + codespeci,'Impresión de Informe Examenes',opciones) ; 
}

function creareceta(){
    $('#todos').focus();
    $("#creareceta").dialog('open');
    
    var variables={"funcion": 35}
		var id="creareceta";
		ajax_rceespecialidades(variables,id);
}

function salirpopupreceta(){
    $("#creareceta").dialog('close');
}

function buscareceta(){
    if($('#txtbusquedareceta').val() === ''){ //Esconder desplegado cuando este vacio
        $('#muestralistareceta').hide('fast');
    }else{
        $('#muestralistareceta').show('fast');
    }
    
	var min_length = 1; // minimo de caracteres para autocomplete
	var keyword = $('#txtbusquedareceta').val();
        
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ext/RCEESPECIALIDADES/class/autocompletreceta.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#resultreceta').show();
				$('#resultreceta').html(data);
			}
		});
	} else {
		$('#resultdiagnostico').hide();
	}
}

function set_itemreceta(idproducto,texto,presentacion,codigoproducto, stock) { //LLenado de autocomplete diagnostico
    var comprueba = 0;
    
        $('[id^=receta_]').each(function() {
        idreceta  	   = $(this).attr('id');
		idreceta         = idreceta.replace('receta_', '');
      if (idproducto==idreceta){
          comprueba = 1;
      }
         });
         
    if(comprueba == 1){
        jAlert("El producto a agregar ya se encuentra en la receta", "Error");
    }else{

        document.getElementById('muestralistareceta').style.display = "none";
        
        document.getElementById("txtbusquedareceta1").value = texto; //agregar a input hidden
        
        document.getElementById("txtbusquedareceta").value = texto;

        $("#unidadreceta").html(presentacion);
        
        $("#saldoreceta").html(stock);
        
        $("#buttonreceta").html(stock);
        
         $("#idreceta").val(idproducto);
         
         $("#codigoproducto").val(codigoproducto);
        
    $('#resultreceta').hide();
    $('#completereceta').val('');
}
} 

function cerrarformreceta(){
    document.getElementById('muestralistareceta').style.display = "none"; //Cierre desplegar complete procedimientos
    $('#txtbusquedareceta').val("");
}

function agregarnuevareceta(){

    var errores = 0;
    var error = '';
    
    $('#diastratamiento').removeClass('errores');
    $('#cantidaddespachar').removeClass('errores');
    $('#txtbusquedareceta').removeClass('errores');
    $("#tiempcontrol").removeClass('errores');
    
    var idproducto = document.getElementById("idreceta").value; //Capturar Hidden idreceta
    
    var codigoproducto = document.getElementById("codigoproducto").value; //Capturar hidden codigo producto
    
    var nomreceta = document.getElementById("txtbusquedareceta1").value;
    
    var unidadreceta  = document.getElementById("unidadreceta").innerHTML;
    
    var stock  = document.getElementById("saldoreceta").innerHTML;
    
    var diastratamiento = document.getElementById("diastratamiento").value;
    
    var cantidaddespachar = document.getElementById("cantidaddespachar").value;
    
    var valtcontrol = document.getElementById('tiempcontrol').selectedIndex;
    var opttiempocontrol = document.getElementById('tiempcontrol').options[valtcontrol].text;
    
    var valueposologia = document.getElementById('tiempcontrol').value;
    
    var txtposologia = '';
    var val = '';
    if(valueposologia == -1){
        val = $('#txtposologia').val();
        txtposologia = ' - ' + val;
    }
    
    var comprueba = 0;
    
    $('[id^=receta_]').each(function() {
        idreceta  	   = $(this).attr('id');
		idreceta         = idreceta.replace('receta_', '');
      if (codigoproducto==idreceta){
         comprueba = 1;
      }
         });
     
    if(comprueba === 1){
        jAlert("El producto a agregar ya se encuentra en la receta", "Error");
    }else{
    if(diastratamiento === ''){
         error += ' - Debe completar los dias de tratamiento.\n';
        $("#diastratamiento").addClass('errores');
        errores = '1';
    }
    
    if(cantidaddespachar === ''){
         error += ' - Debe especificar una cantidad.\n';
        $("#cantidaddespachar").addClass('errores');
        errores = '1';
    }
    
    if(nomreceta === ''){
        error += ' - Debe especificar una Receta.\n';
        $("#txtbusquedareceta").addClass('errores');
        errores = '1';
    }
    
    if(valtcontrol === 0){
        error += ' - Debe especificar el tiempo de control.\n';
        $("#tiempcontrol").addClass('errores');
        errores = '1';
    }
//   <img src="ext/RCEESPECIALIDADES/images/edit.png" alt="Modificar" style="border:none" width="22" height="22" title="Modificar Medicamento" onclick="editarreceta('+idproducto+')">
    if(errores != 1){
    var txt1 = '<tr class="formulario" align="center" id="receta_'+idproducto+'">\n\
                <td width="30%" id="nomreceta_'+idproducto+'">' + nomreceta + '</td>\n\
                <td width="15%" id="unidadreceta_'+idproducto+'">' + unidadreceta + '</td>\n\
                <td width="25%" id="tiempcontrol_'+idproducto+'">' + opttiempocontrol + txtposologia+'</td>\n\
                <td width="10%" id="diastratreceta_'+idproducto+'">' + diastratamiento + '</td>\n\
                <td width="10%" id="cantidaddespreceta_'+idproducto+'">' + cantidaddespachar + '</td>\n\
                <input type="hidden" id="stock_'+idproducto+'" value="'+stock+'">\n\
                <input type="hidden" id="valueposo_'+idproducto+'" value="'+valueposologia+'">\n\
                <input type="hidden" id="txtposologia_'+idproducto+'" value="'+val+'">\n\
                <td width="8%">\n\
                <span class="hint  hint--left" data-hint="Modificar Medicamento"><img src="ext/RCEESPECIALIDADES/images/edit.png" alt="Modificar" style="border:none;cursor: pointer;" width="22" height="22" onclick="editarreceta('+idproducto+')"></span> \n\
                <span class="hint  hint--left" data-hint="Eliminar Medicamento"><img src="ext/RCEESPECIALIDADES/images/remove2.png" alt="Familia" style="border:none;cursor: pointer;" width="22" height="22" onclick="eliminareceta(this, '+idproducto+')"></span> \n\
                </td>\n\
                </tr>';
    $('#agregarrecetas').append(txt1);
    
        var vacio = "";
            
        document.getElementById("txtbusquedareceta").value = vacio;
        $("#unidadreceta").html(vacio);//limmpiar los hidden
        $("#saldoreceta").html(vacio);//limpiar hidden
        $("#buttonreceta").html(vacio);//limpiar 
        $("#idreceta").val(vacio);  //limpiar 
        $("#codigoproducto").val(vacio);  //limpiar 
        $("#tiempcontrol").val(0);  //limpiar 
        $("#diastratamiento").val(vacio);  //limpiar 
        $("#cantidaddespachar").val(vacio);//limpiar 
        $("#txtbusquedareceta1").val(vacio);//Limpiar hidden
        $("#txtposologia").val(vacio);//limpiar 
        compcambposologiavuelta();
}else{
    jAlert(error, "Listado de Errores");
}
}
}

function eliminareceta(id, trborrar){ //Eliminar td receta
    
    jConfirm('¿Está seguro de eliminar el medicamento de la receta?', 'Confirmacion', function(r) {
        if(r){
           $("#receta_" + trborrar).remove(); 
        } 
    });
}

function editarreceta(codigoproducto){
        
    var nomreceta = $('#nomreceta_' + codigoproducto).html();

    var unidadreceta  = $('#unidadreceta_' + codigoproducto).html();
    
    var posologia = $('#posologiareceta_' + codigoproducto).html();
    
    var diastratamiento = $('#diastratreceta_' + codigoproducto).html();
    
    var cantidaddespachar = $('#cantidaddespreceta_' + codigoproducto).html();
    
    var stock = $('#stock_' + codigoproducto).val();
    
    var valueposo = $('#valueposo_' + codigoproducto).val();
    
    var txtposologia = $('#txtposologia_' + codigoproducto).val();
    
    
        $("#unidadreceta").html(unidadreceta);  
        $("#txtbusquedareceta").val(nomreceta);  
        $("#txtbusquedareceta1").val(nomreceta);//hidden
        $("#txtposologia").val(posologia);  
        $("#diastratamiento").val(diastratamiento);  
        $("#cantidaddespachar").val(cantidaddespachar);
        $("#saldoreceta").html(stock);
        $("#tiempcontrol").val(valueposo);
        
        $("#buttonreceta").prop('value', 'Editar');
        $("#buttonreceta").attr("onclick","replacenewreceta("+codigoproducto+")");
        $("#editarrecetax").prop('value', 'Cancelar');
        
        if(txtposologia != ''){
            compcambposologia();
            $("#txtposologia").val(txtposologia);
        }
}

function limpiarbusqreceta(){
    
        var vacio = '';
        document.getElementById("txtbusquedareceta").value = vacio;
        $("#unidadreceta").html(vacio);//limmpiar los hidden
        $("#saldoreceta").html(vacio);//limpiar hidden
        $("#buttonreceta").html(vacio);//limpiar 
        $("#idreceta").val(vacio);  //limpiar 
        $("#codigoproducto").val(vacio);  //limpiar 
        $("#txtposologia").val(vacio);  //limpiar 
        $("#diastratamiento").val(vacio);  //limpiar 
        $("#cantidaddespachar").val(vacio);//limpiar 
        $("#tiempcontrol").val(0);
        
        $("#buttonreceta").prop('value', 'Agregar');
        $("#buttonreceta").attr("onclick","agregarnuevareceta();");
        $("#editarrecetax").prop('value', 'Limpiar');
}

function replacenewreceta(idproducto){
    $("#receta_" + idproducto).remove();
    
      var errores = 0;
    var error = '';
    
    $('#diastratamiento').removeClass('errores');
    $('#cantidaddespachar').removeClass('errores');
    $('#txtbusquedareceta').removeClass('errores');
    $("#tiempcontrol").removeClass('errores');
    
    var codigoproducto = document.getElementById("codigoproducto").value; //Capturar hidden codigo producto
    
    var nomreceta = document.getElementById("txtbusquedareceta1").value;
    
    var unidadreceta  = document.getElementById("unidadreceta").innerHTML;
    
    var stock  = document.getElementById("saldoreceta").innerHTML;
    
    var diastratamiento = document.getElementById("diastratamiento").value;
    
    var cantidaddespachar = document.getElementById("cantidaddespachar").value;
    
    var valtcontrol = document.getElementById('tiempcontrol').selectedIndex;
    var opttiempocontrol = document.getElementById('tiempcontrol').options[valtcontrol].text;
    
    var valueposologia = document.getElementById('tiempcontrol').value;
    
    var txtposologia = '';
    var val = '';
    if(valueposologia == -1){
        val = $('#txtposologia').val();
        txtposologia = ' - ' + val;
    }
    
    var comprueba = 0;
    
    $('[id^=receta_]').each(function() {
        idreceta  	   = $(this).attr('id');
		idreceta         = idreceta.replace('receta_', '');
      if (codigoproducto==idreceta){
         comprueba = 1;
      }
         });
     
    if(comprueba === 1){
        jAlert("El producto a agregar ya se encuentra en la receta", "Error");
    }else{
    if(diastratamiento === ''){
         error += ' - Debe completar los dias de tratamiento.\n';
        $("#diastratamiento").addClass('errores');
        errores = '1';
    }
    
    if(cantidaddespachar === ''){
         error += ' - Debe especificar una cantidad.\n';
        $("#cantidaddespachar").addClass('errores');
        errores = '1';
    }
    
    if(nomreceta === ''){
        error += ' - Debe especificar una Receta.\n';
        $("#txtbusquedareceta").addClass('errores');
        errores = '1';
    }
    
    if(valtcontrol === 0){
        error += ' - Debe especificar el tiempo de control.\n';
        $("#tiempcontrol").addClass('errores');
        errores = '1';
    }
//   <img src="ext/RCEESPECIALIDADES/images/edit.png" alt="Modificar" style="border:none" width="22" height="22" title="Modificar Medicamento" onclick="editarreceta('+idproducto+')">
    if(errores != 1){
    var txt1 = '<tr class="formulario" align="center" id="receta_'+idproducto+'">\n\
                <td width="30%" id="nomreceta_'+idproducto+'">' + nomreceta + '</td>\n\
                <td width="15%" id="unidadreceta_'+idproducto+'">' + unidadreceta + '</td>\n\
                <td width="25%" id="tiempcontrol_'+idproducto+'">' + opttiempocontrol + txtposologia+'</td>\n\
                <td width="10%" id="diastratreceta_'+idproducto+'">' + diastratamiento + '</td>\n\
                <td width="10%" id="cantidaddespreceta_'+idproducto+'">' + cantidaddespachar + '</td>\n\
                <input type="hidden" id="stock_'+idproducto+'" value="'+stock+'">\n\
                <input type="hidden" id="valueposo_'+idproducto+'" value="'+valueposologia+'">\n\
                <input type="hidden" id="txtposologia_'+idproducto+'" value="'+val+'">\n\
                <td width="8%">\n\
                <span class="hint  hint--left" data-hint="Modificar Medicamento"><img src="ext/RCEESPECIALIDADES/images/edit.png" alt="Modificar" style="border:none;cursor: pointer;" width="22" height="22" onclick="editarreceta('+idproducto+')"></span> \n\
                <span class="hint  hint--left" data-hint="Eliminar Medicamento"><img src="ext/RCEESPECIALIDADES/images/remove2.png" alt="Familia" style="border:none;cursor: pointer;" width="22" height="22" onclick="eliminareceta(this, '+idproducto+')"></span> \n\
                </td>\n\
                </tr>';
    $('#agregarrecetas').append(txt1);
    
        var vacio = "";
            
        document.getElementById("txtbusquedareceta").value = vacio;
        $("#unidadreceta").html(vacio);//limmpiar los hidden
        $("#saldoreceta").html(vacio);//limpiar hidden
        $("#buttonreceta").html(vacio);//limpiar 
        $("#idreceta").val(vacio);  //limpiar 
        $("#codigoproducto").val(vacio);  //limpiar 
        $("#tiempcontrol").val(0);  //limpiar 
        $("#diastratamiento").val(vacio);  //limpiar 
        $("#cantidaddespachar").val(vacio);//limpiar 
        $("#txtbusquedareceta1").val(vacio);//Limpiar hidden
        $("#txtposologia").val(vacio);//limpiar 
        
        $("#buttonreceta").prop('value', 'Agregar');
         $("#buttonreceta").attr("onclick","agregarnuevareceta();");
         $("#editarrecetax").prop('value', 'Limpiar');
        compcambposologiavuelta();
}else{
    jAlert(error, "Listado de Errores");
}
}
}

function compruebarecetapaciente(){ //Grabar solicitar firma simple
    var error = 1;
    var errores = '';
    var arrreceta = new Array();
    $('[id^=receta_]').each(function() {//obtener los valores de la receta
        
        var objreceta = new Object();
        
        objreceta.idreceta   =     $(this).attr('id');
        objreceta.idreceta   =     objreceta.idreceta.replace('receta_', '');
        objreceta.producto   =     $("#nomreceta_" +  objreceta.idreceta).html();
        objreceta.diastrat   =     $("#diastratreceta_" +  objreceta.idreceta).html();
        objreceta.cantidad   =     $("#cantidaddespreceta_" +  objreceta.idreceta).html();
        objreceta.posologia  =     $("#posologiareceta_" +  objreceta.idreceta).html();
        arrreceta.push(objreceta);
        
        error = 0;
         });
         
         if(error === 1){
             errores = '- Debe seleccionar a lo menos una receta';
         }
         
         if(error === 0){
        $("#resConfim").val('');
        $("#JpromtF").dialog("open");
        $("#JpromtMensaje").html('Con esta acci&oacute;n se proceder&aacute; a enviar respuesta a la solicitud.<br /><br />&iquest;Est&aacute; seguro de continuar?');
        $("#JpromtBtn").html('<input class="btnPop"  type="button" value="ACEPTAR" onclick="grabaRespConfreceta();"><input type="hidden" id="varConfirm" value="2">');
   
   $('#resConfim').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        
            grabaRespConfreceta();
    }
});
}else{
    jAlert(errores, "Listado de errores");
    }
}

function grabaRespConfreceta(){   
 
    var res = $('#resConfim').val();
    	var variables={"funcion": 35.5, "res":res}
		var id="guardarce";
		ajax_rceespecialidades(variables,id);
}

function grabarnuevareceta(rutgraba){
   
    var arrreceta = new Array();
    $('[id^=receta_]').each(function() {//obtener los valores de la receta
        var objreceta = new Object();
        
        objreceta.idreceta   =     $(this).attr('id');
        objreceta.idreceta   =     objreceta.idreceta.replace('receta_', '');
        objreceta.producto   =     $("#nomreceta_" +  objreceta.idreceta).html();
        objreceta.diastrat   =     $("#diastratreceta_" +  objreceta.idreceta).html();
        objreceta.cantidad   =     $("#cantidaddespreceta_" +  objreceta.idreceta).html();
        objreceta.posologia   =     $("#posologiareceta_" +  objreceta.idreceta).html();
        arrreceta.push(objreceta);
        
         });
         
     var variables={"funcion": 36, "arrreceta":arrreceta, "rutgraba":rutgraba}
		var id="divgrabareceta";
		ajax_rceespecialidades(variables,id);     
}

function abrepdfdatosic(numinterconsulta, codempresa){//abrir pdf interconsulta
    
     if(impresion != null){
        impresion.close()
    }
   
var anchura = screen.width;
    var altura = screen.height ;
    var opciones = 'top=0,left=0,toolbar=0,location=0,directories=0, status=0,menubar=0,scrollbars=0,resizable=0' +
    ',width=' + anchura +
    ',height=' + altura ;
    
    impresion = window.open('ext/RCEESPECIALIDADES/class/datosic.php?nintercon=' + numinterconsulta + '&cempresa=' + codempresa,'Impresión Datos Interconsulta',opciones) ; 
}

function agregaradiag(a){
    
    var textodiag = a;
    textodiag = textodiag.toUpperCase();//paso el texto a mayusculas
    
    if(textodiag != ''){
    document.getElementById("completediagnostico").value = textodiag;
    autocomplet();
    }
}

function compruebafechacref(){
         var variables={"funcion": 36.9}
		var id="consultadiag";
		ajax_rceespecialidades(variables,id);   
}
function datosinterconsulta(){
    
    $("#interconsulta").dialog('open');
         var variables={"funcion": 37}
		var id="interconsulta";
		ajax_rceespecialidades(variables,id);     
}

function cierracontraref(){
    $("#interconsulta").dialog('close');
}

function llenahistoriaclinica(){//llena historia clinica en contrareferencia
    
    des = $('#hiddenhipodiag').val();//caputrar hidden con diag
    cie10 = $('#codcie10').val();//capturar hidden codigo cie10
    destrataindi = $('#destrataindi').val();//capturar hidden codigo descripcion tratamiento
    fectrata = $('#fectrata').val();//capturar hidden codigo fecha tratamiento
    
    document.getElementById("txtresumenhistoriacli").value = des;
    document.getElementById("txtcodcie1").value = cie10;
    
    if(destrataindi != ''){
    document.getElementById("txtTratamientoind").value = destrataindi;
    }
    
    if(fectrata != ''){
    document.getElementById("txtfectratamiento").value = fectrata;
    }
    
    buscarcie10xcodigocref();
}

function grabacontraref(rutgraba){
    
    $("#JpromtF").dialog("close");
    $("#txtfectratamiento").removeClass('errores');
    $("#txtcodcie1").removeClass('errores');
    $("#txtresumenhistoriacli").removeClass('errores');
    
    if($("#augeSI").is(':checked')) { //
        auge = 1;
        }else if($("#augeNO").is(':checked')) {
         auge = 0;
        }
        
    diag = $('#hiddenhipodiag').val();//caputrar hidden con diag
    cie10 = $('#txtcodcie1').val();//capturar hidden codigo cie10
    historiaclin = $('#txtresumenhistoriacli').val();//Resumen Historia Clínica
    tratateindi = $('#txtTratamientoind').val();//Tratamiento e Indicaciones
    fechatrat = $('#txtfectratamiento').val();//fecha tratamiento
    
    var variables={"funcion": 38, "diag":diag, "cie10":cie10, "historiaclin":historiaclin, "tratateindi":tratateindi, "auge":auge, "rutgraba":rutgraba, "fechatrat":fechatrat}
	var id="guardadocontraref2"; 
	     ajax_rceespecialidades(variables,id);

}

function buscarcie10xcodigocref(){ //buscar cie10 x codigo
    
    var codigocie = $('#txtcodcie1').val();
    if(codigocie != ''){
    var variables={"funcion": 39, "codigocie":codigocie}
    var id="guardadocontraref2";
    ajax_rceespecialidades(variables,id);
    }
}

function grabarefcsimple(){ //Grabar solicitar firma simple
    var error = 0;
    var errores = '';
    
    
    $("#txtfectratamiento").removeClass('errores');
    $("#txtcodcie1").removeClass('errores');
    $("#txtresumenhistoriacli").removeClass('errores');
    $("#lblCie10").removeClass('errores');
    
    
    if($("#augeSI").is(':checked')) { //
        auge = 1;
        }else if($("#augeNO").is(':checked')) {
         auge = 0;
        }
        
    diag = $('#hiddenhipodiag').val();//caputrar hidden con diag
    cie10 = $('#txtcodcie1').val();//capturar hidden codigo cie10
    historiaclin = $('#txtresumenhistoriacli').val();//Resumen Historia Clínica
    tratateindi = $('#txtTratamientoind').val();//Tratamiento e Indicaciones
    fechatrat = $('#txtfectratamiento').val();//fecha tratamiento
    
    if(fechatrat == ''){
        error = 1;
        errores += '- Debe especificar una Fecha de Inicio de Tratamiento.\n';
        $("#txtfectratamiento").addClass('errores');
    }
    
    if(cie10 == ''){
        error = 1;
        errores += '- Debe especificar un Diagnóstico CIE 10.\n';
        $("#txtcodcie1").addClass('errores');
        $("#lblCie10").addClass('errores');
    }
    
    if(historiaclin == ''){
        error = 1;
        errores += '- Debe especificar el Resumen Historia Clínica.\n';
        $("#txtresumenhistoriacli").addClass('errores');
    }
    
    if(error == 0){
        $("#resConfim").val('');
        $("#JpromtF").dialog("open");
        $("#JpromtMensaje").html('Con esta acci&oacute;n se proceder&aacute; a enviar respuesta a la solicitud.<br /><br />&iquest;Est&aacute; seguro de continuar?');
        $("#JpromtBtn").html('<input class="btnPop"  type="button" value="ACEPTAR" onclick="grabarefcsimpleconf();"><input type="hidden" id="varConfirm" value="2">');
   
   $('#resConfim').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        
            grabarefcsimpleconf();
    }
});
    }else{
             jAlert(errores, "Listado de Errores");
         }
}

function grabarefcsimpleconf(){   
    
    
    var r = $('#resConfim').val();
    	var variables={"funcion": 40, "r":r}
		var id="guardadocontraref2";
		ajax_rceespecialidades(variables,id);
}

function exlaboratorio(){
    $('#todos').focus();
    $("#exlaboratorio").dialog("open");
    
        	var variables={"funcion": 42}
		var id="exlaboratorio";
		ajax_rceespecialidades(variables,id);
}

function selectexamen(){
     $('#todos').focus();
    $("#selectexamen").dialog("open");
    
        	var variables={"funcion": 50}
		var id="selectexamen";
		ajax_rceespecialidades(variables,id);
}

function exmicrobiologico(){
    $('#todos').focus();
    $("#exmicrobiologico").dialog("open");
    
        	var variables={"funcion": 51}
		var id="exmicrobiologico";
		ajax_rceespecialidades(variables,id);
}

function exbioquimico(){
    $("#exbioquimico").dialog("open");
    
    var variables={"funcion": 43}
		var id="exbioquimico";
		ajax_rceespecialidades(variables,id);
}

function exhormonales(){
    $("#exhormonales").dialog("open");
    
    var variables={"funcion": 44}
		var id="exhormonales";
		ajax_rceespecialidades(variables,id);
}

function pcambiaestadonsp(id, numatencion, tipoic, numinterconsulta){
    
    if(numatencion == 1){// estado de atencion = 0
        mensaje = 'La siguiente acci&oacute;n cambiará el estado de la ateci&oacute;n a: "Sin Atención por NSP"<br /><br />&iquest;Est&aacute; seguro de continuar?';
    }else if(numatencion == 2){//estado de atencion es NSP
        mensaje = 'La siguiente acci&oacute;n confirma que el paciente será atendido<br /><br />&iquest;Est&aacute; seguro de continuar?';
    }
    
    $("#JpromtF2").dialog("open");
        $("#resConfim1").val('');
        $("#JpromtMensaje1").html(mensaje);
        $("#JpromtBtn1").html('<input class="btnPop"  type="button" value="ACEPTAR" onclick="grabarestnsppw('+id+', '+tipoic+', '+numinterconsulta+');"><input type="hidden" id="varConfirm" value="2"> \n\
        <input class="btnPop"  type="button" value="CANCELAR" onclick="cerrarpopnsp('+id+');">');

   $('#resConfim1').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        
            grabarestnsppw(id, tipoic, numinterconsulta);
    }
});
}

function cerrarpopnsp(id){
    $('#JpromtF2').dialog('close');
    
    if($("#sinatxnsp_" + id).is(':checked')) {
        $("#sinatxnsp_"+id).prop("checked", "");
    }else{
        $("#sinatxnsp_"+id).prop("checked", "checked");
    }
}
function grabarestnsppw(id, tipoic, numinterconsulta){   
    
    
    var r = $('#resConfim1').val();
    	var variables={"funcion": 44.5, "r":r, "id":id, "tipoic":tipoic, "numinterconsulta":numinterconsulta}
		var id="imprimir2";
		ajax_rceespecialidades(variables,id);
}

function cambiaestadonsp(rut, id, tipoic, numinterconsulta){
    
    $("#JpromtF2").dialog("close");
    
    var nsp = 0;
     if($("#sinatxnsp_" + id).is(':checked')) {
         nsp = 2;
        }else{
        nsp = 1;
        }
    
     var variables={"funcion": 45, "id":id, "nsp":nsp, "rut":rut, "tipoic":tipoic, "numinterconsulta":numinterconsulta}
		var id="imprimir2";
		ajax_rceespecialidades(variables,id);
}

function verdatopaciente(rut, digito){ // Ver datos del paciente
    $('#todos').focus();
    $("#verdatopaciente").dialog('open');
      
    var variables={"funcion": 46, "rut":rut, "digito":digito}  
    var id="verdatopaciente";
    ajax_rceespecialidades(variables,id);
}

function buscapacxrut(){
    
    var txtRut = $('#txtRutppac').val();
    var digito = $('#txtDvpacc').val();
    var error = 0;
    var errores = '';
    
    if(txtRut == ''){
        error = 1;
        errores += '- Debe completar el rut del paciente\n';
    }
    
    if(digito == ''){
        error = 1;
        errores += '- Debe completar el digito del rut\n';
    }
    
    if(error == 0){
   var variables={"funcion": 47, "txtRut":txtRut, "digito":digito}
     var id="cargadpac";
    ajax_rceespecialidades(variables,id);
}else{
    jAlert(errores, "Listado de errores");
}
}

function datoslocalesverpac(){
    
    var nficha = $('#numfichaepacc').val();
    var codestab = $('#estabxnficha').val();
    
     var variables={"funcion": 48, "nficha":nficha, "codestab":codestab}
     var id="cargadpac";
    ajax_rceespecialidades(variables,id);
}

function llenaestabverpac(){
    
    var nficha = $('#numfichaepacc').val();
    
     var variables={"funcion": 49, "nficha":nficha}
     var id="txtEstablecimiento";
    ajax_rceespecialidades(variables,id);
}

function marcansp(idcorrel){
    $("#sinatxnsp_"+idcorrel).prop("checked", "checked");
}

function solexam(idexamen){//
var nomexamen = $('#'+idexamen).html();
    nomexamen = nomexamen.trim();

if($("#exsangre_"+idexamen).is(':checked')) {
    
          var txt = '<tr class="formulario" id="trexsangre_'+idexamen+'">\n\
          <td id="tdexsangre_'+idexamen+'">'+nomexamen+'\
          <input type="hidden" value="'+nomexamen+'" id="txtexsangre_'+idexamen+'"</td>\n\
          <td><img src="" onclick="eliminaexamen(this, '+idexamen+')">\n\
          <input type="hidden" id="ocultoexsangre_'+idexamen+'" value="'+idexamen+'"></td>';
$("#hiddentabpdfexsangre").append(txt); 
}else{
     $("#trexsangre_" + idexamen).remove();   
        return true;
}
}

function imprimeexsangre(){
    
    var compimpsangre = 0;
    var otrosexsangre = $('#otrosexsangre').val();
    var arrexsangre = new Array();
    $('[id^=trexsangre_]').each(function() {
        compimpsangre = 1;
        
		var objProducto = new Object();

		objProducto.idexam  	     =    $(this).attr('id');
                
                objProducto.idexam           =    objProducto.idexam.replace('trexsangre_', '');
                
                objProducto.txtexsangre      =    $("#txtexsangre_" + objProducto.idexam).val();
                
                arrexsangre.push(objProducto);	     
    });
  
  if(compimpsangre == 1){
    var variables={"funcion": 52, "arrexsangre":arrexsangre, "otrosexsangre":otrosexsangre}
     var id="arrpdfexsangre";
    ajax_rceespecialidades(variables,id);
  }else{
      jAlert("Debe seleccionar al menos un exámen", "Error");
  }
}

  function imprimeexsangre2(pass){  
      
      if(impresion != null){
        impresion.close()
    }
    
     var anchura = screen.width ;
    var altura = screen.height ;
    var opciones = 'top=0,left=0,toolbar=0,location=0,directories=0, status=0,menubar=0,scrollbars=0,resizable=0' +
    ',width=' + anchura +
    ',height=' + altura ;
    
    impresion = window.open('ext/RCEESPECIALIDADES/class/impresionexsangre.php?p=' + pass,'Impresión',opciones) ; 
}
 
function solexamicro(idexamen){//
var nomexamen = $('#'+idexamen).html();
    nomexamen = nomexamen.trim();

if($("#exmicro_"+idexamen).is(':checked')) {
    
          var txt = '<tr class="formulario" id="trexmicro_'+idexamen+'">\n\
          <td id="tdexmicro_'+idexamen+'">'+nomexamen+'\
          <input type="hidden" value="'+nomexamen+'" id="txtexmicro_'+idexamen+'"</td>\n\
          <td><img src="" onclick="eliminaexamen(this, '+idexamen+')">\n\
          <input type="hidden" id="ocultoexmicro_'+idexamen+'" value="'+idexamen+'"></td>';
$("#hiddentabpdfexmicro").append(txt); 
}else{
     $("#trexmicro_" + idexamen).remove();   
        return true;
}
} 

function imprimeexmicro(){
    
    var compimpmicro = 0;
    var arrexmicro = new Array();
    $('[id^=trexmicro_]').each(function() {
        compimpmicro = 1;
        
		var objProducto = new Object();

		objProducto.idexam  	     =    $(this).attr('id');
                
                objProducto.idexam           =    objProducto.idexam.replace('trexmicro_', '');
                
                objProducto.txtmicro      =    $("#txtexmicro_" + objProducto.idexam).val();
                
                arrexmicro.push(objProducto);	     
    });
  
  if(compimpmicro == 1){
    var variables={"funcion": 53, "arrexmicro":arrexmicro}
     var id="arrpdfmicrob";
    ajax_rceespecialidades(variables,id);
  }else{
      jAlert("Debe seleccionar al menos un exámen", "Error");
  }
}

function imprimeexmicro2(pass){  
      
      if(impresion != null){
        impresion.close()
    }
    
     var anchura = screen.width ;
    var altura = screen.height ;
    var opciones = 'top=0,left=0,toolbar=0,location=0,directories=0, status=0,menubar=0,scrollbars=0,resizable=0' +
    ',width=' + anchura +
    ',height=' + altura ;
    
    impresion = window.open('ext/RCEESPECIALIDADES/class/impresionexmicro.php?p=' + pass,'Impresión',opciones) ; 
}

function compcambposologia(){
    
    var posologia = $('#tiempcontrol').val();
    
    if(posologia == -1){
        document.getElementById('tiempcontrol').style.display = "none";
        document.getElementById('txtposologia').style.display = "";
        document.getElementById('imgvolverreceta').style.display = "";
    }
}

function compcambposologiavuelta(){
        document.getElementById('tiempcontrol').style.display = "";
        document.getElementById('txtposologia').style.display = "none";
        document.getElementById('imgvolverreceta').style.display = "none";
        $('#txtposologia').val("");
        $('#tiempcontrol').val(0);
}

function creaselectdiag(){

    $('#selectcie10motivo option').remove();
    
    var arrdiag = new Array();
    $('[id^=diagb_]').each(function() {  //Obtener valores de Diagnostico
        
		var objProducto = new Object();

		objProducto.iddiag  	     =    $(this).attr('id');

		objProducto.iddiag           =    objProducto.iddiag.replace('diagb_', '');
                
                objProducto.txtdiagnostico   =    $("#txtdiag_" + objProducto.iddiag).val();
                
                objProducto.txtcie10   =    $("#codcie10_" + objProducto.iddiag).val();
                
                objProducto.clase        =     document.getElementById("tachado_" + objProducto.iddiag).value;
                
                arrdiag.push(objProducto);	     
    });
    
     var variables={"funcion": 54, "arrdiag":arrdiag}
     var id="cargarefycref";
    ajax_rceespecialidades(variables,id);
    
}

function llenaselectdiagmotivo(value, opcion){ //
    
    var a = $('#selectcie10motivo').val();
    
    if(a == null){//el select no contiene nada y agrego el seleccione.
        var result = '<option value=0>Seleccione...</option>'
        $("#selectcie10motivo").append(result); 
        }
    var result = '<option value='+ value + '>' + opcion + '</option>';
    $("#selectcie10motivo").append(result); 

}

function datosgyo(numfichae, numcita){
    $('#todos').focus();
    $("#datosgyo").dialog('open');
    
     var variables={"funcion": 56, "numfichae":numfichae, "numcita":numcita}
    var id="datosgyo";
    ajax_rceespecialidades(variables,id);
}

function calculofur(){
        var fecha_inicio = new Date();
	var dia_parto = new Date();
	var hoy = new Date();
	var lleva = new Date();
	var falta = new Date();
	
        var fecha = $('#fecfur2').val();
        
        if(fecha == ''){
            jAlert("Debe indicar la fecha FUR", "error");
        }else{
        
        var fecha2 = fecha.split("/");
        var day = fecha2[0];
        var month = fecha2[1];
        var year = fecha2[2];

	var fecha_dada = new Date(year, (month-1), day);//month+"/"+day+"/"+year
	

//Validación de la fechas
	if ((month=='04' || month=='06' || month=='09' || month=='11') && day==31) 
	{
		jAlert("Este mes no tiene 31 dias!")
		return false;
	}
	if (month == 2) 
	{ // check for february 29th
		var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
		if (day>29 || (day==29 && !isleap))
		{
			jAlert("Febrero " + year + " no tiene " + day + " días!");
			return false;
		}
	}

	//Calculamos la fecha probable del parto
	fecha_inicio.setTime(fecha_dada.getTime())
	dia_parto.setTime(fecha_inicio.getTime() + (280 * 86400000)); //(14 * 86400000) es la fecha de concepción
    
	//Calculamos el tiempo que lleva
	
	lleva.setTime(hoy.getTime() - fecha_inicio.getTime());
	llevasemanas = parseInt(((lleva.getTime()/86400000)/7));
	llevadias = Math.floor(((lleva.getTime()/86400000)%7));
	//Calculamos el tiempo faltante
	falta.setTime(dia_parto.getTime() - hoy.getTime());
	
	faltasemanas = parseInt(((falta.getTime()/86400000)/7));
	faltadias = parseInt(((falta.getTime()/86400000)%7));

   if(llevasemanas<0 || llevasemanas >40 || llevadias>280 || llevadias<0 || faltadias < 0 )
	{ 
	  jAlert("Existe un error con la fecha proporcionada anteriormente", "Error");
          $('#semanasembarazo').html('');
          $('#diasfaltaembarazo').html('');
          $('#fecprobparto').html('');
	  return false;
	}

	document.getElementById('semanasembarazo').innerHTML = llevasemanas + " Semanas y " + llevadias +" D&iacute;as";
	document.getElementById('diasfaltaembarazo').innerHTML = faltasemanas + " Semanas y " + faltadias+ " D&iacute;as";
	document.getElementById('fecprobparto').innerHTML = diasParto(dia_parto)+", Est&aacute; en la Semana "+llevasemanas+" de Embarazo.";
    }
}

function diasParto(dateObj) 
{
	month = dateObj.getMonth()+1;
	var months = new Array(12);
	months[1] = "Enero";
	months[2] = "Febrero";
	months[3] = "Marzo";
	months[4] = "Abril";
	months[5] = "Mayo";
	months[6] = "Junio";
	months[7] = "Julio";
	months[8] = "Agosto";
	months[9] = "Septiembre";
	months[10] = "Octubre";
	months[11] = "Noviembre";
	months[12] = "Diciembre";
	day   = dateObj.getDate();
	var days = new Array(7);
	days[0] = "Domingo";
	days[1] = "Lunes";
	days[2] = "Martes";
	days[3] = "Mi&eacute;rcoles";
	days[4] = "Jueves";
	days[5] = "Viernes";
	days[6] = "S&aacute;bado";
	dayw = dateObj.getDay();
	day = (day < 10) ? "0" + day : day;
	year  = dateObj.getYear();
	if (year < 2000) year += 1900;
	return (days[dayw] + " " + day + " de " + months[month] + " del " + year);
}

function llevaafecfur2(){
    fecha = $('#fecfur').val();
    $('#fecfur2').val(fecha);
}

function compruebaobs(val){
    
    var valor1 = $('#formobs' + val).val();
    var tamaño = valor1.length;
    if(tamaño == 1){
        valor1 = 0+valor1;
    }
    
    var text1 = $('#formobs1').val(); var tamtext1 = text1.length; if(tamtext1 == 1){text1 = 0+text1;}
    var text2 = $('#formobs2').val(); var tamtext2 = text2.length; if(tamtext2 == 1){text2 = 0+text2;}
    var text3 = $('#formobs3').val(); var tamtext3 = text3.length; if(tamtext3 == 1){text3 = 0+text3;}
    var text4 = $('#formobs4').val(); var tamtext4 = text4.length; if(tamtext4 == 1){text4 = 0+text4;}
    var text5 = $('#formobs5').val(); var tamtext5 = text5.length; if(tamtext5 == 1){text5 = 0+text5;}
    
    var formula = text1+'-'+text2+'-'+text3+'-'+text4+'-'+text5;
    $('#formulacompletaobs').val(formula);
    $('#formobs' + val).val(valor1);
    
    
}

function compruebaobs2(val){
    
    var valor1 = $('#formobs' + val + '2').val();
    var tamaño = valor1.length;
    if(tamaño == 1){
        valor1 = 0+valor1;
    }
    
    var text1 = $('#formobs12').val(); var tamtext1 = text1.length; if(tamtext1 == 1){text1 = 0+text1;}
    var text2 = $('#formobs22').val(); var tamtext2 = text2.length; if(tamtext2 == 1){text2 = 0+text2;}
    var text3 = $('#formobs32').val(); var tamtext3 = text3.length; if(tamtext3 == 1){text3 = 0+text3;}
    var text4 = $('#formobs42').val(); var tamtext4 = text4.length; if(tamtext4 == 1){text4 = 0+text4;}
    var text5 = $('#formobs52').val(); var tamtext5 = text5.length; if(tamtext5 == 1){text5 = 0+text5;}
    
    var formula = text1+'-'+text2+'-'+text3+'-'+text4+'-'+text5;
    $('#formulacompletaobs2').val(formula);
    $('#formobs' + val + '2').val(valor1);
    
    
}

function compruebagine(val){
    
    var valor1 = $('#formgine' + val).val();
    var tamaño = valor1.length;
    if(tamaño == 1){
        valor1 = 0+valor1;
    }
    
    var text1 = $('#formgine1').val(); var tamtext1 = text1.length; if(tamtext1 == 1){text1 = 0+text1;}
    var text2 = $('#formgine2').val(); var tamtext2 = text2.length; if(tamtext2 == 1){text2 = 0+text2;}
    var text3 = $('#formgine3').val(); var tamtext3 = text3.length; if(tamtext3 == 1){text3 = 0+text3;}
    var text4 = $('#formgine4').val(); var tamtext4 = text4.length; if(tamtext4 == 1){text4 = 0+text4;}
    var text5 = $('#formgine5').val(); var tamtext5 = text5.length; if(tamtext5 == 1){text5 = 0+text5;}
    var text6 = $('#formgine6').val(); var tamtext6 = text6.length; if(tamtext6 == 1){text6 = 0+text6;}
    var text7 = $('#formgine7').val(); var tamtext7 = text7.length; if(tamtext7 == 1){text7 = 0+text7;}
    
    formula = text1+'-'+text2+'-'+text3+'-'+text4+'-'+text5+'-'+text6+'-'+text7;
    $('#formulacompletagine').val(formula);
    $('#formgine' + val).val(valor1);
}


function grabadatosgineobs(numfichae){
    
    //////////////REMUEVO CLASS ERRORES/////////////
    var error = 0;
    var errores = '';
    $("#formobs1").removeClass('errores');
    $("#formobs2").removeClass('errores');
    $("#formobs3").removeClass('errores');
    $("#formobs4").removeClass('errores');
    $("#formobs5").removeClass('errores');
    $("#formgine1").removeClass('errores');
    $("#formgine2").removeClass('errores');
    $("#formgine3").removeClass('errores');
    $("#formgine4").removeClass('errores');
    $("#formgine5").removeClass('errores');
    $("#formgine6").removeClass('errores');
    $("#formgine7").removeClass('errores');
    //////////////REMUEVO CLASS ERRORES/////////////
    
    var formobs1 = $('#formobs1').val(); 
    if(formobs1 == ''){ 
        error = 1; 
        errores = '- Falta completar campos\n'; 
        $("#formobs1").addClass('errores');
    }
    var formobs2 = $('#formobs2').val(); 
    if(formobs2 == ''){ 
        error = 1; 
        errores = '- Falta completar campos\n'; 
        $("#formobs2").addClass('errores');
    }
    var formobs3 = $('#formobs3').val(); 
    if(formobs3 == ''){ 
        error = 1; 
        errores = '- Falta completar campos\n';
        $("#formobs3").addClass('errores');
    }
    var formobs4 = $('#formobs4').val(); 
    if(formobs4 == ''){ 
        error = 1; 
        errores = '- Falta completar campos\n'; 
        $("#formobs4").addClass('errores');
    }
    var formobs5 = $('#formobs5').val(); 
    if(formobs5 == ''){ 
        error = 1; 
        errores = '- Falta completar campos\n'; 
        $("#formobs5").addClass('errores');
    }
//    var formgine1 = $('#formgine1').val(); 
//    if(formgine1 == ''){
//        error = 1; 
//        errores = '- Falta completar campos\n'; 
//        $("#formgine1").addClass('errores');
//    }
//    var formgine2 = $('#formgine2').val(); 
//    if(formgine2 == ''){ 
//        error = 1; 
//        errores = '- Falta completar campos\n'; 
//        $("#formgine2").addClass('errores');
//    }
//    var formgine3 = $('#formgine3').val(); 
//    if(formgine3 == ''){ 
//        error = 1; 
//        errores = '- Falta completar campos\n'; 
//        $("#formgine3").addClass('errores');
//    }
//    var formgine4 = $('#formgine4').val(); 
//    if(formgine4 == ''){ 
//        error = 1; 
//        errores = '- Falta completar campos\n'; 
//        $("#formgine4").addClass('errores');
//    }
//    var formgine5 = $('#formgine5').val(); 
//    if(formgine5 == ''){ 
//        error = 1; 
//        errores = '- Falta completar campos\n'; 
//        $("#formgine5").addClass('errores');
//    }
//    var formgine6 = $('#formgine6').val(); 
//    if(formgine6 == ''){ 
//        error = 1; 
//        errores = '- Falta completar campos\n'; 
//        $("#formgine6").addClass('errores');
//    }
//    var formgine7 = $('#formgine7').val(); 
//    if(formgine7 == ''){ 
//        error = 1; 
//        errores = '- Falta completar campos\n'; 
//        $("#formgine7").addClass('errores');
//    }

    var formulaobst = $('#formulacompletaobs').val();
//    var formulagine = $('#formulacompletagine').val();
    var menarquia = $('#Menarquia').val();
    var fur = $('#fecfur').val();//fecha ultima regla
    var pap = $('#fecpap').val();
    var mac = $('#mac').val();
    var trh = $('#trh').val();
    var mamografa = $('#fecmamog').val();
    var birads = $('#birads').val();
    var ces = $('#ces').val(); //partos por cesaria
    var ptve = $('#ptve').val();
    var forceps = $('#forceps').val();
    var pelprob = $('#pelprob').val();
    
    if(error == 0){
         $("#resConfim").val('');
        $("#JpromtF").dialog("open");
        $("#JpromtMensaje").html('Con esta acci&oacute;n se proceder&aacute; a enviar respuesta a la solicitud.<br /><br />&iquest;Est&aacute; seguro de continuar?');
        $("#JpromtBtn").html('<input class="btnPop"  type="button" value="ACEPTAR" onclick="grabargineobspw1('+numfichae+');"><input type="hidden" id="varConfirm" value="2">');
   
   $('#resConfim').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        
            grabargineobspw1(numfichae);
    }
});
    }else{
        jAlert(errores, "Listado de errores");
    }
}

function grabargineobspw1(numfichae){   

    var r = $('#resConfim').val();
    	var variables={"funcion": 57, "r":r, "numfichae":numfichae}
		var id="cargaobsygine";
		ajax_rceespecialidades(variables,id);
}

function grabadatosgineobsconfirma(rutgrabado, numfichae){
    
    var formulaobst = $('#formulacompletaobs').val();
//    var formulagine = $('#formulacompletagine').val();
    var menarquia = $('#Menarquia').val();
    var fur = $('#fecfur').val();//fecha ultima regla
    var pap = $('#fecpap').val();
    var mac = $('#mac').val();
    var trh = $('#trh').val();
    var mamografa = $('#fecmamog').val();
    var birads = $('#birads').val();
    var ces = $('#ces').val(); //partos por cesaria
    var ptve = $('#ptve').val();
    var forceps = $('#forceps').val();
    var pelprob = $('#pelprob').val();
    
     var variables={"funcion": 58, "formulaobst":formulaobst, "menarquia":menarquia, "fur":fur, "pap":pap, "mac":mac, "trh":trh, "mamografa":mamografa,
                        "birads":birads, "ces":ces, "ptve":ptve, "forceps":forceps, "pelprob":pelprob, "numfichae":numfichae, "rutgrabado":rutgrabado}
        var id="cargaobsygine2";
        ajax_rceespecialidades(variables,id);   
}

function formulaobs(val){
    
        var formobs = val.split("-");
        var formobs1 = formobs[0];
        var formobs2 = formobs[1];
        var formobs3 = formobs[2];
        var formobs4 = formobs[3];
        var formobs5 = formobs[4];
        
        $('#formobs1').val(formobs1); 
        $('#formobs2').val(formobs2); 
        $('#formobs3').val(formobs3); 
        $('#formobs4').val(formobs4); 
        $('#formobs5').val(formobs5); 
        
        compruebaobs(1);
}

function formulaobs2(val){
    
        var formobs = val.split("-");
        var formobs1 = formobs[0];
        var formobs2 = formobs[1];
        var formobs3 = formobs[2];
        var formobs4 = formobs[3];
        var formobs5 = formobs[4];
        
        $('#formobs12').val(formobs1); 
        $('#formobs22').val(formobs2); 
        $('#formobs32').val(formobs3); 
        $('#formobs42').val(formobs4); 
        $('#formobs52').val(formobs5); 
        
        compruebaobs(1);
}

function formulagine(val){
    
        var formgine = val.split("-");
        var formgine1 = formgine[0];
        var formgine2 = formgine[1];
        var formgine3 = formgine[2];
        var formgine4 = formgine[3];
        var formgine5 = formgine[4];
        var formgine6 = formgine[5];
        var formgine7 = formgine[6];
        
        $('#formgine1').val(formgine1); 
        $('#formgine2').val(formgine2); 
        $('#formgine3').val(formgine3); 
        $('#formgine4').val(formgine4); 
        $('#formgine5').val(formgine5); 
        $('#formgine6').val(formgine6); 
        $('#formgine7').val(formgine7); 
        compruebagine(1);
}

function nuevoobsgine(numfichae){
    
    mensaje = 'Con esta acci&oacute;n se proceder&aacute; crear un nuevo registro.<br/>\n\
            <br />El anterior registro pasar&aacute; a la secci&oacute;n "Historial" <br />&iquest;Est&aacute; seguro de continuar?';
    
$("#JpromtF2").dialog("open");
        $("#resConfim1").val('');
        $("#JpromtMensaje1").html(mensaje);
        $("#JpromtBtn1").html('<input class="btnPop"  type="button" value="ACEPTAR" onclick="confirmanuevogineobs('+numfichae+');"><input type="hidden" id="varConfirm" value="2"> \n\
        <input class="btnPop"  type="button" value="CANCELAR" onclick="cerrarconfirm2();">');

   $('#resConfim1').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        
           confirmanuevogineobs(numfichae);
    }
});
    
}

function cerrarconfirm2(){
    $("#JpromtF2").dialog("close");
}

function confirmanuevogineobs(numfichae){   
    
    var r = $('#resConfim1').val();
    	var variables={"funcion": 62, "r":r, "numfichae":numfichae}
		var id="cargaobsygine2";
		ajax_rceespecialidades(variables,id);
}

function grabanuevoregobsgine(rutgraba, numfichae){
    
    var variables={"funcion": 59, "rutgraba":rutgraba, "numfichae":numfichae}
		var id="cargaobsygine2";
		ajax_rceespecialidades(variables,id);
}

function historialobsgine(numfichae){
    $("#historialgineobs").dialog("open");
    
    var variables={"funcion": 60, "numfichae":numfichae}
		var id="historialgineobs";
		ajax_rceespecialidades(variables,id); 
}

function detallegineobs(id){
    
    $("#detallegineobs").dialog("open");
    
    var variables={"funcion": 61, "id":id}
		var id="detallegineobs";
		ajax_rceespecialidades(variables,id); 
}

function compruebapert(){
    
    if($("#pertinenciaSI").is(':checked')) { //Comprobar Radiobutton Pertinencia
        var pertinencia = 1 //1 = SI
        }else if($("#pertinenciaNO").is(':checked')){
        var pertinencia = 0 //0 = NO   
        }else{
        var pertinencia = 2 // No marca
        }
        
        if(pertinencia == 0){
            document.getElementById('motivopertinencia').style.display = "";
        }else{
            document.getElementById('motivopertinencia').style.display = "none";
        }
}

function llenamotivopertinencia(valor){
    
    if(valor != 0){
        document.getElementById('motivopertinencia').style.display = "";
        
        $('#motivonopertinencia').val(valor);
    }
}

function marcamesatencionesgine(val){
    
    var diasenmes = $('#hgineobsmes' + val).html();
    
    var suma = parseInt(1)+parseInt(diasenmes);
    
    $('#hgineobsmes' + val).html(suma);
    
    if(suma != 0){
        document.getElementById("hgineobsmes" + val).className = "badge badge-important";
    }else{
        document.getElementById("hgineobsmes" + val).className = "badge badge-success";
    }
}

function buscareggineobs(numfichae, indestado){
    
    $('#hgineobsmes1').html(0); document.getElementById("hgineobsmes1").className = "badge badge-success";
    $('#hgineobsmes2').html(0); document.getElementById("hgineobsmes2").className = "badge badge-success";
    $('#hgineobsmes3').html(0); document.getElementById("hgineobsmes3").className = "badge badge-success";
    $('#hgineobsmes4').html(0); document.getElementById("hgineobsmes4").className = "badge badge-success";
    $('#hgineobsmes5').html(0); document.getElementById("hgineobsmes5").className = "badge badge-success";
    $('#hgineobsmes6').html(0); document.getElementById("hgineobsmes6").className = "badge badge-success";
    $('#hgineobsmes7').html(0); document.getElementById("hgineobsmes7").className = "badge badge-success";
    $('#hgineobsmes8').html(0); document.getElementById("hgineobsmes8").className = "badge badge-success";
    $('#hgineobsmes9').html(0); document.getElementById("hgineobsmes9").className = "badge badge-success";
    $('#hgineobsmes10').html(0); document.getElementById("hgineobsmes10").className = "badge badge-success";
    $('#hgineobsmes11').html(0); document.getElementById("hgineobsmes11").className = "badge badge-success";
    $('#hgineobsmes12').html(0); document.getElementById("hgineobsmes12").className = "badge badge-success";
    
    
    var aniogineobsh = $('#aniogineobsh').val();
    
    var variables={"funcion": 64, "numfichae":numfichae, "indestado":indestado, "aniogineobsh":aniogineobsh}
		var id="cargaconsgineobs";
		ajax_rceespecialidades(variables,id);
}

function cargahistgineobs(mes, numfichae){
    
   var aniogineobsh = $('#aniogineobsh').val();
   document.getElementById('containhistgineobs').style.display = "none";

   var variables={"funcion": 65, "mes":mes, "numfichae":numfichae, "aniogineobsh":aniogineobsh}
		var id="newhistgineobs";
		ajax_rceespecialidades(variables,id); 
}

function volvercalendariogine(){
    document.getElementById('divtabhisgineobs').style.display = "none";
    document.getElementById('containhistgineobs').style.display = "";
    
}

function editadatosgineobs(ideditar){
     //////////////REMUEVO CLASS ERRORES/////////////
    var error = 0;
    var errores = '';
    $("#formobs12").removeClass('errores');
    $("#formobs22").removeClass('errores');
    $("#formobs32").removeClass('errores');
    $("#formobs42").removeClass('errores');
    $("#formobs52").removeClass('errores');
//    $("#formgine1").removeClass('errores');
//    $("#formgine2").removeClass('errores');
//    $("#formgine3").removeClass('errores');
//    $("#formgine4").removeClass('errores');
//    $("#formgine5").removeClass('errores');
//    $("#formgine6").removeClass('errores');
//    $("#formgine7").removeClass('errores');
    //////////////REMUEVO CLASS ERRORES/////////////
    
    var formobs1 = $('#formobs12').val(); 
    if(formobs1 == ''){ 
        error = 1; 
        errores = '- Falta completar campos\n'; 
        $("#formobs1").addClass('errores');
    }
    var formobs2 = $('#formobs22').val(); 
    if(formobs2 == ''){ 
        error = 1; 
        errores = '- Falta completar campos\n'; 
        $("#formobs2").addClass('errores');
    }
    var formobs3 = $('#formobs32').val(); 
    if(formobs3 == ''){ 
        error = 1; 
        errores = '- Falta completar campos\n';
        $("#formobs3").addClass('errores');
    }
    var formobs4 = $('#formobs42').val(); 
    if(formobs4 == ''){ 
        error = 1; 
        errores = '- Falta completar campos\n'; 
        $("#formobs4").addClass('errores');
    }
    var formobs5 = $('#formobs52').val(); 
    if(formobs5 == ''){ 
        error = 1; 
        errores = '- Falta completar campos\n'; 
        $("#formobs5").addClass('errores');
    }
//    var formgine1 = $('#formgine1').val(); 
//    if(formgine1 == ''){
//        error = 1; 
//        errores = '- Falta completar campos\n'; 
//        $("#formgine1").addClass('errores');
//    }
//    var formgine2 = $('#formgine2').val(); 
//    if(formgine2 == ''){ 
//        error = 1; 
//        errores = '- Falta completar campos\n'; 
//        $("#formgine2").addClass('errores');
//    }
//    var formgine3 = $('#formgine3').val(); 
//    if(formgine3 == ''){ 
//        error = 1; 
//        errores = '- Falta completar campos\n'; 
//        $("#formgine3").addClass('errores');
//    }
//    var formgine4 = $('#formgine4').val(); 
//    if(formgine4 == ''){ 
//        error = 1; 
//        errores = '- Falta completar campos\n'; 
//        $("#formgine4").addClass('errores');
//    }
//    var formgine5 = $('#formgine5').val(); 
//    if(formgine5 == ''){ 
//        error = 1; 
//        errores = '- Falta completar campos\n'; 
//        $("#formgine5").addClass('errores');
//    }
//    var formgine6 = $('#formgine6').val(); 
//    if(formgine6 == ''){ 
//        error = 1; 
//        errores = '- Falta completar campos\n'; 
//        $("#formgine6").addClass('errores');
//    }
//    var formgine7 = $('#formgine7').val(); 
//    if(formgine7 == ''){ 
//        error = 1; 
//        errores = '- Falta completar campos\n'; 
//        $("#formgine7").addClass('errores');
//    }

    var formulaobst = $('#formulacompletaobs2').val();
//    var formulagine = $('#formulacompletagine').val();
    var menarquia = $('#Menarquia2').val();
    var fur = $('#fecfur22').val();//fecha ultima regla
    var pap = $('#fecpap2').val();
    var mac = $('#mac2').val();
    var trh = $('#trh2').val();
    var mamografa = $('#fecmamog2').val();
    var birads = $('#birads2').val();
    var ces = $('#ces2').val(); //partos por cesaria
    var ptve = $('#ptve2').val();
    var forceps = $('#forceps2').val();
    var pelprob = $('#pelprob2').val();
    
    if(error == 0){
         $("#resConfim").val('');
        $("#JpromtF").dialog("open");
        $("#JpromtMensaje").html('Con esta acci&oacute;n se proceder&aacute; a enviar respuesta a la solicitud.<br /><br />&iquest;Est&aacute; seguro de continuar?');
        $("#JpromtBtn").html('<input class="btnPop"  type="button" value="ACEPTAR" onclick="editargineobspw1('+ideditar+');"><input type="hidden" id="varConfirm" value="2">');
   
   $('#resConfim').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        
            editargineobspw1(ideditar);
    }
});
    }else{
        jAlert(errores, "Listado de errores");
    }
}

function editargineobspw1(ideditar){   

    var r = $('#resConfim').val();
    	var variables={"funcion": 66, "r":r, "ideditar":ideditar}
		var id="cargaeditarhineobs";
		ajax_rceespecialidades(variables,id);
}

function editardatosgineobsconfirma(rutgrabado, ideditar){
    
    var formulaobst = $('#formulacompletaobs2').val();
//    var formulagine = $('#formulacompletagine').val();
    var menarquia = $('#Menarquia2').val();
    var fur = $('#fecfur22').val();//fecha ultima regla
    var pap = $('#fecpap2').val();
    var mac = $('#mac2').val();
    var trh = $('#trh2').val();
    var mamografa = $('#fecmamog2').val();
    var birads = $('#birads2').val();
    var ces = $('#ces2').val(); //partos por cesaria
    var ptve = $('#ptve2').val();
    var forceps = $('#forceps2').val();
    var pelprob = $('#pelprob2').val();
    
     var variables={"funcion": 67, "formulaobst":formulaobst, "menarquia":menarquia, "fur":fur, "pap":pap, "mac":mac, "trh":trh, "mamografa":mamografa,
                        "birads":birads, "ces":ces, "ptve":ptve, "forceps":forceps, "pelprob":pelprob, "ideditar":ideditar, "rutgrabado":rutgrabado}
        var id="cargaeditarhineobs";
        ajax_rceespecialidades(variables,id);   
}

function ajax_rceespecialidades(variables, id, funcion) {
    
//    if(funcion == undefined || funcion == ''){
//        alert(id);
//    }
    
    $.ajax({
        type: "POST",
        dataType: "text",
        url: "rceespecialidades/" + funcion,
        data: variables,
        beforeSend: function () {
            $("#" + id).html('<img src="assets/themes/esissan/img/cargando.gif">');
        },
        success: function (datos) {
            $("#" + id).html(datos);
        },
        timeout: 4000,
        cache: false,
        error: $("#" + id).text('Problemas en el servidor.')
    });
}

///////////////////////VALIDACIONES ///////////////////////////

function validarNro(e) {//solo numeros
var key;
if(window.event) // IE
	{
	key = e.keyCode;
	}
else if(e.which) // Netscape/Firefox/Opera
	{
	key = e.which;
	}

if (key < 48 || key > 57)
    {
    if(key == 46 || key == 8) // Detectar . (punto) y backspace (retroceso)
        { return true; }
    else 
        { return false; }
    }
return true;
}

///////////////////////VALIDACIONES ///////////////////////////

