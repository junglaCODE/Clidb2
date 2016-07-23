<?php

/*
 * Creado el dia 6-Mayo-2015
 * @author Ing Juan Luis Garcia Corrales
 * Descripción: Controlador que llevara el control del cli consultas y demas
 * plugins que se le añaden
 */
require_once __DIR__ . '/../modelos/conexion_odbc.inc.php';

class Controlador_CliWeb extends Conexion_Adobd
{

    private $styleTable = "
<style type='text/css'>
table{
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
        width: 100%;
}table th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}table td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}</style>";
    private $scriptFiltro = "   <script type='text/javascript'>$(function () {
            var theTable = $('table');
            theTable.find('tbody > tr').find('td:eq(1)').mousedown(function () {
                $(this).prev().find(':checkbox').click();
            });

            $('#filter').keyup(function () {
                $.uiTableFilter(theTable, this.value);
            });

            $('#filter-form').submit(function () {
                theTable.find('tbody > tr:visible > td:eq(1)').mousedown();
                return false;
            }).focus(); //Give focus to input field
        });</script>";

    public function __ejecutaConsulta($query)
    {
        echo utf8_encode(parent::__execConsultas($query)) . $this->styleTable . $this->scriptFiltro;
    }

    public function __filterFilesToDB2($filter/* string TABLE_TYPE */, $find/* string TABLE_NAME */)
    {
        $html = '<table><thead><tr><th>#</th>'
                . '<th>TABLE_CAT</th><th>TABLE_SCHEM</th><th>TABLE_NAME</th>'
                . '<th>TABLE_TYPE</th><th>REMARKS</th></tr></thead><tbody>';
        $i = 0;
        foreach (parent::__showAllFiles() as $tabla):
            // foreach ($tabla as $key):
            if ($filter == $tabla['TABLE_TYPE'] && preg_match("/$find/i", $tabla['TABLE_NAME'])):
                $html.='<tr><td>' . ++$i . '</td><td>' . $tabla['TABLE_CAT'] . '</td><td>' . $tabla['TABLE_SCHEM'] .
                        '</td><td onclick=\'autoSelect("' . $tabla['TABLE_SCHEM'] . '","' . $tabla['TABLE_NAME'] . '")\' '
                        . 'style=\'font-weight: bold;cursor: pointer;\'>' .
                        $tabla['TABLE_NAME'] . '</td><td>' . $tabla['TABLE_TYPE'] . '</td><td>' .
                        $tabla['REMARKS'] . '</td></tr>';
            endif;
            // endforeach;/*obteniendo las columna*/
        endforeach; /* obteniendo la table */
        echo '</tbody>' . $html . '</table>' . $this->styleTable . $this->scriptFiltro;
    }

    public function __filesToDB2($find)
    {
        $html = '<table><thead><tr><th>#</th>'
                . '<th>TABLE_CAT</th><th>TABLE_SCHEM</th><th>TABLE_NAME</th>'
                . '<th>TABLE_TYPE</th><th>REMARKS</th></tr></thead><tbody>';
        $i = 0;
        foreach (parent::__showAllFiles() as $tabla):
            // foreach ($tabla as $key):
            if (preg_match("/$find/i", $tabla['TABLE_NAME'])):
                $html.='<tr><td>' . ++$i . '</td><td>' . $tabla['TABLE_CAT'] . '</td><td>' . $tabla['TABLE_SCHEM'] .
                        '</td><td onclick=\'autoSelect("' . $tabla['TABLE_SCHEM'] . '","' . $tabla['TABLE_NAME'] . '")\' '
                        . 'style=\'font-weight: bold;cursor: pointer;\'>' .
                        $tabla['TABLE_NAME'] . '</td><td>' . $tabla['TABLE_TYPE'] . '</td><td>' .
                        $tabla['REMARKS'] . '</td></tr>';
            endif;
            // endforeach;/*obteniendo las columna*/
        endforeach; /* obteniendo la table */
        echo '</tbody>' . $html . '</table>' . $this->styleTable . $this->scriptFiltro;
    }

//fin de la funcion de todos los archivos

    public function __setKeyToTable($resource /* string schema.table */)
    {
        list($schema, $table) = explode('.', $resource);
        echo parent::__setPrimaryKeys($schema, $table) . $this->styleTable . $this->scriptFiltro;
    }

    /* <fin de la funcion que obtiene todas las llaves primarias */

    public function __saveCommandsOfPrompt($contenido/* string del textarea */, $file/* string nameoffile */)
    {         
            if (!$gestor = fopen(__DIR__.'/'.$file, 'w')):
                echo "No se puede abrir el archivo ($file)";
                exit;
            endif;
            if (fwrite($gestor, $contenido) === FALSE):
                echo "No se puede escribir en el archivo ($file)";
                exit;
            endif;
            echo "Se ha guardado correctamente el archivo $file en la carpetra <<Controladores>>";
            fclose($gestor);
    }/* <fin de la funcion guardar archivos> */
    
    public function __setColumnsToTables($resource /*string schema.tabñe*/){
        list($schema, $table) = explode('.', $resource);
        echo parent::__descriptionToTables($schema, $table). $this->styleTable . $this->scriptFiltro;;
    }

    
}

//fin de la clase


    