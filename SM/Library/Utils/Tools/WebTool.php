<?php

/* Classe que modela uma ferramenta para manipular classes do pacote
 * Web
 * 
 * Marcelo Barbosa,
 * julho, 2016.
 */

// declaracao do namespace
namespace SM\Library\Utils\Tools;
//require_once("../../../autoload.php");
// importacao de classes
use SM\Library\IO\File\File;
use SM\Library\Model\Package;
use SM\Library\Utils\StringManager;
use SM\Configuration\SystemConfiguration;

// declaracao da classe
class WebTool
{
    // declaracao de atributos
    const designSource = "Library/Web/Design";
    const templatePatternSource = "Library/Web/Template/Pattern";
    const templateSource = "Library/Web/Template";
    const gridSource = "Library/Web/Template/DataGridModel";
    
    // declaracao de metodos estaticos
    private static function getScript($className, $body, $cssScripts, $jsScripts)
    {
        // obtem o script formatado para o novo template
        // declaracao de variaveis
        $path = SystemConfiguration::getRoot() . WebTool::templatePatternSource;
        $file = new File($path, "pattern.txt");
        $script = "";
        
        if($file->exist())
        {
            $script = "<?php\n".$file->read();
            $script = str_replace("{{date}}", SystemConfiguration::getCurrentDate(), $script);
            $script = str_replace("{{className}}", $className, $script);
            $script = str_replace("{{body}}", $body, $script);
            $externScripts = WebTool::getCSSScripts($cssScripts).WebTool::getJSScripts($jsScripts);
            $script = str_replace("{{scripts}}", $externScripts, $script);
        }
                
        // retorno de valor
        return $script;
    }
    
    public static function getCSSScripts($cssScripts)
    {
        // obtem scripts css
        // declaracao de variaveis
        $cssList = '';
        if(is_array($cssScripts))
        {
            foreach ($cssScripts as $name) 
            {
                $cssList .= '$this->addCSSScript(new CSSFileScript(SystemConfiguration::getCSSDir(), "'.$name.'.css"));';
                 $cssList .= "\n";
            }
        }
        
        // retorno de valor
        return $cssList;        
    }
    
    public static function getJSScripts($jsScripts)
    {
        // obtem scripts css
        // declaracao de variaveis
        $jsList = '';
        if(is_array($jsScripts))
        {
            foreach ($jsScripts as $name) 
            {
                $jsList .= '$this->addJSScript(new JSFileScript(SystemConfiguration::getJSDir(), "'.$name.'.js"));';
                $jsList .= "\n";
            }
        }
        
        // retorno de valor
        return $jsList;        
    }
    
    private static function getGrid($className, $gridContent, array $array, $pattern)
    {        
        $grid = "";
        $count = 1;
        $vars = "";        
        
        $grid = "<?php\n".$pattern;            
        $grid = str_replace("{{date}}", SystemConfiguration::getCurrentDate(), $grid);
        $grid = str_replace("{{className}}", $className, $grid);
        $size = count($array);

        // verifica existencia de variaveis
        if(count($array) > 0)
        {
            foreach ($array as $value) 
            {
                if($count < $size)
                {
                    $vars .= "$".$value.", ";
                }else
                    {
                        $vars .= "$".$value;
                    }

                // incrementa o contador
                $count++;
            }
        }

        $grid = str_replace("{{var}}", $vars, $grid);
        $grid = str_replace("{{modelContent}}", $gridContent, $grid);        
        
        // retorno de valor
        return $grid;
    }
    
    public static function createDataGrid($gridContent, $pattern)
    {
        // cria um data grid
        // declaracao de variaveis
        $array = array();
        $status = false;
        $gridName = null;
        
        // verifica se o conteudo da grid existe
        if(strcmp($gridContent, "") != 0)
        {
            $gridName = StringManager::extract($gridContent, "<!--@Grid name=", "@-->");
            $gridContent = str_replace("<!--@Grid name=".$gridName."@-->", "", $gridContent);
            $gridName = StringManager::captalize($gridName);
            
            if(strcmp($gridName, "") != 0)
            {                    
                // obtem as variaveis da grid
                $amountVars = substr_count($gridContent, "<!--@var");

                // verifica se a grid possui variaveis
                if($amountVars > 0)
                {
                    // insere as variaveis no conteudo do script da grid
                    for($i = 1; $i <= $amountVars; $i++)
                    {
                        $varName = StringManager::extract($gridContent, "<!--@var name=", "@-->");                        
                        
                        // verifica se o nome de variavel eh nulo
                        if(strcmp($varName, "") != 0)
                        {
                            // cria um id para a variavel na grade de conteudo
                            $gridContent = str_replace("<!--@var name=".$varName."@-->", "\".$".$varName.".\"", $gridContent);
                            
                            // adiciona o nome da variavel a lista de array apenas uma vez
                            if(!in_array($varName, $array))
                            {
                                $array[] = $varName;

                            }
                        }
                        
                    }
                }

                // constroi um modelo de grid. Caso o arquivo ja exista ele sera substituido                                 
                $source = SystemConfiguration::getRoot() . WebTool::gridSource;
                $status = WebTool::createResource($source, $gridName, WebTool::getGrid($gridName, $gridContent, $array, $pattern));
            }
        }
        
        // retorno de valor
        return $status;
        
    }
    
    public static function extractGrids(Package $package, $pattern)
    {
        // extrai grades do layout e as cria como classes
        // declaracao de variaveis
        $newContent = $package->getContent();
        $gridContent = "";
        
        do
        {
            $gridContent = StringManager::extract($newContent, "<!--@Content Grid-->", "<!--/@Content Grid-->");
            $condition = strcmp($gridContent, "") != 0;
            if($condition)
            {
                // cria um objeto de data grid para o template
                $newContent = str_replace("<!--@Content Grid-->".$gridContent."<!--/@Content Grid-->", "", $newContent);
                
                // altera o flag do pacote
                if(!$package->getFlag())
                {
                    $package->setFlag(true);
                }
                
                // extrai sub grades
                do
                {    
                    $subGrid = StringManager::extract($gridContent, "<!--@Content SubGrid-->", "<!--/@Content SubGrid-->");
                    $secondCondition = strcmp($subGrid, "") != 0;
                    if($secondCondition)
                    {
                        $gridContent = str_replace("<!--@Content SubGrid-->".$subGrid."<!--/@Content SubGrid-->", "", $gridContent);
                    }
                    
                    WebTool::createDataGrid($subGrid, $pattern); 
                    
                }while($secondCondition); 
                
                WebTool::createDataGrid($gridContent, $pattern);     
                
            }

        }while($condition);
        
        // fixa o novo conteudo
        $package->setContent($newContent);
        
        // retorno de valor
        return $package;
    }
    
     public static function extractScripts($content, $type)
    {
        // extrai scripts de um documento e retorna um array de elementos
        // declaracao de variaveis
        $scripts = array();
        $contentHead = $content;
        $script = "";
     
        do
        {
            if(strpos($contentHead, "<!--@".$type) !== false)
            {
                $script = StringManager::extract($contentHead, "<!--@".$type." name=", " /".$type."-->");            
            }else
                {
                    $script = "";            
                }
                
            $condition = strcmp($script, "") != 0;
            
            if($condition)
            {                
                $scripts[] = $script;                
                $contentHead = str_replace("<!--@".$type." name=".$script." /".$type."-->", "", $contentHead);
            }
            
        }while($condition);
        
        // retorno de valor
        return $scripts;
    }
        
    public static function createResource($source, $name, $content)
    {
        // cria um recurso
        // declaracao de variaveis                
        $file = new File($source, $name.".php");
        $status = false;

        if($file->exist())
        {
            $file->delete();
        }

        $file->create();
        $status = $file->write($content);
        
        // retorno de valor
        return $status;
    }
    
    public static function findGrids(Package $package)
    {
        // encontra grades no conteudo
        $gridPattern = new File(SystemConfiguration::getRoot() . WebTool::templatePatternSource, "gridPattern.txt");
            
        if($gridPattern->exist())
        {
            $pattern = $gridPattern->read();

            // extrai grades do hipertexto
            $package = WebTool::extractGrids($package, $pattern);
        }
        
        // retorno de valor
        return $package;
    }
    
    public static function createTemplate($fileName, $className)
    {
        // declaracao de variaveis  
        $path = SystemConfiguration::getRoot();
        $file = new File($path . WebTool::designSource, $fileName); 
        $status = false;
        
        // verifica se o arquivo existe
        if($file->exist())
        {
            // obtem o conteudo do arquivo                        
            $package = WebTool::findGrids(new Package(StringManager::setQuotes($file->read())));
            $content = $package->getContent();
            
            // obtem arquivos de cabecalho
            $head = StringManager::extract($content, "<!--@Head-->", "<!--/@Head-->");
            $cssScripts =  WebTool::extractScripts($head, "css");
            $jsScripts = WebTool::extractScripts($head, "js");
            
            // obtem os componentes do template
            $structure = StringManager::extract($content, "<!--@Structure-->", "<!--/@Structure-->");
            $bodyContent = "<!--@Structure-->" . $structure;
            
            // verifica se o documento eh valido
            if(strcmp($structure, "") != 0)
            {
                $source = $path . WebTool::templateSource;
                $name = $className."Template";
                $status = WebTool::createResource($source, $name, WebTool::getScript($name, $bodyContent, $cssScripts, $jsScripts));                    
                
            }
        }
        
        // retorno de valor
        return $status;
    }
}