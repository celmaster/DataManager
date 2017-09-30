<?php
/*
 * Classe para definir um objeto
 * 
 * Marcelo Barbosa.
 * dezembro, 2013.
*/

// declaracao do namespace
namespace SM\Library\Collection;

// declaracao da classe
class Node extends Linker
{
    // declaração de atributos
    private $element;
    private $balanceFactor;
    
    // declaração de métodos
    public function __construct(Element $element = null, $objectName = "")
    {
        // método construtor         
        // inicialização de atributos             
       parent::__construct($objectName); 
       $this->balanceFactor = 0;
       $this->element = $element;
    }

    // métodos gatilhadores
    public function setElement($element)
    {
        if($element instanceof Element)
        {
            $this->element = $element;
        }else
            {
                $this->element = null;
            }
    }
    
    public function getElement()
    {
        return $this->element;
    }

    public function toString()
    {
        // converte os valores da classe em strings
        // declaração de variáveis
        $stringValue = "";

        // verificando se o objeto da classe é ou não uma instancia de uma classe
        if(!is_object($this->getElement()->getData()))
        {
            $stringValue .= " ". $this->getElement()->getData(); 
        }else
            {

                $stringValue .= " ". $this->getElement()->getData()->toString();
            }

        // retorno de valor
        return $stringValue;

    }
    
    public function setBalanceFactor($balanceFactor)
    {
        $this->balanceFactor = $balanceFactor;
    }
    
    public function getBalanceFactor()
    {
        return $this->balanceFactor;
    }
}