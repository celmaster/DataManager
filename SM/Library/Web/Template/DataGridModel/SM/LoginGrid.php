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
class LoginGrid extends DataGrid
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
                
                <div class=\"menu\">
                    <div class=\"loginArea\">
                        <form id=\"loginForm\" action=\"".SystemConfiguration::getURLBase()."Library/Controller/SM/SMUserController.php\" method=\"POST\">
                            <div class=\"horizontalInput\">
                                <div class=\"usernameTitle\"></div>
                                <input type=\"text\" id=\"username\" name=\"username\" placeholder=\"Nome de usuário\">
                            </div>
                            <div class=\"horizontalInput\">
                                <div class=\"passwordTitle\"></div>
                                <input type=\"password\" id=\"password\" name=\"password\" placeholder=\"Password de usuário\">
                            </div>
                            <div class=\"horizontalItem\">
                                <div class=\"loginButton\" onclick=\"login('loginForm')\"></div>
                            </div>
                            <input type=\"hidden\" name=\"operation\" value=\"login\">
                        </form>
                    </div>
                </div>
                ";
        
        // fixa o conteudo da grid
        $this->setGrid($model);
    }
}