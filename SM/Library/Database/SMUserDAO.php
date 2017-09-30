<?php

/* DAO criado para gerenciar a entidade "user"
 * 
 * Marcelo Barbosa,
 * julho, 2016.
 */

// declaracao do namespace
namespace SM\Library\Database;

// importacao de classes
use SM\Configuration\DbConfiguration;
use SM\Library\Model\SMUser;
use SM\Library\Utils\ProcessContext;

// declaracao de classe
class SMUserDAO extends DAO
{
    // declaracao de metodos
    public function __construct()
    {
        $model = new SMUser();
        parent::__construct(DbConfiguration::getDefaultConfiguration(),"users", $model->getContext(), 0, "username");
    }
    
    protected function getObject($data)
    {
        // instancia um objeto referente de uma entidade
        // declaracao de variaveis
        $obj = null;
        
        // tenta instanciar o objeto via resultado obtido do SQL
        try 
        {
            $obj = new SMUser($data[ProcessContext::decipher("username")], 
                               $data[ProcessContext::decipher("password")]);
        }catch(Exception $e) 
             {
                 echo "Error: " . $e->getMessage();
             }
        
        // retorno de valor
        return $obj;
    }

}