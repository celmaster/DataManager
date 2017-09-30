<?php

/* Classe responsavel por codificar e decodificar JSON.
 * 
 * Marcelo Barbosa, 
 * dezembro, 2015.
 */

// declaracao do namespace
namespace SM\Library\Utils;

// declaracao da classe
class JSONManager
{
    // declaracao dos metodos estaticos
    public static function arrayToJSON($list)
    {
        // codifica os dados de um array em um JSON
        $json = json_encode($list);
        
        // retorno de valor
        return $json;
    }
    
    public static function jsonToArray($json)
    {
        // decodifica os dados de um json em um array
        $array = json_decode($json);
        
        // retorno de valor
        return $array;
    }
}