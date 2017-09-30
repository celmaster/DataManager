<?php

/* DAO criado para gerenciar a entidade "expressmessage"
 * 
 * Marcelo Barbosa,
 * setembro, 2016.
 */

// declaracao do namespace
namespace SM\Library\Database;

// importacao de classes
use SM\Configuration\DbConfiguration;
use SM\Library\Model\ExpressMessage;
use SM\Library\Utils\ProcessContext;

// declaracao de classe
class ExpressMessageDAO extends DAO
{
    // declaracao de metodos   
    public function __construct()
    {
        // metodo construtor
        $model = new ExpressMessage();
        parent::__construct(DbConfiguration::getDefaultConfiguration(),"expressmessage", $model->getContext(), 0, "sendDate, sendTime DESC");
    }
    
    protected function getObject($data)
    {
        // instancia um objeto referente de uma entidade
        // declaracao de variaveis
        $obj = null;
        
        // tenta instanciar o objeto via resultado obtido do SQL
        try 
        {
            $obj = new ExpressMessage($data["sendDate"], 
                                      $data["sendTime"], 
                                      $data[ProcessContext::decipher("senderAddress")], 
                                      $data[ProcessContext::decipher("receiverAddress")], 
                                      $data[ProcessContext::decipher("dataContent")]);
        }catch(Exception $e) 
             {
                 echo "Error: " . $e->getMessage();
             }
        
        // retorno de valor
        return $obj;
    }

}