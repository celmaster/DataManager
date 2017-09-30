<?php

// incorporacao do autoload
require_once("autoload.php");

// importacao de classes
use SM\Library\Web\Template\SM\SMTemplate;
use SM\Library\Web\Link;
use SM\Library\Web\Template\DataGridModel\SM\ContainerGrid;
use SM\Library\IO\Session;

// instanciacao da pagina
$page = new SMTemplate("SM Framework - Notificação");

// instanciacao de grids
$errorGrid = new ContainerGrid("Notificação:", Session::get("message"), Session::get("type"));

// criacao de um link
$link = new Link("voltar", Session::get("redirect"));
$link->setClass("title2 white");

// agregacao de conteudo a pagina
$page->addContent($errorGrid->getGrid());
$page->addContentByCommentTag("<!-- @ContainerGridContent -->", $link->toString());

// imprime a pagina
echo $page->toString();
