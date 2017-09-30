<?php
/*
 * Classe responsavel por criar uma conexao com um banco de dados MySQL
 * 
 * Marcelo Barbosa.
 * dezembro, 2013.
*/

// declaracao do namespace
namespace SM\Library\Database;

// importacao de classes
use SM\Library\Model\Configuration;

// declaracao de classes
class Connection
{
    // declaracao de atributos
    private $userName;
    private $serverName;
    private $password;
    private $databaseName;
    private $driver;

    // declaracao de metodos
    public function __construct(Configuration $configuration)
    {
        // metodo construtor
        // inicializacao de atributos
        $this->userName = $configuration->getDbUsername();
        $this->serverName = $configuration->getDbServername();
        $this->password = $configuration->getDbPassword();
        $this->databaseName = $configuration->getDbName();
        $this->driver = $configuration->getDbDriver();

        // fixando o local padrao para o controle de datas e horas
        date_default_timezone_set($configuration->getLocale());
    }

    // metodos gatilhadores {setters e getters}
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }        

    public function getUserName()
    {
        return $this->userName;
    }        

    public function setServerName($serverName)
    {
        $this->serverName = $serverName;
    }

    public function getServerName()
    {
        return $this->serverName;
    }    

    public function setPassword($password)
    {
        $this->password = $password;
    }    

    public function getPassword()
    {
        return $this->password;
    }        

    public function setDatabaseName($databaseName)
    {
        $this->databaseName = $databaseName;
    }     

    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    public function setDriver($driver)
    {
        $this->driver = $driver;
    }

    public function getDriver()
    {
        return $this->driver;
    }

    // metodos de aplicacao
    public function getConnection()
    {
        // abre uma conexao ha um banco de dados
        // declaracao de variaveis              
        $pdo = null;
        $url = "";
        // tenta criar uma conexao com o banco de dados
        try
        {
            // recebe o endereco para acesso ao sgbd
            $url = $this->getDriver().":host=".$this->getServerName();
            
            //caso o nome do banco de dados seja informado, ele eh concatenado no endereco do sgbd
            if(strcmp($this->getDatabaseName(), "") != 0)
            {
                $url .= ";dbname=".$this->getDatabaseName();
            }
            
            $pdo = new \PDO($url, 
                           $this->getUserName(), 
                           $this->getPassword());
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);            
            
        }catch(\PDOException $exception)
              {
                 // imprime a excecao
                 echo "Connection failed: ".$exception->getMessage();
              }

        // retorno de valor
        return $pdo;
    } 

}