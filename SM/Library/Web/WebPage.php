<?php

/* Classe criada para modelar paginas HTML
 *
 * Marcelo Barbosa
 * outubro, 2015.
 */

// declaracao do namespace
namespace SM\Library\Web;

// importacao de classes
use SM\Library\Generic\Generic;

// declaracao da classe
abstract class WebPage extends Generic
{
    // declaracao de atributos
    private $title;                 // titulo do documento (*elemento de contexto)
    private $charset;               // conjunto de caracteres (*elemento de contexto)
    private $head;                  // cabecalho do documento
    private $body;                  // corpo do documento
    private $lang;                  // idioma do documento web (*elemento de contexto)    
    
    // declaracao de metodos
    public function __construct($title = "Web Page", $chaset = "utf-8", $lang = "pt-br")
    {
        // metodo construtor
        // inicializa a superclasse
        parent::__construct("Web Page");
        
        // inicializa demais atributos
        $this->title = $title;
        $this->charset = $chaset;
        
        $this->head = "<head>\n" 
                . "<title>" . $this->title . "</title>\n"
                . "\n</head>\n";
        
        $this->body = "<body>\n"
                . "<!-- @Structure -->\n"
                . "<!-- @Content -->\n"
                . "<!-- Script JS -->\n"
                . "\n</body>";        
        
        $this->lang = $lang;
    }
    
    // metodos de encapsulamento
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function  setCharset($charset)
    {
        $this->charset = $charset;
    }
    
    public function getCharset()
    {
        return $this->charset;
    }
    
    public function setLang($lang)
    {
        $this->lang = $lang;
    }
    
    public function getLang()
    {
        return $this->lang;
    }
    
    public function setHead($head)
    {
        $this->head = $head;
    }
    
    public function getHead()
    {
        return $this->head;
    }
    
    public function setBody($body)
    {
        $this->body = $body;
    }
    
    public function getBody()
    {
        return $this->body;
    }
}