<?php
/*
 * Script de sub-rotinas criado para gerir estruturas de dados
 * 
 * Marcelo Barbosa.
 * dezembro, 2013.
*/

// declaracao do namespace
namespace SM\Library\Utils\Tools;

// importacao de classes
use SM\Library\Collection\LinkedList;
use SM\Library\Collection\Queue;
use SM\Library\Collection\Stack;
use SM\Library\Collection\Node;

// declaracao de classe
class CollectionTool
{
    
    // declaracao de metodos
    public static function setLessThan(Node &$previous = null, Node &$oldNode, Node &$newNodeLessThanOldNode)
    {
        // fixa os dados de um no menor que outro
        if($previous != null)
        {
            $previous->setNext($newNodeLessThanOldNode);
            $newNodeLessThanOldNode->setPrior($previous);
        }else
            {
                $newNodeLessThanOldNode->setPrior(null);
            }

        $oldNode->setPrior($newNodeLessThanOldNode);    
        $newNodeLessThanOldNode->setNext($oldNode);
        $oldNode = $newNodeLessThanOldNode;
    }

    public static function removeNode(Node &$node)
    {
        // remove um no liberando memória
        unset($node); 
    }

    public static function objectToString($object)
    {
        // retorna o valor do método toString de um objeto
        // declaração de variáveis
        $stringValue = "";
        $auxObject = null;
        $objectName = "";

        // filtrando o tipo de objeto a ser empregado o toString
        if($object instanceof LinkedList)
        {
            $objectName = "LinkedList";            

        }else if($object instanceof Stack)
              {
                    $objectName = "Stack";                                

              }else if($object instanceof Queue)
                    {
                        $objectName = "Queue";                   

                    }else 
                        {
                            $objectName = "Object Unknown";
                        }

         $stringValue ="Object's Name: ".$objectName."<br>"
                 . "<hr style='width:100%' noshade size='0.5' color='black'>"
                 . "<br>". $object->toString();

         // retorno de valor
         return $stringValue;     
    }
    
}