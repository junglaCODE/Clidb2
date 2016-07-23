<?php

/**
 * Creado el de 5 de mayo del 2015
 * @author Ing. Juan Luis Garcia Corrales
 * Descripcion de la conexion hacia la base de datos de as400
 * atravez de la libreria ADOBD http://php.net/manual/es/book.uodbc.php
 */
require_once __DIR__ . '/../librerias/adodb/adodb.inc.php';

class Conexion_Adobd
{

    protected $__DRIVER = 'Definir'; //variable para poder cambiar los drivers

    protected function __setConexionDB($usuario, $password)
    {
        /* <parametros para poder ver vizualizacion objeto de la conexion> */
        $_SESSION['key']['user'] = $usuario;
        $_SESSION['key']['pass'] = $password;
        /* </fin de los parametros> */
        $__CONEXION = odbc_connect($this->__DRIVER, $usuario, $password);
        if ($__CONEXION):
            return $__CONEXION;
        else:
            return $__CONEXION;
        endif;
    }

//fin del establecimiento de conexión

    protected function __execConsultas($sql)
    {
        $_odbc_ = $this->__setConexionDB($_SESSION['key']['user'], $_SESSION['key']['pass']);
        if (odbc_exec($_odbc_, $sql)):
            return odbc_result_all(odbc_exec($_odbc_, $sql));
        else:
            return odbc_errormsg();
        endif;
    }

//fin del sistema de ejecución de consultas

    protected function __showAllFiles()
    {
        $datos = array();
        $i = 0;
        $_odbc_ = $this->__setConexionDB($_SESSION['key']['user'], $_SESSION['key']['pass']);
        $tablas = odbc_tables($_odbc_);
        while (odbc_fetch_row($tablas)):
            $datos[$i]['TABLE_CAT'] = utf8_encode(odbc_result($tablas, 'TABLE_CAT'));
            $datos[$i]['TABLE_SCHEM'] = utf8_encode(odbc_result($tablas, 'TABLE_SCHEM'));
            $datos[$i]['TABLE_NAME'] = utf8_encode(odbc_result($tablas, 'TABLE_NAME'));
            $datos[$i]['TABLE_TYPE'] = utf8_encode(odbc_result($tablas, 'TABLE_TYPE'));
            $datos[$i]['REMARKS'] = utf8_encode(odbc_result($tablas, 'REMARKS'));
            $i++;
        endwhile; /* fin del while */
        return $datos;
    }

    /* fin de visualización de todas las tablas especificacion del comando odbc_tables
      TABLE_CAT	TABLE_SCHEM	TABLE_NAME	TABLE_TYPE	REMARKS */
    

    protected function __setPrimaryKeys($schema,$table)
    {
        $_odbc_ = $this->__setConexionDB($_SESSION['key']['user'], $_SESSION['key']['pass']);
        $rs = odbc_primarykeys($_odbc_,$schema,$_SESSION['key']['user'],$table);
        return odbc_result_all($rs);
    }//FIN DE LA FUNCION LLAVES PRIMARIAS
    
    protected function __descriptionToTables($schema,$table){
        $_odbc_ = $this->__setConexionDB($_SESSION['key']['user'], $_SESSION['key']['pass']);
        $rs = odbc_columns($_odbc_, $schema, "%", $table, "%");
        return odbc_result_all($rs);
    }//fin de la funcion que busca las columnas
}

//fin de la clase




    
