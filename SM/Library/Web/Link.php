<?php

/*
 * Modela um link de uma ancora em HTML 
 * 
 * Marcelo Barbosa
 * outubro, 2015.
 */

// declaracao do namespace
namespace SM\Library\Web;

// importacao de classes
use SM\Library\Generic\Generic;

// declaracao da classe
class Link extends Generic
{
    // declaracao de atributos
    private $name;
    private $href;
    private $target;
    private $title;
    private $style;
    private $class;
    private $id;
    
    // declaracao de metodos
    public function __construct($name = "", $href = "", $target = "", 
            $title = "", $style = "", $id = "", $class = "") 
    {
        // metodo construtor
        // inicializa a superclasse
        parent::__construct("Link");
        
        // inicializa demais atributos
        $this->name = $name;
        $this->href = $href;
        $this->target = $target; 
        $this->title = $title;
        $this->style = $style;
        $this->id = $id;
        $this->class = $class;
    }
    
    // metodos de encapsulamento
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setHref($href)
    {
        $this->href = $href;
    }
    
    public function getHref()
    {
        return $this->href;
    }
    
    public function setTarget($target)
    {
        $this->target = $target;
    }
    
    public function getTarget()
    {
        return $this->target;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setStyle($style)
    {
        $this->style = $style;
    }
    
    public function getStyle()
    {
        return $this->style;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setClass($class)
    {
        $this->class = $class;
    }
    
    public function getClass()
    {
        return $this->class;
    }
    
    public function getLink()
    {
        // declaracao de variaveis
        $styleProperty = "";
        $titleProperty = "";
        $idProperty = "";
        $classProperty = "";
        $targetProperty = "";
        
        if(strcmp($this->getTarget(), "") != 0)
        {
            $targetProperty = "target=\"".$this->getTarget()."\" ";
        }
        
        if(strcmp($this->getTitle(), "") != 0)
        {
            $titleProperty = "title=\"".$this->getTitle()."\" ";
        }
        
        if(strcmp($this->getStyle(), "") != 0)
        {
            $styleProperty = "style=\"".$this->getStyle()."\" ";
        }
        
        if(strcmp($this->getId(), "") != 0)
        {
            $idProperty = "id=\"".$this->getId()."\" ";
        }
        
        if(strcmp($this->getClass(), "") != 0)
        {
            $classProperty = "class=\"".$this->getClass()."\"";
        }
        
        $tag = "\n<a href=\"".$this->getHref()."\" "
                . "".$targetProperty.""
                . "".$titleProperty.""
                . "".$styleProperty.""
                . "".$idProperty.""
                . "".$classProperty.">"
                    .$this->getName().
                "</a>\n";
        
        return  $tag;
    }
    
    public function toString() 
    {
        return $this->getLink();
    }

}
?>

