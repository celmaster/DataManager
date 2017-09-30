<?php

/* Gerencia os dados das linhas de onibus
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
use SM\Library\Database\LinhaDAO;
use SM\Library\Database\Context\Context;
use SM\Library\Database\Context\ContextElement;
use SM\Library\Model\Linha;
use SM\Library\Interfaces\iController;
use SM\Library\Utils\TimeStamp;
use SM\Library\Utils\ProcessContext;

// declaracao da classe
class LinhaController implements iController
{
    // declaracao de atributos
    private $linha;
    private $operation;
    
    // declaracao de metodos
    public function __construct() 
    {
        // metodo construtor
        // declaracao de variaveis
        $timestamp = new TimeStamp();
        
        // obtem dados de parametros        
        $id = Request::getParameter("id", "post");
        $horarioDeIda = $timestamp->getStrTimeToSeconds(Request::getParameter("horarioDeIda", "post"));
        $horarioDeVolta = $timestamp->getStrTimeToSeconds(Request::getParameter("horarioDeVolta", "post"));
        $diaDaSemana = Request::getParameter("diaDaSemana", "post");
        $origem = Request::getParameter("origem", "post");
        $destino = Request::getParameter("destino", "post");
        
        $this->operation = Request::getParameter("operation", "post");
        $this->linha = new Linha($id, $horarioDeIda, $horarioDeVolta, $diaDaSemana, $origem, $destino);
    }
    
    private function save(Linha $linha)
    {
        // grava uma linha de onibus no banco de dados
        // declaracao de variaveis
        $dao = new LinhaDAO();        
        $status = ($linha->getHorarioDeIda() != -1) && ($linha->getHorarioDeVolta() != -1);
        
        if($status)
        {
            $status &= $dao->insert($linha);        
        }
        
        // verifica se a operacao foi realizada com sucesso
        if($status)
        {                  
            Session::set("message", "Linha de ônibus cadastrada com sucesso.");
            Session::set("type", "positiveMessage");
        }else
            {
                Session::set("message", "Erro ao cadastrar linha de ônibus.");
                Session::set("type", "negativeMessage");
            }
            
        // redireciona a navegacao do usuario    
        Session::set("redirect", "cadastrarLinha.php"); 
        SystemConfiguration::letsgoByRoot("notice.php");
        
    }
    
    private function delete(Linha $linha)
    {
        // remove o registro de uma linha de onibus
        // declaracao de variaveis
       $dao = new LinhaDAO();
       $context = new Context();
       $context->add(new ContextElement("id", $linha->getId()));
       $context->add(new ContextElement("horarioIda", $linha->getHorarioDeIda()));
       $context->add(new ContextElement("horarioVolta", $linha->getHorarioDeVolta()));
       $context->add(new ContextElement("diaDaSemana", $linha->getDiaDaSemana()));
       $status = $dao->remove(ProcessContext::getCondition($context), $context);
       
       // verifica se a operacao foi realizada com sucesso
       if($status)
        {                  
            Session::set("message", "Linha de ônibus removida com sucesso.");
            Session::set("type", "positiveMessage");
        }else
            {
                Session::set("message", "Erro ao remover linha de ônibus.");
                Session::set("type", "negativeMessage");
            }
            
        // redireciona a navegacao do usuario    
        Session::set("redirect", "gerenciarLinhas.php"); 
        SystemConfiguration::letsgoByRoot("notice.php");
    }
    
    private function update(Linha $new, Linha $old)
    {
        // atualiza os dados de uma linha de onibus
        // declaracao de variaveis
        $dao = new LinhaDAO();
        $status = ($new->getHorarioDeIda() != -1) && ($new->getHorarioDeVolta() != -1);
        
        if($status)
        {
            $status = $dao->updateObject($new, $old);
        }
        
        // verifica se a operacao foi realizada com sucesso
        if($status)
        {                  
            Session::set("message", "Os dados da linha de ônibus foram atualizados com sucesso.");
            Session::set("type", "positiveMessage");
        }else
            {
                Session::set("message", "Erro ao atualizar dados da linha de ônibus.");
                Session::set("type", "negativeMessage");
            }
            
        // redireciona a navegacao do usuario        
        Session::set("redirect", "gerenciarLinhas.php"); 
        SystemConfiguration::letsgoByRoot("notice.php");
    }
        
    public function exec()
    {
        // executa uma operacao
        // declaracao de variaveis
        $timestamp = new TimeStamp();
        switch($this->operation)
        {
            case "save":
                $this->save($this->linha);
            break;            
        
            case "delete":
                $this->delete($this->linha);
            break;
        
            case "update":
                
                $linhaAntiga = new Linha(Request::getParameter("idAntigo", "post"), 
                                         $timestamp->getStrTimeToSeconds(Request::getParameter("horarioDeIdaAntigo", "post")), 
                                         $timestamp->getStrTimeToSeconds(Request::getParameter("horarioDeVoltaAntigo", "post")), 
                                         Request::getParameter("diaDaSemanaAntigo", "post"));
                
                $this->update($this->linha, $linhaAntiga);
            break;
        }
    }
}

// instancia o controller para execucao
$controller = new LinhaController();
$controller->exec();