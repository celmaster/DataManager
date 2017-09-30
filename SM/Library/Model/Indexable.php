<?php

/* Classe abstrata criada para modelar um objeto indexavel
 * 
 * Marcelo Barbosa,
 * junho, 2017.
 */

// declaracao do namespace
namespace SM\Library\Model;

// importacao de classes
use SM\Library\Generic\Generic;

//declaracao da classe
abstract class Indexable extends Generic
{
    // declaracao de atributos
    private $index;
    
    // declaracao dos metodos
    public function __construct($index = 0, $objectName = "Index") 
    {
        // metodo construtor
        // inicializa a superclasse
        parent::__construct($objectName);
        
        // inicializa o atributo
        $this->index = $index;
    }
    
     public function setIndex($index) 
    {
        $this->index = $index;
    }
    
    public function getIndex() 
    {
        return $this->index;
    }

    public function toString()
    {
        // retorna o conteudo da classe em uma string
        return "index: " . $this->getIndex();
    }
}
