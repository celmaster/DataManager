<?php

/* Modela um usuario do framework SSF
 * 
 * Marcelo Barbosa,
 * julho, 2016.
 */

// declaracao do namespace
namespace SM\Library\Model;

// importacao de classes
use SM\Library\Generic\Generic;
use SM\Library\Database\Context\Context;
use SM\Library\Database\Context\ContextElement;
use SM\Library\Interfaces\IContextObject;

// declaracao da classe
class SMUser extends Generic implements IContextObject
{
    // declaracao de atributos
    private $username;
    private $password;
    
    // declaracao de metodos
    public function __construct($username = "", $password = "") 
    {
        // metodo construtor
        // inicializa a superclasse
        parent::__construct("SSF User");
        
        // inicializa demais atributos
        $this->username = $username;
        $this->password = $password;
    }
    
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getContext() 
    {
        // retorna o contexto da classe
        // declaracao de variaveis
        $context = new Context();
        
        // adiciona os elementos de contexto
        $context->add(new ContextElement("username", $this->getUsername(), true, true));
        $context->add(new ContextElement("password", $this->getPassword(), false, true));
        
        // retorno de valor
        return $context;
    }

    public function toString() 
    {
        // retorna todos os dados da classe em uma string
        return "User's name: " . $this->getUsername()
               ."<br>User's password: " . $this->getPassword();
    }

}