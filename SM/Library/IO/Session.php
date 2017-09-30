<?php

/* Classe criada para gerenciar sessoes
 * 
 * Marcelo Barbosa,
 * agosto, 2016.
 */

// declaracao do namespace
namespace SM\Library\IO;

// declaracao da classe
class Session
{
    // declaracao de atributos
    
    // declaracao de metodos
    private static function open()
    {
        // abre uma sessao
        session_start();        
    }
        
    public static function delete($sessionName)
    {
        // encerra uma sessao destruindo todas as variaveis
        if(!Session::hasSession())
        {
           Session::open(); 
        }
        
       unset($_SESSION[$sessionName]);
    }
    
    public static function destroy()
    {
        // destroi todas as variaveis
        if(!Session::hasSession())
        {
           Session::open(); 
        }
        
        $_SESSION = array();
        session_destroy();
    }
    
    public static function hasSession()
    {
        // verifica se alguma sessao esta aberta para o usuario
        $status = isset($_SESSION);
    
        //retorno de valor
        return $status;
    }
    
    public static function exist($sessionName)
    {
        // verifica se uma variavel de sessao existe
        $status = false;
        
        if(Session::get($sessionName) != null)
        {
            $status = true;
        }
    
        //retorno de valor
        return $status;
    }
    
    public static function get($sessionName)
    {
        // obtem uma variavel de sessao
        // declaracao de variaveis
        $value = null;
        if(!Session::hasSession())
        {
           Session::open(); 
        }
        
        if(isset($_SESSION[$sessionName]))
        {
            $value = $_SESSION[$sessionName];
        }
        
        // retorno de valor
        return $value;
    }
    
    public static function set($sessionName, $value)
    {
        // fixa o valor de uma variavel de sessao
        // declaracao de variaveis       ;
        if(!Session::hasSession())
        {
           Session::open(); 
        }       
        
        $_SESSION[$sessionName] = $value;
        
    }
}