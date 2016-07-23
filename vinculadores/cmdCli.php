<?php

/*
 * Creado el dia 07/Mayo/2015
 * @utor: Ing Juan Luis Garcia Corales
 * Descripción:
 * Este vinculador hara la conexion controlador => vista
 * [Atravez de la tecnología AJAX]. Simulara una terminal
 */
session_start();
require_once __DIR__ . '/../controladores/cli_web.class.php';
$terminal = new Controlador_CliWeb();
list($sql, $parametro) = explode('->', $_POST['sql']);
date_default_timezone_set('UTC');/*definiendo el zona horaria*/
switch (trim(strtolower($sql))):/* limpiza del query para evitar errores sintacticos */
    case 'show tables':
        $terminal->__filterFilesToDB2('TABLE',trim($parametro));
        break;
    case 'show views':
        $terminal->__filterFilesToDB2('VIEW',trim($parametro));
        break;
    case 'show files':
        $terminal->__filesToDB2(trim($parametro));
        break;
    case 'show keys':
        $terminal->__setKeyToTable($parametro);
        break;
    case 'save file':
        $terminal->__saveCommandsOfPrompt($_POST['texto'],date('d_m_Y').'.sql');
        break;
    case 'describe':
        $terminal->__setColumnsToTables(trim($parametro));
        break;
    default:
        $terminal->__ejecutaConsulta($sql); 
endswitch;
