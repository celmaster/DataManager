<?php
/* Grid criado automaticamente com SM
 * 
 * Marcelo Barbosa,
 * 30/08/2016.
 */

// declaracao do namespace
namespace SM\Library\Web\Template\DataGridModel\SM;

// importacao de classes
use SM\Library\Web\DataGrid\DataGrid;
use SM\Configuration\SystemConfiguration;

// declaracao da classe
class ContainerGrid extends DataGrid
{
    // declaracao de metodos
    public function __construct($title, $message, $class = "") 
    {
        // inicializa a superclasse
        parent::__construct("", "Data Grid");

        $this->gridModeling($title, $message, $class);
    }
    
    public function gridModeling($title, $message, $class)
    {
        // modela o conteudo de uma data grid
        // declaracao de variaveis
        $model = "
                	
                <div class=\"grid\" id=\"errorGrid\">	                                        
                    <p class=\"title3 center\">									
                        ".$title."
                    </p>
                    <div class=\"grid\">
                        <div class=\"opacityBlock\">	
                            <div class=\"blockText\">							    
                                <p class=\"firstP center ".$class."\">
                                    ".$message."
                                </p>        
                                <p class=\"firstP center\">        
                                    <!-- @ContainerGridContent -->    
                                </p>
                                
                            </div>
                        </div>
                    </div>
                </div>
                ";
        
        // fixa o conteudo da grid
        $this->setGrid($model);
    }
}