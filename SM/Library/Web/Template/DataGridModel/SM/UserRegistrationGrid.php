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
class UserRegistrationGrid extends DataGrid
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
                	
                <div class=\"grid\" id=\"userResgistration\">	                                        
                    <p class=\"title3 center\">									
                        Cadastro de Usuário
                    </p>
                    <div class=\"grid\">
                        <div class=\"opacityBlock\">	
                            <div class=\"blockText\">							    
                                <form class=\"formStyle1\" id=\"registerForm\" action=\"".SystemConfiguration::getURLBase()."Library/Controller/SM/SMUserController.php\" method=\"POST\">
                                    <p class=\"title1 white\">Username:<br>
                                        <input type=\"text\" id=\"usernameSaveForm\" name=\"username\" placeholder=\"Seu nome de usuário aqui\">
                                    </p>									
                                    <p class=\"title1 white\">Password:<br>
                                        <input type=\"password\" id=\"passwordSaveForm\" name=\"password\" placeholder=\"Seu password de usuário aqui\">
                                    </p>
                                    <p class=\"title1 white\">Repetir Password:<br>
                                        <input type=\"password\" id=\"confirmPasswordSaveForm\" placeholder=\"Repita seu password\">
                                    </p>
                                    <input type=\"hidden\" name=\"operation\" value=\"save\">									
                                    <input type=\"button\" value=\"Salvar\" onclick=\"saveUser('registerForm')\">
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