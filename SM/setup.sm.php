<?php

/* Configuracoes globais para o projeto SM
 * 
 * Marcelo Barbosa,
 * agosto, 2016.
 */

// declaracao do namespace
namespace SM;

// adicione o nome do diretorio raiz em que o projeto SM sera importado.
// inserir no formato: /diretorio
$GLOBALS["root"] = "/DataManager";

class Setup
{
    public static function getRoot()
    {
        return $GLOBALS["root"];
    }
}

