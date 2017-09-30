<?php

/*  Classe objeto Page Manager, responsavel por gerenciar paginacao de consultas em SQL
 * 
 * Marcelo Barbosa.
 * dezembro, 2014.
 * 
 */

// declaracao do namespace
namespace SM\Library\Utils;

// importacao de classes
use SM\Library\Generic\Object;
use SM\Configuration\SystemConfiguration;

// declaracao de classe
class PageManager extends Object
{
    // declaracao de atributos
    private $p;
    private $index;
    private $numberPages;
    private $numberRecordsPerPages;
    private $numberRecords;
    private $firstPageLink;
    private $lastPageLink;
    private $URL;
    private $firstCaption;
    private $nextCaption;
    private $priorCaption;
    private $lastCaption;    
    
    // declaracao de metodos
    public function __construct($numberRecordsPerPage = 1, $numRegisters = 0, $id = 0)
    {
        // chama o construstor da classe pai
        parent::__construct($id, "Page Manager");
        
        // o atributo "p" e inicializado com o valor da variavel de parametro "p" que indica a pagina atual
        if(isset($_GET["p"]))
        {
            $this->p = $_GET["p"];        
        }else
            {
                $this->p = 1;
            }
        
        // quantidade de registros por pagina    
        $this->numberRecordsPerPages = $numberRecordsPerPage; 
        
        // inicializa o atributo numberPagescom o numero total de paginas mediante a razao entre a quantidade total de registros e sua quantidade por pagina
        $this->numberPages = ceil($numRegisters / $numberRecordsPerPage);
        
        // armazenando o numero de registros existente
        $this->numberRecords = $numRegisters;
        
        // links da primeira e ultima pagina
        $this->firstPageLink = 1;
        $this->lastPageLink = $this->numberPages;
        
        // pega um indice para o navegador
        $this->index = ($this->p - 1) * $this->numberRecordsPerPages;
        
        // pega a url completa da pagina web
        $this->URL = SystemConfiguration::getURL();
        
        // fixa a legenda dos navegadores
        $this->firstCaption = "First";
        $this->nextCaption = "Next";
        $this->priorCaption = "Prior";
        $this->lastCaption = "Last";        
    }
    
    public function setFirstCaption($firstCaption)
    {
        $this->firstCaption = $firstCaption;
    }
    
    public function getFirstCaption()
    {
        return $this->firstCaption;
    }
    
    public function setNextCaption($nextCaption)
    {
        $this->nextCaption = $nextCaption;
    }
    
    public function getNextCaption()
    {
        return $this->nextCaption;
    }
    
    public function setPriorCaption($priorCaption)
    {
        $this->priorCaption = $priorCaption;
    }
    
    public function getPriorCaption()
    {
        return $this->priorCaption;
    }
    
    public function setLastCaption($lastCaption)
    {
        $this->lastCaption = $lastCaption;
    }
    
    public function getLastCaption()
    {
        return $this->lastCaption;
    }
    
    public function getP()
    {
        return $this->p;
    }        
    
    public function setNumberPages($numberPages)
    {
        $this->numberPages = $numberPages;
    }        
    
    public function getNumberPages()
    {
        return $this->numberPages;
    }        
    
    public function sgetNumberRecordsPerPages($numberRecordsPerPages)
    {
        $this->numberRecordsPerPages = $numberRecordsPerPages;
    }        
    
    public function getNumberRecordsPerPages()
    {
        return $this->numberRecordsPerPages;
    }        
    
    public function setFirstPageLink($firstPageLink)
    {
        $this->firstPageLink = $firstPageLink;
    }        
    
    public function getFirstPageLink()
    {
        return $this->firstPageLink;
    }        
    
    public function setLastPageLink($lastPageLink)
    {
        $this->lastPageLink = $lastPageLink;
    }
    
    public function getLastPage()
    {
        return $this->lastPageLink;
    }        
    
    public function getURL()
    {
        return $this->URL;
    } 
    
    public function setNumberRecords($numberRecords)
    {
        $this->numberRecords = $numberRecords;
    }    
    
    public function getNumberRecords()
    {
        return $this->numberRecords;
    }        
    
    public function getIndex()
    {
        return $this->index;
    }        
    
    public function hasParametersInURL()
    {
        // verifica a existencia de parametros na URL
        if(stripos($this->getURL(), "?"))
        {
            return true;
        }else
            {
                return false;
            }
    }  
    
    public function hasPage()
    {
        if(isset($_GET["p"]))
        {
            return true;
        }else
            {
                return false;
            }
    }
    
    public function getURLFormatedForParameter()
    {
        // retorna a URL formatada para inserir um parametro
        
        // declarcao de variaveis
        $link = $this->getURL();
        
        // verificando se URL possui parametros
        if($this->hasParametersInURL())
        {  
            // verificando se o parametro da pagina ja existe
            if($this->hasPage())
            {
                $link = str_ireplace("p=".$_GET["p"], "", $link);
            }else
                {
                    $link .= "&";
                }
        }else
            {
                $link .= "?";
            }
            
        // retorno de valor
        return $link;    
    }        
    
    public function toPageByLinks($numLinks)
    {
        // Paginacao com links numericos
        // declaracao de variaveis       
        $start = $this->getP() - $numLinks;
        $link = $this->getURLFormatedForParameter();
        $navigation = "<div class=\"dbNavigator\">";
        
        // verificando se a variavel de inicio para o laco de repeticao possui valor invalido
        if($start <= 0)
        {
            $start = 1;
        }
        
        // verifica se o valor da pagina atual eh valido
        if($this->getP() > $this->getLastPage())
        {
            $this->p = 1;
        }
            
        // criando os links
        $navigation .= "<a href=\"".$link."p=".$this->getFirstPageLink()."\" class=\"simpleLink\" target=\"_self\">" 
                                                            . $this->getFirstCaption() . "</a>&nbsp;&nbsp;";
        
        // cria os links antes da pagina atual
        for($i = $start; $i < $this->getP(); $i++)
        {            
            $navigation .= "<a href=\"".$link."p=".$i."\" class=\"simpleLink\" target=\"_self\">".$i."</a>&nbsp;&nbsp;";
        }
        
        // exibe pagina atual
        $navigation .= "<span class=\"simpleLinkPointer\">".$this->getP()."</span>&nbsp;&nbsp;";
        
         // cria os links depois da pagina atual
        for($i = 1 + $this->getP(); $i < $this->getP() + $numLinks; $i++)
        {
            if($i <= $this->getLastPage())
            {    
                $navigation .= "<a href=\"".$link."p=".$i."\" class=\"simpleLink\" target=\"_self\">".$i."</a>&nbsp;&nbsp;";
            }    
        }
        
        // exibe o link final
        $navigation .= "<a href=\"".$link."p=".$this->getLastPage()."\" class=\"simpleLink\" target=\"_self\">" 
                                                                                . $this->getLastCaption() . "</a></div>";
        
        // retorno de valor
        return $navigation;
    }
    
    public function toPageByNavigator()
    {
        // Paginacao com navegador de paginas
        // declaracao de variaveis
        $navigator = "<div class=\"dbNavigator\">";
        $btFirstPage = "";
        $btPriorPage = "";
        $btNextPage = "";
        $btLastPage = "";
        $link = $this->getURLFormatedForParameter();
        
        // criacao de botoes com validacao sobre o handleState.        
        $btFirstPage = "<a class=\"linkButton\" href=\"".$link."p=".$this->getFirstPageLink()."\"  target=\"_self\">"
            . $this->getFirstCaption() . "</a>  ";
        $btPriorPage = "<a class=\"linkButton\" href=\"".$link."p=".($this->getP() - 1)."\"  target=\"_self\">"
            . $this->getPriorCaption() . "</a>  ";
        $btNextPage = "<a class=\"linkButton\" href=\"".$link."p=".($this->getP() + 1)."\"  target=\"_self\">"
            . $this->getNextCaption() . "</a>  ";
        $btLastPage = "<a class=\"linkButton\" href=\"".$link."p=".$this->getLastPage()."\"  target=\"_self\">"
            . $this->getLastCaption() . "</a>";
        
        // exibe o navegador caso o numero de registros seja maior ou igual que o numero de registeos por pagina
         if($this->getNumberRecords() >= $this->getNumberRecordsPerPages())
        {
            // fixando configuracoes dos botoes de navegacao
            if($this->getP() - 1 == 0)
            {
               // se nao ha pagina anterior entao o botao referente nao deve ser exibido
               $btPriorPage = "";
            }
            
            if($this->getP() == $this->getLastPage())
            {
               // se a pagina corrente e a final entao o botao refente nao deve ser exibido
               $btNextPage = "";
            }    
            
            // construindo o navegador
            $navigator .= $btFirstPage . $btPriorPage . $btNextPage . $btLastPage . "</div>";            
        }
        
        // imprimindo o navegador
        return $navigator;
    }        
            
    public function toString()
    {
        // retorna uma string com os dados da classe
        return "FirstPageLink = " . $this->getFirstPageLink()
                . "<br>LastPageLink = " . $this->getLastPage()
                . "<br>NumberPages = " . $this->getNumberPages()
                . "<br>NumberRecords = " . $this->getNumberRecords()
                . "<br>NumberRecordsPerPages = " . $this->getNumberRecordsPerPages()
                . "<br>First Caption = " . $this->getFirstCaption()
                . "<br>Prior Caption = " . $this->getPriorCaption()
                . "<br>Next Caption = " . $this->getNextCaption()
                . "<br>Last Caption = " . $this->getLastCaption()
                . "<br>p = " . $this->getP()
                . "<br>URL = ". $this->getURL();
    }

}