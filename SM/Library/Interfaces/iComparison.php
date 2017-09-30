<?php

/* Interface criada para modelar o conceito de comparacao de dados
 * 
 * Marcelo Barbosa,
 * maio, 2017.
 */

// declaracao do namespace
namespace SM\Library\Interfaces;

// importacao de classes
use SM\Library\Generic\Generic;

// declaracao da interface
interface iComparison 
{
    // assinatura dos metodos
    public function equals(Generic $obj);
}
