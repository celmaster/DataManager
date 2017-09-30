<?php

/* Gerencia os dados do usuario do framework
 * 
 * Marcelo Barbosa,
 * agosto, 2016.
 */

// importacao do autoload
require_once('../../../autoload.php');

// importacao de classes
use SM\Configuration\SystemConfiguration;
use SM\Library\IO\Request;
use SM\Library\Utils\Tools\WebTool;
use SM\Library\Interfaces\iController;
use SM\Library\Utils\StringManager;
use SM\Library\IO\Session;
use SM\Library\Model\Package;

// declaracao da classe
class WebController implements iController
{
    // declaracao de atributos
    private $resourcesName;
    private $className;
    private $gridContent;
    private $operation;
    
    // declaracao de metodos
    public function __construct() 
    {
        // metodo construtor
        // inicializa os atributos
        $this->resourcesName = Request::getParameter("resourceName", "post");
        $this->className = Request::getParameter("className", "post");
        $this->gridContent = Request::getParameter("gridContent", "post");
        $this->operation = Request::getParameter("operation", "post");
    }
    private function makeTemplate()
    {
        // cria templates
        $status = WebTool::createTemplate($this->resourcesName, $this->className);
        
        if($status)
        {
            Session::set("message", "Template criado com sucesso!");
            Session::set("type", "positiveMessage");
        }else
            {
                Session::set("message", "Erro ao criar template.");
                Session::set("type", "negativeMessage");
            }
        
        Session::set("redirect", "main.php"); 
        SystemConfiguration::letsgo("notice.php");
    }
    
    private function makeGrid()
    {
        // cria grids
        $package = WebTool::findGrids(new Package(StringManager::setQuotes($this->gridContent)));
        
        if($package->getFlag())
        {
            Session::set("message", "Grid(s) criado(s) com sucesso!");
            Session::set("type", "positiveMessage");
        }else
            {
                Session::set("message", "Erro ao criar grid(s).");
                Session::set("type", "negativeMessage");
            }
        
        Session::set("redirect", "grids.php"); 
        SystemConfiguration::letsgo("notice.php");
    }

    public function exec()
    {
        switch($this->operation)
        {
            case "makeTemplate":                
                $this->makeTemplate();
            break;    
        
            case "makeGrid":               
                $this->makeGrid();
            break;    
        }
    }

}

// instancia o controller para execucao
$webController = new WebController();
$webController->exec();