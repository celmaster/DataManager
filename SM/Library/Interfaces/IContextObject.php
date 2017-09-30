<?php

/* Interface criada para moldar os métodos de criam um contexto de um objeto
 * para manipular seus dados via padrão DAO.
 * 
 * Marcelo Barbosa,
 * junho, 2016.
 */

// declaracao do namespace
namespace SM\Library\Interfaces;

// declaracao da interface
interface IContextObject
{
    // assinatura dos metodos
    public function getContext();    
}