<?php

/* Classe criada para modelar uma noticia 
 *
 * Marcelo Barbosa,
 * setembro, 2016.
 */

// declaracao do namespace
namespace SM\Library\Model;

// importacao de classes
use SM\Library\Generic\Generic;
use SM\Library\Database\Context\Context;
use SM\Library\Database\Context\ContextElement;
use SM\Library\Interfaces\IContextObject;

// declaracao da classe
class ExpressMessage extends Generic implements IContextObject
{
   // declaracao de atributos
    private $sendDate;                      // data de envio da mensagem
    private $sendTime;                      // horario de envio da mensagem
    private $senderAddress;                 // Address do emissor
    private $receiverAddress;               // Address do receptor
    private $dataContent;                   // conteudo da mensagem
   
    // declaracao de metodos
    public function __construct($sendDate = "", $sendTime = "", $senderAddress = "", $receiverAddress = "", $dataContent = "") 
    {
        // metodo construtor
        // inicializa a superclasse
        parent::__construct("ExpressMessage");
                
        // inicializa atributos
        $this->sendDate = $sendDate;
        $this->sendTime = $sendTime;
        $this->senderAddress = $senderAddress;
        $this->receiverAddress = $receiverAddress;
        $this->dataContent = $dataContent;
    }    
    
    // metodos de encapsulamento
    public function setSendDate($sendDate)
    {
        $this->sendDate = $sendDate;
    }
    
    public function getSendDate()
    {
        return $this->sendDate;
    }
    
    public function setSendTime($sendTime)
    {
        $this->sendTime = $sendTime;
    }
    
    public function getSendTime()
    {
        return $this->sendTime;
    }
    
    public function setSenderAddress($senderAddress)
    {
        $this->senderAddress = $senderAddress;
    }
    
    public function getSenderAddress()
    {
        return $this->senderAddress;
    }
    
    public function setReceiverAddress($receiverAddress)
    {
        $this->receiverAddress = $receiverAddress;
    }
    
    public function getReceiverAddress()
    {
        return $this->receiverAddress;
    }
    
    public function setDataContent($dataContent)
    {
        $this->dataContent = $dataContent;
    }
    
    public function getDataContent()
    {
        return $this->dataContent;
    }
    
    public function getContext() 
    {
        // retorna o contexto da classe
        // declaracao de variaveis
        $context = new Context();
        $context->add(new ContextElement("sendDate", $this->getSendDate(), true));
        $context->add(new ContextElement("sendTime", $this->getSendTime(), true));
        $context->add(new ContextElement("senderAddress", $this->getSenderAddress(), true, true));
        $context->add(new ContextElement("receiverAddress", $this->getReceiverAddress(), true, true));
        $context->add(new ContextElement("dataContent", $this->getDataContent(), false, true));
        
        // retorno de valor
        return $context;
    }
    
    
    public function toString() 
    {
         // retorna todos os dados da classe em uma string
        return "<br>Sender's Address: " . $this->getSenderAddress()
             . "<br>Receiver's Address: " . $this->getReceiverAddress()
             . "<br>Send date: " . $this->getSendDate()
             . "<br>Send time: " . $this->getSendTime()
             . "<br>Data content: " . $this->getDataContent() . "<br>";
    }
}