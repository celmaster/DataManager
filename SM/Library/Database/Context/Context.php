<?php

/* Classe criada para modelar um contexto para parametrizar consultas ao 
 * banco de dados.
 *
 * Marcelo Barbosa, 
 * marco, 2016. 
 */

// declaracao do namespace
namespace SM\Library\Database\Context;

// importacao de classes
use SM\Library\Generic\Generic;
use SM\Library\Collection\LinkedList;
use SM\Library\Collection\Element;

// declaracao da classe
class Context extends Generic
{
    // declaracao de atributos
    private $parameters;
    
    // declaracao de metodos
    public function __construct(array $array = null) 
    {
        // metodo construtor sem parametro
        $this->parameters = new LinkedList(false, "Context Element List");
        
        if($array != null)
        {
            $this->initParameterList($array);
        }
    }
    
    private function initParameterList(array $array)
    {
        // fixa elementos de contexto na lista
        // declaracao de variaveis        
        $amount = count($array);
        
        // verifica se o array possui elementos para serem inseridos na lista
        if($amount > 0)
        {
            foreach($array as $value)
            {
                // adiciona elementos a lista
                $this->parameters->add(new Element($value, $this->getKey($value)));
            }
        }
    }
    
    private function getKey(ContextElement $contextElement)
    {
        // retorna a chave do elemento de contexto
        // declaracao de variaveis
        $key = 0;
        
        // verifica se o campo do contexto e chave
        if($contextElement->getIsKeyField())
        {            
           $key = 1;
        }
        
        // retorno de valor
        return $key;
    }
    
    public function getContextValue($key)
    {
        // retorna um valor de contexto pela sua chave
        $value = null;
        $contextValues = $this->parameters->toArray();
        
        for($i = 0; $i < $this->parameters->getSize(); $i++)
        {
            $contextElement = $contextValues[$i]->getData();
            if(strcmp($contextElement->getCaption(), $key) == 0)
            {
                $value = $contextElement->getValue();
                break;
            }
        }
        
        // retorno de valor
        return $value;
    }
    
    public function add(ContextElement $contextElement)
    {
        // adiciona elementos de contexto        
        $this->parameters->add(new Element($contextElement, $this->getKey($contextElement)));
    }
    
    public function getParameters()
    {
        return $this->parameters;
    }
    
    public function setParameters(LinkedList $parameters)
    {
        $this->parameters->destroy();
        unset($this->parameters);
        $this->parameters = $parameters;
    }
    
    public function getSize()
    {
        return $this->parameters->getSize();
    }
    
    private function getParametersValues()
    {
        // retorna uma string com todos os valores dos parametros
        // declaracao de variaveis
        $text = "";
        $contextValues = $this->parameters->toArray();
        
        for($i = 0; $i < $this->parameters->getSize(); $i++)
        {
            $obj = $contextValues[$i]->getData();
            $text .= "<br>".$obj->toString();
        }
        
        // retorno de valor
        return $text;
    }

    public function toString() 
    {
        // retorna o conteudo da classe em uma string
        return "<br>Parameters:<br>".$this->getParametersValues();
    }

}