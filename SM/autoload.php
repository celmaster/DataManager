<?php

/* Script criado para sobrescrever a funcao de autoload do PHP
 * 
 * Marcelo Barbosa,
 * agosto, 2016.
 */

// inclui o arquivo de configuracao do SM
require_once('setup.sm.php');

// declaracao de sub-rotinas
spl_autoload_register(function ($class) 
{
    // faz a requisicao do arquivo
    try
    {
        require_once($_SERVER["DOCUMENT_ROOT"].$GLOBALS["root"]."/".str_replace('\\', '/', $class . '.php'));
    }  catch (Exception $e)
             {
                echo "<br>Class not found<br>";
             }
});