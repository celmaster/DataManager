<?php

/* Classe estatica criada para definir dados de configuracao do sistema 
 * 
 * Marcelo Barbosa, 
 * outubro, 2015.
 */

// declaracao do namespace
namespace SM\Configuration;

// importacao de classes
use SM\Library\Utils\TimeStamp;
use SM\Setup;

// declaracao da classe
class SystemConfiguration
{
        
    // declaracao de metodos estaticos        
    public static function getURL()
    {
        return "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    
    public static function go($destine)
    {
        header("location:".$destine);
    }
    
    public static function letsgo($sourcePage)
    {
        SystemConfiguration::go(SystemConfiguration::getURLBase().$sourcePage);
    }
    
    public static function letsgoByRoot($sourcePage)
    {
        SystemConfiguration::go(SystemConfiguration::getLocalURLBase().$sourcePage);
    }
    
    public static function getLocalLink($sourcePage)
    {
        return SystemConfiguration::getLocalURLBase().$sourcePage;
    }
    
    public static function getLink($sourcePage)
    {
        return SystemConfiguration::getURLBase().$sourcePage;
    }
    
    public static function getLocalURLBase()
    {
        $path = Setup::getRoot() . "/";
        $url = SystemConfiguration::getURL();
        $url = substr($url,0,strpos($url, $path));
        $url .= $path;
        return $url;
    }
    
    public static function getURLBase()
    {
        $path = Setup::getRoot() . "/SM/";
        $url = SystemConfiguration::getURL();
        $url = substr($url,0,strpos($url, $path));
        $url .= $path;
        return $url;
    }
    
    public static function getLocalRoot()
    {   
        return $_SERVER["DOCUMENT_ROOT"] . Setup::getRoot() . "/";
    }
    
    public static function getRoot()
    {   
        return $_SERVER["DOCUMENT_ROOT"] . Setup::getRoot() . "/SM/";
    }
    
    public static function getCSSDir()
    {        
        $url = SystemConfiguration::getURLBase() . "CSS";
        return $url;
    }
    
    public static function getJSDir()
    {
        $url = SystemConfiguration::getURLBase() . "JS";
        return $url;
    }
    
    public static function getImageDir()
    {
        $url = SystemConfiguration::getURLBase() . "Assets/Images";
        return $url;
    }
    
    public static function getControllerDir()
    {
        $url = SystemConfiguration::getURLBase() . "/Library/Controller";
        return $url;
    }
    
    public static function getServicesDir()
    {
        $url = SystemConfiguration::getURLBase() . "/Library/Services";
        return $url;
    }
    
    public static function getAssetsDir()
    {
        $url = SystemConfiguration::getURLBase() . "Assets";
        return $url;
    }
    
    public static function getAssetsPath()
    {
        $url = SystemConfiguration::getRoot() . "Assets";
        return $url;
    }
    
    public static function getUploadFileDir()
    {
        $url = SystemConfiguration::getURLBase() . "Assets/Uploads";
        return $url;
    }
    
    public static function getUploadFilePath()
    {
        $url = SystemConfiguration::getRoot() . "Assets/Uploads";
        return $url;
    }
    
    public static function getVerb()
    {
        // obtem um verbo para servico REST
        $url = SystemConfiguration::getURL();
        $url = substr($url,strpos($url, ".php")+4,strpos($url, ".php"));        
        return $url;
    }
    
    public static function getCurrentDate()
    {
        // retorna a data corrente
        $timestamp = new TimeStamp();
        return $timestamp->getCurrentDate();
    }
    
    public static function getCurrentTime()
    {
        // retorna o horario corrente
        $timestamp = new TimeStamp();
        return $timestamp->getCurrentTime();
    }
}