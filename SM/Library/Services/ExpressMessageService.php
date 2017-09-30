<?php

/* Servico criado para gerenciar os dados da entidade ExpressMessage
 * 
 * Marcelo Barbosa,
 * outubro, 2016.
 */


// importacao do autoload
require_once('../../autoload.php');

// importacao de classes
use SM\Library\Database\ExpressMessageDAO;
use SM\Library\Database\Context\Context;
use SM\Library\Database\Context\ContextElement;
use SM\Library\Model\ExpressMessage;
use SM\Library\Utils\ProcessContext;
use SM\Library\Utils\Tools\DatabaseTool;
use SM\Library\IO\Request;
use SM\Configuration\SystemConfiguration;
use SM\Configuration\DbConfiguration;

// declaracao da classe
class ExpressMessageService
{
    // declaracao de atributos
    private $operation;    
    
    // declaracao de metodos
    public function __construct() 
    {
        // metodo construtor
        $this->operation = SystemConfiguration::getVerb();
    }
    
    private function post()
    {
        // faz a postagem de uma mensagem
        // declaracao de variaveis
        $senderAddress = Request::getParameter("senderAddress", "post");
        $receiverAddress = Request::getParameter("receiverAddress", "post");
        $dataContent = Request::getParameter("dataContent", "post");
        $status = false;
        $message = "false";
        
        $statement = ($senderAddress != null) && ($receiverAddress != null) && ($dataContent != null);
        
        if($statement)
        {
            $expressMessage = new ExpressMessage(SystemConfiguration::getCurrentDate(), 
                                                 SystemConfiguration::getCurrentTime(), 
                                                 $senderAddress, 
                                                 $receiverAddress, 
                                                 $dataContent);
            
            $expressMessageDAO = new ExpressMessageDAO();
            $status = $expressMessageDAO->insert($expressMessage);
        }
        
        // altera a mensagem
        if($status)
        {
            $message = "true";
        }
        
        // imprime o resultado da operacao
        echo $message;
    }
    
    private function delete()
    {
        // realiza a remocao de todas as mensagens que um dado emissor postou
        // declaracao de variaveis
        $status = false;
        $message = "false";
        $senderAddress = Request::getParameter("senderAddress", "post");

        // verifica se o endereco do emissor esta disponivel
        if($senderAddress != null)
        {
            // cria um contexto
            $context = new Context();
            $context->add(new ContextElement("senderAddress", $senderAddress, false, true));            

            // criacao do DAO
            $expressMessageDAO = new ExpressMessageDAO();

            // realiza a remocao
            $status = $expressMessageDAO->remove(ProcessContext::getCondition($context), $context);
        }

        // altera a mensagem
        if($status)
        {
            $message = "true";
        }
        
        // imprime o resultado da operacao
        echo $message;
    }
    
    private function get()
    {
        // obtem uma mensagem para um receptor caso ela exista
        // declaracao de variaveis
        $receiverAddress = Request::getParameter("receiverAddress", "post");
        $expressMessage = null;
        $expressMessageDAO = null;

        // verifica se o endereco do receptor esta disponivel
        if($receiverAddress != null)
        {
            // cria um contexto
            $context = new Context();
            $context->add(new ContextElement("receiverAddress", $receiverAddress, false, true));  
            
            // obtencao de dados            
            $expressMessageDAO = new ExpressMessageDAO();

            // obtencao da mensagem expressa
            $expressMessage = $expressMessageDAO->getObjectByCondition(ProcessContext::getCondition($context), $context);
        }

        // verifica se o objeto e diferente de nulo
        if($expressMessage != null)
        {
            // remove o registro da mensagem
            $expressMessageDAO->removeObject($expressMessage);

            // retorna os dados da mensagem em formato JSON
            echo ProcessContext::getContextToJSON($expressMessage->getContext());
        }else
            {
                // informa que o conteudo e nulo, indicando ausencia de mensagens
                echo "null";
            }  
    }
    
    public function execService()
    {
        // executa o servico        
        switch($this->operation)
        {
            case "/DELETE":     // remove todas as postagens que um emissor realizou
                $this->delete();
            break;

            case "/GET":        // obtem uma mensagem para um receptor
                $this->get();
            break;

            case "/POST":       // realiza a postagem de uma mensagem
                $this->post();
            break;
        
            case "/LIVE":
                if(DatabaseTool::hasTable("expressmessage", DbConfiguration::getDefaultConfiguration()))
                {
                    echo "true";
                }else
                    {
                        echo "false";
                    }                    
                    
            break;

            default:            // toda operacao invalida tem como resposta um valor nulo
                echo "false";
            break;    
        }
    }
    
}

// inicia o servico
$service = new ExpressMessageService();
$service->execService();
