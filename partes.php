<?php
$NOM_SISTEMA = 'Agenda 2030';
$NOM_PAGINA  = null;

function getInicio(){
    global $NOM_SISTEMA;
    global $NOM_PAGINA;

    $DESC_SISTEMA = 'Plataforma online da Agenda 2030 para o Desenvolvimento Sustentável';
    $PALAVRAS_CHV = 'ODS, Objetivos, Desenvolvimento, Sustetável';

    include_once 'conectar.php';
?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta name="viewport" content="width=device-width" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="utf-8">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content='pt-BR' />
        <meta name="country" content="Brazil" />
        <meta name="geo.country" content="BR" />
        <meta content="4mti" name="author" />
        <meta name="robots" content="index, follow, noarchive" />
        <meta name="googlebot" content="noarchive" />
        <!--
        <link rel="sitemap" type="application/xml" title="Sitemap" href="sitemap.php" />
        -->
        <meta name="application-name" content="<? echo $NOM_SISTEMA; ?>"  />
        <link rel="shortcut icon" type="image/x-icon" href="img/logo_pq.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="img/logo_pq.png" />
        <link rel="apple-touch-icon" type="image/x-icon" href="img/logo_pq.png" />

        <title><? echo $NOM_SISTEMA . ( isset($NOM_PAGINA) ? ' - ' . $NOM_PAGINA : '' ); ?></title>
        <meta name="description" content="<? echo $DESC_SISTEMA; ?>">
        <meta name="keywords" content="<? echo $PALAVRAS_CHV; ?>" />

        <meta property="fb:app_id" content="796464717165526" />
        <meta property="og:locale" content="pt_BR" />
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="<? echo $NOM_SISTEMA; ?>" />
        <meta property="og:image" content="http://52.24.9.238/sala_situacao_nescon/img/logo_dp.png" />
        <meta property="og:title" content="<? echo $NOM_SISTEMA; ?>" />
        <meta property="og:description" content="<? echo $DESC_SISTEMA; ?>" />

        <link rel="stylesheet" type="text/css" href="css/jquery.fullpage.css" />
        <link rel="stylesheet/less" type="text/css" href="css/genesis.less">
        <script type="text/javascript" src="js/less.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/screen.css"/>
        <link rel="stylesheet" type="text/css" href="css/menu.css"/>

        <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="js/jquery.number.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/jquery.fullpage.min.js"></script>
        <script type="text/javascript" src="js/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="js/xsl.js"></script>
        <script type="text/javascript" src="js/util.js"></script>
        <script type="text/javascript" src="js/brain.js.php"></script>

        <link href="js/c3-0.4.11/c3.css" rel="stylesheet" type="text/css">
        <script src="js/d3.v3.min.js" charset="utf-8"></script>
        <script src="js/c3-0.4.11/c3.min.js"></script>
        <script type="text/javascript" src="js/grafico.js"></script>
    </head>
    <body>
        <header>
            <div id="menu-burger-wrapper" onclick="openNav();">
                <div class="line-burger"></div>
                <div id="menu-burger">
                    <div class="line line-1"></div>
                    <div class="line line-2"></div>
                    <div class="line line-3"></div>
                </div>
            </div>
        </header>
        <div id="mySidenav" class="sidenav">
            <a href="#abertura">Abertura</a>
            <a href="#objetivos">Objetivos</a>
            <a href="#territorio">Território</a>
            <a href="#projetos">Projetos</a>
            <a href="#agenda">Agenda</a>
            <!--<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>-->
        </div>
        <div id="fullpage">
            <div class="section abertura">
                <!--
                https://css-tricks.com/snippets/css/css-triangle/
                http://tympanus.net/Development/ArrowNavigationStyles/
http://html-tuts.com/css-arrows-up-down-left-right-triangle/
                http://tympanus.net/Development/HoverEffectIdeas/index.html
                http://www.cssauthor.com/jquery-css3-hover-effects/
http://www.akaru.fr/
http://enjoycss.com/start#transition
http://www.sony-asia.com/microsite/mdr-10/#aboutPage
http://educationaboveall.org
                -->
                <video autoplay muted loop>
                    <!--<source src="img/DockHdr.mp4" type="video/mp4">-->
                </video>
                <h1><div>Agenda 2030</div> para o Desenvolvimento Sustentável</h1>
                <div id="teste"></div>
                <script>
                    $('#teste').html('width: ' + $( window ).width() + ' - ' + $( document ).width() + '<br/>height: ' + $( window ).height() + ' - ' + $( document ).height());
                </script>
                <form class="cadastro" action="javascript:cadastrar();">
                    <label for="email">Seu e-mail:</label><input id="email" type="text" name="email"/>
                    <button type="submit">Cadastrar</button>
                </form>
                <div id="menu_opcoes" class="opcoes">
                    <div class="opcao"><a href="#objetivos">Objetivos</a></div>
                    <div class="opcao"><a href="#territorio">Território</a></div>
                    <div class="opcao"><a href="#projetos">Projetos</a></div>
                    <div class="opcao"><a href="#agenda">Agenda</a></div>
                </div>
            </div>

            <div class="section">
                <script type="text/javascript" src="js/d3.v3.min.js"></script>
                <script type="text/javascript" src="js/sunburst.js"></script>
                <div class="slide objetivos">
                    <div class="menu_pag btt_ant">
                        <div class="triangulo"></div>
                        <a href="#abertura">Abertura</a>
                    </div>
                    <h2>Objetivos</h2>
                    <div>
                        <div id="grafico_menu">
                            <div id="ex_wp"><h2 id="explanation"></h2></div>
                        </div>
                        <script>
                            var root = {
                                'name':'0',
                                'size':17,
                                'children':[
                            <?
                                $sql = 'select seq_dim_ods, nom_ods, dsc_ods
                                          from dim_ods order by seq_dim_ods;';
                                $result = $conn->query($sql);
                                $cont = 1;
                                while( $row = $result->fetch_assoc() ) {
                                    if( $cont != 1 ){
                                        echo ',';
                                    }
                                    echo "{'chave':'{$row['seq_dim_ods']}','name':'{$row['nom_ods']}','size':'1'}\n\r";
                                    $cont++;
                                }
                            ?>
                                ]
                            };
                            gerarSunburst();
                        </script>
                    </div>
                    <div class="menu_pag btt_prox">
                        <div class="triangulo"></div>
                        <a href="#territorio">Território</a>
                    </div>
                    <a class="next c1" href="javascript:$.fn.fullpage.moveSlideRight();"><i class="fa fa-step-forward" aria-hidden="true"></i></a>
                </div>
                <?php
                    //Busca os ODS e os apresenta na tela
                    $sql = 'select seq_dim_ods, nom_ods, dsc_ods
                              from dim_ods
                             order by seq_dim_ods;';
                    $result = $conn->query($sql);
                    while( $row = $result->fetch_assoc() ) {
                        echo "<div class=\"slide c{$row['seq_dim_ods']}\">";
                        echo "<div class='titulo'><h2>{$row['seq_dim_ods']}. {$row['nom_ods']}</h2>";
                        echo "<span class=\"dsc\">{$row['dsc_ods']}</span></div>";
                        echo "<div class=\"d_ind\" id=\"inds_{$row['seq_dim_ods']}\"></div>";

                        $sql = "select m.seq_dim_meta, m.num_meta, m.dsc_meta
                                  from dim_meta m
                                 where m.seq_dim_ods = {$row['seq_dim_ods']}
                                 order by m.num_meta;";
                        $metas = $conn->query($sql);
                        echo '<span style="font-size:1.2em;margin-left:30px;">Metas:</span>';
                        echo '<ul class="metas">';
                        while( $meta = $metas->fetch_assoc() ) {
                            echo "<li class=\"meta\" id=\"m{$meta['seq_dim_meta']}\"><a title=\"Detalhar meta\" href=\"javascript:mostraMeta({$row['seq_dim_ods']}, {$meta['seq_dim_meta']});\"><div>{$meta['num_meta']} - {$meta['dsc_meta']}</div></a></li>";
                        }
                        echo '</ul>';

                        echo '<a class="prev c' . ($row['seq_dim_ods'] - 1) . '" href="javascript:$.fn.fullpage.moveSlideLeft();"><i class="fa fa-step-backward" aria-hidden="true"></i></a>';
                        echo '<div id="btt_objetivos" onclick="toogleMenu();"></div>';
                        if( $row['seq_dim_ods'] < 17 ){
                            echo '<a class="next c' . ($row['seq_dim_ods'] + 1) . '" href="javascript:$.fn.fullpage.moveSlideRight();"><i class="fa fa-step-forward" aria-hidden="true"></i></a>';
                        }
                        echo '</div>';
                    }
                ?>
            </div>

            <?
            /**
             * Página sobre com o Território
             */
            ?>
            <div class="section territorio">
                <div id="mapa"></div>
                <div class="menu_pag btt_ant">
                    <div class="triangulo"></div>
                    <a href="#objetivos">Objetivos</a>
                </div>
                <h2>Território</h2>
                <div class="menu_pag btt_prox">
                    <div class="triangulo"></div>
                    <a href="#projetos">Projetos</a>
                </div>
            </div>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBO8Cn0J79Pfmv61d780xpT8178Cnedw7Y"></script>
            <script>
                var options = {
                    center:{lat:-15.7941, lng:-47.8825},
                    zoom:4,
                    mapTypeControl: true,
                    mapTypeControlOptions:{
                        position: google.maps.ControlPosition.RIGHT_BOTTOM
                    },
                    zoomControl: true,
                    zoomControlOptions:{
                        position: google.maps.ControlPosition.RIGHT_CENTER
                    },
                    scaleControl: true,
                    streetViewControl: false
                };
                var map = new google.maps.Map(document.getElementById('mapa'), options);
            </script>

            <?
            /**
             * Página sobre os Projetos
             */
            ?>
            <div class="section projetos">
                <video id="video_projetos" autoplay="" muted="" loop="" data-keepplaying>
                    <source src="img/formiga.webm" type="video/webm"/>
                    <source src="img/formiga.mp4" type="video/mp4"/>
                </video>
                <div class="menu_pag btt_ant">
                    <div class="triangulo"></div>
                    <a href="#territorio">Território</a>
                </div>
                <h2>Projetos</h2>
                <div class="menu_pag btt_prox">
                    <div class="triangulo"></div>
                    <a href="#agenda">Agenda</a>
                </div>
            </div>

            <?
            /**
             * Página sobre os Projetos
             */
            ?>
            <div class="section agenda">
                <div class="menu_pag btt_ant">
                    <div class="triangulo"></div>
                    <a href="#projetos">Projetos</a>
                </div>
                <h2>Agenda</h2>
                <footer>
                    <div id="footer-button"></div>
                    <div class="footer-container">
                        <div id="footer-small">
                            Desenvolvido por PNUD
                        </div>
                        <div id="footer-big">
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
    <script>
        $(document).ready(function() {
            $('#fullpage').fullpage({
                anchors: ['abertura', 'objetivos', 'territorio', 'projetos', 'agenda'],
                controlArrows: false,
                loopHorizontal: false,
                afterRender: function(){
                    $('#video_projetos').get(0).play();
                }
            });
        });
/*
        window.smartlook||(function(d) {
            var o=smartlook=function(){ o.api.push(arguments)},s=d.getElementsByTagName('script')[0];
            var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
            c.charset='utf-8';c.src='//rec.getsmartlook.com/bundle.js';s.parentNode.insertBefore(c,s);
        })(document);
        smartlook('init', '9128cea0314f08f8198ffea0e11d9eb6fcf61349');
        smartlook('tag', 's', 'AG');
*/
    </script>
    </html>
    <?
}