<?php

/* Gerencia os dados do usuario do BUSS
 * 
 * Marcelo Barbosa,
 * agosto, 2016.
 */

// importacao do autoload
require_once('../../autoload.php');

// importacao de classes
use SM\Configuration\SystemConfiguration;
use SM\Library\IO\Request;
use SM\Library\IO\Session;
use SM\Library\Database\UsuarioDAO;
use SM\Library\Database\Context\Context;
use SM\Library\Database\Context\ContextElement;
use SM\Library\Model\Usuario;
use SM\Library\Interfaces\iController;
use SM\Library\Utils\ProcessContext;

// declaracao da classe
class UsuarioController implements iController
{
    // declaracao de atributos
    private $user;
    private $operation;
    
    // declaracao de metodos
    public function __construct() 
    {
        // metodo construtor
        // obtem os parametros do usuario
        $email = Request::getParameter("email", "post");
        $senha = Request::getParameter("senha", "post");
        $nome = Request::getParameter("nome", "post");
        $sobrenome = Request::getParameter("sobrenome", "post");
        $descricao = Request::getParameter("descricao", "post");
        
        $this->operation = Request::getParameter("operation", "post");        
        $this->user = new Usuario($email, $senha, $nome, $sobrenome, $descricao);
    }
    
    private function save(Usuario $usuario)
    {
        // grava um usuario no banco de dados
        // declaracao de variaveis
        $dao = new UsuarioDAO();
        $dao->insert($usuario);        
        
        // vai para a tela do sistema principal
        SystemConfiguration::letsgoByRoot("mainSystem.php");
    }
    
    private function delete(Usuario $usuario)
    {
        // deleta os dados de um usuário
        // declaracao de variaveis
       $dao = new UsuarioDAO();
       $dao->removeObject($usuario);
    }
    
    private function update(Usuario $new, Usuario $old)
    {
        // atualiza os dados de um usuario
        // declaracao de variaveis
        $dao = new UsuarioDAO();
        $status = $this->validateUser($old) && $dao->updateObject($new, $old);
        
        if($status)
        {
            Session::set("email", $new->getEmail());
            Session::set("senha", $new->getSenha());            
            Session::set("message", "Dados de usuário atualizados com sucesso");
            Session::set("type", "positiveMessage");
        }else
            {
                Session::set("message", "Erro ao atualizar dados de usuário");
                Session::set("type", "negativeMessage");
            }
            
        Session::set("redirect", "usuario.php"); 
        SystemConfiguration::letsgoByRoot("notice.php");
    }
    
    private function login(Usuario $usuario)
    {
        // realiza o login do usuario
        if($this->validateUser($usuario))
        {
            Session::set("email", $usuario->getEmail());
            Session::set("senha", $usuario->getSenha());
            
            // vai para a pagina inicial do sistema
            SystemConfiguration::letsgoByRoot("mainSystem.php");
        }else
            {
                // vai para a tela de erro
                SystemConfiguration::letsgoByRoot("error.php");
            }
        
            
    }
    
    private function validateUser(Usuario $usuario)
    {
        // valida os dados de entrada do usuario desse framework
        // declaracao de variaveis
        $dao = new UsuarioDAO();
        $context = new Context();
        ;
        $context->add(new ContextElement("email", $usuario->getEmail(), true, false));
        $context->add(new ContextElement("senha", $usuario->getSenha(), false, true));
        
        return $dao->exists(ProcessContext::getCondition($context), $context);
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
                $this->update($this->user, new Usuario(Session::get("email"), Request::getParameter("senhaAntiga", "post")));
            break;
        }
    }
}

// instancia o controller para execucao
$controller = new UsuarioController();
$controller->exec();