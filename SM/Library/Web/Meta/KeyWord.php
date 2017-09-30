<?php

/* Classe criada para modelar uma palavra-chave
 * 
 * Marcelo Barbosa,
 * julho, 2016.
 */

// declaracao do namespace
namespace SM\Library\Web\Meta;

// importação de classes
use SM\Library\Generic\Generic;
use SM\Library\Database\Context\Context;
use SM\Library\Database\Context\ContextElement;
use SM\Library\Interfaces\IContextObject;

// declaracao da classe
class KeyWord extends Generic implements IContextObject
{
    // declaracao de atributos
    private $value;
    
    // declaracao de metodos
    public function __construct($value = "") 
    {
        // metodo construtor
        // inicializa a superclasse
        parent::__construct("keyword");
        
        // inicializacao de atributos
        $this->value = $value;
    }
    
    public function setValue($value)
    {
        $this->value = $value;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function getContext() 
    {
        // retorna o contexto da classe
        $context = new Context();
        $context->add(new ContextElement("value", $this->getValue(), false, false));
        
        return $context;
    }

    public function toString()
    {
        // retorna o conteudo da classe em uma string
        return $this->getValue();
    }
    
    public function equals(Generic $obj) 
    {
        // verifica se dois objetos sao iguais
        // declaracao de variaveis
        $comparison = false;
        
        if($obj instanceof KeyWord)
        {
            $comparison = (strcmp($this->getValue(), $obj->getValue()) == 0);
        }
        
        // retorno de valor
        return $comparison;
    }

}