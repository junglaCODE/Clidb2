<?php

/**
 * Creado el 05/mayo/2015
 * @author Ing Juan Luis Garcia Corrales
 * Descripcion.- esta clase llevara el control de los acceso para
 * la aplicación del CLI_WEB [login]
 */
require_once __DIR__ . '/../modelos/conexion_odbc.inc.php';

class Controlador_Seguridad extends Conexion_Adobd
{

    public function __construct($state/* session */, $page = 'NaN'/* string pagina inicial */)
    { /* me dice en que pagina esta situado */        
        if (strcasecmp($page, 'index.php') != 0):
            if (!is_null($state)):
                $this->__verifyUserActive__($state);
            endif;
        else:
            $this->__validateLogin__($_SESSION);
        endif;
        /* comprobando si se logeado el usuario o en su caso que tenga una seccion activa */
    }

    /* fin ddel constructor */

    public function __validateCardOfUser($usuario/* string */, $password /* string */)
    {
        if (parent::__setConexionDB($usuario, $password)):
            return true;
        else:
            return false;
        endif;
    }

    public function __isCorrectAuthentication($flag /* boolean */)
    {
        if ($flag):
            header("Location: clidb2.php");
        else:
            echo utf8_encode(odbc_errormsg());
        endif;
    }

    /* fin del fucnion autenticar */

    private function __verifyUserActive__($pid /* session */)
    {
        if (empty($pid)):
            header("Location: ."); /* no tiene acceso al sistema */
        else:
       /* $_SESSION['key']['conexion'] = parent::__setConexionDB($_SESSION['key']['user'], $_SESSION['key']['pass']);
        * <aun ese funcion no se ha defino pero pude usarse para tareas que se hagan una vez un
        * usuaruia este adentro del sistem
        */
        
        endif;
    }

    /* funcion para verificar si un usuaruio tiene una session activa */

    public function __kill_9()
    {
        session_destroy();
        if (isset($_SESSION)):
            header("Location: .");
        else:
            echo "existe problemas para que salga de sistema intentelo nuevamente";
        endif;
    }

    /* FuncionSalida de un usuario del sistema */

    private function __validateLogin__($session/* session */)
    {
        if (!empty($session)):
            header("Location: clidb2.php");
        endif;
    }

}

//fin de la clase
