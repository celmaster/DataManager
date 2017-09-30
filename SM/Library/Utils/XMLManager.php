<?php

/* Classe responsavel por codificar e decodificar XML.
 * 
 * Marcelo Barbosa, 
 * setembro, 2016.
 */

// declaracao do namespace
namespace SM\Library\Utils;

// declaracao da classe
class XMLManager
{
    // declaracao de metodos estaticos
    public static function  getSimpleXMLElement($xml)
    {
        // retorna um objeto de SimpleXMLElement a partir de uma string em xml
        return simplexml_load_string($xml);
    }
}