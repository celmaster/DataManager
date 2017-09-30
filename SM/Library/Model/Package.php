<?php

/* Modela um pacote de dados com um flag
 * 
 * Marcelo Barbosa,
 * setembro, 2016.
 */

// declaracao do namespace
namespace SM\Library\Model;

// importacao de classes
use SM\Library\Generic\Generic;
use SM\Library\Database\Context\Context;
use SM\Library\Database\Context\ContextElement;
use SM\Library\Interfaces\IContextObject;

// declaracao da classe
class Package extends Generic implements IContextObject
{    
    // declaracao de atributos
    private $content;
    private $flag;
    
    // declaracao de metodos
    public function __construct($content = "", $flag = false) 
    {
        // metodo construtor
        parent::__construct("Package");
        
        // inicializa atributos
        $this->content = $content;
        $this->flag = $flag;
    }
    
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }
    
    public function getFlag()
    {
        return $this->flag;
    }
    
    public function getContext()
    {
        // retorna o contexto da classe
        $context = new Context();
        
        // adiciona elementos de contexto para descrever a classe
        $context->add(new ContextElement("content", $this->getContent()));
        $context->add(new ContextElement("flag", $this->getFlag()));
        
        // retorno de valor
        return $context;
    }

    public function toString()
    {
        // retorna o conteudo da classe em uma strng
        return "content: " . $this->getContent() . "<br>"
                . "flag: " . $this->getFlag() . "<br>";
    }

}
