// jQuery Alert Dialogs Plugin
//
// Version 1.1
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 14 May 2009
//
// Visit http://abeautifulsite.net/notebook/87 for more information
//
// Usage:
//		jAlert( message, [title, callback] )
//		jConfirm( message, [title, callback] )
//		jPrompt( message, [value, title, callback] )
// 
// History:
//
//		1.00 - Released (29 December 2008)
//
//		1.01 - Fixed bug where unbinding would destroy all resize events
//
// License:
// 
// This plugin is dual-licensed under the GNU General Public License and the MIT License and
// is copyright 2008 A Beautiful Site, LLC. 
//
(function ($) {

    $.alerts = {
        // These properties can be read/written by accessing $.alerts.propertyName from your scripts at any time

        verticalOffset: -75, // vertical offset of the dialog from center screen, in pixels
        horizontalOffset: 0, // horizontal offset of the dialog from center screen, in pixels/
        repositionOnResize: true, // re-centers the dialog on window resize
        overlayOpacity: 0.5, // transparency level of overlay
        overlayColor: '#111111', // base color of overlay
        draggable: true, // make the dialogs draggable (requires UI Draggables plugin)
        okButton: '&nbsp;ACEPTAR&nbsp;', // text for the OK button
        cancelButton: '&nbsp;CANCELAR&nbsp;', // text for the Cancel button
        dialogClass: 'ui-dialog', // if specified, this class will be applied to all dialogs

        // Public methods

        alert: function (message, title, callback) {
            if (title == null)
                title = 'Alert';
            $.alerts._show(title, message, null, 'alert', function (result) {
                if (callback)
                    callback(result);
            });
        },
        confirm: function (message, title, callback) {
            if (title == null)
                title = 'Confirm';
            $.alerts._show(title, message, null, 'confirm', function (result) {
                if (callback)
                    callback(result);
            });
        },
        prompt: function (message, value, title, callback) {
            if (title == null)
                title = 'Prompt';
            $.alerts._show(title, message, value, 'prompt', function (result) {
                if (callback)
                    callback(result);
            });
        },
        message: function (message, title, callback) {
            if (title == null)
                title = 'Mensaje';
            $.alerts._show(title, message, null, 'message', function (result) {
                if (callback)
                    callback(result);
            });
        },
        warning: function (message, title, callback) {
            if (title == null)
                title = 'Advertencia';
            $.alerts._show(title, message, null, 'warning', function (result) {
                if (callback)
                    callback(result);
            });
        },
        error: function (message, title, callback) {
            if (title == null)
                title = 'Error';
            $.alerts._show(title, message, null, 'error', function (result) {
                if (callback)
                    callback(result);
            });
        },

        //hito 3
        firmaUnica : function (message, value, title, callback) {
            var title = 'Firma Única'; // Título fijo para este tipo de diálogo
            $.alerts._show(title, message, value, 'firmaUnica', function (result) {
                if (callback)
                    callback(result);
            });
        },

        // Private methods
        _show: function (title, msg, value, type, callback) {

            $.alerts._hide();
            $.alerts._overlay('show');

            $("BODY").append(
                    '<div id="popup_container">' +
                    '<h1 id="popup_title"></h1>' +
                    '<div id="popup_content">' +
                    '<div id="popup_message"></div>' +
                    '</div>' +
                    '</div>');

            if ($.alerts.dialogClass)
                $("#popup_container").addClass($.alerts.dialogClass);

            // IE6 Fix
            var pos = ($.browser.msie && parseInt($.browser.version) <= 6) ? 'absolute' : 'fixed';

            var zMax2 = $.maxZIndex() + 1;
            $("#popup_container").css({
                position: pos,
                zIndex: zMax2,
                padding: 0,
                margin: 0
            });

            $("#popup_title").text(title);
            $("#popup_content").addClass(type);
            $("#popup_message").text(msg);
            $("#popup_message").html($("#popup_message").text().replace(/\n/g, '<br />'));

            $("#popup_container").css({
                minWidth: $("#popup_container").outerWidth(),
                maxWidth: $("#popup_container").outerWidth()
            });

            $.alerts._reposition();
            $.alerts._maintainPosition(true);

            switch (type) {

                case 'alert':
                    $("#popup_message").after('<div id="popup_panel"><a class="btn btn-small  btn-alert" href="javascript:" style="font-size: 11px !important;" id="popup_ok"><i class="fa fa-check"></i> ACEPTAR</a></div>');
//                    $("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /></div>');
                    $("#popup_ok").click(function () {
                        $.alerts._hide();
                        callback(true);
                    });
                    $("#popup_ok").focus().keypress(function (e) {
                        if (e.keyCode == 13 || e.keyCode == 27)
                            $("#popup_ok").trigger('click');
                    });
                    break;

                case 'confirm':
                    //$("#popup_message").after('<div id="popup_panel"><input type="button" value="SI" id="popup_ok" /> <input type="button" value="NO" id="popup_cancel" /></div>');
                    $("#popup_message").after('<div id="popup_panel"><a class="btn btn-small  btn-alert" href="javascript:" style="font-size: 11px !important;" id="popup_ok"><i class="fa fa-check"></i> SI</a> <a class="btn btn-small  btn-alert" style="font-size: 11px !important;" id="popup_cancel"><i class="fa fa-ban"></i> NO</a></div>');
                    $("#popup_ok").click(function () {
                        $.alerts._hide();
                        if (callback)
                            callback(true);
                    });
                    $("#popup_cancel").click(function () {
                        $.alerts._hide();
                        if (callback)
                            callback(false);
                    });
                    $("#popup_ok").focus();
                    $("#popup_ok, #popup_cancel").keypress(function (e) {
                        if (e.keyCode == 13)
                            $("#popup_ok").trigger('click');
                        if (e.keyCode == 27)
                            $("#popup_cancel").trigger('click');
                    });
                    break;
                    
                case 'prompt':
                    $("#popup_message").append('<br><b><label id="txtFirmaS" style="font-weight: bold;">FIRMA UNICA DIGITAL: </label>&nbsp;</b><input type="password" autocomplete="new-password" size="30" style="width: 160px;" id="popup_prompt"/>').after('<div id="popup_panel"><a class="btn btn-small  btn-alert" href="javascript:" style="font-size: 11px !important;" id="popup_ok"><i class="fa fa-check"></i> ACEPTAR</a> <a class="btn btn-small  btn-alert" href="javascript:" style="font-size: 11px !important;" id="popup_cancel"><i class="fa fa-ban"></i> CANCELAR</a></div>');
                    //$("#popup_prompt").width( $("#popup_message").width() );
                    $("#popup_ok").click(function () {
                        var val = $("#popup_prompt").val();
                        $.alerts._hide();
                        if (callback)
                            callback(val);
                    });
                    $("#popup_cancel").click(function () {
                        $.alerts._hide();
                        if (callback)
                            callback(null);
                    });
                    $("#popup_prompt, #popup_ok, #popup_cancel").keypress(function (e) {
                        if (e.keyCode == 13)
                            $("#popup_ok").trigger('click');
                        if (e.keyCode == 27)
                            $("#popup_cancel").trigger('click');
                    });
                    if (value)
                        $("#popup_prompt").val(value);
                    $("#popup_prompt").focus().select();
                    break;

                case 'message':
                    $("#popup_message").after('<div id="popup_panel"><a class="btn btn-small  btn-alert" href="javascript:" style="font-size: 11px !important;" id="popup_ok"><i class="fa fa-check"></i> ACEPTAR</a></div>');
                    $("#popup_ok").click(function () {
                        $.alerts._hide();
                        callback(true);
                    });
                    $("#popup_ok").focus().keypress(function (e) {
                        if (e.keyCode == 13 || e.keyCode == 27)
                            $("#popup_ok").trigger('click');
                    });
                    break;

                case 'warning':
                    $("#popup_message").after('<div id="popup_panel"><a class="btn btn-small  btn-alert" href="javascript:" style="font-size: 11px !important;" id="popup_ok"><i class="fa fa-check"></i> ACEPTAR</a></div>');
                    $("#popup_ok").click(function () {
                        $.alerts._hide();
                        callback(true);
                    });
                    $("#popup_ok").focus().keypress(function (e) {
                        if (e.keyCode == 13 || e.keyCode == 27)
                            $("#popup_ok").trigger('click');
                    });
                    break;

                case 'error':
                    $("#popup_message").after('<div id="popup_panel"><a class="btn btn-small  btn-alert" href="javascript:" style="font-size: 11px !important;" id="popup_ok"><i class="fa fa-check"></i> ACEPTAR</a></div>');
                    $("#popup_ok").click(function () {
                        $.alerts._hide();
                        callback(true);
                    });
                    $("#popup_ok").focus().keypress(function (e) {
                        if (e.keyCode == 13 || e.keyCode == 27)
                            $("#popup_ok").trigger('click');
                    });
                    break;

                //hito    
                case 'firmaUnica':
                    $("#popup_message").append(`
                        <br>
                        <table style="margin-left: 70px;">
                            <tr>
                                <td><label id="txtRun" style="font-weight: bold;">RUN: </label>&nbsp;</td>
                                <td><input type="text" autocomplete="run usuario" size="30" style="width:100px;" id="txt_run_prompt"/></td>
                            </tr>
                            <tr>
                                <td> <label id="txtFirmaS" style="font-weight: bold;">FIRMA SIMPLE DIGITAL: </label>&nbsp;</td>
                                <td><input type="password" autocomplete="new-password" size="30" style="width: 160px;" id="popup_prompt"/></td>
                            </tr>
                        </table>
                        `).after(`
                            <div id="popup_panel">
                                <a class="btn btn-small  btn-alert" href="javascript:" style="font-size: 11px !important;" id="popup_ok"><i class="fa fa-check"></i> ACEPTAR</a> 
                                <a class="btn btn-small  btn-alert" href="javascript:" style="font-size: 11px !important;" id="popup_cancel"><i class="fa fa-ban"></i> CANCELAR</a>
                            </div>
                        `);
                        let v_status_run = false;
                        $('#txt_run_prompt').Rut({
                            format_on   :   'keyup',
                            on_error    :   function(){  v_status_run = false; $("#txt_run_prompt").css("border","1px solid red"); },
                            on_success  :   function(){  v_status_run = true;  },
                        });
                        $("#popup_ok").click(function () {
                            let v_run = $("#txt_run_prompt").val();
                            let val = $("#popup_prompt").val();
                            $.alerts._hide();
                            if (callback){
                                callback({'v_run':v_run,'v_pass':val,'status_run':v_status_run});
                            }
                        });
                        $("#popup_cancel").click(function () {
                            $.alerts._hide();
                            if (callback)
                                callback(null);
                        });
                        $("#txt_run_prompt, #popup_prompt, #popup_ok, #popup_cancel").keypress(function(e){
                            if (e.keyCode == 13)
                                $("#popup_ok").trigger('click');
                            if (e.keyCode == 27)
                                $("#popup_cancel").trigger('click');
                        });
                        if (value)
                            $("#txt_run_prompt").val(value);
                            $("#txt_run_prompt").focus().select();
                        break;

            }

            // Make draggable
            if ($.alerts.draggable) {
                try {
                    $("#popup_container").draggable({handle: $("#popup_title")});
                    $("#popup_title").css({cursor: 'move'});
                } catch (e) { /* requires jQuery UI draggables */
                }
            }
        },
        _hide: function () {
            $("#popup_container").remove();
            $.alerts._overlay('hide');
            $.alerts._maintainPosition(false);
        },
        _overlay: function (status) {

            switch (status) {
                case 'show':
                    var zMax = $.maxZIndex();
                    $.alerts._overlay('hide');
                    $("BODY").append('<div id="popup_overlay"></div>');
                    $("#popup_overlay").css({
                        position: 'absolute',
                        zIndex: zMax,
                        top: '0px',
                        left: '0px',
                        width: '100%',
                        height: $(document).height(),
                        background: $.alerts.overlayColor,
                        opacity: $.alerts.overlayOpacity
                    });
                    break;
                case 'hide':
                    $("#popup_overlay").remove();
                    break;
            }
        },
        _reposition: function () {
            var top = (($(window).height() / 2) - ($("#popup_container").outerHeight() / 2)) + $.alerts.verticalOffset;
            var left = (($(window).width() / 2) - ($("#popup_container").outerWidth() / 2)) + $.alerts.horizontalOffset;
            if (top < 0)
                top = 0;
            if (left < 0)
                left = 0;

            // IE6 fix
            //if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();

            $("#popup_container").css({
                top: top + 'px',
                left: left + 'px'
            });
            $("#popup_overlay").height($(document).height());
        },
        _maintainPosition: function (status) {
            if ($.alerts.repositionOnResize) {
                switch (status) {
                    case true:
                        $(window).bind('resize', $.alerts._reposition);
                        break;
                    case false:
                        $(window).unbind('resize', $.alerts._reposition);
                        break;
                }
            }
        }

    }

    // Shortuct functions
    jAlert = function (message, title, callback) {
        $.alerts.alert(message, title, callback);
    }

    jConfirm = function (message, title, callback) {
        $.alerts.confirm(message, title, callback);
    };

    jPrompt = function (message, value, title, callback) {
        $.alerts.prompt(message, value, title, callback);
    };

    // New features
    jMessage = function (message, title, callback) {
        $.alerts.message(message, title, callback);
    }

    jWarning = function (message, title, callback) {
        $.alerts.warning(message, title, callback);
    }

    jError = function (message, title, callback) {
        $.alerts.error(message, title, callback);        
    }

    //hito 2
    jFirmaUnica = function (message, value, title, callback) {
        $.alerts.firmaUnica(message, value, title, callback);
    };

})(jQuery);