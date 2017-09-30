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
class AboutGrid extends DataGrid
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
                	
                <div class=\"gridContent grid\" id=\"about\">
                    <div class=\"logoBlock\">	
                    </div>
                    <div class=\"logoTitle\">	
                    </div>
                    <div class=\"grid\">
                        <div class=\"opacityBlock\">	
                            <div class=\"blockText\">
                                <p class=\"firstP\">									
                                    Semantic Modeling, SM, é um framework de modelagem semântica para o design de aplicações web que foi criado
                                    para suprir as deficiências existentes suas dimensões de sua modelagem diante da dependência entre conteúdo, hipertexto 
                                    e apresentação (KAPPEL et al., 2001).
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