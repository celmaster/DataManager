<?php
/*
 * Classe criada para gerar uma lista dinamica de elementos em um array
 * 
 * Marcelo Barbosa.
 * dezembro, 2013.
 */

// declaracao do namespace
namespace SM\Library\Collection;

// importacao de classes
use SM\Library\Utils\Tools\CollectionTool;

// declaracao da classe
class LinkedList extends LinearlyLinkedCollection
{    
    // declaracao de metodos
    public function __construct($isAutoIncrement = true, $objectName = "LinkedList")
    {
        // metodo construtor
        // inicializa a superclasse
        parent::__construct($isAutoIncrement, $objectName);                
    } 

    // metodos de aplicacao
    public function insert($data, $key)
    {
        // insere um objeto na estrutura de dados            
        // declaracao de variaveis
        $status = false;
        $element = new Element($data, $key);
        
        try
        {
            $node = new Node($element);

            // verificando se a estrutura esta vazia
            if($this->isEmpty())
            { 
                // insere o elemento no inicio da estrutura
                $this->root = $node;
                $this->end = $this->root;
                
            }else
                {
                    // insere o elemento no inicio da lista caso tenha chave menor que o elemento atual
                    if($this->root->getElement()->getKey() > $node->getElement()->getKey())
                    {
                        $node->setNext($this->root);
                        $this->root->setPrior($node);
                        $this->root = $node;
                    }else
                        {
                            // pega o inicio da lista
                            $list = $this->root;
                        
                            // procura a posicao de insercao do elemento na lista
                            while(($list->getNext() !== null) && ($list->getNext()->getElement()->getKey() <= $node->getElement()->getKey()))
                            {
                                $list = $list->getNext();
                            }
                            
                            // faz os ajustes entre os ponteiros direcionais
                            $node->setNext($list->getNext());                            
                            
                            if($list->getNext() !== null)
                            {
                                $list->getNext()->setPrior($node);
                            }
                            
                            $node->setPrior($list);
                            $list->setNext($node);
                            
                            // ajusta o ponteiro para o ultimo elemento
                            if($this->end->getElement()->getKey() < $node->getElement()->getKey())
                            {
                                $this->end = $node;
                            }                            
                        }
                        
                    // altera o valor da variavel logica
                    $status = true;
                }

            // incrementando o contador
            $this->setSize($this->getSize() + 1);
            
        }catch(\Exception $e)
            {
                echo $e->getMessage();
            }
            
        // retorno de valor
        return $status;
    } 
    
    public function removeFirst()
    {
        // remove o primeiro objeto da lista 
        // declaracao de variaveis
        $status = false;
        $node;
        $next;

        // verificando se a lista esta vazia
        if(!$this->isEmpty())
        {
            // pegando o elemento a ser removido
            $node = &$this->root;

            // pegando o proximo no
            $next = $node->getNext();

            // verificando se o proximo no e vazio
            if($next !== null)
            {    
                $this->root = $next;

                // deletando o elemento
                CollectionTool::removeNode($node); 
            }else
                {
                    unset($this->root);

                    // pegando um novo bloco de memoria
                    $this->root = new Node();
                }

            // decrementando o contador
            $this->setSize($this->getSize() - 1);
            
            // altera o valor da variavel logica
            $status = true;

        }else
            {     
                echo "<br>Can't delete object! LinkedList is empty!<br>";

            }
            
        // retorno de valor
        return $status;
    }

    public function remove($key)
    {
        // remove um elemento pela sua chave
        // declaracao de variaveis
        $status = false;
        
        // verificando se a lista esta vazia
        if(!$this->isEmpty())
        {
            // o elemento a ser removido esta no primeiro no da lista
            if($this->compare($key, $this->root->getElement()->getKey()))
            {
                $this->removeFirstObject();
                
                // altera o valor da variavel logica
                $status = true;
            }else
                {
                    // o elemento a ser removido esta no meio ou final da lista
                    $obj = $this->getNode($key, 2);            

                    if($obj !== null)
                    {                
                        // ajusta os ponteiros
                        $node = &$obj;
                        $prior = $node->getPrior();
                        $next = $node->getNext();
                        $prior->setNext($next);

                        if($next !== null)
                        {
                            $next->setPrior($prior);
                        }else
                            {
                                $this->end = $prior;
                            }

                        // remove o elemento
                        CollectionTool::removeNode($node);

                        // decrementa o numero de elementos da lista
                        $this->setSize($this->getSize() - 1);

                         // altera o valor da variavel logica
                         $status = true;
                    }
                }            
        }
            
        // retorno de valor
        return $status;
    }    

    public function removeObject(Element $element)
    {
        // remove um objeto por comparacao de enderecos
        // declaracao de variaveis
        $status = $this->remove($element->getKey());
        
        // retorno de valor
        return $status;
    }
    
} 