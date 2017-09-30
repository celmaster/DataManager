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
class MakeGrids extends DataGrid
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
                	
                <div class=\"grid\" id=\"makeGrids\">	                                        
                    <p class=\"title3 center\">									
                        Criação de Grids
                    </p>
                    <div class=\"grid\">
                        <div class=\"opacityBlock\">	
                            <div class=\"blockText\">							    
                                <form class=\"formStyle1\" id=\"makeGridForm\" action=\"".SystemConfiguration::getURLBase()."Library/Controller/SM/WebController.php\" method=\"POST\">
                                    <p class=\"title1 white\">Código fonte da grid:<br>
                                        <textarea id=\"gridContent\" name=\"gridContent\" placeholder=\"insira o código fonte da grid aqui.\"></textarea>
                                    </p>
                                    <input type=\"hidden\" name=\"operation\" value=\"makeGrid\">									
                                    <input type=\"button\" value=\"Criar Grid\" onclick=\"makeGrid('makeGridForm')\">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                ";
        
        // fixa o conteudo da grid
        $this->setGrid($model);
    }
}