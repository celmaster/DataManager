<?php
/* Classe criada para gerar uma fila dinamica de elementos.
 * 
 * Marcelo Barbosa.
 * dezembro, 2013.
*/

// declaracao do namespace
namespace SM\Library\Collection;

// importacao de classes
use SM\Library\Utils\Tools\CollectionTool;

// declaração de classes
class Queue extends LinearlyLinkedCollection
{
    // declaração de métodos        
    public function __construct($isAutoIncrement = true, $objectName = "Queue") 
    {
        // método construtor
        // inicializa a superclasse
        parent::__construct($isAutoIncrement, $objectName);
        
        // inicializacao de atributos        
        $this->end = $this->root;
    }
    
    
    // metodos de manipulacao de dados
    public function insert($data, $key) 
    {
        // insere um elemento na fila
        // declaracao de variaveis
        $element = new Element($data, $key);
        
        // verifica se a fila esta vazia
        if($this->isEmpty())
        {
            // insere o elemento no inicio da fila
            $this->root = new Node($element);
            $this->end = $this->root;
        }else 
            {
                // cria um novo no e insere ele no final da fila
                $node = new Node($element);

                $node->setPrior($this->end);
                $this->end->setNext($node);
                $this->end = $node;
            }
            
        // incrementa o contador    
        $this->setSize($this->getSize() + 1);
    }
    
    public function removeFirst() 
    {
        // remove o primeiro elemento da fila através da caracteristica FIFO
        // declaracao de variaveis            
        $status = false;
        
        // verifica se a fila possui elementos        
        if(!$this->isEmpty())
        {
            $next = $this->root->getNext();
            if($next === null)
            {
                CollectionTool::removeNode($this->root);
                $this->root = null;
                $this->end = $this->root;
            }else
                {
                    $prior = $this->root->getPrior();
                    $next->setPrior($prior);                    
                    CollectionTool::removeNode($this->root);
                    $this->root = $next;
                }
            
            // decrementa o numero de elementos da fila
            $this->setSize($this->getSize() - 1);
            
            // altera o valor da variavel logica
            $status = true;
        }
        
        // retorno de valor
        return $status;
    }

}