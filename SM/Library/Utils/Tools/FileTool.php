<?php

/* Classe que modela uma ferramenta arquivos através de streams
 * 
 * Marcelo Barbosa,
 * julho, 2016.
 */

// declaracao do namespace
namespace SM\Library\Utils\Tools;

// importacao de classes
use SM\Configuration\SystemConfiguration;
use SM\Library\IO\File\File;

// declaracao da classe
class FileTool
{
    // declaracao de atributos
    
    // declaracao de metodos
    public static function uploadfile($filename, $path = null)
    {
        // move streams de arquivos enviados via upload
        // declaracao de variaveis
        $source = null;
        
        try
        {       
            // o caminho do upload eh fixado com o diretorio padrao caso nao seja informado
            $filepath = SystemConfiguration::getAssetsPath();
            
            if($path == null)
            {
                $path = "Uploads";
            }
                
            $filepath .= "/". $path;
            
            // instancia a classe para a criacao do arquivo
            $file = new File($filepath, basename($_FILES[$filename]['name']));
            
            // substitui o arquivo caso ele ja exista
            if($file->exist())
            {
               $file->delete();                 
            }
            
            // cria o arquivo
            $file->create();
            
            // obtem os dados do arquivo
            $tmp = fopen($_FILES[$filename]['tmp_name'], "r");
            $data = fread($tmp, $_FILES[$filename]['size']);                 
            
            // grava os dados do arquivo
            if($file->write($data))
            {
                $source = $file->getFileName();
            }
            
        }catch(\Exception $e) 
              {
                 echo $e->getMessage();
              }
              
        // retorno de valor
        return $source;
    }
}

