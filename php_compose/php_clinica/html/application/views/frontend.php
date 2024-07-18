<?php
$login = $this->session->userdata('logAdmin');
if ($login != 1 || !isset($login)) {
    header('Location: admin');
}
if (!ini_get('date.timezone')) {
    date_default_timezone_set('GMT');
}
?>
<html lang="es">
    <head>
        <title>SISSAN - Administración</title>
        <meta name="resource-type" content="document" />
        <meta name="robots" content="all, index, follow"/>
        <meta name="googlebot" content="all, index, follow" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />

        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="assets/themes/img/iconAdmin.png" type="image/x-icon"/>

        <link href="assets/themes/css/jquery-ui.css" rel="stylesheet"/>
        <link href="assets/themes/css/jquery.alerts.css" rel="stylesheet"/>
        <link href="assets/themes/css/boobtstrap.css" rel="stylesheet"/>
        <link href="assets/themes/css/newcss.css" rel="stylesheet"/>

        <link href="assets/themes/css/styles_menu.css" rel="stylesheet"/>
        <link href="assets/themes/css/chosen.css" rel="stylesheet"/>
        <link href="assets/themes/css/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>

        <link href="assets/themes/css/pnotify.custom.min.css" rel="stylesheet"/>
        <link href="assets/themes/css/jquery-confirm.css" rel="stylesheet"/>
        <link href="assets/themes/css/pnotify.custom.min.css" rel="stylesheet"/>

        <!-- JavaScript -->

        <script src="assets/themes/js/jquery-1.9.1.js" type="text/javascript"></script>
        <script src="assets/themes/js/jquery-ui.js" type="text/javascript"></script>  
        <script src="assets/themes/js/funciones.js" type="text/javascript"></script>
        <script src="assets/themes/js/jquery.alerts.mod.js" type="text/javascript"></script>
        <script src="assets/themes/js/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <script src="assets/themes/js/chosen.jquery.js" type="text/javascript"></script>
        <script src="assets/themes/js/jquery.Rut.js" type="text/javascript"></script>
        <script src="assets/themes/js/jquery.Rut.min.js" type="text/javascript"></script>

        <script src="assets/themes/js/pnotify.custom.min.js" type="text/javascript"></script>
        <script src="assets/themes/js/autoCompleteSelect.js" type="text/javascript"></script>
        <script src="assets/themes/js/jquery.tablesorter.js" type="text/javascript"></script>

        <script src="assets/themes/js/javaGlobal.js" type="text/javascript"></script> 
        <script src="assets/themes/js/pretty.js" type="text/javascript"></script>     
        <script src="assets/themes/js/jquery-confirm.js" type="text/javascript"></script>

        <script src="assets/themes/js/loader.js" type="text/javascript"></script>

        <script src="assets/themes/js/jquery.PrintArea.js" type="text/javascript"></script>
        <script src="assets/themes/js/pnotify.custom.min.js" type="text/javascript"></script>

        <?php
        if (!empty($canonical)) {
            echo "\n\t\t";
            ?><link rel="canonical" href="<?php echo $canonical ?>" /><?php
        }
        echo "\n\t";

        foreach ($css as $file) {
            echo "\n\t\t";
            ?><link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" /><?php
        } echo "\n\t";

        foreach ($js as $file) {
            echo "\n\t\t";
            ?><script src="<?php echo $file; ?>"></script><?php
        } echo "\n\t";

        /** -- to here -- */
        ?>

        <style type="text/css">

            ::selection{ background-color: #E13300; color: white; }
            ::moz-selection{ background-color: #E13300; color: white; }
            ::webkit-selection{ background-color: #E13300; color: white; }

            body {
                background-color: #fff;
                margin: 40px;
                font: 13px/20px normal Helvetica, Arial, sans-serif;
                color: #4F5155;
            }

            a {
                color: #003399;
                background-color: transparent;
                font-weight: normal;
            }

            h1 {
                color: #444;
                background-color: transparent;
                border-bottom: 1px solid #D0D0D0;
                font-size: 19px;
                font-weight: normal;
                margin: 0 0 14px 0;
                padding: 14px 15px 10px 15px;
            }

            code {
                font-family: Consolas, Monaco, Courier New, Courier, monospace;
                font-size: 12px;
                background-color: #f9f9f9;
                border: 1px solid #D0D0D0;
                color: #002166;
                display: block;
                margin: 14px 0 14px 0;
                padding: 12px 10px 12px 10px;
            }

            #body{
                margin: 0 15px 0 15px;
            }

            p.footer{
                text-align: right;
                font-size: 11px;
                border-top: 1px solid #D0D0D0;
                line-height: 32px;
                padding: 0 10px 0 10px;
                margin: 20px 0 0 0;
            }

            #container{
                margin: 10px;
                border: 1px solid #D0D0D0;
                -webkit-box-shadow: 0 0 8px #D0D0D0;
            }
        </style>

    </head>

    <body >

        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <a class="brand" href="homeadmin" style="padding:2px">
                        <img src="assets/themes/img/SSAN_LOGO.png" alt="logo"/>
                    </a>
                    <div style="height: 0px;" class="nav-collapse collapse">
                        <ul class="nav" style="margin: 9px 10px 14px 39px;">
                            <li id="ges_home"><a href="homeadmin"><b>Inicio</b></a></li>
                            <?php if ($this->session->userdata('logUserN') != '12562992-K') { ?>
                                <li id="ges_ext"><a href="gestionextensiones"><b>Gestión de Extensiones</b></a></li>
                                <li id="ges_priv"><a href="gestiondeprivilegios"><b>Gestión de Privilegios</b></a></li>
                            <?php } ?>
                            <li id="ges_user"><a href="gestiondeusuarios"><b>Gestión de Usuarios</b></a></li>
                        </ul>

                        <div style="float:right; height: 40px; padding-top:20px;">
                            <b><?php echo $login = $this->session->userdata('logUserName'); ?></b>&nbsp;&nbsp;
                            <a class="btn btn-small btn-danger" href="admin/cerrarSes" style="margin-top: -4px;">
                                <i class="fa fa-lock fa-large"></i> <span>Cerrar Sesión</span></a>
                        </div>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <br><br>
        <div id="contorno">
            <div id="wrapper">
                <div id="header">


                </div>

                <div id="main">
                    <div id="content">
                        <div id="cont" style="width: 1200px;min-height: 500px;margin: 0 auto;">
                            <div id="carga" style="height: 9px;"></div>
                            <table>
                                <tr>
                                    <td style="vertical-align:top;">
                                        <div id="menuEdit">

                                        </div>
                                    </td>
                                    <td style="vertical-align:top;padding-left: 10px;" width="100%;">
                                        <div style="">
                                            <div class="respuesta" id="respuesta"></div>
                                            <div class="post">
                                                <?php echo $output; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <hr style="width: 1210px;"/>

            <footer>
                <div class="row">
                    <div class="span6 b10">
                        © 2016 <a target="_blank" href="http://www.araucanianorte.cl/">Servicio de Salud Araucanía Norte</a> - Dirección: Pedro de Oña 387 Angol. - Chile  
                    </div>
                </div>
            </footer>
        </div>
    </body></html>
