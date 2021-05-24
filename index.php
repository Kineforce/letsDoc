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
            <div id="tela-home" class="painel show">
                <h1>Bem vindo ao letsDoc, aplicação com o objetivo de auxiliar na documentação dos sistemas do IESB.</h1><br>
                <h2>Por favor, selecione alguma das opções no painel à esquerda para começar a navegar</h2>
            </div>
            <div id="tela-arq-serv" class="painel hide">
                <div class="as-content-wrapper">
                    <div class="as-label_busca_dinamica">
                        <form id="as-form_busca_dinamica" onsubmit="retornaDadosFiltrados(event)">
                            <label for="as-input_busca_dinamica" id="as-label-busca-dinamica">Busque qualquer palavra: </label></br></br>
                            <input type="text" id="as_input_busca_dinamica" value=""/><br><br>
                            <input type="submit" id="pesquisa_filtrada" value="Pesquisar" />
                        </form>
                    </div>
                    <div class="as-content">  
                        
                    </div>
                </div>
            </div>
            <div id="tela-arq-db" class="painel hide">
                <h1>Abrir painel para visualização e cadastro de dados a respeito da arquitetura do banco de dados!</h1>
            </div>
            <div id="tela-map-job" class="painel hide">
                <h1>Abrir painel para visualização e cadastro de dados a respeito do mapeamento de jobs e triggers!</h1>
            </div>
            <div id="tela-map-sis" class="painel hide">
                <h1>Abrir painel para visualização e cadastro de dados a respeito do mapeamento dos sistemas!</h1>
            </div>
        </div>
    </main>
    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>    
    <script src="./public/js/scripts_paineis.js"></script>
    <script src="./public/js/funcoes_arq_servers.js"></script>
</body>
</html>



