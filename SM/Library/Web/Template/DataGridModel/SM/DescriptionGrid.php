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
class DescriptionGrid extends DataGrid
{
    // declaracao de metodos
    public function __construct() 
    {
        // inicializa a superclasse
        parent::__construct("", "Data Grid");

        $this->gridModeling();
    }
    
    public function gridModeling()
    {
        // modela o conteudo de uma data grid
        // declaracao de variaveis
        $model = "
                
                <div class=\"descriptionArea grid\"  id=\"description\">	
                    <div class=\"borderStamp1\"></div>					
                    <div class=\"sustainableBlock\">	
                    </div>					
                    <div class=\"grid\">
                        <div class=\"opacityBlock\">	
                            <div class=\"blockText\">																								
                                <p class=\"firstP\">
                                    As dimensões de modelagem de aplicações web organizam-se em: aspectos, níveis/camadas e fases de desenvolvimento.
                                    Os aspectos definem a estrutura e comportamento de cada um dos níveis, ou camadas, a serem trabalhados
                                    durante o design de uma aplicação web. Assim, a estrutura preocupa-se com a organização do conteúdo, 
                                    hipertexto e apresentação, sendo este último nível trabalhado com componentes de interface do usuário. Já 
                                    o comportamento preocupa-se com os eventos que a interface e seus componentes deverão prover ao usuário durante 
                                    sua interação com a aplicação web (KAPPEL et al., 2001).
                                </p>
                                <p class=\"firstP\">
                                    Os níveis, ou camadas, especificam como o conteúdo será disponibilizado ao usuário através de uma aplicação 
                                    web. Este conteúdo é composto de um conjunto de dados que são voltados a um domínio de conhecimento, ou área de 
                                    interesse significante aos usuários. Sendo assim, este conteúdo é exibido aos usuários por meio do hipertexto,
                                    que por sua vez tem seus componentes de interface personalizados através da camada de apresentação.
                                </p>
                                <p class=\"firstP\">
                                    As fases, por sua vez, descrevem as etapas do processo de desenvolvimento de aplicações web. Neste caso,
                                    inicialmente é realizada a análise de requisitos dos usuários e consequentemente descrição dos processos dos 
                                    quais o design da aplicação deverá suprir. Durante a fase de design, a interface da aplicação web é estudada 
                                    e modelada através de protótipos. Após isso, o protótipo passa pela validação e avaliação. Caso seja aprovado 
                                    nessa etapa, ele é finalmente elaborado e liberado para os usuários.
                                </p>
                                <p class=\"firstP\">
                                    Contudo, o diagrama proposto por Kappel et al. (2001) também demonstra limitações no que se refere à dependência 
                                    entre os elementos da dimensão abrangida pelos níveis de uma aplicação web. Isso ocorre porque a personalização da 
                                    apresentação do conteúdo depende da estruturação do hipertexto, o que significa que a cada novo layout de 
                                    interface que se deseje aplicar em uma aplicação web, tornar-se-á necessário editar o hipertexto de todos 
                                    os documentos que designam as seções que esta aplicação web oferece aos seus usuários, tarefa essa que 
                                    se mostra árdua e pouco eficiente diante do design de aplicações web. 
                                </p>								
                                <p class=\"firstP\">
                                    Para contornar essas limitações o framework SM considera uma versão adaptada do diagrama proposto por Kappel et al. (2001). 
                                    A essa versão adaptada acrescentou-se uma camada de modelagem, denominada de modelo, entre a camada de conteúdo e hipertexto. 
                                    Essa nova camada visa garantir independência entre conteúdo, hipertexto e apresentação, de modo que o design de interfaces 
                                    torne-se flexível e escalável para a aplicação sem a necessidade de aplicar modificações de design diretamente sobre suas inúmeras 
                                    seções.
                                </p>
                                <div class=\"webArchitecture\"></div>	
                                <p class=\"firstP\">
                                    Em síntese, a camada de modelagem fornece meios para garantir que o conteúdo seja apresentado ao usuário independentemente do design de sua 
                                    interface. Por meio dessa abstração entre conteúdo e apresentação, pode-se agregar significado a esse conteúdo através de um aspecto semântico. 
                                    O aspecto semântico foi incorporado ao diagrama de Kappel et al. (2001) para fornecer meios para habilitar a comunicação entre aplicações web inteligentes 
                                    que possam interpretar esse conteúdo e gerar respostas satisfatórias às necessidades dos usuários.

                                </p>
                                <p class=\"firstP\">
                                    Em virtude disso, essa metodologia fornece ferramentas práticas para a criação de templates dinâmicos através de modelos criados com HTML, CSS e JS. 
                                    Para isso, essa metodologia utiliza metadados para dar semântica à estrutura dos documentos web para extração e geração dinâmica de templates 
                                    e seus componentes.
                                </p>								
                                <p class=\"firstP\">
                                    Uma vez que um template tenha sido criado, o designer pode alterar a estrutura de apresentação 
                                    de suas aplicações web sem ter que se preocupar com a disposição de seu conteúdo sobre a 
                                    interface criada dinamicamente. 
                                </p>
                            </div>
                        </div>
                    </div>
                </div>	
                ";
        
        // fixa o conteudo da grid
        $this->setGrid($model);
    }
}