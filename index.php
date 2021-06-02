<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/style_arq_servers.css">
    <link rel="stylesheet" href="./public/css/style_geral.css">
    <link rel="stylesheet" href="./public/css/style_arq_database.css">
    <link rel="icon" href="./favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>govTI</title>
</head>
<body>

    <?php

        // error_reporting(E_ALL | E_WARNING | E_NOTICE);
        // ini_set('display_errors', 1);

        // // Inicializando sessão
        // session_start();

        // // Se não existe uma variável login na sessão (herdada no login no GOnline), então o usuário não está autenticado
        // if(!isset($_SESSION['login'])){
        //     // Redirecionar para o site do IESB
        //     echo '<script>alert("Em construção!")</script>';
        //     exit();
        // }

    ?>

    <header style="display: none">
        <nav>
            <div id="logo_menu">
                <figure>
                    <img src="./iesb-logo.png" id="logo-iesb"/>
                    <figcaption>Documentação de sistemas do IESB</figcaption>
                </figure>
                <i class="fa fa-times" id="btn-oculta-menu" aria-hidden="true"></i>
            </div>
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
                <h1>Bem vindo ao govTI, aplicação com o objetivo de auxiliar na documentação dos sistemas do IESB.</h1><br>
                <h2>Por favor, selecione alguma das opções no painel à esquerda para começar a navegar</h2>
            </div>
            <div id="tela-arq-serv" class="painel hide">
                <div class="as-content-wrapper">
                    <div class="as-label_busca_dinamica">
                        <form id="as-form_busca_dinamica">
                            <label for="as-input_busca_dinamica" id="as-label-busca-dinamica">Busque qualquer palavra: </label></br></br>
                            <input type="text" id="as_input_busca_dinamica" value=""/><br><br>
                            <input type="submit" id="as_pesquisa_filtrada" value="Pesquisar" />
                        </form>
                    </div>
                    <div class="as-content">  
                    </div>
                </div>
            </div>
            <div id="tela-arq-db" class="painel hide">
                <div class="db-content-wrapper">
                    <div class="db-label_busca_dinamica">
                        <form id="db-form_busca_dinamica">
                            <label for="db-input_busca_dinamica" id="db-label-busca-dinamica">Busque qualquer palavra: </label></br></br>
                            <input type="text" id="db_input_busca_dinamica" value=""/><br><br>
                            <input type="submit" id="db_pesquisa_filtrada" value="Pesquisar" />
                        </form>
                    </div>
                    <div class="db-content">  
                    </div>
                </div>
            </div>
            <div id="tela-map-job" class="painel hide">
                <h1>Abrir painel para visualização e cadastro de dados a respeito do mapeamento de jobs e triggers!</h1>
            </div>
            <div id="tela-map-sis" class="painel hide">
                <h1>Abrir painel para visualização e cadastro de dados a respeito do mapeamento dos sistemas!</h1>
            </div>
        </div>
    </main>

    <!-- Modals para o painel de arquitetura de servidores --> 
        <!-- Modal para insert de dados servidor -->
        <div id="as_modal_cria_server" class="modal" style="display: none">
            <div class="as_modal_cria_server">
                <h2>Inserir novo registro de servidor</h2>
                <input type="text" name="nome" id="as_nome_servidor" placeholder="Nome do servidor"/>
                <textarea type="text" name="objetivo" id="as_objetivo_servidor" placeholder="Objetivo do servidor"></textarea>
                <input type="text" name="linguagem" id="as_linguagem_servidor" placeholder="Linguagem do servidor"/>
                <select id="as_ativo_servidor">
                    <option value="" selected disabled>Ativo?</option>
                    <option value="S">Sim</option>
                    <option value="N">Não</option>
                </select>
                <input type="submit" id="as_cadastra" value="Cadastrar" />
            </div>
        </div>

        <!-- Modal para insert de dados subitem servidor -->
        <div id="as_modal_cria_server_subitem" class="modal" style="display: none">
            <div class="as_modal_cria_server_subitem">
                <h2>Inserir novo item do servidor</h2>
                <input type="hidden" id="id_servidor_subitem" value="" />
                <input type="text" name="nome" id="as_nome_servidor_subitem" placeholder="Nome do item"/>
                <textarea type="text" name="descricao" id="as_descricao_servidor_subitem" placeholder="Descrição do item"></textarea>
                <select id="as_ativo_servidor_subitem">
                    <option value="" selected disabled>Ativo?</option>
                    <option value="S">Sim</option>
                    <option value="N">Não</option>
                </select>
                <input type="submit" id="as_cadastra_subitem" value="Cadastrar" />
            </div>
        </div>

        <!-- Modal para update de dados servidor -->
        <div id="as_modal_update_server" class="modal" style="display: none">
            <div class="as_modal_update_server">
                <h2>Atualizar registro do item atual</h2>
                <input type="hidden" name="id" id="as_id_update" value="" />
                <input type="text" name="nome" id="as_nome_servidor_update" placeholder="Nome do servidor"/>
                <textarea type="text" name="objetivo" id="as_objetivo_servidor_update" placeholder="Objetivo do servidor"></textarea>
                <input type="text" name="linguagem" id="as_linguagem_servidor_update" placeholder="Linguagem do servidor"/>
                <select id="as_ativo_servidor_update">
                    <option value="" selected disabled>Ativo?</option>
                    <option value="S">Sim</option>
                    <option value="N">Não</option>
                </select>
                <input type="submit" id="as_update" value="Update" />
            </div>
        </div>

        <!-- Modal para update de dados subitem servidor -->
        <div id="as_modal_update_server_subitem" class="modal" style="display: none">
            <div class="as_modal_update_server_subitem">
                <h2>Atualizar registro atual</h2>
                <input type="hidden" name="id" id="as_id_update_subitem" value="" />
                <input type="text" name="nome" id="as_nome_update_subitem" placeholder="Nome do item"/>
                <textarea type="text" name="descricao" id="as_descricao_update_subitem" placeholder="Descrição do item"></textarea>
                <select id="as_ativo_update_subitem">
                    <option value="" selected disabled>Ativo?</option>
                    <option value="S">Sim</option>
                    <option value="N">Não</option>
                </select>
                <input type="submit" id="as_update_subitem" value="Update" />
            </div>
        </div>

    <!-- Modals para o painel de databases -->
        <!-- Modal para insert de dados database -->
        <div id="db_modal_cria_database" class="modal" style="display: none">
            <div class="db_modal_cria_database">
                <h2>Inserir novo registro de banco de dados</h2>
                <input type="text" name="nome" id="db_nome_database" placeholder="Nome do banco de dados"/>
                <textarea type="text" name="objetivo" id="db_descricao_database" placeholder="Descricao do banco de dados"></textarea>
                <select id="db_ambiente">
                    <option value="" selected disabled>Ambiente</option>
                    <option value="Prod">Produção</option>
                    <option value="Homolog">Homologação</option>
                    <option value="Desenv">Desenvolvimento</option>
                </select>
                <select id="db_ativo_database">
                    <option value="" selected disabled>Ativo?</option>
                    <option value="S">Sim</option>
                    <option value="N">Não</option>
                </select>
                <input type="submit" id="db_cadastra" value="Cadastrar" />
            </div>
        </div>

        <!-- Modal para update de dados database -->
        <div id="db_modal_update_database" class="modal" style="display: none">
            <div class="db_modal_update_database">
                <h2>Atualizar registro do item atual</h2>
                <input type="hidden" name="id" id="db_id_update" value="" />
                <input type="text" name="nome" id="db_nome_database_update" placeholder="Nome do banco de dados"/>
                <textarea type="text" name="descricao" id="db_descricao_update" placeholder="Descrição do banco de dados"></textarea>
                <select id="db_ambiente_update">
                    <option value="" selected disabled>Ambiente</option>
                    <option value="Prod">Produção</option>
                    <option value="Homolog">Homologação</option>
                    <option value="Desenv">Desenvolvimento</option>
                </select>
                 <select id="db_ativo_database_update">
                    <option value="" selected disabled>Ativo?</option>
                    <option value="S">Sim</option>
                    <option value="N">Não</option>
                </select>
                <input type="submit" id="db_update" value="Update" />
            </div>
        </div>

        <!-- Modal para insert de dados subitem database -->
        <div id="db_modal_cria_database_subitem" class="modal" style="display: none">
            <div class="db_modal_cria_database_subitem">
                <h2>Inserir novo item do banco de dados</h2>
                <input type="hidden" id="db_database_subitem" value="" />
                <input type="text" name="nome" id="db_nome_database_subitem" placeholder="Nome da tabela"/>
                <textarea type="text" name="descricao" id="db_descricao_database_subitem" placeholder="Descrição da tabela"></textarea>
                <input type="submit" id="db_cadastra_subitem" value="Cadastrar" />
            </div>
        </div>

        <!-- Modal para update de dados subitem servidor -->
        <div id="db_modal_update_database_subitem" class="modal" style="display: none">
            <div class="db_modal_update_database_subitem">
                <h2>Atualizar registro atual</h2>
                <input type="hidden" name="id" id="db_id_update_subitem" value="" />
                <input type="text" name="nome" id="db_nome_update_subitem" placeholder="Nome do item"/>
                <textarea type="text" name="descricao" id="db_descricao_update_subitem" placeholder="Descrição do item"></textarea>
                <input type="submit" id="db_update_subitem_database" value="Update" />
            </div>
        </div>


    <script src="./public/jquery/jquery-3.6.0.min.js"></script>    
    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <!-- Scripts utilizados nos paineis -->
    <script src="./public/js/scripts_paineis.js"></script>
    <!-- Scripts para a tela de arquitetura de servidores -->
    <script src="./public/js/arq_servers/el_arq_servers.js"></script>
    <script src="./public/js/arq_servers/funcoes_arq_servers.js"></script>
    <!-- Scripts para a tela de arquitetura de banco de dados -->
    <script src="./public/js/arq_database/funcoes_arq_database.js"></script>
    <script src="./public/js/arq_database/el_arq_database.js"></script>
</body>
</html>



