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

// declaracao da classe
class ReferencesGrid extends DataGrid
{
    // declaracao de metodos
    public function __construct() 
    {
        // inicializa a superclasse
        parent::__construct("", "Data Grid");

        $this->gridModeling();
    }
    
    public function gridModeling()
    {
        // modela o conteudo de uma data grid
        // declaracao de variaveis
        $model = "
                	
                <div class=\"referencesArea grid\" id=\"references\">	
                    <div class=\"borderStamp3\"></div>					
                    <div class=\"referencesTitle\">	
                    </div>
                    <div class=\"grid\">
                        <div class=\"opacityBlock\">	
                            <div class=\"blockText\">							    
                                <p>
                                    KAPPEL, Gerti et al. Modeling ubiquitous web applications–a comparison of approaches. na, 2001. 
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