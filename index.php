<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/style.css">
    <title>letsDoc</title>
</head>
<body>

    <header>
        <nav>
            <figure>
                <img src="./iesb-logo.png" id="logo-iesb"/>
                <figcaption>Documentação de sistemas do IESB</figcaption>
            </figure>
            <span id="arquitetura-servidores" class="span-menu-generico">
                <span class="texto-menu-generico">
                    Arquitetura de servidores
                </span>
            </span>
            <span id="arquitetura-banco" class="span-menu-generico">
                <span class="texto-menu-generico">
                    Arquitetura de banco de dados
                </span>
            </span>
            <span id="mapeamento-jobs" class="span-menu-generico">
                <span class="texto-menu-generico">
                    Mapeamento de Jobs, triggers no banco de dados
                </span>
            </span>
            <span id="mapeamento-sistemas" class="span-menu-generico">
                <span class="texto-menu-generico">
                    Mapeamento de Sistemas
                </span>
            </span>
        </nav>
    </header>

    <main>
        <div class="container"> 
            <div id="tela-home" class="show">
                Selecione alguma opção à esquerda...
            </div>
            <div id="tela-arq-serv" class="hide">
                <h1>Abrir painel para visualização e cadastro de dados a respeito da arquitetura de servidores!</h1>
            </div>
            <div id="tela-arq-db" class="hide">
                <h1>Abrir painel para visualização e cadastro de dados a respeito da arquitetura do banco de dados!</h1>
            </div>
            <div id="tela-map-job" class="hide">
                <h1>Abrir painel para visualização e cadastro de dados a respeito do mapeamento de jobs e triggers!</h1>
            </div>
            <div id="tela-map-sis" class="hide">
                <h1>Abrir painel para visualização e cadastro de dados a respeito do mapeamento dos sistemas!</h1>
            </div>
        </div>
    </main>
    

    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="./public/js/scripts.js"></script>
</body>
</html>



