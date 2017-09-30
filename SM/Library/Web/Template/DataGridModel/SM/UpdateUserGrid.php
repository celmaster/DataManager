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
class UpdateUserGrid extends DataGrid
{
    // declaracao de metodos
    public function __construct($username) 
    {
        // inicializa a superclasse
        parent::__construct("", "Data Grid");

        $this->gridModeling($username);
    }
    
    public function gridModeling($username)
    {
        // modela o conteudo de uma data grid
        // declaracao de variaveis
        $model = "
                	
                <div class=\"grid\" id=\"userResgistration\">	                                        
                    <p class=\"title3 center\">									
                        Atualização dos dados de usuário
                    </p>
                    <div class=\"grid\">
                        <div class=\"opacityBlock\">	
                            <div class=\"blockText\">							    
                                <form class=\"formStyle1\" id=\"updateForm\" action=\"".SystemConfiguration::getURLBase()."Library/Controller/SM/SMUserController.php\" method=\"POST\">
                                    <p class=\"title1 white\">Username:<br>
                                        <input type=\"text\" id=\"usernameUpdateForm\" name=\"username\" placeholder=\"Seu nome de usuário aqui\" value=\"".$username."\">
                                    </p>									
                                    <p class=\"title1 white\">Password atual:<br>
                                        <input type=\"password\" id=\"oldPasswordUpdateForm\" name=\"oldPassword\" placeholder=\"Password atual\">
                                    </p>
                                    <p class=\"title1 white\">Novo Password:<br>
                                        <input type=\"password\" id=\"newPasswordUpdateForm\" name=\"password\" placeholder=\"Seu password de usuário aqui\">
                                    </p>
                                    <p class=\"title1 white\">Repetir Novo Password:<br>
                                        <input type=\"password\" id=\"confirmPasswordUpdateForm\" placeholder=\"Repita seu novo password\">
                                    </p>
                                    <input type=\"hidden\" name=\"operation\" value=\"update\">									
                                    <input type=\"button\" value=\"Atualizar\" onclick=\"updateUser('updateForm')\">
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