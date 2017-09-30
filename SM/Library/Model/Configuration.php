<?php

/* Classe criada para modelar configuracoes para conexao com banco de dados.
 *
 * Marcelo Barbosa
 * julho, 2016. 
 *  
 */

// declaracao do namespace
namespace SM\Library\Model;

// importacao de recursos
use SM\Library\Generic\Generic;

class Configuration extends Generic
{
    
    // declaracao de atributos
    private $dbDriver;
    private $dbName;
    private $dbServername;
    private $dbUsername;
    private $dbPassword;
    private $cryptKey;
    private $cipherAlgorithm;
    private $decipherAlgorithm;
    private $locale;
    
    // declaracao de metodos
    public function __construct($dbDriver = "", $dbName = "", $dbServername = "", 
            $dbUsername = "", $dbPassword = "", $cryptKey = "", 
            $cipherAlgorithm = "", $decipherAlgorithm = "", $locale = "") 
    {
        // metodo construtor
        $this->dbDriver = $dbDriver;
        $this->dbName = $dbName;
        $this->dbServername = $dbServername;
        $this->dbUsername = $dbUsername;
        $this->dbPassword = $dbPassword;
        $this->cryptKey = $cryptKey;
        $this->cipherAlgorithm = $cipherAlgorithm;
        $this->decipherAlgorithm = $decipherAlgorithm;
        $this->locale = $locale;           
    }
    
    public function getDbDriver()
    {
        return $this->dbDriver;
    }
    
    public function setDbDriver($dbDriver)
    {
        $this->dbDriver = $dbDriver;
    }
    
    public function getDbName()
    {
        return $this->dbName;
    }
    
    public function setDbName($dbName)
    {
        $this->dbName = $dbName;
    }
    
    public function getDbServername()
    {
        return $this->dbServername;
    }
    
    public function setDbServername($dbServername)
    {
        $this->dbServername = $dbServername;
    }
    
    public function getDbUsername()
    {
        return $this->dbUsername;
    }
    
    public function setDbUsername($dbUsername)
    {
        $this->dbUsername = $dbUsername;
    }
    
    public function getDbPassword()
    {
        return $this->dbPassword;
    }
    
    public function setDbPassword($dbPassword)
    {
        $this->dbPassword = $dbPassword;                
    }
    
    public function getCryptKey()
    {
        return $this->cryptKey;
    }
    
    public function setCryptKey($cryptKey)
    {
        $this->cryptKey = $cryptKey;
    }
    
    public function getLocale()
    {
        return $this->locale;        
    }
    
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
    
    public function getCipherAlgorithm()
    {
        return $this->cipherAlgorithm;
    }
    
    public function setCipherAlgorithm($cipherAlgorithm)
    {
        $this->cipherAlgorithm = $cipherAlgorithm;
    }
    
    public function getDecipherAlgorithm()
    {
        return $this->decipherAlgorithm;
    }
    
    public function setDecipherAlgorithm($decipherAlgorithm)
    {
        $this->decipherAlgorithm = $decipherAlgorithm;
    }
    
    public function toString()
    {
        // retorna os dados da classe em uma string
        return "Database driver: " . $this->getDbDriver()
                . "<br>Database Name: " . $this->getDbName()
                . "<br>Database Servername: " . $this->getDbServername()
                . "<br>Database Username: " . $this->getDbUsername()
                . "<br>Database Password: " . $this->getDbPassword()
                . "<br>Database Crypt Key: ". $this->getCryptKey()
                . "<br>Database Cipher Algorithm: ". $this->getCipherAlgorithm()
                . "<br>Database Decipher Algorithm: ". $this->getDecipherAlgorithm()
                . "<br>Database Locale: ". $this->getLocale();
    }

}