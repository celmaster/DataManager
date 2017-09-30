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
class MakeTemplateGrid extends DataGrid
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
                	
                <div class=\"grid\" id=\"makeTemplateGrid\">	                                        
                    <p class=\"title3 center\">									
                        Criação de Templates
                    </p>
                    <div class=\"grid\">
                        <div class=\"opacityBlock\">	
                            <div class=\"blockText\">							    
                                <form class=\"formStyle1\" id=\"makeTemplateForm\" action=\"".SystemConfiguration::getURLBase()."Library/Controller/SM/WebController.php\" method=\"POST\">
                                    <p class=\"title1 white\">Nome do arquivo de modelo:<br>
                                        <input type=\"text\" id=\"resourceName\" name=\"resourceName\" placeholder=\"Exemplo: arquivo.extensao\">
                                    </p>									
                                    <p class=\"title1 white\">Nome da classe:<br>
                                        <input type=\"text\" id=\"className\" name=\"className\" placeholder=\"Insira o nome da classe do template\">
                                    </p>
                                    <input type=\"hidden\" name=\"operation\" value=\"makeTemplate\">									
                                    <input type=\"button\" value=\"Criar Template\" onclick=\"makeTemplate('makeTemplateForm')\">
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