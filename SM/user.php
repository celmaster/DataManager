<?php

// incorporacao do autoload
require_once("autoload.php");

// importacao de classes
use SM\Configuration\SystemConfiguration;
use SM\Configuration\DbConfiguration;
use SM\Library\Web\Template\SM\SMTemplate;
use SM\Library\Web\Template\DataGridModel\SM\MainMenuGrid;
use SM\Library\Web\Template\DataGridModel\SM\UpdateUserGrid;
use SM\Library\IO\Session;

if(DbConfiguration::hasUserSession())
{
    // instanciacao da pagina
    $page = new SMTemplate("SM Framework - Atualização dos dados de Usuário");

    // instanciacao de grids
    $mainMenuGrid = new MainMenuGrid();
    $updateUserGrid = new UpdateUserGrid(Session::get("username"));

    // agregacao de conteudo a pagina
    $page->addHeaderContent($mainMenuGrid->getGrid());
    $page->addContent($updateUserGrid->getGrid());

    // imprime a pagina
    echo $page->toString();
}else
    {
        SystemConfiguration::letsgo("index.php");
    }
