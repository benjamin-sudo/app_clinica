/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var keepAliveTimeout;;
var connect = true;
var timeConex;

$(document).ready(function() {

    jQuery.browser = {};
    jQuery.browser.msie = false;
    jQuery.browser.version = 0;
    if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
    }

    type = ['', 'info', 'success', 'warning', 'danger'];

    //Verifica version movil
    var isMobile = false;
    //initiate as false
    // device detection
    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) ||
        /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) {
        isMobile = true;
    }

    if (isMobile) {
        $('.side_menu').show();
    }

    $(":input").keypress(function(event) {
        if (event.which === 60 || event.which === 62 || event.which === 39) {
            return false;
        }
    });

    // keepSessionAlive();
});

function keepSessionAlive() {
    clearTimeout(timeConex);
    $.ajax({
        type: 'GET',
        url: '//' + window.location.hostname,
        success: function(data) {
            if (!connect) {
                $('#loadConex').modal('hide');
            }
            connect = true;
            timeConex = setTimeout(function() { keepSessionAlive(); }, 10000);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            if (connect) {
                $('#loadConex').modal('show');
            }
            connect = false;
            timeConex = setTimeout(function() { keepSessionAlive(); }, 1000);
        },
        timeout: 3500
    });
}

Fuente: https: //www.iteramos.com/pregunta/75984/jquery-ajax---como-detectar-la-conexion-de-red-de-error-al-hacer-la-llamada-ajax

    /*
     * 
     * @param {string} from posicion vertical
     * @param {string} align posicion horizontal
     * @param {string} Mensaje
     * @param {number} color - 1: info, 2:success, 3:warning, 4:danger
     * @param {string} icono fontawesome v4.7.0
     */

    function showNotification(from, align, txt, color, icono, width) {
        //$('div.col-xs-11.col-sm-4.alert.alert-danger.alert-with-icon.animated.fadeInDown').addClass('fadeOutUp');

        $.notify({
            icon: icono,
            message: txt
        }, {
            type: type[color],
            timer: 4000,
            placement: {
                from: from,
                align: align
            }
        });


        $('.alert').css('z-index', '9999');
        if (width != '') {
            $('.alert').css('width', width);
            $('.message').css('width', width);
        }
        //showNotification('top', 'center', errores, 4);
    }

function cambiaEstable() {

    $('#cambiarEstbleTmp').modal('show');

    AjaxExt({}, 'esteblesChanges', 'cambiaEstable', '', 'inicio');
}

function confirmCambio() {

    var listarestab = $("#listarestab").val();
    var nomestab = $("#listarestab :selected").text();

    jConfirm('Con esta acci&oacute;n se proceder&aacute; a cambiar de establecimiento<br>La pantalla de trabajo actual sera reiniciada<br>¿Desea continuar?', 'Informacion', function(r) {
        if (r) {
            $('#cambiarEstbleTmp').modal('hide');
            AjaxExt({ listarestab: listarestab, nomestab: nomestab }, 'respuesta', 'confirmCambio', '', 'inicio');
        } else {

        }

    });
}

function CambioPass() {

    var txtPassOLD = $("#txtPassOLD").val();
    var txtPassNueva = $("#txtPassNueva1").val();
    var txtRePassNueva = $("#txtRePassNueva1").val();
    var nivelPass = $("#nivContr0").val();
    var token = $_GET('tk');

    if (txtPassNueva == '' || txtRePassNueva == '') {
        jWarning("La Contraseña no puede estar vacia", "Restricción");
    } else if (nivelPass == 'Pobre') {
        jWarning("El Nivel de seguridad de la contraseña es muy bajo", "Restricción");
    } else {
        var funcion = "cambiopass";
        var id = "respuesta";
        var variables = { "txtPassNueva": txtPassNueva, "txtRePassNueva": txtRePassNueva, "txtPassOLD": txtPassOLD, "txtPassOLD": txtPassOLD, token: token }
        AjaxExt(variables, id, funcion, '', 'frontend');
    }
}

function ValPassIguales() {
    if ($('#txtPassNueva1').val() != $('#txtRePassNueva1').val()) {
        $("#mensaje2").html('Contraseñas no coinciden.');
        $("#txtPassNueva1").css("border-color", "#FA5858");
        $("#txtRePassNueva1").css("border-color", "#FA5858");
    } else {
        $("#mensaje2").html('');
        $("#txtPassNueva1").css("border-color", "#CCC");
        $("#txtRePassNueva1").css("border-color", "#CCC");
    }
}

function tableBootstrap(toggle, columns, filas, search) {

    if (toggle == undefined) {
        toggle = false;
    }
    if (columns == undefined) {
        columns = false;
    }
    if (filas == undefined) {
        filas = 25;
    }
    if (search == undefined) {
        search = true;
    }

    var $tables = $('.bootstrap-table');
    $().ready(function() {
        $tables.bootstrapTable({
            toolbar: '.toolbar',
            clickToSelect: true,
            showRefresh: false,
            search: search,
            showToggle: toggle,
            showColumns: columns,
            pagination: true,
            searchAlign: 'left',
            pageSize: filas,
            clickToSelect: false,
            pageList: [8, 10, 25, 50, 100],
            formatShowingRows: function(pageFrom, pageTo, totalRows) {

            },
            formatRecordsPerPage: function(pageNumber) {
                return pageNumber + ' resultados visibles';
            },
            icons: {
                refresh: 'fa fa-refresh',
                toggle: 'fa fa-th-list',
                columns: 'fa fa-columns',
                detailOpen: 'fa fa-plus-circle',
                detailClose: 'fa fa-minus-circle'
            }
        });
        //activate the tooltips after the data table is initialized
        $('[rel="tooltip"]').tooltip();

        $(window).resize(function() {
            $tables.bootstrapTable('resetView');
        });
    });
}

function login() {
    $('#formLog').validate();

    var user = $("#user").val();
    var pass = $("#pass").val();
    var access = $_GET('access');
    if (access == undefined) {
        access = '';
    }
    var funcion = 'login';
    var id = "test2";
    var variables = { "user": user, "pass": pass, "access": access };
    AjaxExt(variables, id, funcion, '', 'inicio');

    return false;
}

function validaPass(idPass, idError) {
    $('#'.idError).hide('fast');
    var passNew = $('#' + idPass).val();
    var variables = { passNew: passNew, idError: idError };
    if (passNew != '') {
        AjaxExt(variables, 'respuesta', 'validaPass', '', 'inicio');
    }
}

function sesiones() {
    var access = $_GET('access');
    if (access == undefined) {
        access = '';
    }
    $('#iniEstabl').prop('disabled', true);
    $('#iconSes').attr('class', 'fa fa-spinner fa-spin');
    var funcion = 'arraymenu';
    var id = "respuesta";
    var establecimiento = $("#listarestab option:selected").val();
    establecimiento = establecimiento.split('#');
    var variables = { "establecimiento": establecimiento[0], "tipoEstabl": establecimiento[1], "access": access };
    AjaxExt(variables, id, funcion, '', 'inicio');
}

function irSisemas(idPrin) {
    window.location = 'home_sistemas?m=' + idPrin;
}

function loadDash() {
    var idSel = $_GET('m');
    var idMen = $_GET('id');

    //    var funcion = 'loadMenuDashBoard';
    var funcion = 'loadMenuMaterial';
    var variables = { idSel: idSel, idMen: idMen, controller: 'frontend' };

    var isMobile = false;
    //initiate as false
    // device detection
    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) ||
        /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) {
        isMobile = true;
    }

    var id = "menuDash";
    if (isMobile) {
        id = "menuDashMobile";
    }
    AjaxExt(variables, id, funcion, '', 'frontend');
}



function abrirVentanaCambioClave() {
    change_captcha();
    $('#idResetearClave').modal("show");
}

function resetearClaves() {

    $('#formResetPass').validate();

    $("#m1").hide(500);
    $("#m2").hide(500);
    $("#m3").hide(500);
    $("#m4").hide(500);
    $("#m5").hide(500);
    $("#m6").hide(500);
    var correo = $("#txtEmail").val();
    var variables = { "correo": correo };
    var id = "respuesta";
    var codigo = $("#code").val();
    var captcha = $("#codeCap").val();
    if (correo == '') {
        $("#m2").show(500);
    } else if (codigo.toLowerCase() != captcha) {
        $("#m1").show(500);
    } else {
        AjaxExt(variables, id, 'recuperaPassAccess', '', 'inicio');
        $("#m4").show(500);
    }
    return false;
}

function change_captcha() {
    AjaxExt({}, 'imgCaptcha', 'traeCod', '', 'inicio');
}

function validaPassChang() {
    var token = $_GET("tk");
    AjaxExt({ token: token }, 'respuesta', 'validaPassRestable', '', 'inicio');
}

function validaPass(idPass, idError) {
    $('#'.idError).hide('fast');
    var passNew = $('#' + idPass).val();
    var variables = { passNew: passNew, idError: idError };
    if (passNew != '') {
        AjaxExt(variables, 'respuesta', 'validaPass', '', 'inicio');
    }
}


function valida(F) {
    var arr = $(F).val().split(" ");

    var nam = arr.length;

    if (nam > 1) {
        return false;
    } else {
        return true;
    }
}

function nuevaFirma() {
    timerDestroy();
    $('#modalNewFirma').modal('show');
}

function subirImgsPerfil(formulario) {

    if ($('#imagenPerfil').val() == '') {
        jAlert('Debe Seleccionar una Imagen', 'Restricción');

    } else if (valida('#imagenPerfil') == false) {
        jAlert('Nombre de Archivo Invalido', 'Restricción');
    } else {

        jPrompt('Ingrese su Firma Simple', '',
            'Confirmaci\u00F3n',
            function(r) {
                if (r) {

                    //                        $('#grabando').dialog('open');

                    var fileExtension = "";
                    //                        $(':file').change(function ()
                    //                        {
                    //obtenemos un array con los datos del archivo
                    var file = $("#imagenPerfil")[0].files[0];
                    //obtenemos el nombre del archivo
                    var fileName = file.name;
                    //obtenemos la extensión del archivo
                    fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
                    //obtenemos el tamaño del archivo
                    var fileSize = file.size;
                    //obtenemos el tipo de archivo image/png ejemplo
                    var fileType = file.type;
                    //mensaje con la información del archivo
                    //showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
                    //$("#docs").append("<tr>><td>"+fileName+"</td><td>"+fileSize+" bytes.</td></tr>");

                    //                        });

                    //información del formulario
                    var formData = new FormData($("." + formulario)[0]);

                    var message = "";
                    if (isImage(fileExtension)) {
                        $('#modalImgUser').modal('hide');
                        //hacemos la petición ajax  
                        $.ajax({
                            url: 'assets/themes/admin/subePerfil.php',
                            type: 'POST',
                            // Form data
                            //datos del formulario
                            data: formData,
                            //necesario para subir archivos via ajax
                            cache: false,
                            contentType: false,
                            processData: false,
                            //mientras enviamos el archivo
                            beforeSend: function() {
                                message = "Subiendo Archivos Adjuntos, por favor espere...";
                                showNotification('top', 'center', message, 1, 'fa fa-upload');
                            },
                            //una vez finalizado correctamente
                            success: function(data) {
                                //AjaxExt(variables, 'respuesta', 'validaPass', '', 'inicio');
                                //tx_opssannewmisugerencias_pi1grabaDatImg(data, r[0]);{

                                message = "Archivo de imagen subido Correctamente. (" + data + ")";
                                showNotification('top', 'center', message, 2, 'fa fa-check');

                            },
                            //si ha ocurrido un error
                            error: function() {
                                message = "Ha ocurrido un error al subir la imagen";
                                showNotification('top', 'center', message, 4, 'fa fa-warning');
                            }
                        });
                    } else {
                        message = 'Debe subir un archivo de imagen valido.';
                        showNotification('top', 'center', message, 4, 'fa fa-warning');
                    }
                }
            });
    }
}

//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
function isImage(extension) {
    switch (extension.toLowerCase()) {
        case 'jpg':
        case 'gif':
        case 'png':
        case 'jpeg':
            return true;
            break;
        default:
            return false;
            break;
    }
}

function confirmDatPss() {

    $('#formConfirDat').validate();

    var idUsrS = $('#idUsrS').val();
    var nombres = $('#nameUsr').val();
    var apePat = $('#apePatUsr').val();
    var apeMat = $('#apeMatUsr').val();
    var email = $('#emailUsr').val();
    var fono = $('#fonoUsr').val();
    var passActual = $('#passAcUsr').val();
    var passNew = $('#password1').val();
    var passNew2 = $('#passNew2Usr').val();
    var nivPass = $('#nivContr').val();
    var username = $('#username').val();
    var err = '';
    if (nombres === '') {
        err += 'Nombres\n';
    } else if (apePat === '') {
        err += 'Apellido Paterno\n';
    } else if (apeMat === '') {
        err += 'Apellido Materno\n';
    } else if (email === '') {
        err += 'Correo Electrónico de Contacto\n';
    } else if (fono === '') {
        err += 'Número Celular de Contacto\n';
    } else if (passActual === '') {
        err += 'Contraseña Actual\n';
    } else if (passNew === '') {
        err += 'Nueva Contraseña\n';
    } else if (passNew2 === '') {
        err += 'Repetir Contraseña\n';
    }

    if (err !== '') {
        $('#error_LPass').show('fast');
        $('#txtErrPss').html('Estimado Usuario, El Campo <b>' + err + '</b> es Requerido');
    } else if (nivPass === 'Pobre') {
        $('#error_LPass').show('fast');
        $('#txtErrPss').html('Estimado Usuario,\n En Nivel de Seguridad de la Nueva Contraseña es muy Bajo.');
    } else if (nivPass === 'Vulnerable') {
        $('#error_LPass').show('fast');
        $('#txtErrPss').html('La Contraseña Ingresada está dentro del registro de contraseñas vulnerables.');
    } else if (passNew !== passNew2) {
        $('#error_LPass').show('fast');
        $('#txtErrPss').html('Estimado Usuario,\n Las Contraseñas ingresadas con Coinciden.');
    } else {
        var variables = { idUsrS: idUsrS, nombres: nombres, apePat: apePat, apeMat: apeMat, email: email, fono: fono, passActual: passActual, passNew: passNew, username: username };
        AjaxExt(variables, 'respuesta', 'confirNewDat', '', 'inicio');
    }
    return false;

}

function irUrl(url) {
    window.location = url;
}

function selectM(ext, idPrin, idMen, isToken, param) {
    if (isToken) {
        var variables = { ext: ext, idPrinP: idPrin, idMen: idMen, param: param };
        AjaxExt(variables, 'respuesta', 'getTokMenu', '', 'inicio');
    } else {
        if (param == undefined) {
            param = '';
        }
        window.location = ext + '?id=' + idMen + '&m=' + idPrin + param;
    }

}
$.maxZIndex = $.fn.maxZIndex = function(opt) {
    /// <summary>
    /// Returns the max zOrder in the document (no parameter)
    /// Sets max zOrder by passing a non-zero number
    /// which gets added to the highest zOrder.
    /// </summary>    
    /// <param name="opt" type="object">
    /// inc: increment value, 
    /// group: selector for zIndex elements to find max for
    /// </param>
    /// <returns type="jQuery" />
    var def = { inc: 10, group: "*" };
    $.extend(def, opt);
    var zmax = 0;
    $(def.group).each(function() {
        var cur = parseInt($(this).css('z-index'));
        zmax = cur > zmax ? cur : zmax;
    });
    if (!this.jquery)
        return zmax;
    return this.each(function() {
        zmax += def.inc;
        $(this).css("z-index", zmax);
    });
}

function cambiaPassNew() {

    var txtPassOLD = $('#passOld').val();
    var txtPassNueva = $('#passNew1').val();
    var token = $('#token').val();
    var username = $('#username').val();

    if (!validaInputPass()) {
        return false;
    }

    jPrompt('Ingrese su Firma Simple', '', 'Confirmaci\u00F3n', function(r) {
        if (r) {
            $('#loadFade').modal('show');
            AjaxExt({ txtPassOLD: txtPassOLD, txtPassNueva: txtPassNueva, clave: r, token: token, username: username }, 'respuesta', 'cambiopass', '', 'perfilUsuario');
        }
    });
}

function validaInputPass() {
    var txtPassOLD = $('#passOld').val();
    var txtPassNueva = $('#passNew1').val();
    var txtPassNueva2 = $('#passNew2').val();
    var nivContr = $('#nivContr').val();

    $('#passOld').css('border-color', '#E3E3E3');
    $('#passNew1').css('border-color', '#E3E3E3');
    $('#passNew2').css('border-color', '#E3E3E3');
    if (txtPassOLD == '') {
        jWarning("La contrase&ntilde;a actual es obligatoria.", "Información");
        $('#passOld').css('border-color', '#f44336');
        return false;
    } else if (txtPassNueva == '') {
        jWarning("La contrase&ntilde;a nueva es obligatoria.", "Información");
        $('#passNew1').css('border-color', '#f44336');
        return false;
    } else if (txtPassNueva2 == '') {
        jWarning("Debe repetir la contrase&ntilde;a nueva.", "Información");
        $('#passNew2').css('border-color', '#f44336');
        return false;
    } else if (txtPassNueva != txtPassNueva2) {
        jWarning("Las contrase&ntilde;as no coinciden.", "Información");
        $('#passNew1').css('border-color', '#f44336');
        $('#passNew2').css('border-color', '#f44336');
        return false;
    } else if (txtPassOLD == txtPassNueva2) {
        jWarning("La contrase&ntilde;as nueva es igual a la anterior.", "Información");
        $('#passNew1').css('border-color', '#f44336');
        $('#passNew2').css('border-color', '#f44336');
        return false;
    } else if (nivContr == 'Vulnerable') {
        jWarning("La contrase&ntilde;a ingresada está dentro del registro de contrase&ntilde;as vulnerables.", "Informaci&oacute;n");
        $('#passNew1').css('border-color', '#f44336');
        $('#passNew2').css('border-color', '#f44336');
        return false;
    } else if (nivContr == 'Pobre') {
        jWarning("La contrase&ntilde;a ingresada tiene un nivel bajo de seguridad, favor intente con una contrase&ntilde;a mas segura.", "Informaci&oacute;n");
        $('#passNew1').css('border-color', '#f44336');
        $('#passNew2').css('border-color', '#f44336');
        return false;
    }
    return true;
}

function validaPassSegura() {
    var txtPassNueva = $('#passNew1').val();
    AjaxExt({ txtPassNueva: txtPassNueva }, 'respuesta', 'validaPassSegura', '', 'perfilUsuario');
}

function clearPass() {
    $('#passOld').val('');
    $('#passNew1').val('');
    $('#passNew2').val('');
    $('#nivContr').val('Pobre');
    $('.entropizer-bar').css('width', '0');
}

function confirmDatosNuevos() {

    var nombres = $('#txtNombresUsu').val();
    var apePat = $('#txtApellidoP').val();
    var apeMat = $('#txtApellidoM').val();
    var email = $('#txtCorreo').val();
    var fono = $('#txtFono').val();
    var username = $('#username').val();

    var err = '';
    if (nombres === '') {
        err += 'Nombres\n';
    }
    if (apePat === '') {
        err += 'Apellido Paterno\n';
    }
    if (apeMat === '') {
        err += 'Apellido Materno\n';
    }
    if (email === '') {
        err += 'Correo Electrónico de Contacto\n';
    }
    if (fono === '') {
        err += 'Número Celular de Contacto\n';
    }

    if (err !== '') {
        $('#error_LPass').show('fast');
        jWarning('Estimado Usuario, El Campo <b>' + err + '</b> es Requerido');
    } else {
        jPrompt('Ingrese su Firma Simple', '', 'Confirmaci\u00F3n', function(r) {
            if (r) {
                var variables = { nombres: nombres, apePat: apePat, apeMat: apeMat, email: email, fono: fono, clave: r, username: username };
                AjaxExt(variables, 'respuesta', 'confirNewDat', '', 'perfilUsuario');
            }
        });
    }

}

function confirmEnvioRecuperacion() {
    jConfirm('Se enviar&aacute; un correo electronico con su firma digital simple.<br>Desea continuar?', 'Confirmaci\u00F3n', function(r) {
        if (r) {
            AjaxExt({}, 'respuesta', 'RecuerdaContrasena', '', 'frontend');
        }
    });
}

var min = 4;
var seg = 60;

function stratVerif() {
    min = 4;
    seg = 60;
    $('#newFirma').hide('fast');
    $('#codeFirma').show('fast');
    $('#codVerif').focus();
    timer();
}

var timerH;

function timer(cancel) {
    if (cancel == 1) {
        clearTimeout(timerH);
        $('#minute').html('0');
        $('#second').html('00');
        return false;
    }

    timerH = setTimeout(function() {
        seg--;
        if (seg < 10) {
            seg = '0' + seg;
        }
        $('#second').html(seg);
        if (seg === '00') {
            seg = 60;
            min--;
        }

        if (min == -1 && seg == 60) {
            cancel = 1;
        }
        $('#minute').html(min);
        timer(cancel);
    }, 1000);

}

function timerDestroy(hide) {
    min = 4;
    seg = 60;
    clearTimeout(timerH);
    $('#minute').html('5');
    $('#second').html('00');
    $('#codVerif').val('');

    $('#newFirma').show('fast');
    $('#codeFirma').hide('fast');

    if (hide == undefined) {
        $('#firmaNew1').val('');
        $('#firmaNew2').val('');
        $('#modalNewFirma').modal('hide');
    }
}

function validaExFirm() {
    var firma = $('#firmaNew1').val();
    var username = $('#username').val();
    if (firma != '') {
        $('#btnFS').prop('disabled', true);
        AjaxExt({ firma: firma, username: username }, 'respuesta', 'validaFirmaExist', '', 'perfilUsuario');
    }
}

function cambiaFirma() {
    timerDestroy(1);

    var firma = $('#firmaNew1').val();
    var firma2 = $('#firmaNew2').val();
    var exFirm = $('#exFirm').val();
    var username = $('#username').val();

    if (firma == '') {
        jWarning('Debe ingresar la nueva firma', 'Informaci\u00F3n');
        return false;
    }
    if (firma2 == '') {
        jWarning('Debe repetir la nueva firma', 'Informaci\u00F3n');
        return false;
    }
    if (firma != firma2) {
        jWarning('Las firmas no coinciden', 'Informaci\u00F3n');
        return false;
    }
    if (firma.length < 6) {
        jWarning('La firma debe contener un minimo de 6 caracteres', 'Informaci\u00F3n');
        return false;
    }
    if (exFirm == 1) {
        jWarning('La firma ingresada está dentro del registro de contrase&ntilde;as vulnerables', 'Informaci\u00F3n');
        return false;
    }

    var v = 0;
    if (tiene_letras(firma)) {
        v++;
    }
    if (tiene_numeros(firma)) {
        v++;
    }

    if (v < 2) {
        jWarning('Estimado Usuario, Su firma debe contener n&uacute;meros y letras', 'Informaci\u00F3n');
        return false;
    }

    AjaxExt({ firma: firma, username: username }, 'respuesta', 'solicitudNuevaFirma', '', 'perfilUsuario');
}

function confirmCambioF() {
    var codVerif = $('#codVerif').val();
    var firmaNew = $('#firmaNew1').val();
    var username = $('#username').val();

    AjaxExt({ codVerif: codVerif, firmaNew: firmaNew, username: username }, 'respuesta', 'confirmCambioFirma', '', 'perfilUsuario');
}

function tiene_letras(texto) {
    texto = texto.toLowerCase();
    var letras = "abcdefghyjklmnñopqrstuvwxyz";
    for (i = 0; i < texto.length; i++) {
        if (letras.indexOf(texto.charAt(i), 0) != -1) {
            return true;
        }
    }
    return false;
}

function tiene_numeros(texto) {
    var numeros = "0123456789";
    for (i = 0; i < texto.length; i++) {
        if (numeros.indexOf(texto.charAt(i), 0) != -1) {
            return true;
        }
    }
    return false;
}

function $_GET(param) {
    /* Obtener la url completa */
    url = document.URL;
    /* Buscar a partir del signo de interrogación ? */
    url = String(url.match(/\?+.+/));
    /* limpiar la cadena quitándole el signo ? # */
    url = url.replace("?", "");
    url = url.replace("#", "");
    /* Crear un array con parametro=valor */
    url = url.split("&");
    /* 
     Recorrer el array url
     obtener el valor y dividirlo en dos partes a través del signo = 
     0 = parametro
     1 = valor
     Si el parámetro existe devolver su valor
     */
    x = 0;
    while (x < url.length) {
        p = url[x].split("=");
        if (p[0] == param) {
            return decodeURIComponent(p[1]);
        }
        x++;
    }
}

function formateaRUTIn() {

    rut = document.getElementById('user').value;

    if (rut != "") {
        dv = rut.substr(rut.length - 1, 1); //asigna dv
        rut = rut.substr(0, rut.length - 1); //asigna cuerpo
        nerut = "";
        for (i = 0; i < rut.length; i++) {
            if (rut.charAt(i) >= "0" && rut.charAt(i) <= "9") {
                nerut += parseInt(rut.charAt(i), 10); //conv char a num dec, parÃ¡metro "10", octal=8, etc
            }
        }
        num = parseInt(nerut, 10);
        strXYZ = "";

        if (num > 1000000) {
            millones = ((num - num % 1000000) / 1000000);
            strXYZ += millones; // + ".";
        }
        if (num > 1000) {
            miles = (((num % 1000000) - (num % 1000000) % 1000) / 1000);
            if (num > 1000000)
                miles = cerosmil(miles);
            strXYZ += miles; //+ ".";
        }
        if (num > 1000)
            num = cerosmil(num % 1000);
        strXYZ += num;
        strXYZ = strXYZ + "-" + dv;
        nueva_cadena = strXYZ.replace("NaN", "");
        nueva_cadena = nueva_cadena.replace("--", "");
        if (nueva_cadena.length == 2) {
            nueva_cadena = nueva_cadena.replace("-k", "");
        }
        if (nueva_cadena.length == 2) {
            nueva_cadena = nueva_cadena.replace("-K", "");
        }

        nueva_cadena = nueva_cadena.replace("-.", "");
        document.getElementById('user').value = nueva_cadena;
    }

}

function cerosmil(st) {
    st = "" + st;
    if (st.length == 3)
        return st;
    if (st.length < 3)
        return cerosmil("0" + st);
    else
        return st;
}

function logoutSes() {

    var id = "respuesta";
    var funcion = 'cierresesion';
    var variables = {};
    AjaxExt(variables, id, funcion, '', 'frontend');
}

//Funcion General de Ajax
function AjaxExt(variables, id, funcion, tipDest, extension) {

    var imagens = '<img src="assets/themes/frontend/img/loadings.gif" style="width:100%; height:4px">';
    if (extension == undefined || extension == '') {
        var URLactual = jQuery(location).attr('href');
        var res = URLactual.split("/");
        var cont = res.length;
        cont = cont - 1;
        var nombreExt = res[cont];
        var res = nombreExt.split("#");
        nombreExt = res[0];
        var res = nombreExt.split("?");
        nombreExt = res[0];
    } else {
        var nombreExt = extension;
    }

    if (id == 'respuesta') {
        var newId = Math.floor(Math.random() * 9999);
        $("#respuesta").append('<div id="idDat_' + newId + '" style="display:none"></div>');
        id = 'idDat_' + newId;
    }

    if (tipDest == undefined || tipDest == '') {
        $("#" + id).html("");
    }

    $("#carga").show();
    $(".loader").show();
    $("#cargaSecundaria").html(imagens);
    var post_llamada = $.post(nombreExt + "/" + funcion, variables, function(data) {

    }).done(function(data) {
        //hace lo que quieres cuando sale correctamente
        switch (tipDest) {
            case 'append':
                $("#" + id).append(data);
                break;
            case 'prepend':
                $("#" + id).prepend(data);
                break;
            case 'last':
                $("#" + id).last(data);
                break;
            case 'first':
                $("#" + id).first(data);
                break;
            case 'after':
                $("#" + id).after(data);
                break;
            case 'val':
                $("#" + id).val(data);
                break;
            default:
                $("#" + id).html(data);
                break;
        }


        $("#carga").hide();
        $(".loader").hide();
        $("#cargaSecundaria").html("");
    }).fail(function(jqXhr, textStatus, errorThrown) {
        post_llamada.abort();
        // hace lo que quieras cuando sale con problemas.
        //$("#" + id).text("Problema al Procesar su Solicitud. " + errorThrown);
        //alert("Problema al Procesar su Solicitud.<br>" + errorThrown);
        if (errorThrown != 'Internal Server Error' && errorThrown != '') {
            jError("Problema al Procesar su Solicitud.<br>" + errorThrown, 'Error Detectado');
            var URLactual = nombreExt + "/" + funcion;
            var variables = { error: errorThrown, URLactual: URLactual };
            AjaxExt(variables, 'respuesta', 'errorMail', '', 'frontend');
        }
    });
    return false;
}