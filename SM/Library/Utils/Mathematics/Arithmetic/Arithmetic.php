<?php

/* Modela uma classe para realizar operacoes aritmeticas
 * 
 * Marcelo Barbosa,
 * julho, 2016.
 */

// declaracao do namespace
namespace SM\Library\Utils\Mathematics\Arithmetic;

// declaracao da classe
class Arithmetic
{
    // declaracao de metodos
    public static function getAPTerm($firstNumber, $ratio, $term)
    {
        // calcula o termo geral da P.A.
        // declaracao de variaveis
        $apTerm = null;

        // valida os parametros
        if(($ratio != 0) && ($term > 0))
        {
            $apTerm = $firstNumber + (($term - 1) * $ratio);
        }

        // retorno de valor
        return $apTerm;
    }

    public static function getAP($firstNumber, $ratio, $amountTerms)
    {
        // gera um vetor com o numero de termos de uma P.A.
        // declaracao de variaveis
        $apArray = null;

        // valida os parametros
        if(($ratio != 0) && ($amountTerms != 0))
        {
            // pega o primeiro elemento
            $apArray = array();
            $apArray[] = $firstNumber;

            // pega os demais termos
            for($i = 2; $i <= $amountTerms; $i++)
            {
                $apArray[] = Arithmetic::getAPTerm($firstNumber, $ratio, $i);
            }

        }

        // retorno de valor
        return $apArray;
    }

    public static function sumAP($firstNumber, $lastNumber, $amountTerms)
    {
        // realiza a soma dos terms de uma P.A.
        // declaracao de variaveis
        $sum = 0;

        // valida a quantidade de termos
        if($amountTerms > 1)
        {
            $sum = (($firstNumber + $lastNumber) * $amountTerms) / 2;
        }

        // retorno de valor
        return $sum;
    }

    public static function sumAPByArray($apArray = array())
    {
        // soma todos os termos da P.A. atraves de um vetor
        // declaracao de variaveis
        $firstNumber = 0;
        $lastNumber = 0;
        $sum = 0;

        if($apArray != null)
        {
            if(is_array($apArray))
            {
                $amountTerms = count($apArray);        

                // validacao do vetor com a P.A.
                if($amountTerms > 1)
                {
                    $firstNumber = $apArray[0];
                    $lastNumber = $apArray[$amountTerms - 1];
                    $sum = Arithmetic::sumAP($firstNumber, $lastNumber, $amountTerms);
                }
            }
        }

        // retorno de valor
        return $sum;
    }
}