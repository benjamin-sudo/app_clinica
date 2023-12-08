/*
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
*/
/* 
    Created on : 09-feb-2016, 11:28:02
    Author     : nicolas.villagra
*/
  
function eliminarVacio(valor)
{
var palabra;
var palabraresultado;
palabra = valor;
//palabraresultado = palabra.replace(" ","");
//palabraresultado = palabra;
palabraresultado=trim(palabra);
return palabraresultado;
}
function validar(e) {
        tecla = (document.all)?e.keyCode:e.which;
        if(tecla==86 && e.ctrlKey)
            return false;
    }

function replaceAll( text, busca, reemplaza ){
        while (text.toString().indexOf(busca) != -1) {
              text = text.toString().replace(busca,reemplaza);
         }
        return text;
  }


function limpiaEquiTmp(){
  document.bdsfrm.tmpName.value='';
  document.bdsfrm.tmpCargo.value='';
}

function verificaRut(str){
  var resp=true;
  var rut=trim(str);
  if(rut.length>=9){
    var digver=rut.charAt(rut.length -1);
    rut=rut.substr(0,rut.length -1);
    digver=digver.toUpperCase();
    if(((digver>="0")&&(digver<="9"))||(digver=="K")){
      //eliminar caracteres extras
      nerut="";
      for(i=0;i<rut.length;i++){
        if(rut.charAt(i)>="0"&&rut.charAt(i)<="9")
          nerut += rut.charAt(i);
        else
          if(rut.charAt(i)!="." && rut.charAt(i)!="-")
          resp=false;
        }
      //calcula el digito
      if(resp){
        var sum=0;
        var mul=2;
        for(i=nerut.length-1;i>=0;i--){
          sum += mul++ * nerut.charAt(i);
          if(mul>7) mul=2;
        }
        var resul = 11 - (sum % 11);
        digcal = "" + ((resul<10)?resul:((resul==11)?0:"K"));
        resp = (digcal == digver);
      }
    }
    else
      resp=false;
  }
  else
    resp=false;
  return resp;
}

function trim(s){
  espacios=String(" \t\n\r");
  if(s=="")
    return "";
  if(espacios.indexOf(s.charAt(0))!= -1){
    return trim(s.substr(1,s.length));
  }
  if(espacios.indexOf(s.charAt(s.length-1))!= -1){
    return trim(s.substr(0,s.length-1));
  }
  return s;
}

function NumGuion(e) {
   // extranjero = document.getElementById('inp_ext');
    //if(extranjero.checked!=true){
        evt = e ? e : event;
        tcl = (window.Event) ? evt.which : evt.keyCode;
       // alert("key="+tcl);
        if ((tcl < 48 || tcl > 57) && (tcl != 8 && tcl != 9 && tcl != 0 && tcl != 46 && tcl != 107 && tcl != 75) && tcl != 45 )
        {
            return false;
        }
        return true;
   /* }
    else {

        return true;
    }*/
  }

function formateaDNI(){
      
    //extranjero = document.getElementById('inp_ext');
    //if(extranjero.checked==true){
      rut = document.getElementById('login_username').value;
      dnicuerpo = replaceAll(rut, ".", "" );
      dnicuerposinguion = replaceAll(dnicuerpo, "-", "" );
      document.getElementById('login_username').value = dnicuerposinguion;
      // }
}


function formateaRUT(){

  //extranjero = document.getElementById('inp_ext');

  //if(extranjero.checked!=true){
  rut = document.getElementById('login_username').value;

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
      strXYZ += millones + ".";
    }
    if(num>1000){
      miles=( ( (num%1000000)-(num%1000000)%1000)/1000);
      if (num > 1000000) miles = cerosmil(miles);
      strXYZ += miles + ".";
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
    document.getElementById('login_username').value = nueva_cadena;
    }
  //}
}

function formateaDNIIn(){
      
    //extranjero = document.getElementById('inp_ext');
    //if(extranjero.checked==true){
      rut = document.getElementById('username').value;
      dnicuerpo = replaceAll(rut, ".", "" );
      dnicuerposinguion = replaceAll(dnicuerpo, "-", "" );
      document.getElementById('username').value = dnicuerposinguion;
      // }
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

function validarForm(){
//extranjero = document.getElementById('inp_ext');

//if(extranjero.checked!=true){
 rut=document.getElementById('login_username').value;

  if(verificaRut(rut)==true){
/*
    text = rut;
    nueva_cadena = text.replace(".","");
    text = nueva_cadena.replace(".","");
    aText = text.split("-");
    document.getElementById('login_username').value = text;*/
    formateaRUT();
  return true;
  }
  else {
  alert("Debe ingresar un rut v\u00e1lido");
  return false;
  }
//}
//else {
//  return true;
//}
}

function validarFormIn(){
//extranjero = document.getElementById('inp_ext');

//if(extranjero.checked!=true){
 rut=document.getElementById('username').value;

  if(verificaRut(rut)==true){
/*
    text = rut;
    nueva_cadena = text.replace(".","");
    text = nueva_cadena.replace(".","");
    aText = text.split("-");
    document.getElementById('username').value = aText[0];*/
    formateaRUT();
  return true;
  }
  else {
  alert("Debe ingresar un rut v\u00e1lido");
  return false;
  }
//}
//else {
//  return true;
//}
}

function validarFormRbd(){

 rut=document.getElementById('user').value;
    text = rut;
    nueva_cadena = text.replace(".","");
    text = nueva_cadena.replace(".","");
    aText = text.split("-");
    document.getElementById('login_username').value = aText[0];
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