<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('autoload.php');

use SM\Library\Utils\Tools\FileTool;

$mensagem = "falha ao enviar arquivo";

if(FileTool::uploadfile("arquivo"))
{
    $mensagem = "arquivo enviado com sucesso!";
}

echo $mensagem;