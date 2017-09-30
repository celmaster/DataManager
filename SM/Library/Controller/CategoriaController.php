<?php

/* Gerencia os dados das categorias de noticias
 * 
 * Marcelo Barbosa,
 * setembro, 2016.
 */

// importacao do autoload
require_once('../../autoload.php');

// importacao de classes
use SM\Configuration\SystemConfiguration;
use SM\Library\IO\Request;
use SM\Library\IO\Session;
use SM\Library\Database\CategoriaDAO;
use SM\Library\Model\Categoria;
use SM\Library\Interfaces\iController;

// declaracao da classe
class CategoriaController implements iController
{
    // declaracao de atributos
    private $categoria;
    private $operation;
    
    // declaracao de metodos
    public function __construct() 
    {
        // metodo construtor
        // obtem dados de parametros
        $nomeDaCategoria = Request::getParameter("categoria", "post");       
        
        $this->operation = Request::getParameter("operation", "post");
        $this->categoria = new Categoria($nomeDaCategoria);
    }
    
    private function save(Categoria $categoria)
    {
        // grava uma categoria no banco de dados
        // declaracao de variaveis
        $dao = new CategoriaDAO();
        $status = $dao->insert($categoria);        
        
        // verifica se a operacao foi realizada com sucesso
        if($status)
        {                  
            Session::set("message", "Categoria cadastrada com sucesso.");
            Session::set("type", "positiveMessage");
        }else
            {
                Session::set("message", "Erro ao cadastrar categoria.");
                Session::set("type", "negativeMessage");
            }
            
        // redireciona a navegacao do usuario    
        Session::set("redirect", "cadastrarCategoria.php"); 
        SystemConfiguration::letsgoByRoot("notice.php");
    }
    
    private function delete(Categoria $categoria)
    {
        // remove o registro de uma categoria
        // declaracao de variaveis
       $dao = new CategoriaDAO();
       $status = $dao->removeObject($categoria);
       
       // verifica se a operacao foi realizada com sucesso
       if($status)
        {                  
            Session::set("message", "Categoria removida com sucesso.");
            Session::set("type", "positiveMessage");
        }else
            {
                Session::set("message", "Erro ao remover categoria.");
                Session::set("type", "negativeMessage");
            }
            
        // redireciona a navegacao do usuario    
        Session::set("redirect", "gerenciarCategorias.php"); 
        SystemConfiguration::letsgoByRoot("notice.php");
    }
    
    private function update(Categoria $new, Categoria $old)
    {
        // atualiza os dados de uma categoria
        // declaracao de variaveis
        $dao = new CategoriaDAO();
        $status = $dao->updateObject($new, $old);
        
        // verifica se a operacao foi realizada com sucesso
        if($status)
        {                  
            Session::set("message", "Os dados da categoria foram atualizados com sucesso.");
            Session::set("type", "positiveMessage");
        }else
            {
                Session::set("message", "Erro ao atualizar dados da categoria.");
                Session::set("type", "negativeMessage");
            }
            
        // redireciona a navegacao do usuario        
        Session::set("redirect", "gerenciarCategorias.php"); 
        SystemConfiguration::letsgoByRoot("notice.php");
    }
        
    public function exec()
    {
        // executa uma operacao
        switch($this->operation)
        {
            case "save":
                $this->save($this->categoria);
            break;            
        
            case "delete":
                $this->delete($this->categoria);
            break;
        
            case "update":
                $this->update($this->categoria, new Categoria(Request::getParameter("nomeAntigoDaCategoria", "post")));
            break;
        }
    }
}

// instancia o controller para execucao
$controller = new CategoriaController();
$controller->exec();