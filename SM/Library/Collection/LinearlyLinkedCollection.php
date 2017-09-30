<?php

/* Classe abstrata criada para modelar o conceito de estrutura de dados generica
 * com encadeamento linear.
 * 
 * Marcelo Barbosa,
 * janeiro, 2017.
 */

// declaracao do namespace
namespace SM\Library\Collection;

// importacao de classes
use SM\Library\Generic\Generic;
use SM\Library\Model\Indexable;

// declaracao da classe
abstract class LinearlyLinkedCollection extends Collection
{
    // declaracao de atributos
    protected $end;
    
    public function __construct($isAutoIncrement = true, $objectName = "LinearlyLinkedCollection")
    {
        // metodo construtor
        // inicializa a superclasse
        parent::__construct($isAutoIncrement, $objectName);
        
        // inicializa demais atributos
        $this->end = null;
    }
    
    public function add(Element $element, $isAutoIncrement = true)
    {
        // insere um elemento na estrutura de dados        
        if($this->getIsAutoIncrement())
        {
            // utiliza um indice de auto incremento como chave do elemento            
            $element->setKey($this->getIndex());            
            $this->setIndex($this->getIndex() + 1);
        }
        
        // verifica se o elemento a ser inserido implementa a interface de indexacao
        if(is_object($element->getData()))
        {
            if($element->getData() instanceof Indexable)
            {
                $element->getData()->setIndex($element->getKey());
            }
        }
        
        $this->insert($element->getData(), $element->getKey());         
    }
    
    public function get($index = 1)
    {
        // obtem um objeto por seu indice
        // declaracao de variaveis
        $obj = null;

        // verifica se a estrutura de dados nao esta vazia
        if(!$this->isEmpty())
        {
            if($index <= $this->getSize())
            {
                // cria uma variavel de controle para o laco de repeticao
                $pointer = 1;
                $obj = $this->root;

                while(($obj !== null) && ($pointer != $index))
                {
                    $obj = $obj->getNext();                        
                    $pointer++;
                }
            }
        }

        // retorno de valor
        return $obj->getElement();

    }
    
    // declaracao de metodos
    abstract public function insert($data, $key);

    // metodos de manipulacao de dados    
    protected function compare($value1, $value2)
    {
        // compara o valor de dois objetos
        // declaracao de variaveis
        $status = false;
        
        if(!is_object($value1) && !is_object($value2))
        {
            if($value1 == $value2)
            {
                $status = true;
            }
        }else
            {
                if(($value1 instanceof Generic) &&
                   ($value2 instanceof Generic))
                {
                    $status = $value1->equals($value2);
                }
            }
        
        // retorno de valor
        return $status;
    }
    
    protected function getElementPropertyValue(Element $element, $type)
    {
        // recupera o valor de uma propriedade de um no
        // declaracao de variaveis
        $value = null;
        if($type == 1)
        {
            $value = $element->getData();
        }else
            {
                $value = $element->getKey();
            }
            
        // retorno de valor    
        return $value;
    }
        
    protected function getNode($search, $typeSearch = 1)
    {
        // recupera um no atraves de seu valor (1) ou chave (2)        
        // declaracao de variaveis
        $node = null;
        
        // verifica se a estrutura de dados nao esta vazia        
        if(!$this->isEmpty())
        {
            // verifica se esta no inicio da estrutura de dados  
            $list = $this->root;
            $value = $this->getElementPropertyValue($list->getElement(), $typeSearch);
            
            if($this->compare($search, $value))
            {
                $node = $list;
            }
            
            // verifica se esta no meio ou no fim da estrutura de dados
            if($node === null)
            {
                $list = $list->getNext();
                
                while($list !== null)
                {
                    $value = $this->getElementPropertyValue($list->getElement(), $typeSearch);
                    if($this->compare($search, $value))
                    {
                        $node = $list;
                        break;
                    }
                    
                    $list = $list->getNext();
                }
            }
            
        }
        
        // retorno de valor
        return $node;
    }
    
    public function select($lineStyle = "<br>", $reverse = false) 
    {
        // seleciona todos os elementos da estrutura e os armazena em uma string
        // declaracao de variaveis
        $result = "";
        
        if(!$this->isEmpty())
        {            
            // verifica se a ordem de selecao sera crescente ou decrescente
            if(!$reverse)
            {
                $node = $this->root;
            }else
                {
                    $node = $this->end;
                }
                
                while($node != null)
                {
                    if(is_object($node->getElement()->getData()))
                    {
                        $result .= $node->getElement()->getData()->toString();
                    }else
                        {
                             $result .= $node->getElement()->getData();
                        }
                    
                        if(!$reverse)
                        {
                            $node = $node->getNext();
                        }else
                            {
                                $node = $node->getPrior();
                            }
                            
                     // aplica o estilo de linha caso o proximo elemento nao seja nulo
                     if($node != null)
                     {
                         $result .= $lineStyle;
                     }
                }
        }
        
        // retorno de valor
        return $result;
    }
    
    public function update(Element $element)
    {
        // atualiza um elemento da estrutura de dados atraves do valor de sua chave
        // declaracao de variaveis
        $status = false;
        
        //verificando se a estrutura de dados nao esta vazia
        if(!$this->isEmpty())
        {
            $key = $element->getKey();            
            $obj = $this->getNode($key, 2);
            
            if($obj !== null)
            {
                $node = &$obj;
                $node->setElement($element);                
                
                // altera o valor da variavel logica
                $status = true;
            }
        }
        
        // retorno de valor
        return $status;            
    }
    
    public function getKeyOf($data)
    {
        // obtem um elemento atraves de seu valor
        // declaracao de variaveis
        $obj = $this->getNode($data);
        $key = null;
        
        if($obj !== null)
        {
           $key = $obj->getElement()->getKey();
        }
        
        //retorno de valor
        return $key;
    }
    
    public function getByKey($key)
    {
        // obtem um elemento atraves de sua chave
        // declaracao de variaveis
        $obj = $this->getNode($key, 2);
        $element = null;
                
        if($obj !== null)
        {
           $element = $obj->getElement();
        }
        
        //retorno de valor
        return $element;
    }
    
    public function contains($data)
    {
        // verifica se um elemento existe
        // declaracao de variaveis
        $status = false;
        
        // altera o valor da variavel logica
        if($this->getKeyOf($data) !== null)
        {
            $status = true;
        }
        
        // retorno de valor
        return $status;
    }
    
    public function toArray() 
    {
        // retorna um array com todos os elementos da estrutura de dados
        // declaracao de variaveis        
        $array = null;
        
        // verifica se a estrutura de dados esta vazia
        if(!$this->isEmpty())
        {
            // pega o primeiro elemento da estrutura de dados
            $element = $this->root;
            
            while($element !== null)
            {
                $arrayList[] = $element->getElement();
                $element = $element->getNext();
            }
            
            $array = $arrayList;
        }        
        
        // retorno de valor
        return $array;
    }
    
    public function toString()
    {
        // passa todo o conteudo da estrutura de dados para uma string
        // declaracao de variaveis
        $stringValue = "";          

        // verificando se a estrutura de dados possui objetos            
        if(!$this->isEmpty())
        {   
            // pegando o primeiro no da estrutura de dados
            $node = $this->root;

            // percorrendo os dados da estrutura de dados
            do
            { 
                // verifica se o valor do objeto e uma instancia
                if(is_object($node->getElement()->getData()))
                {
                    $stringValue .= "<br> Object's value: <br>"
                            . "&nbsp;&nbsp;&nbsp;"
                            . "<div style='margin-left:50px; border: 1px solid; border-radius: 3px; padding: 2px;'>"
                            . "<b>". Collection::objectToString($node->getElement()->getData())
                            . "</b></div><br> Key: &nbsp;<b>".$node->getElement()->getKey()."</b><br><br>";
                }else 
                    {
                        // gravando os dados na string de retorno
                        $stringValue .= "<br> Object's value: "
                                . "&nbsp;&nbsp;&nbsp;<b>".$node->getElement()->getData()
                                ."</b><br> Key: &nbsp;<b>".$node->getElement()->getKey()."</b><br><br>";
                    }

                // pegando o proximo objeto
                $node = $node->getNext();

            }while(isset($node));

        }else
            {
                $stringValue = "Empty!";
            }

        // inserindo a quantidade de itens na string de retorno
        $stringValue .= "<br><br>"
                . "<hr style='width:100%' noshade size='0.5' color='black'>"
                . "<br>Size: &nbsp;<b>".$this->getSize()."</b> object(s) in " . $this->getObjectName() . "<br>";    

        // retorno de valor
        return $stringValue;
    } 
}

