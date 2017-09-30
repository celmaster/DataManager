<?php

/* Realiza o processamento de contextos para SQL e LinkedList.
 * 
 * Marcelo Barbosa,
 * junho, 2016. 
 */

// declaracao do namespace
namespace SM\Library\Utils;

// importacao de classes
use SM\Library\Collection\LinkedList;
use SM\Library\Database\Context\Context;
use SM\Library\Interfaces\IContextObject;

// declaracao da classe
class ProcessContext
{
    // declaracao de atributos
    private static $cryptKey = null;
    private static $cipherAlgorithm = null;
    private static $decipherAlgorithm = null;
    
    // declaracao de metodos
    public static function setCryptKey($cryptKey)
    {
        ProcessContext::$cryptKey = $cryptKey;
    }
    
    public static function setCipherAlgorithm($cipherAlgorithm)
    {
        ProcessContext::$cipherAlgorithm = $cipherAlgorithm;
    }
    
    public static function setDecipherAlgorithm($decipherAlgorithm)
    {
        ProcessContext::$decipherAlgorithm = $decipherAlgorithm;
    }
    
    private static function getParameter($name, $isCiphered)
    {
        // retorna um parametro formatado
        $parameter = "";
        
        try
        {
            if($isCiphered)
            {
                $parameter = ProcessContext::cipher(":".$name, ProcessContext::$cipherAlgorithm);
            }else
                {
                    $parameter = ":".$name;
                }
        }catch(\Exception $e)
            {
                echo "(EN): Error when formating parameter.\n"
                        . "(PT): Erro ao formatar parametro.";
            }
        
        return $parameter;
    }
    
    public static function cipher($value, $algorithm = null)
    {
        // faz a cifragem de um campo
        // declaracao de variaveis
         $cipher = "";
         $localAlgorithm = "AES_ENCRYPT({{resource}}, '{{key}}')";
         
        if($algorithm!= null)
        {
            $localAlgorithm = $algorithm;
        }else
            {
                $algorithm = "";
            }
         
        if(((strpos($algorithm, "{{key}}") !== false) || (strpos($algorithm, "{{resource}}") !== false)) 
                && ((ProcessContext::$cryptKey == null) || (strcmp(ProcessContext::$cryptKey, "") == 0)))
        {
            throw new \Exception("(EN): Error. Encryption key not found!\n"
                              . "(PT): Erro. Chave de criptografia não encontrada!");
            
        }else
            {   
                $cipher = str_replace("{{resource}}", $value, $localAlgorithm);
                $cipher = str_replace("{{key}}", ProcessContext::$cryptKey, $cipher);
            }
        
        return $cipher;
    }
    
    public static function decipher($field, $algorithm = null)
    {
        // faz a decifragem de um campo
        // declaracao de variaveis
        $decipher = "";
        $localAlgorithm = "AES_DECRYPT({{resource}}, '{{key}}')";
        
        if($algorithm!= null)
        {
            $localAlgorithm = $algorithm;
        }else
            {
                $algorithm = "";
            }
         
        if(((strpos($algorithm, "{{key}}") !== false) || (strpos($algorithm, "{{resource}}") !== false)) 
                && ((ProcessContext::$cryptKey == null) || (strcmp(ProcessContext::$cryptKey, "") == 0)))
        {
            throw new \Exception("(EN): Error. Encryption key not found!\n"
                              . "(PT): Erro. Chave de criptografia não encontrada!");
        }else
            {   
                $decipher = str_replace("{{resource}}", $field, $localAlgorithm);
                $decipher = str_replace("{{key}}", ProcessContext::$cryptKey, $decipher);
            }
        
        return $decipher;
    }
    
    public static function getIndexes(Context $context)
    {
        // retorna um conjunto de indices que serao substituidos pelos itens de consulta
        // declaracao de variaveis
        $indexes = "(";
        
        try
        {
            // obtem o vetor do array list
            $array = $context->getParameters()->toArray();
            
            // cria a sequencia de indices
            for($i = 0; $i < $context->getSize(); $i++)
            {
                $contextElement = $array[$i]->getData();
                $name = $contextElement->getCaption();
                
                if(!$contextElement->getAutoIncrement())
                {
                    if($contextElement->getIsCiphered())
                    {
                        $indexes .= ProcessContext::cipher(":".$name, ProcessContext::$cipherAlgorithm);
                    }else
                        {
                            $indexes .= ":".$name;
                        }
                        
                    // poe uma virgula a cada indice
                    if($i < ($context->getSize() - 1))
                    {
                        $indexes .= ", ";
                    }
                    
                }else
                    {
                        $indexes = substr($indexes, 0, strrpos($indexes, ","));
                    }
                    
            }
        }catch(\Exception $e)
            {
                echo "Errors:\n" . $e->getMessage() . "\n";                
            }
        
        // fecha parentese
        $indexes .= ")";
        
        return $indexes;
    }
    
    public static function getContextKeyFields(Context $target, Context $data, $hasSuffix = true)
    {
        // obtem os dados chave de um contexto e os adiciona a outro contexto.
        $newContext = $target;
        $suffix = "";
        
        if($hasSuffix)
        {
            $suffix = "_key";
        }
        
        // obtem o vetor do array list
        $array = $data->getParameters()->toArray();
        
        for($i = 0; $i < $data->getSize(); $i++)
        {
            $contextElement = $array[$i]->getData();
            
            if($contextElement->getIsKeyField())
            {
                $contextElement->setCaption($contextElement->getCaption() . $suffix);
                $target->add($contextElement);
            }
        }
        
        // retorno de valor
        return $newContext;
    }
    
    public static function getAdaptedContext(Context $target, Context $data, $hasSuffix = true)
    {
        // adapta um contexto.
        $newContext = $target;
        $suffix = "";
        
        if($hasSuffix)
        {
            $suffix = "_key";
        }
        
        // obtem o vetor do array list
        $array = $data->getParameters()->toArray();
        
        for($i = 0; $i < $data->getSize(); $i++)
        {
            $contextElement = $array[$i]->getData();
            
            if($contextElement->getIsKeyField())
            {
                $contextElement->setCaption($contextElement->getCaption() . $suffix);
                $target->add($contextElement);
            }
            
            $target->add($contextElement);
        }
        
        // retorno de valor
        return $newContext;
    }
    
    public static function getContextFields(Context $target, Context $data)
    {
        // obtem os dados de um contexto e os adiciona a outro contexto.
        $newContext = $target;
        
        // obtem o vetor do array list
        $array = $data->getParameters()->toArray();
        
        for($i = 0; $i < $data->getSize(); $i++)
        {
            $contextElement = $array[$i]->getData();
            $target->add($contextElement);
        }
        
        // retorno de valor
        return $newContext;
    }
    
    public static function getCondition(Context $context)
    {
        // retorna um conjunto de indices que serao substituidos pelos itens de consulta
        // declaracao de variaveis
        $indexes = "";
        
        // obtem o vetor do array list
        $array = $context->getParameters()->toArray();
        
        // cria a sequencia de indices
        for($i = 0; $i < $context->getSize(); $i++)
        {
            $contextElement = $array[$i]->getData();
            $name = $contextElement->getCaption();
            
            $indexes .= $name . " = "
                    . ProcessContext::getParameter($name, $contextElement->getIsCiphered());
            
            // poe uma virgula a cada indice
            if($i < ($context->getSize() - 1))
            {
                $indexes .= " AND ";
            }
        }
        
        return $indexes;
    }
    
    public static function getConditionByFieldDisjunction(Context $context, $fieldName)
    {
        // retorna uma disjuncao de indices que serao substituidos pelos itens de consulta
        // declaracao de variaveis
        $indexes = "";  
        
        // obtem o vetor do array list
        $array = $context->getParameters()->toArray();
        
        // cria a sequencia de indices
        for($i = 0; $i < $context->getSize(); $i++)
        {
            $contextElement = $array[$i]->getData();
            $name = $contextElement->getCaption();
            
            $indexes .= $fieldName . " = "
                    . ProcessContext::getParameter($name, $contextElement->getIsCiphered());
            
            // poe uma virgula a cada indice
            if($i < ($context->getSize() - 1))
            {
                $indexes .= " OR ";
            }
        }
        
        return $indexes;
    }
    
    public static function getKeyCondition(Context $context, $hasSuffix = true)
    {
        // retorna um conjunto de indices que serao substituidos pelos itens de consulta
        // declaracao de variaveis
        $indexes = "";
        $suffix = "";
        
        if($hasSuffix)
        {
            $suffix = "_key";
        }
        
        // obtem o vetor do array list
        $array = $context->getParameters()->toArray();
        
        // cria a sequencia de indices
        for($i = 0; $i < $context->getSize(); $i++)
        {
            
            $contextElement = $array[$i]->getData();
            
            if($contextElement->getIsKeyField())
            {
                $name = $contextElement->getCaption();
                $indexes .= $name . " = "
                    . ProcessContext::getParameter($name . $suffix, $contextElement->getIsCiphered());
                
                // poe uma virgula a cada indice
                if($i < ($context->getSize() - 1))
                {
                    // pega o proximo elemento da lista
                    $nextContextElement = $array[$i+1]->getData();
                    
                    if($nextContextElement->getIsKeyField())
                    {
                        $indexes .= " AND ";
                    }
                }
            }
        }
                
        return $indexes;
    }
    
    public static function getIndexesForUpdate(Context $context)
    {
        // retorna um conjunto de indices que serao substituidos pelos itens de consulta
        // declaracao de variaveis
        $indexes = "";
        $indexesFields = null;
        $controle = 0;
        
        // obtem o vetor do array list
        $array = $context->getParameters()->toArray();
        
        // cria a sequencia de indices
        for($i = 0; $i < $context->getSize(); $i++)
        {
            $contextElement = $array[$i]->getData();

            if(!$contextElement->getIsKeyField())
            {    
                $name = $contextElement->getCaption();
                $indexes .= $name . " = "
                    . ProcessContext::getParameter($name, $contextElement->getIsCiphered());
                
                // pega o proximo elemento da lista
                $nextContextElement = $array[$i+1]->getData();
                
                // poe uma virgula a cada indice
                if(($i < ($context->getSize() - 1) && (!$nextContextElement->getIsKeyField())))
                {
                    $indexes .= ", ";
                }
                
                $controle++;                
            }            
        }
                
        if($controle > 0)
        {
            $indexesFields = $indexes;
        }else
            {
                throw new \Exception("(EN): The fields to update the values were not found!\n"
                                  . "(PT): Os campos para atualizar os valores não foram encontrados!");
            }
        
        return $indexesFields;
    }
    
    public static function getAllIndexesForUpdate(Context $context)
    {
        // retorna um conjunto de indices que serao substituidos pelos itens de consulta
        // declaracao de variaveis
        $indexes = "";
        
        // obtem o vetor do array list
        $array = $context->getParameters()->toArray();
        
        // cria a sequencia de indices
        for($i = 0; $i < $context->getSize(); $i++)
        {
            $contextElement = $array[$i]->getData();
           
            $name = $contextElement->getCaption();
            $indexes .= $name . " = "
                . ProcessContext::getParameter($name, $contextElement->getIsCiphered());
            
            // poe uma virgula a cada indice
            if($i < ($context->getSize() - 1))
            {
                $indexes .= ", ";
            }
        }
        
        return $indexes;
    }
    
    public static function getFields(Context $context)
    {
        // retorna um conjunto de nomes de colunas associadas a um contexto
        // declaracao de variaveis
        $indexes = "(";
        
        // obtem o vetor do array list
        $array = $context->getParameters()->toArray();
        
        // cria a sequencia de indices
        for($i = 0; $i < $context->getSize(); $i++)
        {
            $contextElement = $array[$i]->getData();
            
            if(!$contextElement->getAutoIncrement())
            {
                $indexes .= $contextElement->getCaption();
                
                // poe uma virgula a cada indice
                if($i < ($context->getSize() - 1))
                {
                    $indexes .= ", ";
                }
                
            }else
                {
                    $indexes = substr($indexes, 0, strrpos($indexes, ","));
                }
        }
        
        // fecha parentese
        $indexes .= ")";
        
        return $indexes;
    }
    
    public static function getFieldsForSelection(Context $context)
    {
        // retorna um conjunto de nomes de colunas associadas a um contexto
        // declaracao de variaveis
        $indexes = "";
        
        // verifica se o contexto eh nulo
        if($context != null)
        {
            try
            {
                // obtem o vetor do array list
                $array = $context->getParameters()->toArray();
                
                // cria a sequencia de indices
                for($i = 0; $i < $context->getSize(); $i++)
                {
                    
                    $contextElement = $array[$i]->getData();
                    
                    if($contextElement->getIsCiphered())
                    {
                        $indexes .= ProcessContext::decipher($contextElement->getCaption(), ProcessContext::$decipherAlgorithm);
                    }else
                        {
                            $indexes .= $contextElement->getCaption();
                        }

                    // poe uma virgula a cada indice
                    if($i < ($context->getSize() - 1))
                    {
                        $indexes .= ", ";
                    }
                }               
            }catch(Exception $e)
                {
                   echo "(EN): Error when encrypt context's values.\n"
                                 . "(PT): Erro ao criptografar valores de contexto!";
                }
        }else
            {
                $indexes .= "*";
            }
        
        return $indexes;
    }
    
    public static function processParameters(Context $context, $required = true)
    {
        // obtem os parametros para consulta e retorna o objeto ao método que o invocou
        // declaracao de variaveis        
        $array = array();
        
        // obtem o vetor do array list
        $dataArray = $context->getParameters()->toArray();
        
        for($i = 1; $i <= $context->getSize(); $i++)
        {
            $contextElement = $dataArray[$i-1]->getData();
            
            if(!$required && !$contextElement->getAutoIncrement())
            {
                $array[$contextElement->getCaption()] = $contextElement->getValue();
            }else if($required)
                {
                    $array[$contextElement->getCaption()] = $contextElement->getValue();
                }
        }
        
        return $array;
    }
    
    public static function processKeyParameters(Context $context)
    {
        // obtem os parametros para consulta e retorna o objeto ao método que o invocou
        // declaracao de variaveis
        $array = array();   
        
        // obtem o vetor do array list
        $dataArray = $context->getParameters()->toArray();
         
        for($i = 0; $i < $context->getSize(); $i++)
        {            
            $contextElement = $dataArray[$i]->getData();
            
            if($contextElement->getIsKeyField())
            {  
               $array[$contextElement->getCaption()] = $contextElement->getValue();
            }
        }
        
        return $array;
    }
    
    public static function getContextToJSON(Context $context)
    {
        // retorna dados de um contexto em um objeto JSON
        // declaracao de variaveis
        $json = null;
        
        // verifica se o contexto eh diferente de nulo
        if($context != null)
        {
            $json = JSONManager::arrayToJSON(ProcessContext::getContextToArray($context));
        }
        
        // retorno de valor
        return $json;
    }
    
    private static function getContextToArray(Context $context)
    {
        // converte um contexto em array
        // declaracao de variaveis
        $array = array();
        
        // obtem o vetor do array list
        $dataArray = $context->getParameters()->toArray();
        
        for($i = 0; $i < $context->getSize(); $i++)
        {
            $contextElement = $dataArray[$i]->getData();
            
            if($contextElement->getValue() instanceof LinkedList)
            {
                $list = $contextElement->getValue();
                $contextArray = ProcessContext::getListToArray($list);
                $array[$contextElement->getCaption()] = $contextArray[$list->getObjectName()];                
            }else if($contextElement->getValue() instanceof Context)
                  {
                     $tmpContext = $contextElement->getValue();
                     $array[$contextElement->getCaption()] = ProcessContext::getContextToArray($tmpContext);                
                  }else
                      {
                        $array[$contextElement->getCaption()] = $contextElement->getValue();                
                      }
            
        }
        
        // retorno de valor
        return $array;
    }
    
    public static function getContextToXML(Context $context, $rootName)
    {
        // retorna dados de um contexto em um XML
        // declaracao de variaveis
        $xml = null;
        
        // verifica se o contexto eh diferente de nulo
        if($context != null)
        {
            $xml .= "<".$rootName.">";
            
            // obtem o vetor do array list
            $dataArray = $context->getParameters()->toArray();
            
            for($i = 0; $i < $context->getSize(); $i++)
            {
                $contextElement = $dataArray[$i]->getData();
                
                if($contextElement->getValue() instanceof LinkedList)
                {
                    $xml .= ProcessContext::getListToXML($contextElement->getValue());
                }else
                    {
                        $xml .= "<".$contextElement->getCaption().">";
                        $xml .= $contextElement->getValue()."";
                        $xml .= "</".$contextElement->getCaption().">";
                    }
                
            }
            
            $xml .= "</".$rootName.">";
        }
        
        // retorno de valor
        return $xml;
    }
    
    public static function getListToArray(LinkedList $list)
    {        
        // retorna o conteudo de uma lista em um arquivo JSON
        // declaracao de variaveis
        $array = null;
        if($list->getSize() > 0)
        {
            // cria um array
            $array = array($list->getObjectName() => array());
            
            // obtem o vetor do array list
            $dataArray = $list->getParameters()->toArray();
            
            // percorre os elementos da lista
            for($i = 0; $i < $list->getSize(); $i++)
            {
                $object = $dataArray[$i]->getData();
                
                // verifica se o objeto implementa a interface de objeto de contexto
                if($object instanceof IContextObject)
                {
                    $array[$list->getObjectName()][] = ProcessContext::getContextToArray($object->getContext());
                }else if($object instanceof Context)
                      {
                            $array[$list->getObjectName()][] = ProcessContext::getContextToArray($object);
                      }else if($object instanceof LinkedList)
                            {
                                  $array[$list->getObjectName()][] = ProcessContext::getListToArray($object);
                            }else
                                {
                                    $array[$list->getObjectName()][] = $object;
                                }
            }
        }
        
        // retorno de valor
        return $array;
    }
    
    public static function getListToJSON(LinkedList $list)
    {        
        // retorna o conteudo de uma lista em um arquivo JSON
        // declaracao de variaveis
        $json = null;
        if($list->getSize() > 0)
        {   
            $json = JSONManager::arrayToJSON(ProcessContext::getListToArray($list));
        }
        
        // retorno de valor
        return $json;
    }
    
    public static function getListToXML(LinkedList $list)
    {
        // converte o conteudo de uma lista em XML
        // declaracao de variaveis
        $xml = null;
        
        // verifica se a lista possui conteudo
        if($list->getSize() > 0)
        {
            // obtem o nome do elemento raiz
            $xml .= "<".$list->getObjectName().">";
            
            // obtem o vetor do array list
            $dataArray = $list->getParameters()->toArray();
            
            // obtem os demais elementos
            for($i = 0; $i < $list->getSize(); $i++)
            {
                $object = $dataArray[$i]->getData();
                
                // verifica se o objeto eh
                if($object instanceof IContextObject)
                {
                    $xml .= ProcessContext::getContextToXML($object->getContext(), $object->getObjectName());
                }else
                    {
                        $xml .= "<".$list->getObjectName()."Value>";
                        $xml .= $object;
                        $xml .= "</".$list->getObjectName()."Value>";
                    }
            }
            
            // tag de fechamento
            $xml .= "</".$list->getObjectName().">";
        }
        
        // retorno de valor
        return $xml;
    }
}