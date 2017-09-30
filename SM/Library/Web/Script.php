<?php

/*
 * Classe criada para modelar atributos de um script
 * 
 * Marcelo Barbosa
 * outubro, 2015.
 */

// declaracao do namespace
namespace SM\Library\Web;

// importacao de classes
use SM\Library\Generic\Generic;

// declaracao da classe
abstract class Script extends Generic
{
    // declaracao de atributos
    private $type;
    private $path;
    private $filename;
    
    
    // declarcao de metodos
    public function __construct($type = "", $path = "", $filename = "") 
    {
        // metodo construtor
        // incializa a superclasse 
        parent::__construct("Script");
        
        // inicializacao de atributos
        $this->type = $type;
        $this->path = $path;
        $this->filename = $filename;
        
    }
    
    // metodos de encapsulamento
    public function setType($type)
    {
        $this->type = $type;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function setPath($path)
    {
        $this->path = $path;
    }
    
    public function getPath()
    {
        return $this->path;
    }
    
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }
    
    public function getFilename()
    {
        return $this->filename;
    }
    
    public function toString() 
    {
        return $this->getType(). " : " .$this->getPath();
    }
    
    public function equals(Generic $obj) 
    {
        // verifica se dois objetos sao iguais
        // declaracao de variaveis
        $comparison = false;
        
        if($obj instanceof Script)
        {
            $comparison = ((strcmp($this->getFilename(), $obj->getFilename()) == 0)
                           && (strcmp($this->getPath(), $obj->getPath()) == 0)
                           && (strcmp($this->getType(), $obj->getType()) == 0));
        }
        
        // retorno de valor
        return $comparison;
    }
    
    public abstract function getTagScript();
}