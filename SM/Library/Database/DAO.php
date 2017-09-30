<?php

/* Data Access Object, criado para gerenciar consultas em banco de dados.
 * 
 * Marcelo Barbosa.
 * junho, 2016.
 */

// declaracao do namespace
namespace SM\Library\Database;

// importacao de classes
use SM\Library\Interfaces\IContextObject;
use SM\Library\Generic\Generic;
use SM\Library\Model\Configuration;
use SM\Library\Collection\LinkedList;
use SM\Library\Collection\Element;
use SM\Library\Database\Context\Context;
use SM\Library\Utils\ProcessContext;

// declaracao de classes
abstract class DAO
{
    // declaracao de atributos
    private static $index;
    private $tableName;
    private $connection;
    private $internalErroMessage;
    private $ordinationParameter;
    private $contextModel;


    // declaracao de metodos
    public function __construct(Configuration $configuration, $tableName = "", Context $contextModel = null, $index = 0, $ordinationParameter = "")
    {
        // metodo construtor
        // inicializacao dos atributos
        $this->tableName = $tableName;
        $this->connection = new Connection($configuration);        
        $this->ordinationParameter = $ordinationParameter;
        $this->internalErroMessage = "";
        $this->contextModel = $contextModel;
        
        // indice estatico para navegacao
        self::$index = $index;
        
        // fixa a chave de criptografia e respectivos algoritmos para cifrar e decifrar campos
        ProcessContext::setCryptKey($configuration->getCryptKey());
        ProcessContext::setCipherAlgorithm($configuration->getCipherAlgorithm());
        ProcessContext::setDecipherAlgorithm($configuration->getDecipherAlgorithm());
    }
    
    // metodos de encapsulamento
    public static function setIndex($index)
    {
        self::$index = $index;
    }
    
    public static function getIndex()
    {
        return self::$index;
    }
    
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }    
    
    public function getTableName()
    {
        return $this->tableName;
    }
    
    public function setOrdinationParameter($ordinationParameter)
    {
        $this->ordinationParameter = $ordinationParameter;
    }
    
    public function getOrdinationParameter()
    {
        return $this->ordinationParameter;
    }
    
    public function setInternalErrorMessage($internalErrorMessage)
    {
        $this->internalErroMessage = $internalErrorMessage;
    }
    
    public function getInternalErrorMessage()
    {
        return $this->internalErroMessage;
    }
    
    public function setContextModel(Context $contextModel)
    {
        $this->contextModel = $contextModel;
    }
    
    public function getContextModel()
    {
        return $this->contextModel;
    }
    
    // metodos de processamento de dados
    public function getQuantityOfRegisters()
    {
        // obtem a quantidade de registros em uma tabela       

        // retorno de valor
        return $this->getQuantityRegistered();
    }
    
    public function getQuantityRegistered($field = null, $condition = null, Context $context = null)
    {
        // obtem a quantidade de um campo registrado em uma tabela
        // declaracao de variaveis
        $quantity = 0;
        $expression = "";
        $fieldName = "*";
        $hasCondition = ($condition != null) && ($context != null);
        $hasField = ($field != null);
        
        // tenta realizar a contagem de dados em uma tabela
        try
        {   
            // obtem uma conexao para o banco de dados
            $pdo = $this->connection->getConnection(); 
            $pdo->exec("set names utf8");
            
            // verifica se a conexao foi bem sucedida
            if($pdo !== null)
            {
                if($hasField)
                {
                    $fieldName = $field;
                }
                
                if($hasCondition)
                {
                    $expression = " WHERE " . $condition;                    
                    $stmt = $pdo->prepare("SELECT COUNT(".$fieldName.") AS quantity FROM " 
                                                                            . $this->getTableName() . $expression . ";");                    
                    
                     $stmt->execute(ProcessContext::processParameters($context));
                
                }else
                    {
                        $stmt = $pdo->prepare("SELECT COUNT(".$fieldName.") AS quantity FROM " 
                                                                            . $this->getTableName() . $expression . ";");
                        $stmt->execute();
                    }                
                
                // obtem a quantidade de registros
                $data = $stmt->fetch();
                $quantity = $data["quantity"];
                        
            }else
                {
                    // registra uma mensagem de erro caso uma excecao nao seja lancada
                    $this->setInternalErrorMessage("Connection failed!");
                }            
        }catch(\Exception $e)
              {
                  echo "Error: " . $e->getMessage();
              }
        
        // retorno de valor
        return $quantity;
    }
    
    public function getSum($field)
    {
        // obtem a quantidade de registros em uma tabela        

        // retorno de valor
        return $this->getSumByCondition($field, null, null);
    }
    
    public function getSumByCondition($field, $condition = null, Context $context = null)
    {
        // obtem a quantidade de registros em uma tabela
        // declaracao de variaveis
        $sum = 0.0;        
        $expression = "";
        $hasCondition = ($condition != null) && ($context != null);
        
        // tenta realizar a somatoria de valores
        try
        {
            // obtem uma conexao para o banco de dados
            $pdo = $this->connection->getConnection(); 
            $pdo->exec("set names utf8");
            
            // verifica se a conexao foi bem sucedida
            if($pdo !== null)
            {
             
                if($hasCondition)
                {
                    // insere uma clausula condicional
                    $expression = " WHERE " . $condition;                      
                   
                    $stmt = $pdo->prepare("SELECT SUM(" . $field . ") AS sumResult FROM " 
                                                                         . $this->getTableName() . $expression . ";");
                    $stmt->execute(ProcessContext::processParameters($context));
                   
                }else
                    {
                        $stmt = $pdo->prepare("SELECT SUM(" . $field . ") AS sumResult FROM " 
                                                                         . $this->getTableName() . $expression . ";");
                        $stmt->execute();
                    }                 
                
                // obtem o resultado da soma
                $data = $stmt->fetch();
                $sum = $data["sumResult"];
            }else
                {
                    // registra uma mensagem de erro caso uma excecao nao seja lancada
                    $this->setInternalErrorMessage("Connection failed!");
                }
            
        }catch(\Exception $e)
              {
                  echo "Error: " . $e->getMessage();
              }

        // retorno de valor
        return $sum;
    }
    
    public function insert(IContextObject $contextObj)
    {
        // faz a insercao de dados em uma tabela
        // declaracao de variaveis
        $status = false;
        $fields = ProcessContext::getFields($contextObj->getContext());
        
        // tenta realizar a insercao de dados
        try
        {
            // obtem uma conexao para o banco de dados
            $pdo = $this->connection->getConnection(); 
            $pdo->exec("set names utf8");
            
            // verifica se a conexao foi bem sucedida
            if($pdo !== null)
            {
                // criando um statement
                $stmt = $pdo->prepare("INSERT INTO " . $this->getTableName() . " " . $fields . "" 
                                                    . " VALUES" . ProcessContext::getIndexes($contextObj->getContext()) . ";");
                                
                // executa a consulta
                 $result = $stmt->execute(ProcessContext::processParameters($contextObj->getContext(), false));
                 
                                
                // verifica se houve exito na realizacao da operacao
                if($result)
                {
                    // altera o valor da variavel logica
                    $status = true;
                }else
                    {
                        $this->setInternalErrorMessage("Insert operation failed!");
                    }
            }else
                {
                    // registra uma mensagem de erro caso uma excecao nao seja lancada
                    $this->setInternalErrorMessage("Connection failed!");
                }
            
        }catch(\Exception $e)
              {
                  echo "Error: " . $e->getMessage();
              }
        
        // retorno de valor
        return $status;
    }
    
    public function remove($condition, Context $context)
    {
        // remove registros de uma tabela de dados
        // declaracao de variaveis
        $status = false;
        
        // tenta realizar a operacao de remocao
        try
        {
            // cria uma conexao com o banco de dados
            $pdo = $this->connection->getConnection(); 
            $pdo->exec("set names utf8");
            
            // verifica se houve exito em obter a conexao
            if($pdo !== null)
            {
                 // criando um statement
                $stmt = $pdo->prepare("DELETE FROM " . $this->getTableName() . " WHERE " . $condition . ";");
                
                // executa a consulta
                $result = $stmt->execute(ProcessContext::processParameters($context));                
                
                // verifica se a operacao teve exito
                if($result === true)
                {
                    // altera o valor da variavel logica
                    $status = true;
                }else
                    {
                        $this->setInternalErrorMessage("Deletion operation failed!");
                    } 
            }else
                {
                    // registra uma mensagem de erro caso uma excecao nao seja lancada
                    $this->setInternalErrorMessage("Connection failed!");
                }
            
        }catch(\Exception $e)
              {
                  echo "Error: " . $e->getMessage();
              }
        
        // retorno de valor
        return $status;
    }

    private function update(Context $context = null, $condition = null, Context $contextComplement = null, $isACompleteUpdate = false)
    {
        // atualiza registros em uma tabela de dados
        // declaracao de variaveis
        $status = false;
        $fields = "";
        
        try {
            if($isACompleteUpdate && ($contextComplement != null))
            {
                $fields = ProcessContext::getAllIndexesForUpdate($context);
                $context = ProcessContext::getContextKeyFields($context, $contextComplement);                
            }else
                {
                    $fields = ProcessContext::getIndexesForUpdate($context);
                }
        } catch(\Exception $e) 
                {
                    echo "(EN): Error when try get the indexes for data update."
                                     . "(PT): Erro ao tentar obter os índices para atualização de dados.";
                }
        
        // tenta realizar a operacao de atualizacao de registros
        try
        {
            // cria uma conexão com o banco de dados
            $pdo = $this->connection->getConnection(); 
            $pdo->exec("set names utf8");
            
            // verifica se houve êxito durante a conexão
            if($pdo !== null)
            {
                // cria um statement
                $stmt = $pdo->prepare("UPDATE " . $this->getTableName() . " SET " . $fields . " WHERE " . $condition . ";");
                
                // fixa os valores da consulta
                $result = $stmt->execute(ProcessContext::processParameters($context));                
                
                // verifica se deu certo
                if($result === true)
                {
                    // altera o valor da variável lógica
                    $status = true;
                }else
                    {
                        $this->setInternalErrorMessage("Update operation failed!");
                    }
            }else
                {
                    // registra uma mensagem de erro caso uma exceção não seja lançada
                    $this->setInternalErrorMessage("Connection failed!");
                }
            
        }catch(\Exception $e)
              {
                  echo "Error: " . $e->getMessage();
              }                
        
        // retorno de valor
        return $status;
        
    }
    
    public function cleanTable()
    {
        // remove todos os dados da tabela        
        // obtem uma conexao com o banco de dados
        $pdo = $this->connection->getConnection(); 
        $pdo->exec("set names utf8");
        
        if($pdo !== null)
        {
            // cria a sentenca SQL
           $stmt = $pdo->prepare("DELETE FROM " . $this->getTableName() . " WHERE 1");
           $stmt->execute();
        }
    }
    
    public function select(Context $context = null, $condition = null, $order = null, $index = -1, $registersPerPage = 0)
    {
        // realiza a selecao de dados
       try
        {
            $pdo = $this->connection->getConnection(); 
            $pdo->exec("set names utf8");
            
            // verifica se houve êxito em obter conexão de dados
            if($pdo !== null)
            {
                // cria um statement
                $stmt = $this->getStmtSelect($pdo, $context, $condition, $order, $index, $registersPerPage);
                
                while($data = $stmt->fetch())
                {                   
                    // imprime os dados
                   echo $this->getDataRowToString($this->getObject($data)) . "<br>";
                }
            }else
                {
                    // armazena uma mensagem interna de erro
                    $this->setInternalErrorMessage("Connection failed!");
                }
        }catch(\Exception $e)
              {
                  // lança uma exceção
                  echo "Error: " . $e->getMessage();
              }
    }
    
    public function selectByStatement($stmt)
    {
        // realiza a selecao de dados por meio de um statement
       try
        {
           // caso o stmt nao seja nulo, faz a selecao de dados
            if($stmt !== null)
            {                
                while($data = $stmt->fetch())
                {                   
                    // imprime os dados
                   echo $this->getDataRowToString($this->getObject($data)) . "<br>";
                }
            }else
                {
                    // armazena uma mensagem interna de erro
                    $this->setInternalErrorMessage("Connection failed!");
                }
        }catch(\Exception $e)
              {
                  // lança uma exceção
                  echo "Error: " . $e->getMessage();
              }
    }  
    
    public function removeObject(IContextObject $obj)
    {
        // realiza a remocao de um objeto
        // declaracao de variaveis
        $context = new Context();
        $context = ProcessContext::getContextKeyFields($context, $obj->getContext(), false);
        
        // retorno de valor
        return $this->remove(ProcessContext::getKeyCondition($context, false), $context);
    }
     
    public function updateObject(IContextObject $obj, IContextObject $oldObj = null)
    {
        // atualiza registros em uma tabela de dados
        // declaracao de variaveis
        $status = false;
        if($oldObj !== null)
        {
           $status = $this->update($obj->getContext(), ProcessContext::getKeyCondition($oldObj->getContext()), $oldObj->getContext(), true);
        }else
            {
                $context = new Context();
                $context = ProcessContext::getAdaptedContext($context, $obj->getContext());
                $status = $this->update($context, ProcessContext::getKeyCondition($obj->getContext()), null, false);
            }
             
        // retorno de valor
        return $status;
    }
    
    public function getObjectByCondition($condition, Context $context)
    {
        // realiza a busca de um objeto dado uma condicao
        // declaracao de variaveis
        $obj = null;        
        
        // tenta criar uma conexao com o banco de dados
        try
        {                          
            // cria uma conexao com o banco de dados
            $pdo = $this->connection->getConnection(); 
            $pdo->exec("set names utf8");

            // verifica se a conexao ocorreu com exito
            if($pdo !== null)
            {
                 // cria um Statement
                $stmt = $this->getStmtSearchRow($pdo, $condition, $context);
                        
                // executa a busca pelo o objeto no banco de dados
                $data = $stmt->fetch(); 
                if(!empty($data))
                {                
                    $obj = $this->getObject($data);
                }
            }else
                {
                    // armazena uma mensagem interna de erro
                    $this->setInternalErrorMessage("Connection failed");
                }                
           
        }catch(\Exception $e)
              {
                 echo "Error: " . $e->getMessage();
              }
        
        // retorno de valor
        return $obj;
    }
    
    public function getObjectByNavigation($index = 0, Context $context = null, $condition = null)
    {
        // retorna um objeto por navegacao        
        // declaracao de variaveis
        $obj = null;
       
       // tenta criar uma conexao com o banco de dados
        try
        {                          
            // cria uma conexao com o banco de dados
            $pdo = $this->connection->getConnection(); 
            $pdo->exec("set names utf8");

            // verifica se a conexao ocorreu com êxito
            if($pdo !== null)
            {
                // cria um Statement
                $stmt = $this->getStmtNavigate($pdo, $context, $condition, $index, 1);
                
                // recupera o registro do banco de dados
                $data = $stmt->fetch();
                
                if(!empty($data))
                {
                    $obj = $this->getObject($data);
                }
            }else
                {
                    // armazena uma mensagem interna de erro
                    $this->setInternalErrorMessage("Connection failed!");
                }                
           
        }catch(\Exception $e)
              {
                 // lanca uma excecao
                 echo "Error: " . $e->getMessage();
              }
       
       // retorno de valor
       return $obj;
    }
    
    public function getFirst()
    {
        // retorna um objeto como o primeiro registro de uma tabela
        // declaracao de variaveis
        $obj = $this->getObjectByNavigation(0);
        
        // seta o indice corrente com 0
        DAO::setIndex(0);
        
        // retorno de valor
        return $obj;
    }
    
    public function getPrior()
    {
        // retorna um objeto como o registro anterior de uma tabela
        // declaracao de variaveis
        $obj = null;
        
        // se o indice e maior que 0 entao retorna um elemento anterior ao indice atual
        if($this->getIndex() > 0)
        {
            DAO::setIndex(DAO::getIndex() - 1);
            $obj = $this->getObjectByNavigation($this->getIndex());
        }else
            {
                // caso contrario retorna o primeiro registro
                $obj = $this->getFirst();
            }
        
        // retorno de valor
        return $obj;
    }
    
    public function getNext()
    {
        // retorna um objeto como o proximo registro de uma tabela
        // declaracao de variaveis
        $obj = null;
        
        /* se o indice e menor que a posicao final do ponteiro de registros entao retorna
         * um elemento posterior ao indice atual
         */
         if($this->getIndex() < ($this->getQuantityOfRegisters() - 1))
         {
             DAO::setIndex(DAO::getIndex() + 1);
             $obj = $this->getObjectByNavigation($this->getIndex());
         }else
            {
                // caso contraria retorna o ultimo elemento
                $obj = $this->getLast();
            }
         
         // retorno de valor
         return $obj;
        
    }        
            
    public function getLast()
    {
        // retorna um objeto como o ultimo registro de uma tabela
        // declaracao de variaveis
        $obj = null;
        
        // verifica se a navegacao e possivel
        if($this->getQuantityOfRegisters() > 0)
        {
            $obj = $this->getObjectByNavigation(($this->getQuantityOfRegisters() - 1));
            
            // seta o indice corretamente com o indice do ultimo registro
            DAO::setIndex(($this->getQuantityOfRegisters() - 1));
        }
        
        // retorno de valor
        return $obj;
    }
    
    public function getList(Context $context = null, $condition = null, $order = null, $index = 0, $registersPerPage = -1)
    {
        // obtem todos os dados da tabela e os armazena em memoria, em uma lista nao ordenada.
        // declaracao de variaveis
        $list = new LinkedList(true, $this->getTableName()."DataTable");
        
        try
        {
            $pdo = $this->connection->getConnection(); 
            $pdo->exec("set names utf8");
            
            // verifica se houve êxito em obter conexão de dados
            if($pdo !== null)
            {
                // cria um statement
                $stmt = $this->getStmtSelect($pdo, $context, $condition, $order, $index, $registersPerPage);
                
                // faz uma seleção de todos os dados
                while($data = $stmt->fetch())
                {                   
                    // imprime os dados
                   $list->add(new Element($this->getObject($data)));
                }
            }else
                {
                    // armazena uma mensagem interna de erro
                    $this->setInternalErrorMessage("Connection failed!");
                }
        }catch(\Exception $e)
              {
                  // lanca uma excecao
                  echo "Error: " . $e->getMessage();
              }
        
        return  $list;
    }
    
    public function getListByStatement($stmt)
    {
        // obtem todos os dados da tabela e os armazena em memoria, em uma lista nao ordenada por meio de um statement.
        // declaracao de variaveis
        $list = new LinkedList(true, $this->getTableName()."DataTable");
        
        try
        {
            // verifica se o statement nao eh nulo para fazer a selecao de dados
            if($stmt !== null)
            {
                while($data = $stmt->fetch())
                {                   
                    // imprime os dados
                   $list->add(new Element($this->getObject($data)));
                }
            }else
                {
                    // armazena uma mensagem interna de erro
                    $this->setInternalErrorMessage("Connection failed!");
                }
        }catch(\Exception $e)
              {
                  // lanca uma excecao
                  echo "Error: " . $e->getMessage();
              }
        
        return  $list;
    }
    
    public function exists($condition, Context $context)
    {
        // verifica se um objeto esta registrado no banco de dados
        // declaracao de variaveis
        $status = false;
        $obj = $this->getObjectByCondition($condition, $context);
        
        // verifica se o objeto foi encontrado
        if($obj !== null)
        {
            $status = true;
        }
        
        // retorno de valor
        return $status;
    }
    
    public function hasObjectByKeyFields(IContextObject $obj)
    {
        // busca a existencia de um objeto pelos seus campos-chave
        // declaracao de variaveis
        $context = ProcessContext::getContextKeyFields($context, $obj->getContext(),false);
        $condition = ProcessContext::getKeyCondition($context,false);
        
        return $this->exists($condition, $context);
    }
    
    public function hasObject(IContextObject $obj)
    {
        // busca a existencia de um objeto pela sua instancia
        // declaracao de variaveis        
        $context = $obj->getContext();
        $condition = ProcessContext::getCondition($context);
        
        return $this->exists($condition, $context);
    }
    
    protected function getStmtNavigate($pdo, Context $context = null, $condition = null, $index = -1, $registersPerPage = 0) 
    {
        // retorna um sql para navegação entre os registros da tabela
        // declaração de variáveis
        
        $stmt = $this->getStmtSelect($pdo, $context, $condition, $this->getOrdinationParameter(), $index, $registersPerPage);
        
        return $stmt;        
    }
     
     protected function getStmtSearchRow($pdo, $condition, Context $context) 
    {
        /* Cria um statement para obter um registro de uma tabela de dados.
         */
        
        // declaracao de variaveis
        $stmt = $this->getStmtSelect($pdo, $context, $condition, null, 0, 1);        
        
        // retorno de valor
        return $stmt;
    }
    
   protected function getStmtSelect(\PDO $pdo, Context $contextValue = null, $condition = null, $order, $index, $registersPerPage)
   {
        // cria um statement para consultas com selecao de dados
        // declaracao de variaveis
        $stmt = null;
        $expression = "";
        $expOrder = "";
        $limit = "";
       
        try
        {
            // verifica se houve exito durante a conexao
            if($pdo !== null)
            {
                // filtrando elementos condicionais, ordinais e limitantes
                if(($condition != null) && (strcmp($condition, "") != 0))
                {
                    $expression = " WHERE " . $condition;
                }

                if(($order != null) && (strcmp($order, "") != 0))
                {
                    $expOrder = " ORDER BY " . $order;
                }

                if(($index >= 0) && ($registersPerPage > 0))
                {
                    $limit = " LIMIT " . $index . "," .  $registersPerPage;
                }
                
                $stmt = $pdo->prepare("SELECT " . ProcessContext::getFieldsForSelection($this->getContextModel()) 
                                                 . " FROM " . $this->getTableName() . $expression . $expOrder . $limit .";");                      
                
                if(($contextValue != null) && (strcmp($expression, "") != 0))
                {                    
                    $stmt->execute(ProcessContext::processParameters($contextValue));
                }else
                    {
                        $stmt->execute();
                    }                
            }
        }catch(\Exception $e)
            {
                echo "Error: " . $e->getMessage();
            }
       return $stmt;
   }
   
   protected function getDataRowToString(Generic $obj)
   {
       // retorna os dados de um objeto em uma string
       return $obj->toString();
   }
   
   // metodos abstratos
   abstract protected function getObject($data);
}