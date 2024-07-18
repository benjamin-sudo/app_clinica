var recognition                     =   false;
  
    function star_mictrofono()      {
   
        recognizing                 =   false;
    
    if (!('webkitSpeechRecognition' in window)) {
        
        console.log("API NO SOPORTADA");
        
    } else {

        recognition                 =   new webkitSpeechRecognition();
        
        recognition.lang            =   "es";
        
        recognition.continuous      =   true;

        recognition.interimResults  =   true;

        recognition.onstart         =   function(event)      {
                                                            console.log("-----------------------------------------------------------");
                                                            console.log("       empezando a eschucar ",event,"                      ");
                                                            console.log("       function recognition.onstart                        ");
                                                            recognizing                 =   true;
                                                            var mic_id                  =   localStorage.getItem("mic_id");
                                                            var icongrab                =   localStorage.getItem("mic_icongrab");
                                                            var mic_ind_tipo            =   localStorage.getItem("mic_ind_tipo");
                                                            var mic_id_area             =   localStorage.getItem("mic_id_area");
                                                            console.log("mic_id         ->  ",mic_id);
                                                            console.log("mic_id_area    ->  ",mic_id_area,"     <-                  ");
                                                            console.log("mic_ind_tipo   ->  ",mic_ind_tipo,"    <-                  ");
                                                            console.log("mic_id_area    ->  ",icongrab,"        <-                  ");
                                                            console.log("-----------------------------------------------------------");
                                                            
                                                            $("."+icongrab).show();
                                                        };
        recognition.onresult        =   function(event) {
                                                            console.log("-----------------------------------------------------------");
                                                            console.log("       recognition.onresult    ",event,"                   ");
                                                            console.log("-----------------------------------------------------------");
                                                            var interim                     =   '';
                                                            var textActive                  =   $("#"+mic_id_area).val();
                                                            var mic_id_area                 =   localStorage.getItem("mic_id_area");
                                                            console.log("-----------------------------------------------------------");
                                                            console.log("mic_id_area        ->  ",mic_id_area,"<-                   ");
                                                            console.log("textActive         ->  ",textActive,"  <-                  ");
                                                            console.log("event.resultIndex  ->  ",event.resultIndex,"<-             ");
                                                            console.log("-----------------------------------------------------------");
                                                            for(var i = event.resultIndex; i <event.results.length; i++) {
                                                                console.log("-------------------------------------------------------");
                                                                console.log("event          ->  ",event.results,"   <---------------");
                                                                console.log("event.results  ->  ",event.results[i],"    <-----------");
                                                                console.log("-------------------------------------------------------");
                                                                if (event.results[i].isFinal){
                                                                    console.log("----------------------------------------------------");
                                                                    console.log("textActive -> ",textActive,"------------------------");
                                                                    console.log("transcript -> ",event.results[i][0].transcript," ---");
                                                                    console.log("----------------------------------------------------");
                                                                    interim     +=  $("#"+mic_id_area).val()+event.results[i][0].transcript;
                                                                    //console.log("->",document.getElementById(textActive).value,"<-   ");
                                                                    //console.log("----------------------------------------------------");
                                                                    //if(typeof(document.getElementById(textActive).value)!='undefined') {
                                                                        //document.getElementById(textActive).value += event.results[i][0].transcript + ' ';
                                                                    //}
                                                                } else {
                                                                    console.log("       ","->else<-","      ");
                                                                    interim              +=  event.results[i][0].transcript;
                                                                }
                                                            }
                                                            console.log("---------------------------------------------------");
                                                            console.log("mic_id_area        -> ",mic_id_area,"<-            ");
                                                            console.log("interim            -> ",interim,"<-                ");
                                                            console.log("---------------------------------------------------");
                                                            $('#'+mic_id_area).html(interim);
                                                        };
        recognition.onerror         =   function(event) {
                                                            console.log("-------------------------------------------------------");
                                                            console.log("onerror                ->",event,"<-                   ");
                                                            console.log("onerror.error          ->",event.error,"<-             ");
                                                            console.log("-------------------------------------------------------");
                                                            jError("Error al iniciar micr&oacute;fono","e-SISSAN");
                                                            //jError("Todo lo que ha podido fallar lo ha hecho","e-SISSAN");
                                                            $("#"+localStorage.getItem("mic_id_area")).html('');
        };
        recognition.onend           =   function()      {
                                                            recognizing                 =   false;
                                                            //document.getElementById("procesar").innerHTML = '';
                                                            console.log("termina de escuchar");
                                                            showNotification('top','left',"Termino de escuchar",4,'fa fa-exclamation-triangle');
                                                            $("."+localStorage.getItem("mic_icongrab")).hide();
                                                        };
    }
}

function star_microfono_general(id){
    var config_mic      =   document.getElementById(id);
    
    localStorage.setItem("mic_id"               ,id);
    localStorage.setItem("mic_id_area"          ,config_mic.dataset.id_area);
    localStorage.setItem("mic_ind_tipo"         ,config_mic.dataset.ind_tipo);
    localStorage.setItem("mic_icongrab"         ,config_mic.dataset.icongrab);
    localStorage.setItem("mic_procesamiento"    ,config_mic.dataset.proce);
    
    if(recognizing == false){ 
        recognition.start();  
        recognizing     =    true;
    }
}

function mic_terminar(id){
    $("."+localStorage.getItem("mic_icongrab")).hide();
    recognition.stop();
    recognizing             =   false;
}





//EMPEZAR MICROFONO
function empezar_a_escuchar(){
    console.log("---------------------------------------");
    console.log("   empezar_a_escuchar                  ");
    console.log("   recognizing -> ",recognizing,"      ");
    console.log("---------------------------------------");
    if(recognizing == false){
        recognition.start();
        recognizing         =   true;
    }
    var txtResult           =   $(this).attr("data-sufijo");
    console.log("txtResult  ->",txtResult);
    openMic(txtResult);
}

//ABRIR MICROFONO
function openMic(txtResult) {
    //console.log("   txtResult-> ",txtResult);
    $("#textActive").val(txtResult);
    $(".popMic").remove();
    var html    =   '<div class="popMic">'
                        +'<div class="icoRemove" id="endMic"><i class="icon-remove"></i></div>'
                            +'<div class="contMic">'
                        +'<div class="" id="spinMic"></div>'
                            +'<a class="mic" style="color: #607D8B;" id="procesar" onclick="js_procesar()"><i class="fa fa-file-audio-o" aria-hidden="true"></i></a>'
                        +'</div>'
                        +'<div id="areaResult" class="hoberText"></div>'
                    + '</div>';
    //console.log("html ->",html);
    $('#mic_'+txtResult).html(html);
    $('#areaResult').html('<b style="color:#ccc;">Escuchando... 2</b>');
    $('#procesar').html('<i class="fa fa-stop-circle-o parpadea" style="color:#FB404B;" aria-hidden="true"></i>');
}

function js_procesar(){
    if (recognizing == false) {
        recognition.start();
        recognizing         =   true;
        $('#procesar').html('<i class="fa fa-stop-circle-o parpadea" style="color:#FB404B;" aria-hidden="true"></i>');
    } else {
        recognition.stop();
        recognizing         =   false;
        $('#procesar').html('<i class="fa fa-stop-circle-o parpadea" style="color:#FB404B;" aria-hidden="true"></i>');
    }
}

function terminar(){
    recognition.stop();
    recognizing             =   false;
    $('#areaResult,#procesar').html('');
    $('.popMic').hide('fast');
}