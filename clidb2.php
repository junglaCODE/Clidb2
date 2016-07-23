<?php
session_start();
require_once __DIR__ . '/controladores/seguridad.class.php';
$secure = new Controlador_Seguridad($_SESSION);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cli::Web</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link  rel="stylesheet"  type="text/css" href="utilerias/css/style-main.css">
        <script src="utilerias/plugins/jquery.js" type="text/javascript"></script>
        <script src="utilerias/plugins/jquery.uitablefilter.js" type="text/javascript"></script>
    </head>
    <body class="body-main">
        <?php
        if (strcmp($_GET['peticion'], 'salida') == 0):
            $secure->__kill_9();
        endif;
        ?>
        <header>
            <section class='title' style="height: 24px; font-size: 20px;">
                <span style="float: left">
                    Usuario conectado : <?= $_SESSION['key']['user'] ?>
                </span>
                <span style="float: right">
                    <a href="clidb2.php?peticion=salida" style="color: orange; font-size: 20px;">salir</a>
                </span>
            </section>
            <aside class='logotipo'>
                <img src="utilerias/img/logo.png">
            </aside>
        </header>
        <div id="contenedor" style="width: 96%; margin-left: 2%;">
            <article id="console">
                <form name="console">
                    <textarea id="console" name="console" rows="6"></textarea>
                    <input type="button" onclick="__guardarTexto($('textarea#console').val())" value="Guardar Query" style='float: left'>
                    <input type="button" onclick="__envioSQL(this.form.console)" value="Enviar Consulta" style='float: right'>
                </form>
            </article>
            <hr style="margin-top: 35px;">
            <div class="input-group">
                <form id="filter-form">
                    <input type="text" id="filter" class="form-control" placeholder="Filtrado de busquedas"
                           style="width: 50% ! important; margin-left: 48%;">
                </form>
                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
            </div>
            <section id="output">
                <!-- salida del evento tipo ajax -->
            </section>
        </div>
        <script type="text/javascript">

            function  __ejecutaConsulta__(__SQL__) {
              
                $.post('vinculadores/cmdCli.php', {
                    sql: __SQL__
                })
                        .done(function (request) {
                            //console.log(request);
                            $('section#output').html(request);
                        });
            }

            function  __guardarTexto(__TEXT__) {
                $.post('vinculadores/cmdCli.php', {
                    texto: __TEXT__,
                    sql: 'save file'
                })
                        .done(function (request) {
                            //console.log(request);
                            alert(request);
                        });
            }
            
            function __envioSQL(widget) {
                __ejecutaConsulta__(__getSelection__(widget));
            }

            function __getSelection__(myField)
            {
                //IE support
                if (document.selection)
                {
                    myField.focus();
                    sel = document.selection.createRange();
                    return sel.text;
                }
                //MOZILLA/NETSCAPE support
                else if (myField.selectionStart || myField.selectionStart == "0")
                {
                    var startPos = myField.selectionStart;
                    var endPos = myField.selectionEnd;

                    return myField.value.substr(startPos, endPos - startPos);
                } else {
                    return null;
                }
            }
            $(function () {
                $('textarea#console').keypress(function (tecla) {
                    if (tecla.keyCode == 13) {
                        __ejecutaConsulta__( $("textarea#console").val());
                    }
                });
            });//restablecer el color como el inicio
            function autoSelect(schema, table) {

                $("textarea#console").val($("textarea#console").val() +
                        '   SELECT * FROM ' + schema + '.' + table);
            }
        </script>
    </body>
</html>
