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
class MainMenuGrid extends DataGrid
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
        $model = "<div class=\"menu\">					
                    <div class=\"dropdown\">
                            <div class=\"dropdownTitle\">.:Acesso Rápido:.</div>
                            <div class=\"dropdownContent\">
                                    <div class=\"dropdownItem\" onclick=\"navPage('main.php')\">Criar Templates</div>
                                    <div class=\"dropdownItem\" onclick=\"navPage('grids.php')\">Criar Grids</div>
                                    <div class=\"dropdownItem lastItem\" onclick=\"navPage('user.php')\">Atualizar usuário</div>
                            </div>
                    </div>
                    <div class=\"logout\">
                            <div class=\"logoutButton\" onclick=\"navPage('logout.php')\"></div>
                    </div>
            </div>";
        
        // fixa o conteudo da grid
        $this->setGrid($model);
    }
}