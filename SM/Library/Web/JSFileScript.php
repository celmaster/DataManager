<?php

/*
 * Modela um script js
 * 
 * Marcelo Barbosa 
 * outubro, 2015.
 */

// declaracao do namespace
namespace SM\Library\Web;

// declarcaao da classe
class JSFileScript extends Script
{
    // declaracao de metodos
    public function __construct($path = "", $filename = "") 
    {
        // inicializa a superclasse
        parent::__construct("text/javascript", $path, $filename);        
    }    
    
    public function getTagScript() 
    {
        return "\n<script src=\"" . $this->getPath() . "/" . $this->getFilename() ."\" "
              ."type=\"" . $this->getType() . "\"></script>\n";
    }
    
    public function toString() 
    {
        return $this->getTagScript();
    }

}