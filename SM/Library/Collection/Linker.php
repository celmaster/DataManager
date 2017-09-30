<?php
/* Classe abstrata criada para abstrair o conceito de vinculador.
 * 
 * Marcelo Barbosa.
 * dezembro, 2013.
 */

// declaracao do namespace
namespace SM\Library\Collection;

// importacao de classes
use SM\Library\Generic\Generic;

// declaração de classes
abstract class Linker extends Generic
{
    // declaração de atributos
    public $next;
    public $prior;     
    
    // declaração de métodos
    public function __construct($objectName = "")
    {
        // método construtor         
        // inicialização de atributos      
        parent::__construct($objectName);
        $this->next = null;
        $this->prior = null; 
    }
    
    public function setNext($next)
    {
        $this->next = $next;
    }  

    public function getNext()
    {
        return $this->next;
    }    

    public function setPrior($prior)
    {
        $this->prior = $prior;
    }  

    public function getPrior()
    {
        return $this->prior;
    }
}