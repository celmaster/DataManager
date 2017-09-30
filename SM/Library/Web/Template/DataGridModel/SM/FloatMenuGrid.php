<?php
/* Grid criado automaticamente com SM
 * 
 * Marcelo Barbosa,
 * 30/08/2016.
 */

// declaracao do namespace
namespace SM\Library\Web\Template\DataGridModel\SM;

// importacao de classes
use SM\Library\Web\DataGrid\DataGrid;

// declaracao da classe
class FloatMenuGrid extends DataGrid
{
    // declaracao de metodos
    public function __construct($title) 
    {
        // inicializa a superclasse
        parent::__construct("", "Data Grid");

        $this->gridModeling($title);
    }
    
    public function gridModeling($title)
    {
        // modela o conteudo de uma data grid
        // declaracao de variaveis
        $model = "
        
        <!-- navbutton -->		
        <div class=\"navbutton\" id=\"navbutton\" onclick=\"showNavbar(true)\"></div>
        <!-- navbar -->
        <div class=\"nonDisplay\" id=\"navbar\">
            <div class=\"navbarContent\">
                <p class=\"title3 center\">".$title."</p>
                <ul class=\"navLinks\">
                    <!-- @Grid rule -->
                    <!--@rule tagname=itemMenu@-->
                    <!-- #define:<li onclick=\"@var=function@/('@var=parameter@/')\">@var=itemName@/</li>#-->
                    <!-- /@Grid rule -->
                    <!--@Ignore-->
                    <li onclick=\"navLink('description')\">Descrição</li>
                    <li onclick=\"navLink('details')\">Detalhes</li>
                    <li onclick=\"navLink('references')\">Referências</li>
                    <li onclick=\"navLink('about')\">Sobre</li>
                    <!--/@Ignore-->
                </ul>
            </div>
            <div class=\"closebutton\" id=\"closebutton\" onclick=\"showNavbar(false)\"></div>
            <div class=\"topbutton\" onclick=\"navLink('scenery')\"></div>
        </div>
        <div class=\"nonDisplay\" id=\"darkbackground\"></div>
        ";
        
        // fixa o conteudo da grid
        $this->setGrid($model);
    }
}