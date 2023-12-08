/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() {
    
    //cargaMenu();
});

function trim(myString)
{
return myString.replace(/\s/g,'').replace(/\s/g,'')
}

function cargaMenu(){
    var id="menuEdit";
    var funcion = 'cargaMenu';
    var variables={}

    Ajax(variables,id,funcion);
}

function validaTxt(e,Num) { // 
    tecla = (document.all) ? e.keyCode : e.which; 
	
	if(Num==1)//rut usuario solonume
			{ patron = /[0-9]/; //patron
			}
		else if(Num==1.1)//DIGITO DEL RUT
			{patron = /[0-9]/; //patron
			if (tecla==75) return true; //K
			if (tecla==107) return true; //k 
			}
		else if (Num==2)//txtnombre usu
			{patron = /[a-zA-Z]/; //patron
			if (tecla==32) return true; // espacio			
			if (e.ctrlKey && tecla==86) { return true;} //Ctrl v
			if (e.ctrlKey && tecla==67) { return true;} //Ctrl c
			if (e.ctrlKey && tecla==88) { return true;} //Ctrl x				
			}
		else if(Num==2.1)
			{patron = /[a-zA-Z]/; //patron
			if (tecla==64) return true; //@
			if (tecla==46) return true; //.
			}
		else if (Num==6)
			{patron = /[a-zA-Z0-9]/; //patron
			if (tecla==46) return true; //.
			if (e.ctrlKey && tecla==64)  return true; //Ctrl @
			if (e.ctrlKey && tecla==86)  return true; //Ctrl v
			if (e.ctrlKey && tecla==67)  return true; //Ctrl c
			if (e.ctrlKey && tecla==88)  return true; //Ctrl x		
			
			if (tecla==32) return false; // espacio			
			}
		
		else if(Num==3)//txtpriv
			{if (tecla==8) return true; // backspace
			if (tecla==45) return true; // -
			if (tecla==32) return true; // espacio
			if (tecla==62) return true; // >
			if (e.ctrlKey && tecla==86) { return true;} //Ctrl v
			if (e.ctrlKey && tecla==67) { return true;} //Ctrl c
			if (e.ctrlKey && tecla==88) { return true;} //Ctrl x	 
			patron = /[a-zA-Z]/; //patron				
				}
			else if (Num==4)
			{
			if (tecla==8) return true; // backspace
			if (tecla==32) return true; // espacio
			if (tecla==40) return true; // (
			if (tecla==41) return true; // )
			if (e.ctrlKey && tecla==86) { return true;} //Ctrl v
			if (e.ctrlKey && tecla==67) { return true;} //Ctrl c
			if (e.ctrlKey && tecla==88) { return true;} //Ctrl x	
			patron = /[a-zA-Z0-9]/; //patron
 
					}
	
		te = String.fromCharCode(tecla); 
		return patron.test(te); // prueba de patron
		
		
		
	}	
	



function enter(valor){
    if (valor == 'enterreseteapw'){
        $(window).keypress(function(e) {
    if(e.keyCode == 13) {
        resetearClaves();
        }
    }); 
}
    else if(valor == 'enternewpass'){
        $(window).keypress(function(e) {
    if(e.keyCode == 13) {
        CambioPassEmail();
        }
    });
}
    else if(valor == 'enterlogin'){
        $(window).keypress(function(e) {
    if(e.keyCode == 13) {
        login();
         }
    });
}
}

function validar(e) {
        tecla = (document.all)?e.keyCode:e.which;
        if(tecla==86 && e.ctrlKey)
            return false;
}
    
    function NumGuion(e) {
        evt = e ? e : event;
        tcl = (window.Event) ? evt.which : evt.keyCode;
       // alert("key="+tcl);
        if ((tcl < 48 || tcl > 57) && (tcl != 8 && tcl != 9 && tcl != 0 && tcl != 46 && tcl != 107 && tcl != 75) && tcl != 45 )
        {
            return false;
        }
        return true;

}

function cerosmil(st){
  st=""+st;
  if(st.length==3)
    return st;
  if(st.length<3)
    return cerosmil("0" + st);
  else return st;
}

function formateaRUTIn(){

  rut = document.getElementById('user').value;

  if(rut!="" ) {
    dv=rut.substr(rut.length -1,1); //asigna dv
    rut=rut.substr(0,rut.length -1); //asigna cuerpo
    nerut = ""; 
    for(i=0;i<rut.length;i++){
      if(rut.charAt(i) >= "0" && rut.charAt(i) <= "9") {
        nerut += parseInt(rut.charAt(i),10); //conv char a num dec, parÃ¡metro "10", octal=8, etc
      }
    }
    num = parseInt(nerut,10);
    strXYZ ="";
    
    if(num>1000000){
      millones=((num-num%1000000)/1000000);
      strXYZ += millones;// + ".";
    }
    if(num>1000){
      miles=( ( (num%1000000)-(num%1000000)%1000)/1000);
      if (num > 1000000) miles = cerosmil(miles);
      strXYZ += miles ;//+ ".";
    }
    if (num > 1000) num = cerosmil(num%1000);
    strXYZ += num;
    strXYZ = strXYZ + "-" + dv;
    nueva_cadena = strXYZ.replace("NaN","");
    nueva_cadena = nueva_cadena.replace("--","");
    if(nueva_cadena.length==2){
      nueva_cadena = nueva_cadena.replace("-k","");
    }
    if(nueva_cadena.length==2){
      nueva_cadena = nueva_cadena.replace("-K","");
    }
        
    nueva_cadena = nueva_cadena.replace("-.","");
    document.getElementById('user').value = nueva_cadena;
  }
 
}

function Ajax(variables,id,funcion){
    
    $.ajax({
           type: "POST",
           dataType: "text",
           url: "gestionextensiones/" + funcion,
           data: variables,
           beforeSend:function () { $("#"+id).html('<img src="assets/themes/esissan/img/cargando.gif">'); },
           success: function(datos){ $("#"+id).html(datos);},
           timeout:4000,  
           cache:false,
           error:$("#"+id).text('Problemas en el servidor.')
           
         }); 
         
 }