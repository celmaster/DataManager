<?php

/*
 * Modela um script css
 * 
 * Marcelo Barbosa 
 * outubro, 2015.
 */

// declaracao do namespace
namespace SM\Library\Web;

// declarcaao da classe
class CSSFileScript extends Script
{   
    // declaracao de metodos
    public function __construct($path = "", $filename = "") 
    {
        // metodo construtor
        // inicializa a superclasse
        parent::__construct("text/css", $path, $filename);        
    }
    
    public function getTagScript() 
    {
        return "\n<link rel=\"stylesheet\" type=\"" . $this->getType() . "\""
             . " href = \"" . $this->getPath() . "/" . $this->getFilename() . "\">\n";
    }
    
    public function toString() 
    {
        return $this->getTagScript();
    }
}