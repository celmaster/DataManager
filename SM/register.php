<?php

// incorporacao do autoload
require_once("autoload.php");

// importacao de classes
use SM\Configuration\DbConfiguration;
use SM\Configuration\SystemConfiguration;
use SM\Library\Web\Template\SM\SMTemplate;
use SM\Library\Web\Template\DataGridModel\SM\UserRegistrationGrid;

if(DbConfiguration::hasUser())
{
    SystemConfiguration::letsgo("index.php");
}

// instanciacao da pagina
$page = new SMTemplate("SM Framework - Register");

// instanciacao de grids
$userRegistrationGrid = new UserRegistrationGrid();

// agregacao de conteudo a pagina
$page->addContent($userRegistrationGrid->getGrid());

// imprime a pagina
echo $page->toString();

