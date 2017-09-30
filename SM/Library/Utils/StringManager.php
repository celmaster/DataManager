<?php

/* Classe criada para manipular strings
 * 
 * Marcelo Barbosa,
 * julho, 2016.
 */

// declaracao do namespace
namespace SM\Library\Utils;

// declaracao da classe
class StringManager
{
    // declaracao de metodos estaticos
    public static function extract($str, $begin, $end)
    {
        // extrai uma o conteudo de uma string dado o seu inicio e fim
        // declaracao de variaveis
        $content = "";
        
        if(($str != null) && ($begin != null) && ($end != null))
        {
            $content = substr($str, 0, strpos($str, $end));
            $content = substr($content, strpos($content, $begin) + strlen($begin));
            
            // valida a extracao de dados
            if(strcmp($str, $content) == 0)
            {
                $content = "";
            }
        }
        
        // retorno de valor
        return $content;
    }
    
    public static function setTagCharacters($str)
    {
        // formata os caracteres de uma tag para serem impressos na tela
        // declaracao de variaveis
        $strFormatted = str_replace("<", "&lt;", $str);
        $strFormatted = str_replace(">", "&gt;", $strFormatted);
        
        // retorno de valor
        return $strFormatted;
    }
    
    public static function setQuotes($str)
    {
        // formata os caracteres de uma tag para serem impressos na tela
        // declaracao de variaveis
        $strFormatted = str_replace('"', '\"', $str);        
        
        // retorno de valor
        return $strFormatted;
    }
    
    public static function captalize($str)
    {
        // retorna uma string com inicial maiscula
        // declaracao de variaveis
        $strCapitalized = ucfirst($str);
        
        // retorno de valor
        return $strCapitalized;
    }
    
    public static function equals($str1, $str2)
    {
        // verifica se duas strings sao iguais
        $status = strcmp($str1, $str2) == 0;
        
        // retorno de valor
        return $status;
    }
    
    public static function equalsIgnoreCase($str1, $str2)
    {
        // verifica se duas strings sao iguais de modo case insensitive
        $status = strcasecmp($str1, $str2) == 0;
        
        // retorno de valor
        return $status;
    }
    
    public static function getBlankSpace($numOfBlankSpace = 1)
    {
        // insere espacos em branco para textos
        // declaracao de variaveis
        $blankSpace = "&nbsp;";
        
        $num = abs($numOfBlankSpace);
        
        for($i = 1; $i <= $num; $i++)
        {
            $blankSpace .= "&nbsp;";
        }
        
        // retorno de valor
        return $blankSpace;
    }
    
    
}