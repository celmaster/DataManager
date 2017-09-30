<?php

/* Gerencia os dados das noticias
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
use SM\Library\Database\NoticiaDAO;
use SM\Library\Database\Context\Context;
use SM\Library\Database\Context\ContextElement;
use SM\Library\Model\Noticia;
use SM\Library\Utils\Tools\FileTool;
use SM\Library\Utils\ProcessContext;
use SM\Library\Utils\StringManager;
use SM\Library\Interfaces\iController;

// declaracao da classe
class NoticiaController implements iController
{
    // declaracao de atributos
    private $noticia;
    private $operation;
    
    // declaracao de metodos
    public function __construct() 
    {
        // metodo construtor
        // obtem dados de parametros        
        $id = Request::getParameter("id", "post");
        
        if($id == null)
        {
            $id = -1;
        }
        
        $titulo = Request::getParameter("titulo", "post");
        $categoria = Request::getParameter("categoria", "post");
        $emailDoAutor = Request::getParameter("emailDoAutor", "post");
        $texto = Request::getParameter("texto", "post");
        $ilustracao = FileTool::uploadfile("ilustracao");
        
        $this->operation = Request::getParameter("operation", "post");
        
        // refina o valor do parametro 'ilustracao'
        if(StringManager::equalsIgnoreCase( $this->operation, "update"))
        {
            // mantem a ilustracao atual da postagem caso nenhuma outra tenha sido enviada
            if($ilustracao == null)
            {
                $ilustracao = Request::getParameter("ilustracaoAntiga", "post");
            }
        }
        
        $this->noticia = new Noticia($titulo, 
                                     SystemConfiguration::getCurrentDate(), 
                                     SystemConfiguration::getCurrentTime(), 
                                     $categoria, 
                                     $emailDoAutor, 
                                     $texto, 
                                     $ilustracao,
                                     $id);
    }
    
    private function save(Noticia $noticia)
    {
        // grava uma noticia no banco de dados
        // declaracao de variaveis
        $dao = new NoticiaDAO();
        $status = $noticia->getIlustracao() != null;
        
        if($status)
        {
            $status &= $dao->insert($noticia);
        }
        
        // verifica se a operacao foi realizada com sucesso
        if($status)
        {                  
            Session::set("message", "Notícia postada com sucesso.");
            Session::set("type", "positiveMessage");
        }else
            {
                Session::set("message", "Erro ao postar notícia.");
                Session::set("type", "negativeMessage");
            }
            
        // redireciona a navegacao do usuario    
        Session::set("redirect", "postarNoticia.php"); 
        SystemConfiguration::letsgoByRoot("notice.php");
        
    }
    
    private function delete(Noticia $noticia)
    {
        // remove o registro de uma noticia
        // declaracao de variaveis
       $dao = new NoticiaDAO();       
       $context = new Context();
       $context->add(new ContextElement("id", $noticia->getId()));
       $status = $dao->remove(ProcessContext::getCondition($context), $context);
       
       // verifica se a operacao foi realizada com sucesso
       if($status)
        {                  
            Session::set("message", "Notícia removida com sucesso.");
            Session::set("type", "positiveMessage");
        }else
            {
                Session::set("message", "Erro ao remover notícia.");
                Session::set("type", "negativeMessage");
            }
            
        // redireciona a navegacao do usuario    
        Session::set("redirect", "gerenciarNoticias.php"); 
        SystemConfiguration::letsgoByRoot("notice.php");
    }
    
    private function update(Noticia $noticia)
    {
        // atualiza os dados de uma notícia
        // declaracao de variaveis
        $dao = new NoticiaDAO();
        
        $status = $noticia->getIlustracao() != null;
        
        if($status)
        {
             $status = $dao->updateObject($noticia);
        }
        
        // verifica se a operacao foi realizada com sucesso
        if($status)
        {                  
            Session::set("message", "Notícia atualizada com sucesso!");
            Session::set("type", "positiveMessage");
        }else
            {
                Session::set("message", "Falha ao tentar atualizar a notícia.");
                Session::set("type", "negativeMessage");
            }
            
        // redireciona a navegacao do usuario        
        Session::set("redirect", "gerenciarNoticias.php"); 
        SystemConfiguration::letsgoByRoot("notice.php");
    }
        
    public function exec()
    {
        // executa uma operacao
        switch($this->operation)
        {
            case "save":
                $this->save($this->noticia);
            break;            
        
            case "delete":
                $this->delete($this->noticia);
            break;
        
            case "update":
                $this->noticia->setData(Request::getParameter("dataDaPostagem", "post"));
                $this->noticia->setHora(Request::getParameter("horaDaPostagem", "post"));                
                $this->update($this->noticia);
            break;
        }
    }
}

// instancia o controller para execucao
$controller = new NoticiaController();
$controller->exec();