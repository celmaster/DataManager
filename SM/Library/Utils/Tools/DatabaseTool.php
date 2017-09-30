<?php

/* Classe que modela uma ferramenta para utilizar DDL e DML em banco de dados
 * 
 * Marcelo Barbosa,
 * julho, 2016.
 */

// declaracao do namespace
namespace SM\Library\Utils\Tools;

// importacao de classes
use SM\Library\Model\Configuration;
use SM\Library\Database\Connection;

// declaracao de classe
class DatabaseTool
{
    // declaracao de atributos
    
    // declaracao de metodos
    public static function hasDatabase($dbname, Configuration $configuration)
    {
        // verifica se uma base de dados existe
        // declaracao de variaveis
        $status = false;
        $pdo = null;        
        
        try
        {
            $connection = new Connection($configuration);            
            $pdo = $connection->getConnection();
            $pdo->exec("set names utf8");
            
            if(($pdo != null) && (strcmp($dbname, "") != 0))
            {
                
                $stmt = $pdo->prepare("SELECT COUNT(SCHEMA_NAME) AS db FROM "
                        . "INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$dbname."';");
                $stmt->execute();
                $data = $stmt->fetch();
                $status = $data["db"];
            }
            
        }catch(Exception $e)
              {
                echo "Error: " . $e->getMessage();
              }
        
        // retorno de valor
        return $status;
    }
    
    public static function createDatabase($dbname, Configuration $configuration)
    {
        // cria uma base de dados se ela nao existir
        // declaracao de variaveis
        $status = false;
        $pdo = null;
        
        // verifica se a base de dados exist
        if((!DatabaseTool::hasDatabase($dbname, $configuration)) && (strcmp($dbname, "") != 0))
        {
            try
            {
                $connection = new Connection($configuration);            
                $pdo = $connection->getConnection();
                $pdo->exec("set names utf8");
                
                $stmt = $pdo->prepare("CREATE DATABASE ".$dbname.";");
                
                if($stmt->execute())
                {
                    $status = true;
                }
                
            } catch(Exception $e)
                   {
                       echo "Error: " . $e->getMessage();
                   }
        }
        
        // retorno de valor
        return $status;
    }
    
    public static function hasTable($tableName, Configuration $configuration)
    {
        // verifica se uma tabela existe em um esquema
        // declaracao de variaveis
        $status = null;
        $pdo = null;
        
        // valida o parametro do nome da tabela de dados
        if(strcmp($tableName, "") != 0)
        {
            try
            {
                $connection = new Connection($configuration);
                $pdo = $connection->getConnection();
                $pdo->exec("set names utf8");
                $stmt = $pdo->prepare("SELECT COUNT(TABLE_NAME) AS tableName FROM INFORMATION_SCHEMA.TABLES "
                        . "WHERE TABLE_NAME = '".$tableName."' AND TABLE_SCHEMA = '".$configuration->getDbName()."';");
                
                $stmt->execute();
                $data = $stmt->fetch();
                $status = $data["tableName"];
                
            } catch (Exception $e) 
                    {
                        echo "Error: " . $e->getMessage();
                    }
        }
        
        // retorno de valor
         return $status;
    }
    
    public static function createTable($tableName, $tableStatement, Configuration $configuration)
    {
        // cria uma tabela de dados se ela nao existir no banco de dados
        // declaracao de variaveis
        $status = false;
        $pdo = null;
        
        // valida os parametros
        if((strcmp($tableName, "") != 0) && (strcmp($tableStatement, "") != 0))
        {
            // verifica se a tabela existe
            if(!DatabaseTool::hasTable($tableName, $configuration))
            {
                // cria a tabela
                $connection = new Connection($configuration);
                $pdo = $connection->getConnection();
                $pdo->exec("set names utf8");
                $stmt = $pdo->prepare("CREATE TABLE ".$tableName.$tableStatement.";");
                
                if($stmt->execute())
                {
                    $status = true;
                }
            }
        }
        
        // retorno de valor 
        return $status;
    }
    
    public static function exec($sql, Configuration $configuration)
    {
        // executa um comando sql
        // declaracao de variaveis
        $status = false;
        $pdo = null;
        
        // valida os parametros
        if(strcmp($sql, "") != 0)
        {   
            $connection = new Connection($configuration);
            $pdo = $connection->getConnection();
            $pdo->exec("set names utf8");
            $stmt = $pdo->prepare($sql);

            if($stmt->execute())
            {
                $status = true;
            }
            
        }
        
        // retorno de valor 
        return $status;
    }
    
    public static function query($sql, Configuration $configuration)
    {
        // seleciona dados da tabela de dados
        // declaracao de variaveis
        $rs = null;
        $stmt = null;
        
        // valida os parametros
        if(strcmp($sql, "") != 0)
        {   
            $connection = new Connection($configuration);
            $pdo = $connection->getConnection();
            $pdo->exec("set names utf8");
            $stmt = $pdo->query($sql);            
            
        }
        
        // retorno de valor 
        return $stmt;
    }
    
}