<?php
/* Template gerado dinamicamente com SM.
 * 
 * Marcelo Barbosa,
 * 30/08/2016.
 */

// declaracao do namespace
namespace SM\Library\Web\Template\SM;

// importacao de classes
use SM\Library\Web\HTMLPage;
use SM\Configuration\SystemConfiguration;
use SM\Library\Web\CSSFileScript;
use SM\Library\Web\JSFileScript;

// declaracao da classe
class SMTemplate extends HTMLPage
{
    // declaracao de metodos
    public function __construct($title = "HTML document", $chaset = "utf-8") 
    {
        // metodo construtor
        // inicializa a superclasse
        parent::__construct($title, $chaset);

        // inicializa scripts
        $this->initScripts();

        // configura o corpo do documento web
        $this->setBody("\n<body>\n"
                        ."<!-- @Structure -->
        <div class=\"scenery\" id=\"scenery\">
            <div class=\"header\">
                <!-- @Header --> 
                
            </div>
            <div class=\"session\"></div>
            <div class=\"content\">
                <!-- @Content -->
                
                
                
                 
                 

            </div>			
        </div>
        <!-- @Navigation -->
        
        "
                . "<!-- Script JS -->\n"
                   ."\n</body>\n");
    }

    public function initScripts()
    {
        // inicializa as listas de scripts
        // adiciona arquivos de script CSS e JS
        $this->addCSSScript(new CSSFileScript(SystemConfiguration::getCSSDir(), "SM/style.css"));
$this->addJSScript(new JSFileScript(SystemConfiguration::getJSDir(), "SM/library.js"));

    }
}