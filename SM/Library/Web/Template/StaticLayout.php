<?php

/* Modela componentes estaticos de interface
 * 
 * Marcelo Barbosa 
 * outubro, 2015.
 */

// declaracao do namespace
namespace SM\Library\Web\Template;

// importacao de classes
use SM\Library\Database\FotoDAO;
use SM\Library\Database\Context\Context;
use SM\Library\Database\Context\ContextElement;
use SM\Library\Utils\ProcessContext; 

// declarcaao da classe
class StaticLayout
{
    // declaracao de metodos estaticos
    public static function getMenu()
    {
        // obtem o menu do website
        return "<div class=\"drop-down-menu\">
            <div id=\"background-menu\" class=\"background-menu\"></div>                        
            <div id=\"menu-top-icon\" class=\"smartphone-device-element menu-top-icon\">
                <a href=\"javascript:navPage('#');closeMenu()\">
                    <p class=\"font-tangerine text-color-black text-size-x-large bg-color-white\">
                        Voltar ao topo
                    </p>
                </a>
            </div>
            <div id=\"menu-close-button\" class=\"close-icon fa fa-close\" onclick=\"closeMenu();\"></div>            
            <div id=\"menu-icon\" class=\"menu-icon fa fa-bars\" onclick=\"openMenu()\"></div>            
            <div id=\"menu\" class=\"menu bg-color-new-red\">
                <ul id=\"menu-items\" class=\"menu-items\">	                    
                    <li>
                        <a href=\"inicio.php\"><p><span class=\"fa fa-home\"></span> Página inicial</p></a>
                    </li>
                    <li>
                        <p><span class=\"fa fa-star-o\"></span> Conheça nosso buffet</p>
                        <ul id=\"sub-menu-conheca-o-buffet\">
                            <li>
                                <a href=\"nossoEspaco.php\"><p>Nosso espaço</p></a>
                            </li>                            
                            <li>
                                <a href=\"servicosOpcionais.php\"><p>Serviços opcionais</p></a>
                            </li>                            
                        </ul>
                    </li>                    
                    <li>
                        <p>Confira nossos cardápios</p>
                        <ul id=\"sub-menu-cardapios\">
                            <li>
                                <a href=\"cardapioTravessuras.php\"><p>Cadápio Travessuras</p></a>
                            </li>							
                            <li>
                                <a href=\"cardapioTravessurasSocial.php\"><p>Cadápio Travessuras Social</p></a>
                            </li>                            
                        </ul>
                    </li>                    
                    <li>
                        <a href=\"decoracoes.php\"><p>Decorações</p></a>
                    </li>
                    <li>
                        <a href=\"promocoes.php\"><p>Promoções</p></a>
                    </li>
                    <li>
                        <a href=\"orcamento.php\"><p><span class=\"fa fa-handshake-o\"></span> Orçamento</p></a>
                    </li>                    
                    <li>
                        <a class=\"desktop-device-element desktop-and-tablet-device-element\" href=\"#entre-em-contato\"><p><span class=\"fa fa-comments\"></span> Contato</p></a>						
                        <a class=\"smartphone-device-element\" href=\"javascript:navLink('entre-em-contato');closeMenu();\"><p><span class=\"fa fa-comments\"></span> Contato</p></a>
                    </li>                    
                </ul>
            </div>
        </div>";
    }
    
    public static function getFooter()
    {
        // obtem o rodape
        return " <div class=\"container footer-border-decoration bg-repeat-x bg-center-top\"></div>
        <div class=\"container bg-color-new-red\">
            <div class=\"container text-color-white\">
                <h2 id=\"entre-em-contato\" class=\"text-size-large font-poppins text-center small-padding\"><span class=\"fa fa-comments\"></span> Entre em contato:</h2>                
                <p class=\"font-quicksand text-size-medium text-center text-bold\">Terça à Sexta - 9:00 às 12:30 - 14:00 às 19:00hs<br>Sábado - 9:00 às 16:00hs </p>
                <a href=\"https://api.whatsapp.com/send?phone=5511947500609\">
                    <p class=\"font-quicksand text-size-medium text-color-white text-center\">
                        <span class=\"fa fa-whatsapp\"></span> 
                        (11) 94750-0609
                    </p>				
                </a>
                <a href=\"tel:+551124752804\">
                    <p class=\"font-quicksand text-size-medium text-color-white text-center\">
                        <span class=\"fa fa-phone\"></span>
                        (11) 2475-2804
                    </p>				
                </a>
                <a href=\"https://www.facebook.com/travessurastravessuras/\" target=\"_blank\">
                    <p class=\"font-quicksand text-size-medium text-color-white text-center overflow-x\">
                        <span class=\"fa fa-facebook-official\"></span> 
                        Travessuras Travessuras 
                    </p>
                </a>
                <a href=\"mailto:travessurasbuffet1@hotmail.com\">
                    <p class=\"font-quicksand text-size-medium text-color-white text-center overflow-x\">
                        <span class=\"fa fa-envelope\"></span> 
                        travessurasbuffet1@hotmail.com
                    </p>
                </a>                
            </div>            
            <div class=\"container bg-alpha-gradient-4-color-black\">
                <h2 class=\"font-poppins text-size-large text-color-white text-center small-padding\"><span class=\"fa fa-map-marker\"></span> Nossa localização:</h2>                
            </div>            
        </div>
        <div class=\"container\">
            <iframe class=\"col-12 long-height no-border\" src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3660.0237995612483!2d-46.511144300000005!3d-23.459606!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce8acffb84a583%3A0x6beb87ee484dfe09!2zQXYuIE90w6F2aW8gQnJhZ2EgZGUgTWVzcXVpdGEsIDU5MSAtIOODtOOCo-ODvOODqeODu-ODleODreODquODgCBHdWFydWxob3MgLSBTUA!5e0!3m2!1spt-BR!2sbr!4v1410120179948\"></iframe>
        </div>";
    }
    
}

