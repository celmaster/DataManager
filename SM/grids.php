<?php

// incorporacao do autoload
require_once("autoload.php");

// importacao de classes
use SM\Configuration\SystemConfiguration;
use SM\Configuration\DbConfiguration;
use SM\Library\Web\Template\SM\SMTemplate;
use SM\Library\Web\Template\DataGridModel\SM\MainMenuGrid;
use SM\Library\Web\Template\DataGridModel\SM\MakeGrids;

if(DbConfiguration::hasUserSession())
{
    // instanciacao da pagina
    $page = new SMTemplate("SM Framework - Grids");

    // instanciacao de grids
    $mainMenuGrid = new MainMenuGrid();
    $makeGrids = new MakeGrids();

    // agregacao de conteudo a pagina
    $page->addHeaderContent($mainMenuGrid->getGrid());
    $page->addContent($makeGrids->getGrid());

    // imprime a pagina
    echo $page->toString();
}else
    {
        SystemConfiguration::letsgo("index.php");
    }
