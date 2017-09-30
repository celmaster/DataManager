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
class DetailsGrid extends DataGrid
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
                				
                <div class=\"detailsArea grid\" id=\"details\">	
                    <div class=\"borderStamp2\"></div>					
                    <div class=\"oodBlock\">	
                    </div>
                    <div class=\"grid\">
                        <div class=\"opacityBlock\">	
                            <div class=\"blockText\">
                                <p class=\"firstP\">
                                    Adicionalmente, o framework SM fundamenta sua metodologia através do padrão proposto pelo design orientado a objetos, no qual
                                    a estrutura de hipertexto é modelada como um conceito que pode ser instanciado e manipulado para prover independência 
                                    entre as camadas existentes sobre o diagrama das dimensões de modelagem de aplicações web proposto por Kappel et al. (2001). 
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