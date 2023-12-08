
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

//validaciones
function IsNumber(e){//SOLO NUMEROS				
tecla = (document.all) ? e.keyCode : e.which; 		
patron = /[0-9]/; //patron		

te = String.fromCharCode(tecla); 
return patron.test(te); 			
                              }

function validarLetras(e){//SOLOLETRAS
tecla = (document.all) ? e.keyCode : e.which; 		


patron = /[A-Z-a-z]/; //patron
if (tecla==32) return true; // espacio						
te = String.fromCharCode(tecla); 
return patron.test(te); // prueba de patron	

}					


function IsDigitoVerificador(e)//SOLO K Y NUMEROS EN DIGITO VERIFICADOR
{tecla = (document.all) ? e.keyCode : e.which; 
patron = /[0-9]/; //patron	
if (tecla==75) return true; //K
if (tecla==107) return true; //k 
te = String.fromCharCode(tecla); 
return patron.test(te); // prueba de patron	
}

var _utf8c = {
'&aacute;':'\u00e1',
'&eacute;':'\u00e9',
'&iacute;':'\u00ed',
'&oacute;':'\u00f3',
'&uacute;':'\u00fa',
'&Aacute;':'\u00c1',
'&Eacute;':'\u00c9',
'&Iacute;':'\u00cd',
'&Oacute;':'\u00d3',
'&Uacute;':'\u00da',
'&ntilde;':'\u00f1',
'&Ntilde;':'\u00d1',
'&iquest;':'\u00bf'
};

function botX(){
	$("#quitaProfUsuDel").attr("disabled", false);
	$("#quitaEstabUsuDel").attr("disabled", false);
	}
	
function desplegar(val){
	
        
		if(val==3){
                        $('#firmasimple').hide(500);
                        $("#formContenido").show(500);
                  	$("#cambiopassnueva").hide(500);
			$("#creamenu").hide(500);
			$("#creaprivilegios").hide(500);
			$("#CreaUsu").show(500);
			$("#frmguardarUsu").show(500);
                        $("#muestrapagina").hide(500);
			
			$("#quitaProfUsuDel").attr("disabled", true);
                        
		}else if(val==1){
                    $("#formContenido").show(500);
                    $("#muestrapagina").show(500);
                    
                }else if(val==4){
                    $("#formContenido").show(500);
                    $("#cambiopassnueva").show(500);
                    
                }else if(val==5){
                        $("#formContenido").hide(500);
                        $('#firmasimple').show(500);
                        $("#cambiopassnueva").hide(500);
			$("#creamenu").hide(500);
			$("#creaprivilegios").hide(500);
                        $("#muestrapagina").hide(500);
                        $("#quitaProfUsuDel").attr("disabled", true);
                }   
}
function limpiar(){
	$("#formContenido").hide(500);
}
function ocultar(){
	
	setTimeout(function() {
		$("#texto").attr("style","width:378px; -webkit-transition: width .4s;");
		$("#texto").hide("fast");
		
	}, 3000);
}

function abrir(){
        $("#opcionCierre").dialog('open');
    }

function cerrar(){
        $("#opcionCierre").dialog('close');
    }


$().ready(function() 
	{
		$('.pasar').click(function() { return !$('#origen option:selected').clone().appendTo('#destino');}); 
		
		
		$('#quitarizq').click(function() { borrarprivilegio(); return !$('#destino option:selected').remove(); });
		$('#quitarPriv').click(function() {return !$('#destino option:selected').remove();});
		 
		
		$('#quitaProfUsuDel').click(function() {borrarprivilegio2(); return !$('#destinoUsu option:selected').remove();});
		$('#quitaProfUsu').click(function() {return !$('#destinoUsu option:selected').remove();});
		
		
		$('#quitaEstabUsuDel').click(function() { borrarprivilegio3(); return !$('#destinoEstabUsu option:selected').remove();});
		$('#quitaEstabUsu').click(function() {return !$('#destinoEstabUsu option:selected').remove();});
		
		
		$('#privHab').click(function() {
			
				existe = 0;
				$('#destino1 option').each(function() {
					vDestino = $(this).attr('value');
					vOrigen = $('#origen1 option:selected').val();
										
					if(vOrigen == vDestino){
						existe = 1;
					}
                    
                });
				if(existe!= 1){
					valor = $('#origen1 option:selected').val();
					rellenazan(1, valor);
					return !$('#origen1 option:selected').appendTo('#destino1');
					return !$('#origen1 option:selected').remove();
				}
			
		}); 
		
		
		$('#privDes').click(function() {
				existe = 0;
				$('#origen1 option').each(function() {
					vDestino = $(this).attr('value');
					vOrigen = $('#destino1 option:selected').val();
										
					if(vOrigen == vDestino){
						existe = 1;
					}
                    
                });
				
				if(existe!= 1){					
					valor = $('#destino1 option:selected').val();
					rellenazan(2, valor);
					return !$('#destino1 option:selected').appendTo('#origen1');
					return !$('#destino1 option:selected').remove();
					
				}
			
		}); 
		
		
		$('#origen').dblclick(function() {
			varSelect =$('#destino > option').length;
			
			if (varSelect==0){
				return !$('#origen option:selected').clone().appendTo('#destino');
			}else{
				existe = 0;
				$('#destino option').each(function() {
					vDestino = $(this).attr('value');
					vOrigen = $('#origen option:selected').val();
										
					if(vOrigen == vDestino){
						existe = 1;
					}
                    
                });
				
				if(existe!= 1){
					return !$('#origen option:selected').clone().appendTo('#destino');
				}
			}
			
		}); 
	
		
		
		
		
		$('#origenUsu').dblclick(function() {
			varSelect =$('#destinoUsu > option').length;
			
			if (varSelect==0){
				return !$('#origenUsu option:selected').clone().appendTo('#destinoUsu');
			}else{
				existe = 0;
				$('#destinoUsu option').each(function() {
					vDestino = $(this).attr('value');
					vOrigen = $('#origenUsu option:selected').val();
										
					if(vOrigen == vDestino){
						existe = 1;
					}
                    
                });
				
				if(existe!= 1){
					return !$('#origenUsu option:selected').clone().appendTo('#destinoUsu');
				}
				
			}
			
		}); 
		
			$('#origenEstabUsu').dblclick(function() {
			varSelect =$('#destinoEstabUsu > option').length;
			
			if (varSelect==0){
				return !$('#origenEstabUsu option:selected').clone().appendTo('#destinoEstabUsu');
			}else{
				existe = 0;
				$('#destinoEstabUsu option').each(function() {
					vDestino = $(this).attr('value');
					vOrigen = $('#origenEstabUsu option:selected').val();
										
					if(vOrigen == vDestino){
						existe = 1;
					}
                    
                });
				
				if(existe!= 1){
					return !$('#origenEstabUsu option:selected').clone().appendTo('#destinoEstabUsu');
				}
			}
			
		}); 
		
		
			
		
		
	
	});
	
	
	

	
	
	
		
		
	/*function hola (){
		alert("dentro de funcion");
		
		var total=document.frmguardar.destino.length;
	
	alert("holaaa");
	alert(total);
	
		
		var texto 
   	texto = "El numero de opciones del select: " + document.frmguardar.destino.length 
		alert(texto)*/
		
		
		
		
		
		//$('#destino option').each(function() {
//					vDestino = $(this).attr('value');
//					resultado = resultado + 1
//							$("#total").val(resultado);
//							alert("22");
//		}
//		//v = $("#destino").length; 
//			//$("#total").val(v);		}
//	
//	)
	
	/*}*/
	
/*	
	function holafgfgfg(){
		a = $("#destino").val()
		var total= a.options.length;
	alert(total);
num=0;
for(i=0; i<a.options.length; i++)
if(a.options[i].selected) num++;
return num;
alert (contar);
		
		
		}
		*/
		
		
/*function contar(obj) {
	
	var total= obj.options.length;
	alert(total);
num=0;
for(i=0; i<obj.options.length; i++)
if(obj.options[i].selected) num++;
return num;
alert (contar);
}*/

/*function insert(){
	
	var total=document.frmguardar.destino.length;
	
	alert("holaaa");
	alert(total);
	
	traerDatos2(total);
	
	
	}*/
	
	function mensaje(num){
		
		if (num==1){
		$('#oculto').val(1);
		}
		else  if (num==2)
		{
		$('#oculto').val(2);
		}
		else if (num==3)
		{
		$('#oculto').val(3);
		}
		}
		
		
		function ValidaBloqueo(num){
			
			if(num==1)
			{$("#btnEditarMenu").attr("disabled", true);
			
			}else if(num==0)
			{$("#btnEditarMenu").attr("disabled", false);
							}
			
			
			}		

  
	

		
		
		
		
		
		

	
	
	
	
	
	





	



	



