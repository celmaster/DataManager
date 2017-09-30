<?php

// incorporacao do autoload
require_once("autoload.php");

// importacao de classes
use SM\Configuration\SystemConfiguration;
use SM\Library\IO\Session;

// fecha a sessao do usuario
Session::delete("username");
Session::delete("password");
Session::delete("message");
Session::delete("type");
Session::delete("redirect");

// redireciona para o sistema tratar da validacao de usuarios
SystemConfiguration::letsgo("main.php");
