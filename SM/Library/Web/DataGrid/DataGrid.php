<?php

/* Classe abstrata que modela uma grade para dados
 * 
 * Marcelo Barbosa,
 * julho, 2016.
 */

// declaracao do namespace
namespace SM\Library\Web\DataGrid;

// importação de classes
use SM\Library\Generic\Generic;

// declaracao da classe
abstract class DataGrid extends Generic
{
    // declaracao de atributos
    private $grid;
    
    // declaracao de metodos
    public function __construct($grid = "", $objectName = "Data Grid")
    {
        // metodo construtor
        // inicializa a superclasse
        parent::__construct($objectName);
        
        // inicializa demais atributos
        $this->grid = $grid;
    }
    
    public function setGrid($grid)
    {
        $this->grid = $grid;
    }
    
    public function getGrid()
    {
        return $this->grid;
    }
    
    public function toString()
    {
        return "Grid's code: " . $this->getGrid();
    }
    
}

