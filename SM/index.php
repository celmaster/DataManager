<?php

/* Pagina inicial do framework
 * 
 * Marcelo Barbosa,
 * agosto, 2016.
 */

// incorporacao do autoload
require_once("autoload.php");

// importacao de classes
use SM\Configuration\DbConfiguration;
use SM\Configuration\SystemConfiguration;
use SM\Library\Web\Template\SM\SMTemplate;
use SM\Library\Web\Template\DataGridModel\SM\LoginGrid;
use SM\Library\Web\Template\DataGridModel\SM\AboutGrid;
use SM\Library\Web\Template\DataGridModel\SM\DescriptionGrid;
use SM\Library\Web\Template\DataGridModel\SM\DetailsGrid;
use SM\Library\Web\Template\DataGridModel\SM\ReferencesGrid;
use SM\Library\Web\Template\DataGridModel\SM\FloatMenuGrid;

// verifica se o banco de dados existe
DbConfiguration::hasDataSystem();

if(!DbConfiguration::hasUser())
{
    SystemConfiguration::letsgo("register.php");
}

// instanciacao da aplicacao web
$page = new SMTemplate("SM Framework");
$page->addAuthor("Marcelo Barbosa");

// instanciacao dos blocos de conteudo
$loginGrid = new LoginGrid();
$aboutGrid = new AboutGrid();
$descriptionGrid = new DescriptionGrid();
$detailsGrid = new DetailsGrid();
$referencesGrid = new ReferencesGrid();
$floatMenuGrid = new FloatMenuGrid("Menu de navegação");

// incorporacao de blocos de conteudo a aplicacao web
$page->addHeaderContent($loginGrid->getGrid());
$page->addContent($aboutGrid->getGrid().
                  $descriptionGrid->getGrid().
                  $detailsGrid->getGrid().
                  $referencesGrid->getGrid());

$page->addContentByCommentTag("<!-- @Navigation -->", $floatMenuGrid->getGrid());

// disponibilizacao da aplicacao a saida de dados
echo $page->toString();
