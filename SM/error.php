<?php

// incorporacao do autoload
require_once("autoload.php");

// importacao de classes
use SM\Library\Web\Template\SM\SMTemplate;
use SM\Library\Web\Link;
use SM\Library\Web\Template\DataGridModel\SM\ContainerGrid;

// instanciacao da pagina
$page = new SMTemplate("SM Framework - Acesso Negado");

// instanciacao de grids
$errorGrid = new ContainerGrid("Acesso Negado", "Os dados de usuário estão incorretos.", "negativeMessage");

// criacao de um link
$link = new Link("voltar", "index.php");
$link->setClass("title2 white");

// agregacao de conteudo a pagina
$page->addContent($errorGrid->getGrid());
$page->addContentByCommentTag("<!-- @ContainerGridContent -->", $link->toString());

// imprime a pagina
echo $page->toString();
