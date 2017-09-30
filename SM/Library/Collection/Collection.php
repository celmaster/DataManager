<?php

/* Classe abstrata criada para modelar uma estrutura de dados generica
 * 
 * Marcelo Barbosa,
 * janeiro, 2017.
 */

// declaracao do namespace
namespace SM\Library\Collection;

// importacao de classes
use SM\Library\Generic\Generic;
use SM\Library\Interfaces\iCollection;

// declaracao da classe
abstract class Collection extends Generic
{
    // declaracao de atributos
    protected $root;                // inicio da estrutura de dados        
    private $size;                  // quatidade de elementos na estrutura de dados  
    private $isAutoIncrement;       // atributo logico para designar o indice de auto incremento
    private $index;                 // fornece um indice de alto incremento
    
    // declaracao de metodos
    public function __construct($isAutoIncrement = true, $objectName = "Collection", $size = 0, $index = 1)
    {
        // metodo construtor
        // inicializa a superclasse
        parent::__construct($objectName);
        
        // inicializa os atributos
        $this->size = $size;        
        $this->root = null;
        $this->isAutoIncrement = $isAutoIncrement;
        $this->index = $index;
    }
    
    // metodos de encapsulamento
    public function setSize($size)
    {
        $this->size = $size;
    }
    
    public function getSize()
    {
        return $this->size;
    }
    
    public function getRoot()
    {
        return $this->root;
    }

    public function setIndex($index)
    {
        $this->index = $index;
    }
    
    public function getIndex()
    {
        return $this->index;
    }
    
    public function setIsAutoIncrement($isAutoIncrement)
    {
        $this->isAutoIncrement = $isAutoIncrement;
    }
    
    public function getIsAutoIncrement()
    {
        return $this->isAutoIncrement;
    }
        
    public function destroy()
    {
        // destroi toda a estrutura de dados, apagando todos os elementos
        // verifica se ha elementos na estrutura de dados
        if(!$this->isEmpty())
        {
            /* loop condicional para remover o elemento inicial modo
              que o proximo elemento seja o alvo para remocao */
            while(!$this->isEmpty())
            {
                $this->removeFirstObject();
            }
        }else
            {
                echo "<br>Can't destroy " . $this->getObjectName() . "! " 
                        . $this->getObjectName() . " is empty!<br>";
            }

    }
    
    public function isEmpty()
    {
        // retorna verdadeiro ou falso, caso a estrutura de dados esteja vazia
        if($this->root === null)
        {
            return true;
        }else
            {
                return false;
            }
    }
    
    // metodos abstratos
    public abstract function add(Element $element);
    public abstract function getByKey($key);
    public abstract function removeFirst();          
    public abstract function update(Element $element);
}