<?php

/* Obtem dados de requisicoes via metodo post e get
 * 
 * Marcelo Barbosa,
 * agosto, 2016.
 */

// declaracao do namespace
namespace SM\Library\IO;

// declaracao da classe
class Request
{
    public static function getParameter($parameterName, $method)
    {
        // recupera o conteudo de um parametro atraves de seu metodo
        // declaracao de variaveis
        $parameterValue = null;
        
        if(strcasecmp($method, "post") == 0)
        {
            if(isset($_POST[$parameterName]))
            {
                $parameterValue = $_POST[$parameterName];
            }
        }else
            {
                if(strcasecmp($method, "get") == 0)
                {
                    if(isset($_GET[$parameterName]))
                    {
                        $parameterValue = $_GET[$parameterName];
                    }
                }
            }
            
        // retorno de valor
        return $parameterValue;    
    }    
}

