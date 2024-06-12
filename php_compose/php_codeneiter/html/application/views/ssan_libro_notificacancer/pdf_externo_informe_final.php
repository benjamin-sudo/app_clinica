<div class="txt_mensaje">GENERANDO PDF</div>
<div class="html_pdf_notificacion_cancer2"></div>
<script>
    $(document).ready(function(){
    js_pdf_notificacion(<?php echo $id_anatomia;?>);
});

function js_pdf_notificacion(id_anatomia){
    $.ajax({ 
        type		:   "POST",
        url 		:   "ssan_libro_etapaanalitica/pdf_macroscopia_parte2",
        dataType        :   "json",
        beforeSend	:   function(xhr)           {   
                                                        console.log(xhr);
                                                        console.log("generando PDF recepcion ok");
                                                        $('#HTML_PDF_ANATOMIA_PATOLOGICA').html("<i class='fa fa-spinner' aria-hidden='true'></i>&nbsp;GENERANDO PDF");
                                                    },
        data 		:                           { 
                                                        id              :   id_anatomia,
                                                        empresa         :   '100',
                                                    },
        error		:   function(errro)         { 
                                                        console.log("errro  |   ",errro);
                                                        console.log("quisas->",errro,"-error->",errro.responseText); 
                                                        $("#protocoloPabellon").css("z-index","1500"); 
                                                        jError("Error General, Consulte Al Administrador","e-SISSAN"); 
                                                    },
        success		:   function(aData)         { 
                                                       
                                                        $('.txt_mensaje').hide();
                                                        console.log("aData  ",aData);
                                                        if(!aData["STATUS"]){
                                                            alert("error al cargar protocolo PDF","e-SISSAN");
                                                            return false;
                                                        } else {
                                                            //$("#modal_pdf_notificacion_cancer").modal("show");
                                                            var base64str           =   aData["PDF_MODEL"];
                                                            //decode base64 string, Eliminar espacio para compatibilidad con IE
                                                            var binary              =   atob(base64str.replace(/\s/g,''));
                                                            var len                 =   binary.length;
                                                            var buffer              =   new ArrayBuffer(len);
                                                            var view                =   new Uint8Array(buffer);
                                                            for(var i=0;i<len;i++){ view[i] = binary.charCodeAt(i); }
                                                            //console.log("view->",view);
                                                            //create the blob object with content-type "application/pdf"  
                                                            var blob                =   new Blob([view],{type:"application/pdf"});
                                                            var blobURL             =   URL.createObjectURL(blob);
                                                            //console.log("BlobURL->",blobURL);
                                                            Objpdf                  =   document.createElement('object');
                                                            Objpdf.setAttribute('data',blobURL);
                                                            Objpdf.setAttribute('width','100%');
                                                            Objpdf.setAttribute('style','height:700px;');
                                                            Objpdf.setAttribute('title','PDF');
                                                            console.log("Objpdf ",Objpdf);
                                                            $('.html_pdf_notificacion_cancer2').html(Objpdf);
                                                        }
                                                   }, 
   });
}
</script>