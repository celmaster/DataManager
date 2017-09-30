<?php

/* Classe utilizada para modelar um elemento
 * 
 * Marcelo Barbosa,
 * maio, 2017.
 */

// declaracao do namespace
namespace SM\Library\Collection;

// importacao de classes
use SM\Library\Generic\Generic;

// declaracao da classe
class Element extends Generic
{
    // declaracao de atributos
    private $data;
    private $key;
    
    // declaracao de metodos    
    public function __construct($data = null, $key = null)
    {
        // metodo construtor
        // inicializa a superclasse
        parent::__construct("Element");
        
        // inicializa demais atributos
        $this->data = $data;
        $this->key = $key;
    }
    
    public function setData($data)
    {
        $this->data = $data;
    }
    
    public function getData()
    {
        return $this->data;
    }
    
    public function setKey($key)
    {
        $this->key = $key;
    }
    
    public function getKey()
    {
        return $this->key;
    }
    
    public function toString()
    {
        // retorna o conteudo da classe em uma string
        return  $this->getKey() . " : ". $this->getData();
    }

}

