<?php

/* Classe criada para manipular arquivos
 * 
 * Marcelo Barbosa,
 * julho, 2016.
 * 
 */

// declaracao do namespace
namespace SM\Library\IO\File;

// importacao de classes
use SM\Library\Collection\LinkedList;
use SM\Library\Collection\Element;
use SM\Configuration\SystemConfiguration;

// declaracao da classe
class File
{
    // declaracao de atributos
    private $fileName;
    private $filePath;
    private $root;
    
    // declaracao de metodos
    public function __construct($filePath, $fileName) 
    {
        // metodo construtor        
        // inicializacao de atributos
        $this->filePath = $filePath;
        $this->fileName = $fileName;
        $this->root = SystemConfiguration::getRoot();
        
        /* se o caminho ate o arquivo nao existe entao este atributo recebe
         * o caminho ate a raiz
        */
        if($filePath == "")
        {
            $this->filePath = $this->root;
        }
        
        if(!strpos($this->filePath, "/", (strlen($this->filePath) - 1)))
        {
           $this->filePath .= "/";
        }
    }
    
    public function exist()
    {
        // verifica se um arquivo existe
        return file_exists($this->getFilePath().$this->getFileName());
    }
    
    public function create()
    {
        // cria o arquivo caso ele nao exista
        // declaracao de variaveis
        $status = false;        
        
        if(!$this->exist())
        {
            if(fopen($this->getFileSource(), "w") > 0)
            {
                $status = true;
            }
        }
        
        // retorno de valor
        return $status;
                
    }
    
    public function delete()
    {
        // deleta um arquivo caso ele exista
        // declaracao de variaveis
        $status = false;        
        
        if($this->exist())
        {
            $status = unlink($this->getFileSource());
        }
        
        // retorno de valor
        return $status;
    }
    
    public function write($data)
    {
        // escreve dados em um arquivo caso ele exista
        // declaracao de variaveis
        $status = false;
        
        if($this->exist())
        {
            // abre o arquivo para escrita
            $file = fopen($this->getFileSource(), "a");
            
            if(fwrite($file, $data) > 0)
            {
                $status = true;
            }
            
            // fecha o arquivo
            fclose($file);
        }
        
        // retorno de valor
        return $status;        
    }
    
    public function put($object)
    {
        // insere um objeto serializado no arquivo
        // declaracao de variaveis
        $status = false;
        
        if(is_object($object))
        {
           $objectSerialized = serialize($object);
           
           if($this->write($objectSerialized . "\n"))
           {
                   $status = true;
           }
           
        }
        
        // retorno de valor
        return $status;
    }
    
    public function getSize()
    {
        // obtem o numero de linhas do arquivo
        // declaracao de variaveis
        $size = 0;
        
        if($this->exist())
        {
            $size = filesize($this->getFileSource());            
        }
        
        // retorno de valor
        return $size;
    }
    
    public function getList()
    {
        // obtem uma lista de objetos armazenados no arquivo caso ele nao esteja vazio
        // declaracao de variaveis
        $list = null;
        
        if($this->exist())
        {
            $list = new LinkedList();
            // abre o arquivo para leitura
            $file = fopen($this->getFileSource(), "r");
            
            // obtem os registros do arquivo
            while(!feof($file))
            {
                $serialized = fgets($file);
                $obj = unserialize($serialized);
                
                if(is_object($obj))
                {
                    $list->add(new Element($obj));
                }
            }
            
            // fecha o arquivo
            fclose($file);
        }
        
        // retorno de valor
        return $list;
    }
    
    public function read()
    {
        // le os dados de um arquivo caso ele exista
        // declaracao de variaveis
        $data = "";
        
        if($this->exist())
        {
            // abre o arquivo para escrita
            $file = fopen($this->getFileSource(), "r");
            $data = fread($file, filesize($this->getFileSource()));
            
            // fecha o arquivo
            fclose($file);
        }
        
        // retorno de valor
        return $data;
    }
    
    public function find($data)
    {
        // busca um registro no arquivo caso ele exista
        // declaracao de variaveis
        $status = false;
        
        if($this->exist())
        {
            // abre o arquivo para leitura
            $file = fopen($this->getFileSource(), "r");
            
            // tenta encontrar o registro
            while(!feof($file))
            {
                $datafile = trim(fgets($file));
                
                if(strcmp($datafile, $data) == 0)
                {
                    $status = true;
                    break;
                }
            }
            
            // fecha o arquivo
            fclose($file);
        }
        
        // retorno de valor
        return $status;
    }
        
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;        
    }
    
    public function getFilePath()
    {
        return $this->filePath;
    }
    
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }
    
    public function getFileName()
    {
        return $this->fileName;
    }    
    
    public function getRoot()
    {
        $this->getRoot();
    }
    
    public function getFileSource()
    {
        // retorna o caminho completo do arquivo
        return $this->getFilePath() . $this->getFileName();
    }
}