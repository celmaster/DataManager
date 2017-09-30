<?php

/* Classe criada para modelar um autor de uma pagina web
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
class Author extends Generic implements IContextObject
{
    // declaracao de atributos
    private $name;
    
    // declaracao de metodos
    public function __construct($name = "") 
    {
        // metodo construtor
        // inicializacao da superclasse
        parent::__construct("author");
        
        $this->name = $name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getContext() 
    {
        // retorna o contexto da classe
        $context = new Context();
        $context->add(new ContextElement("name", $this->getName(), false, false));
        
        return $context;
    }
    
    public function toString()
    {
        // retorna os dados da classe em uma string
        return "<meta name=\"author\" content=\"".$this->getName()."\">";
    }
    
    public function equals(Generic $obj) 
    {
        // verifica se dois objetos sao iguais
        // declaracao de variaveis
        $comparison = false;
        
        if($obj instanceof Author)
        {
            $comparison = (strcmp($this->getName(), $obj->getName()) == 0);
        }
        
        // retorno de valor
        return $comparison;
    }

}