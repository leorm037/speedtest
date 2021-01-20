<!doctype html>
<html lang="pt_BR">
    <head>
        <title>Velocidade Internet Claro - 240Mbps</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?= theme("/assets/css/boot.css"); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= theme("/assets/css/style.css"); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= theme("/assets/css/dygraph.css"); ?>" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="ajax_load">
            <div class="ajax_load_box">
                <div class="ajax_load_box_circle"><img width="198" height="198" src="<?= theme("assets/img/loader.gif"); ?>"></div>
                <p class="ajax_load_box_title">Aguarde, carregando ...</p>
            </div>
        </div>
        <header class="header">
            <div class="header_container">
                <a href="<?= url(); ?>">
                    <h1>SPEEDTEST</h1>
                </a>
                <nav class="header_nav">
                    <ul>
                        <li><a onclick="return false;" id="measure" href="<?= url("medir"); ?>">medir agora</a></li>
                        <li><a href="<?= url(); ?>">1 dia</a></li>
                        <li><a href="<?= url("dias/3"); ?>">3 dia</a></li>
                        <li><a href="<?= url("dias/7"); ?>">1 semana</a></li>
                        <li><a href="<?= url("dias/30"); ?>">1 mês</a></li>
                        <li><a href="<?= url("dias/90"); ?>">3 meses</a></li>
                        <li><a href="<?= url("dias/90"); ?>">6 meses</a></li>
                        <li><a href="<?= url("dias/365"); ?>">1 ano</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <main class="main">
            <div class="main_content">
                <?= $v->section("content") ?>
            </div>
            <div class="main_graph">
                <canvas id="graphCanvas"></canvas>
            </div>
        </div>
    </main>
    <footer class="footer">            
    </footer>
    <script src="<?= theme("/assets/js/jquery.min.js"); ?>"></script>
    <script src="<?= theme("/assets/js/numeral.min.js"); ?>"></script>
    <script src="<?= theme("/assets/js/locales.min.js"); ?>"></script>
    <script src="<?= theme("/assets/js/moment.min.js"); ?>"></script>
    <script src="<?= theme("/assets/js/Chart.min.js"); ?>"></script>
    <script src="<?= theme("/assets/js/scripts.js"); ?>"></script>
    <?php if ($v->section("script")): ?>
        <?= $v->section("script"); ?>
    <?php else: ?>
        <script src="<?= theme("/assets/js/graph.js"); ?>"></script>
    <?php endif ?> 
</body>
</html>