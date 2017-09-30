<?php

/*  Classe abstrata objeto, que representa as caracteristicas mais gerais de um objeto por meio de um numero de ID.
 * 
 * Marcelo Barbosa.
 * junho, 2014.
 * 
 */

// declaracao do namespace
namespace SM\Library\Generic;

// declaracao de classes
abstract class Object extends Generic
{    
    // declaracao de atributos
    private $id;    
    
    // declaracao de metodos
    public function __construct($id = 0, $objectName = "")
    {
        parent::__construct($objectName);
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }    
    
}