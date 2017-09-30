<?php

/* Gerencia os dados do usuario do framework
 * 
 * Marcelo Barbosa,
 * agosto, 2016.
 */

// importacao do autoload
require_once('../../../autoload.php');

// importacao de classes
use SM\Configuration\SystemConfiguration;
use SM\Library\IO\Request;
use SM\Library\IO\Session;
use SM\Library\Database\SMUserDAO;
use SM\Library\Model\SMUser;
use SM\Library\Interfaces\iController;

// declaracao da classe
class SMUserController implements iController
{
    // declaracao de atributos
    private $user;
    private $operation;
    
    // declaracao de metodos
    public function __construct() 
    {
        // metodo construtor
        // obtem os parametros do usuario
        $username = Request::getParameter("username", "post");
        $password = Request::getParameter("password", "post");
        
        $this->operation = Request::getParameter("operation", "post");        
        $this->user = new SMUser($username, $password);
    }
    
    private function save(SMUser $user)
    {
        // grava um usuario no banco de dados
        // declaracao de variaveis
        $dao = new SMUserDAO();
        $dao->insert($user);        
        
        // vai para a tela de login
        SystemConfiguration::letsgo("index.php");
    }
    
    private function delete(SMUser $user)
    {
        // grava um usuario no banco de dados
        // declaracao de variaveis
        $dao = new SMUserDAO();
        $dao->removeObject($user);
    }
    
    private function update(SMUser $new, SMUser $old)
    {
        // atualiza os dados de um usuario
        // declaracao de variaveis
        $dao = new SMUserDAO();
        $status = $this->validateUser($old) && $dao->updateObject($new, $old);
        
        if($status)
        {
            Session::set("username", $new->getUsername());
            Session::set("password", $new->getPassword());            
            Session::set("message", "Dados de usuário atualizados com sucesso");
            Session::set("type", "positiveMessage");
        }else
            {
                Session::set("message", "Erro ao atualizar dados de usuário");
                Session::set("type", "negativeMessage");
            }
            
        Session::set("redirect", "main.php"); 
        SystemConfiguration::letsgo("notice.php");
    }
    
    private function login(SMUser $user)
    {
        // realiza o login do usuario
        if($this->validateUser($user))
        {
            Session::set("username", $user->getUsername());
            Session::set("password", $user->getPassword());
            
            // vai para a pagina inicial do sistema
            SystemConfiguration::letsgo("main.php");
        }else
            {
                // vai para a tela de erro
                SystemConfiguration::letsgo("error.php");
            }
            
    }
    
    private function validateUser(SMUser $user)
    {
        // valida os dados de entrada do usuario desse framework
        // declaracao de variaveis
        $dao = new SMUserDAO();
        return $dao->hasObject($user);
    }
    
    public function exec()
    {
        // executa uma operacao
        switch($this->operation)
        {
            case "save":
                $this->save($this->user);
            break;            
        
            case "delete":
                $this->delete($this->user);
            break;            
        
            case "login":
                $this->login($this->user);
            break; 
        
            case "update":
                $this->update($this->user, new SMUser(Session::get("username"), Request::getParameter("oldPassword", "post")));
            break;
        }
    }
}

// instancia o controller para execucao
$smUserController = new SMUserController();
$smUserController->exec();