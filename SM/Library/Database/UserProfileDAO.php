<?php

/* DAO criado para gerenciar a entidade "userProfile"
 * 
 * Marcelo Barbosa,
 * setembro, 2016.
 */

// declaracao do namespace
namespace SM\Library\Database;

// importacao de classes
use SM\Configuration\DbConfiguration;
use SM\Library\Model\UserProfile;

// declaracao de classe
class UserProfileDAO extends DAO
{
    // declaracao de metodos   
    public function __construct()
    {
        // metodo construtor
        $model = new UserProfile();
        parent::__construct(DbConfiguration::getBUSSConfiguration(),"userProfile", $model->getContext(), 0, "environmentGroupAddress");
    }
    
    protected function getObject($data)
    {
        // instancia um objeto referente de uma entidade
        // declaracao de variaveis
        $obj = null;
        
        // tenta instanciar o objeto via resultado obtido do SQL
        try 
        {
            $obj = new UserProfile($data["abilityToSee"], 
                                   $data["fontSize"], 
                                   $data["graphicalElementSize"],
                                   $data["interest"], 
                                   $data["environmentGroupAddress"], 
                                   $data["timeOfOccurrence"]);
        }catch(Exception $e) 
             {
                 echo "Error: " . $e->getMessage();
             }
        
        // retorno de valor
        return $obj;
    }

}