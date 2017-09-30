<?php
/* Classe que modela o conceito de colecao multilinear para estrutura de dados do tipo arvore
 *
 * Marcelo Barbosa, 
 * maio, 2017.
 */

// declaracao do namespace
namespace SM\Library\Collection;

// importacao de classes
use SM\Library\Model\Indexable;

// declaracao da classe
class Tree extends Collection
{
    // declaracao de atributos
    private $order;
    
    // declaracao de metodos
    public function __construct($isAutoIncrement = false, $objectName = "Tree", $order = 0) 
    {
        // metodo construtor
        // inicializa a superclasse
        parent::__construct($isAutoIncrement, $objectName);
        
        // inicializa os atributos
        $this->order = $order;
    }
    
    public function setOrder($order)
    {
        if(($order >= 0) && ($order < 3))
        {
            $this->order = $order;
        }else
            {
                $this->order = 0;
            }
    }
    
    public function getOrder()
    {
        return $this->order;
    }
    
    private function correctBalanceFactor(&$node)
    {
        // calcula o fator de balanceamento do no atual pela diferenca das alturas dos nos filhos, esquerdo e direito
	if($node != NULL)
	{
            // calculando o indice de variação do balanceamento
            $node->setBalanceFactor($this->height($node->getNext()) - $this->height($node->getPrior()));

            // realiza a chamada recursiva para atualizar o valor da variação do balanceamento de cada nó da árvore em pré-ordem
            $this->correctBalanceFactor($node->prior);
            $this->correctBalanceFactor($node->next);
	}
    }
    
    public function getNode(Element $element)
    {
        // obtem um no a partir da raiz da estrutura de dados
        // declaracao de variaveis
        $node = $this->root;				

        while(($node != NULL) && ($node->getElement()->getKey() != $element->getKey()))
        {	
            if($element->getKey() < $node->getElement()->getKey())
            {
                $node = $node->getPrior();
            }else if($element->getKey() > $node->getElement()->getKey())
                  {
                      $node = $node->getNext();
                  }			
        }

        // retorno de valor
        return $node;
    }
    
    private function height($node)
    {
        // calcula a altura de uma arvore/subarvore
        // declaracao de variaveis
        $leftHeight = 0;
        $rightHeight = 0;

        // incrementa a altura da arvore para cada nivel visitado durante a chamada recursiva
        if($node != NULL)
        {
            // caso o no avaliado nao haja filhos, retorna 1
            if(($node->getPrior() == NULL) && ($node->getNext() == NULL))
            {
                return 1;
            }else
                {
                    // faz a chamada recursiva calculando a altura das subarvores, esquerda e direita
                    $leftHeight = 1 + $this->height($node->getPrior());
                    $rightHeight = 1 + $this->height($node->getNext());

                    // retorna o valor que corresponde a altura real da arvore/subarvore
                    if($leftHeight > $rightHeight)
                    {
                        return $leftHeight;
                    }else
                        {
                            return $rightHeight;
                        }
                }
        }else
            {
                return 0;
            } 	

    }
    
    public function getHeight()
    {
        // calcula a altura da arvore
 	
 	// retorno de valor
        return $this->height($this->root);
    }
    
    public function getElementBytGreatKeyValue($node)
    {
       // retorna o elemento de maior chave
       while($node->getNext() != NULL)
       {
            $node = $node->getNext();
       }

       // retorno de valor
       return $node;
    }
    
    private function llRotation(&$node, &$unbalance)
    {
        // realiza a rotacao esquerda-esquerda
        // declaracao de variaveis  	
        $son;

        // rotaciona os ponteiros dos nos esquerdos da sub-arvore 
        $son = $node->prior;
        $node->prior = $son->next;
        $son->next = $node;
        $node = $son;

        // zera os valores do indice de balanceamento dos nos da sub-arvore.
        $son->setBalanceFactor(0);
        $node->setBalanceFactor(0);

        // altera o valor da variavel logica
        $unbalance = false;
    }
    
    private function rrRotation(&$node, &$unbalance)
    {
        // realiza a rotacao direita-direita
        // declaracao de variaveis 	
        $son;

        // rotaciona os ponteiros dos nos esquerdos da sub-arvore 
        $son = $node->next;
        $node->next = $son->prior;
        $son->prior = $node;
        $node = $son;

        // zera os valores do indice de balanceamento dos nos da sub-arvore.
        $son->setBalanceFactor(0);
        $node->setBalanceFactor(0);

        // altera o valor da variavel logica
        $unbalance = false;
    }
    
    private function lrRotation(&$node, &$unbalance)
    {
        // realiza a rotacao esquerda-direita
        // declaracao de variaveis
        $son;
        $grandson;

        // rotacionando os valores dos nos em sentido esquerda-direita da sub-arvores
        $son = $node->prior;
        $grandson = $son->next;
        $son->next = $grandson->prior;
        $grandson->prior = $son;
        $node->prior = $grandson->next;
        $grandson->next = $node;

        // colocando o no neto como no raiz da sub-arvore
        $node = $grandson;
        $node->setBalanceFactor(0);

        // ajustando o balanceamento do no raiz da sub-arvore.
        $this->correctBalanceFactor($node->prior);
        $this->correctBalanceFactor($node->next);

        // altera o valor da variavel logica, pois e falso que o no da raiz esteja desbalanceado
        $unbalance = false;
    }
    
    private function rlRotation(&$node, &$unbalance)
    {
        // realiza a rotacao direita-esquerda
        // declaracao de variaveis
        $son;
        $grandson;

        // rotacionando os valores dos nos em sentido esquerda-direita da sub-arvores
        $son = $node->next;
        $grandson = $son->prior;
        $son->prior = $grandson->next;
        $grandson->next = $son;
        $node->next = $grandson->prior;
        $grandson->prior = $node;

        // colocando o no neto como no raiz da sub-arvore
        $node = $grandson;
        $node->setBalanceFactor(0);

        // ajustando o balanceamento do no raiz da sub-arvore.
        $this->correctBalanceFactor($node->prior);
        $this->correctBalanceFactor($node->next);

        // altera o valor da variavel logica, pois e falso que o no da raiz esteja desbalanceado
        $unbalance = false;
    }
    
    private function balance(&$node, &$unbalance)
    {
        // realiza o balanceamento da arvore 	
        // declaracao de variaveis
        $son;	

        if($unbalance)
        {
            // filtrando as acoes a serem tomadas caso haja necessidade de rebalanceamento
            switch($node->getBalanceFactor())
            {
                case 2:	// rebalancear a arvore a direita

                    // pegando o no filho
                    $son = $node->next;								

                    // balanceamento com rotacao simples DD(direita-direita)
                    if(($son->next != NULL) && ($son->prior == NULL))
                    {
                        $this->rrRotation($node, $unbalance);
                    }else
                        {
                            // balanceamento com rotacao dupla DE(direita-esquerda)
                            $this->rlRotation($node, $unbalance);
                        }
                break;			

                case -2: // rebalancear a arvore a esquerda

                    // pegando o no filho
                    $son = $node->prior;

                    // balanceamento com rotacao simples EE(esquerda-esquerda)
                    if(($son->prior != NULL) && ($son->next == NULL))
                    {
                        $this->llRotation($node, $unbalance);
                    }else
                        {
                            // balanceamento com rotacao dupla ED(esquerda-direita)
                            $this->lrRotation($node, $unbalance);
                        }
                break;
            }		
        }
    }
    
    public function hasKey($key)
    {
        // verifica se um elemento existe por meio de sua chave
        // declaracao de variaveis
        $element = new Element();
        $element->setKey($key);

        $node = $this->getNode($element);

        if($node != NULL)
        {
            return true;
        }else
            {
                return false;
            }
    }
    
    public function getByKey($key)
    {
        // verifica se um elemento existe por meio de sua chave
        // declaracao de variaveis
        $element = new Element();
        $element->setKey($key);

        $node = $this->getNode($element);

        if($node != NULL)
        {
            $element = $node->getElement();
        }

        // retorno de valor
        return $element;
    }
    
    public function add(Element $element)
    {
        // adiciona um elemento a estrutura de dados
        // declaracao de variaveis
        $success = false;
        $unbalance = false;
        
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
                
        $this->insert($this->root, $element, $unbalance, $success);
        
        //retorno de valor
        return $success;
    }
    
    public function insert(&$node, $element, &$unbalance, &$success)
    {
        // adiciona um elemento na arvore
        // declaracao de variaveis
        $leaf;

        // inicializa o valor da variavel logica
        $success = false;

        try
        {
            // insere o novo elemento como uma folha da arvore
            if($node == NULL) 
            {
                $leaf = new Node($element);

                // faz o no da arvore apontar para a folha
                $node = $leaf;

                // altera o valor da variavel logica
                $success = true;

                // incrementa a quantidade de elementos da arvore
                $this->setSize($this->getSize() +1);		

            }else
                {				
                    // faz a chamada recursiva fazendo com que o metodo navegue pelas subarvores direita ou esquerda
                    if($node->getElement()->getKey() < $element->getKey())
                    {	
                        // verifica se mudou a altura
                        if(($node->getPrior() == NULL) && ($node->getNext() == NULL))
                        {
                            $unbalance = true;
                        }	

                        $this->insert($node->next, $element, $unbalance, $success);

                    }else if($node->getElement()->getKey() > $element->getKey())
                          {	
                              // verificando se mudou a altura
                              if(($node->getPrior() == NULL) && ($node->getNext() == NULL))
                              {
                                  $unbalance = true;
                              }

                              // realiza a chamada recursiva
                              $this->insert($node->prior, $element, $unbalance, $success);
                          }				  
                }

            // atualiza o valor do fator de balanceamento de cada raiz de sub-arvore
            $this->correctBalanceFactor($node);

            // balanceia os nos
            $this->balance($node, $unbalance);

        }catch(\Exception $e)
            {
                echo "Exception: " . $e->getMessage();
            } 
    }

    public function removeFirst() 
    {
        // remove a raiz da arvore
       
        // retorno de valor
        return $this->remove($this->root->getElement()->getKey());
       
    }
    
    public function remove($key)
    {
        // remove um elemento da arvore por meio de sua chave
        // declaracao de variaveis        
        $success = false;
        
        $this->deleteNode($this->root, new Element(null, $key), $success);
        
        // retorno de valor
        return $success;
    }
    
    private function deleteNode(&$node, $element, &$success)
    {
           // remove um elemento da arvore
           // declaracao de variaveis
           $leaf = NULL;	
           $auxiliaryLeaf = NULL;
           $unbalance = false;

           // inicializa a variavel logica
           $success = false;

           // caso o no nao seja nulo, verifica se achou o elemento a ser deletado
           if($node != NULL)
           {
               // primeiro caso: a chave procurada e encontrado
               if($node->getElement()->getKey() == $element->getKey())
               {
                    // possiveis situacoes:
                    if(($node->prior == NULL)	&& ($node->next == NULL))
                    {
                        // primeiro caso: o no buscado eh uma folha e nao possui nenhum filho

                        // remove o bloco de memoria encontrado
                        unset($node);
                        $node = NULL;

                        // alterando o valor da variavel logica
                        $success = true;				

                        // decrementa a quantidade de elementos
                        $this->setSize($this->getSize() - 1);

                    }else if(($node->prior != NULL) && ($node->next != NULL))
                           {
                                // o no buscado eh uma subarvore e possui 2 filhos

                                // pega o maior no a esquerda do no encontrado para substitui-lo
                                $leaf = $node->prior;
                                $auxiliaryLeaf = $node;

                                // aqui, o bloco de memoria em remocao tem seu valor alterado com o maior no direito da sub-arvore a sua esquerda.
                                $newNode = $this->getElementBytGreatKeyValue($leaf);
                                $node->setElement($newNode->getElement());

                                // removendo o bloco de nó copiado para evitar duplicidade de dados.
                                $this->deleteNode($auxiliaryLeaf->prior, $leaf->getElement(), $success);

                           }else
                                {
                                    // o no buscado eh uma subarvore e possui 1 filho
                                    if($node->prior == NULL)
                                    {
                                        // apaga o bloco de memoria encontrado							  
                                        $leaf = $node;
                                        $node = $node->next;
                                        unset($leaf);						  

                                        // alterando o valor da variavel logica
                                        $success = true;				

                                        // decrementa a quantidade de elementos
                                        $this->setSize($this->getSize() - 1);

                                    }else
                                        {
                                            $leaf = $node;
                                            $node = $node->prior;
                                            unset($leaf);

                                             // alterando o valor da variavel logica
                                             $success = true;				

                                             // decrementa a quantidade de elementos
                                             $this->setSize($this->getSize() - 1);
                                        }	
                                }				

               }else if($node->getElement()->getKey() > $element->getKey())				
                       {
                           // segundo caso: a chave do no buscado eh menor do que o valor da chave do no atual

                           // chamada recursiva
                           $this->deleteNode($node->prior, $element, $success);

                       }else
                           {
                               // terceiro caso: a chave do no buscado eh maior do que o valor da chave do no atual

                               // chamada recursiva
                               $this->deleteNode($node->next, $element, $success);
                           }

                       // verifica se houve desbalanceamento na arvore
                       if(($node != NULL) && $success)
                       {				
                           // fixa o novo fator de balanceamento do no atual.
                           $this->correctBalanceFactor($node);

                           // verificando se ha necessidade de balancear o no
                           if(($node->getBalanceFactor() == 2) || ($node->getBalanceFactor() == -2))
                           {
                                   $unbalance = true;
                                   $this->balance($node, $unbalance);
                           }
                       }
           }
    }
    
    public function select($node, $lineStyle = "")
    {
        // coloca os dados de uma arvore/subarvore em uma string, podendo estarem em pre-ordem (0), ordem(1), pos-ordem(2)
 	// declaracao de variaveis
 	$out = ""; 	 	
        
 	if($node != NULL)
 	{
            $data = "" . $node->getElement()->getData() . $lineStyle;
            
            switch($this->getOrder())
            {
                case 0: // ordem 				
                    $out .= $data . $this->select($node->getPrior(), $lineStyle) . $this->select($node->getNext(), $lineStyle);
                break;	

                case 1: // pre-ordem
                    $out .= $this->select($node->getPrior(), $lineStyle) . $data . $this->select($node->getNext(), $lineStyle);
                break;	

                case 2: // pos-ordem
                    $out .= $this->select($node->getNext(), $lineStyle) . $data . $this->select($node->getPrior(), $lineStyle);
                break;	
            }
	}
	
	// retorno de valor
	return $out;
    }
    
    public function update(Element $element)
    {
        // atualiza um elemento da estrutura de dados atraves do valor de sua chave
        // declaracao de variaveis
        $status = false;
        
        //verificando se a estrutura de dados nao esta vazia
        if(!$this->isEmpty())
        {
            $obj = $this->getNode($element);
            
            if($obj !== NULL)
            {
                $obj->setElement($element);
                
                // altera o valor da variavel logica
                $status = true;
            }
        }
        
        // retorno de valor
        return $status;            
    }
    
    public function toString() 
    {
        // retorna o conteudo da classe em uma string
        return $this->select($this->root, "<br>");
    }

}
