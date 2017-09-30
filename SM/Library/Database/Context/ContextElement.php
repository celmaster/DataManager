<?php

/* Modela um elemento de contexto
 *
 * Marcelo Barbosa,
 * junho, 2016.
 */

// declaracao do namespace
namespace SM\Library\Database\Context;

// importacao de classes
use SM\Library\Generic\Generic;

// declaracao da classe
class ContextElement extends Generic
{
    // declaração de atributos
    private $caption;
    private $value;
    private $isKeyField;
    private $isCiphered;
    private $autoIncrement;    
    
    // declaração de métodos
    public function __construct($caption = "", $value = "", $isKeyField = false, $isCiphered = false, $autoIncrement = false)
    {
        // método construtor sem parametros
        $this->caption = $caption;
        $this->value = $value;
        $this->isKeyField = $isKeyField;
        $this->isCiphered = $isCiphered;
        $this->autoIncrement = $autoIncrement;       
    }
    
    // métodos de encapsulamento
    public function setCaption($caption)
    {
         $this->caption = $caption;
    }
    
    public function getCaption()
    {
        return $this->caption;
    }
    
    public function setValue($value)
    {
        $this->value = $value;
    }
    
    public function getValue()
    {
        return  $this->value;
    }
    
    public function setIsKeyField($isKeyField)
    {
        $this->isKeyField = $isKeyField;
    }
    
    public function getIsKeyField()
    {
        return  $this->isKeyField;
    }
    
    public function setIsCiphered($isCiphered)
    {
        $this->isCiphered = $isCiphered;
    }
    
    public function getIsCiphered()
    {
        return $this->isCiphered;
    }
    
    public function setAutoIncrement($autoIncrement)
    {
        $this->autoIncrement = $autoIncrement;
    }
    
    public function getAutoIncrement()
    {
        return $this->autoIncrement;
    }
        
    public function toString()
    {
        // retorna os dados da classe em uma string
        return "<br>Caption = " . $this->getCaption()
                ."<br>Value = "  . $this->getValue()
                ."<br>IsKeyValue = "  . $this->getIsKeyField()
                ."<br>IsCiphered = "  . $this->getIsCiphered() . "<br>"
                ."<br>AutoIncrement = "  . $this->getAutoIncrement() . "<br>";
    }        
}
