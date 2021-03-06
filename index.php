<?php

/**
 * =======================================================================
 *  GOVTI - SISTEMA DE DOCUMENTAÇÃO DOS SISTEMAS DO IESB
 * =======================================================================
 * 
 * Autor: Lucas Souza Martins
 * Email: lucas.martins@iesb.br / lucas-sm2010@hotmail.com
 * Data: 23/06/2021
 * 
 * A aplicação funciona como uma espécie de MVC
 * No arquivo src/routes são adicionados as rotas da aplicação
 * Que são direcionadas para os controllers e por fim invocando 
 * Ou não as models.
 * 
 */

// Inicializando sessão para integrar com a sessão do GOnline
if (!isset($_SESSION)) {
    session_start();
}

$_SESSION['login'] = 'promitere';

// Se não existe uma variável login na sessão (herdada no login no GOnline), então o usuário não está autenticado
if (!isset($_SESSION['login'])) {
    // Redirecionar para o site do IESB
    header("Location: http://iesb.br");
    die();
}

?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS Bootstrap 5 -->
    <link rel="stylesheet" href="./public/bootstrap5/css/bootstrap.min.css">
    <!-- CSS Painel arquitetura de servidores -->
    <link rel="stylesheet" href="./public/css/style_arq_servers.css">
    <!-- CSS Painéis gerais -->
    <link rel="stylesheet" href="./public/css/style_geral.css">
    <!-- CSS Painel arquitetura de database -->
    <link rel="stylesheet" href="./public/css/style_arq_database.css">
    <link rel="icon" href="./favicon.ico" />
    <!-- CSS Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>govTI</title>
</head>

<body class="d-flex h-100">
    <header class="p-3 bg-light bg-gradient" style="display: none">
        <nav class="d-flex flex-column justify-content-around h-100">
            <div id="logo_menu" class="d-flex position-relative">
                <figure class="d-flex flex-column">
                    <img src="./iesb-logo.png" id="logo-iesb" class="figure-img img-fluid rounded w-50 align-self-center" />
                    <figcaption class="text-center fs-5 mt-3">Documentação de sistemas do IESB</figcaption>
                </figure>
                <i class="fa fa-times btn position-absolute end-0 ms-2" id="btn-oculta-menu" aria-hidden="true"></i>
            </div>
            <span id="arquitetura-servidores" class="span-menu-generico text-center">
                <span class="texto-menu-generico">
                    Servidores WEB
                </span>
            </span>
            <span id="arquitetura-banco" class="span-menu-generico">
                <span class="texto-menu-generico">
                    Servidores de Bancos de Dados
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

    <main class="container-fluid p-3 bg-light bg-gradient d-flex align-items-stretch">
        <div class="container-fluid">
            <div id="tela-home" class="painel show_pannel d-flex align-self-stretch h-100">
                <div class="container-fluid border border-2 rounded d-flex flex-column p-3">
                    <h2 class="text-center">Bem vindo ao govTI, aplicação com o objetivo de auxiliar na documentação dos sistemas do IESB.</h2>
                    <h3 class="text-center">Por favor, selecione alguma das opções no painel à esquerda para começar a navegar</h3>
                </div>
            </div>
            <div id="tela-arq-serv" class="painel hide_pannel container-fluid h-100">
                <div class="as-content-wrapper d-flex flex-column w-100">
                    <div class="as-label_busca_dinamica">
                        <form id="as-form_busca_dinamica" class="form-group d-flex flex-column">
                            <label for="as-input_busca_dinamica" id="as-label-busca-dinamica" class="form-label">Busque qualquer palavra: </label>
                            <input type="text" id="as_input_busca_dinamica" class="form-control" value="" />
                            <span>
                                <button type="submit" class="btn btn-primary mt-2 ms-2" onclick="retornaDadosServidor(event)">Pesquisar</button>
                            </span>
                        </form>
                    </div>
                    <div class="d-flex">
                        <select class="form-select mt-2 mb-2 w-auto load_options_geral" id="load_options_as">
                            <option selected disabled>Quantidade resultados</option>
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="all">Tudo</option>
                        </select>
                        <div class="d-flex ms-auto">
                            <div class="me-3 h2 align-self-center">
                                <img class="span-menu-generico export_excel" style="cursor:pointer" src="./public/Icons/excel.png" / width="40px" height="40px" title="Exportar para excel" table="as">
                            </div>
                            <div class="align-self-center" id="info_count_as">
                            </div>
                        </div>
                    </div>
                    <div class="as-content content-geral d-flex flex-column p-2 border align-self-stretch overflow-auto h-100">
                    </div>
                    <span>
                        <button type="button" class="btn btn-primary mt-2 ms-2" data-bs-toggle="modal" data-bs-target="#as_modal_cria_server">Adicionar servidor</button>
                    </span>
                </div>
            </div>
            <div id="tela-arq-db" class="painel hide_pannel container-fluid h-100">
                <div class="db-content-wrapper d-flex flex-column w-100">
                    <div class="db-label_busca_dinamica">
                        <form id="db-form_busca_dinamica" class="form-group d-flex flex-column">
                            <label for="db-input_busca_dinamica" id="db-label-busca-dinamica" class="form-label">Busque qualquer palavra: </label>
                            <input type="text" id="db_input_busca_dinamica" class="form-control" value="" />
                            <span>
                                <input type="submit" class="btn btn-primary mt-2 ms-2" onclick="retornaDadosDatabase(event)" value="Pesquisar" />
                            </span>
                        </form>
                    </div>
                    <div class="d-flex">
                        <select class="form-select mt-2 mb-2 w-auto load_options_geral" id="load_options_db">
                            <option selected disabled>Quantidade resultados</option>
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="all">Tudo</option>
                        </select>
                        <div class="d-flex ms-auto">
                            <div class="me-3 h2 align-self-center">
                                <img class="span-menu-generico export_excel" style="cursor:pointer" src="./public/Icons/excel.png" / width="40px" height="40px" title="Exportar para excel" table="db">
                            </div>
                            <div class="align-self-center" id="info_count_db">
                            </div>
                        </div>
                    </div>
                    <div class="db-content content-geral d-flex flex-column p-2 border align-self-stretch overflow-auto h-100">
                    </div>
                    <span>
                        <button type="button" class="btn btn-primary mt-2 ms-2" data-bs-toggle="modal" data-bs-target="#db_modal_cria_database">Adicionar servidor de database</button>
                    </span>
                </div>
            </div>
            <div id="tela-map-job" class="painel hide_pannel container-fluid h-100">
                <div class="mj-content-wrapper d-flex flex-column w-100">
                    <div class="mj-label_busca_dinamica">
                        <form id="mj-form_busca_dinamica" class="form-group d-flex flex-column">
                            <label for="mj-input_busca_dinamica" id="mj-label-busca-dinamica" class="form-label">Busque qualquer palavra: </label>
                            <input type="text" id="mj_input_busca_dinamica" class="form-control" value="" />
                            <span>
                                <input type="submit" class="btn btn-primary mt-2 ms-2" onclick="retornaDadosJobTrigger(event)" value="Pesquisar" />
                            </span>
                        </form>
                    </div>
                    <div class="d-flex">
                        <select class="form-select mt-2 mb-2 w-auto load_options_geral" id="load_options_mt">
                            <option selected disabled>Quantidade resultados</option>
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="all">Tudo</option>
                        </select>
                        <div class="d-flex ms-auto">
                            <div class="me-3 h2 align-self-center">
                                <img class="span-menu-generico export_excel" style="cursor:pointer" src="./public/Icons/excel.png" / width="40px" height="40px" title="Exportar para excel" table="mt">
                            </div>
                            <div class="align-self-center" id="info_count_mt">
                            </div>
                        </div>
                    </div>
                    <div class="mj-content content-geral d-flex flex-column p-2 border align-self-stretch overflow-auto h-100">
                    </div>
                    <span>
                        <button type="button" class="btn btn-primary mt-2 ms-2" data-bs-toggle="modal" data-bs-target="#mj_modal_cria_jobtrigger">Adicionar Job ou Trigger</button>
                    </span>
                </div>
            </div>
            <div id="tela-map-sis" class="painel hide_pannel container-fluid h-100">
                <div class="ms-content-wrapper d-flex flex-column w-100">
                    <div class="ms-label_busca_dinamica">
                        <form id="ms-form_busca_dinamica" class="form-group d-flex flex-column">
                            <label for="ms-input_busca_dinamica" id="ms-label-busca-dinamica" class="form-label">Busque qualquer palavra: </label>
                            <input type="text" id="ms_input_busca_dinamica" class="form-control" value="" />
                            <span>
                                <input type="submit" class="btn btn-primary mt-2 ms-2" onclick="retornaDadosMapSistemas(event)" value="Pesquisar" />
                            </span>
                        </form>
                    </div>
                    <div class="d-flex">
                        <select class="form-select mt-2 mb-2 w-auto load_options_geral" id="load_options_ms">
                            <option selected disabled>Quantidade resultados</option>
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="all">Tudo</option>
                        </select>
                        <div class="d-flex ms-auto">
                            <div class="me-3 h2 align-self-center">
                                <img class="span-menu-generico export_excel" style="cursor:pointer" src="./public/Icons/excel.png" / width="40px" height="40px" title="Exportar para excel" table="ms">
                            </div>
                            <div class="align-self-center" id="info_count_ms">
                            </div>
                        </div>
                    </div>
                    <div class="ms-content content-geral d-flex flex-column p-2 border align-self-stretch overflow-auto h-100">
                    </div>
                    <span>
                        <button type="button" class="btn btn-primary mt-2 ms-2" data-bs-toggle="modal" data-bs-target="#ms_modal_cria_mapsis">Adicionar sistema ou processo</button>
                    </span>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="ms_abre_anexo_modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" id="insert_embed">
                </div>
            </div>
        </div>
    </div>



    <!-- Modals para o painel de arquitetura de servidores -->

    <!-- Modal para insert de dados servidor -->
    <div class="modal fade" id="as_modal_cria_server" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inserir novo registro de servidor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nome" id="as_nome_servidor" placeholder="Nome do servidor" />
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="objetivo" id="as_objetivo_servidor" placeholder="Objetivo do servidor"></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="linguagem" id="as_linguagem_servidor" placeholder="Linguagem do servidor" />
                    </div>

                    <select class="form-select" id="as_ativo_servidor">
                        <option value="" selected disabled>Ativo?</option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="as_cadastra">Cadastrar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para insert de dados subitem servidor -->
    <div class="modal fade" id="as_modal_cria_server_subitem" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inserir novo item do servidor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_servidor_subitem" value="" />
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nome" id="as_nome_servidor_subitem" placeholder="Nome do item" />
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="descricao" id="as_descricao_servidor_subitem" placeholder="Descrição do item"></textarea>
                    </div>
                    <select class="form-select" id="as_ativo_servidor_subitem">
                        <option value="" selected disabled>Ativo?</option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="as_cadastra_subitem">Cadastrar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para update de dados servidor -->
    <div class="modal fade" id="as_modal_update_server" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Atualizar registro do item atual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="as_id_update" value="" />
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nome" id="as_nome_servidor_update" placeholder="Nome do servidor" />
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="objetivo" id="as_objetivo_servidor_update" placeholder="Objetivo do servidor"></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="linguagem" id="as_linguagem_servidor_update" placeholder="Linguagem do servidor" />
                    </div>

                    <select class="form-select" id="as_ativo_servidor_update">
                        <option value="" selected disabled>Ativo?</option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="as_update">Atualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para update de dados subitem servidor -->
    <div class="modal fade" id="as_modal_update_server_subitem" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Atualizar registro do item atual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="as_id_update_subitem" value="" />
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nome" id="as_nome_update_subitem" placeholder="Nome do item" />
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="objetivo" id="as_descricao_update_subitem" placeholder="Descrição do item"></textarea>
                    </div>
                    <select class="form-select" id="as_ativo_update_subitem">
                        <option value="" selected disabled>Ativo?</option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="as_update_subitem">Atualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals para o painel de arquitetura de databases -->

    <!-- Modal para insert de dados database -->
    <div class="modal fade" id="db_modal_cria_database" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inserir novo registro de servidor de database</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nome" id="db_nome_database" placeholder="Nome do servidor" />
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="descricao" id="db_descricao_database" placeholder="Descricao do servidor"></textarea>
                    </div>
                    <div class="mb-3">
                        <select id="db_ambiente" class="form-select">
                            <option value="" selected disabled>Ambiente</option>
                            <option value="Prod">Produção</option>
                            <option value="Homolog">Homologação</option>
                            <option value="Desenv">Desenvolvimento</option>
                        </select>
                    </div>
                    <select class="form-select" id="db_ativo_database">
                        <option value="" selected disabled>Ativo?</option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="db_cadastra">Cadastrar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para update de dados database -->
    <div class="modal fade" id="db_modal_update_database" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Atualizar registro do item atual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="db_id_update" value="" />
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nome" id="db_nome_database_update" placeholder="Nome do servidor" />
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="descricao" id="db_descricao_update" placeholder="Descrição do servidor"></textarea>
                    </div>
                    <div class="mb-3">
                        <select id="db_ambiente_update" class="form-select">
                            <option value="" selected disabled>Ambiente</option>
                            <option value="Prod">Produção</option>
                            <option value="Homolog">Homologação</option>
                            <option value="Desenv">Desenvolvimento</option>
                        </select>
                    </div>
                    <select class="form-select" id="db_ativo_database_update">
                        <option value="" selected disabled>Ativo?</option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="db_update">Atualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para insert de dados subitem database -->
    <div class="modal fade" id="db_modal_cria_database_subitem" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inserir novo item do banco de dados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="db_database_subitem" value="" />
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nome" id="db_nome_database_subitem" placeholder="Nome da tabela" />
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="descricao" id="db_descricao_database_subitem" placeholder="Descrição da tabela"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="db_cadastra_subitem">Cadastrar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para update de dados subitem database -->
    <div class="modal fade" id="db_modal_update_database_subitem" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Atualizar registro atual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="db_id_update_subitem" value="" />
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nome" id="db_nome_update_subitem" placeholder="Nome do item" />
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="objetivo" id="db_descricao_update_subitem" placeholder="Descrição do item"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="db_update_subitem_database">Atualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Modals para o painel de mapeamento de jobs e triggers -->

    <!-- Modal para insert de dados job/trigger -->
    <div class="modal fade" id="mj_modal_cria_jobtrigger" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inserir novo registro de job/trigger</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nome" id="mj_nome_jobtrigger" placeholder="Nome do registro" />
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="descricao" id="mj_descricao_jobtrigger" placeholder="Descricao do registro"></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="tabela" id="mj_tabela" placeholder="Tabela do registro" />
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="database" id="mj_database" placeholder="Database do registro" />
                    </div>
                    <select class="form-select" id="mj_ativo_jobtrigger">
                        <option value="" selected disabled>Ativo?</option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="mj_cadastra">Cadastrar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para update de dados job/trigger -->
    <div class="modal fade" id="mj_modal_update_jobtrigger" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Atualizar registro do item atual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="mj_id_update" value="" />
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nome" id="mj_nome_jobtrigger_update" placeholder="Nome do registro" />
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="descricao" id="mj_descricao_update" placeholder="Descrição do registro"></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="tabela" id="mj_tabela_update" placeholder="Tabela do registro" />
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="database" id="mj_database_update" placeholder="Database do registro" />
                    </div>
                    <select class="form-select" id="mj_ativo_jobtrigger_update">
                        <option value="" selected disabled>Ativo?</option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="mj_update">Atualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modals para o painel de mapeamento de sistemas -->

    <!-- Modal para insert de dados de sistema ou processo -->
    <div class="modal fade" id="ms_modal_cria_mapsis" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inserir novo registro de sistema ou processo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nome" id="ms_nome_mapsis" placeholder="Nome do registro" />
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="descricao" id="ms_descricao_mapsis" placeholder="Descricao do registro"></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="database" id="ms_database_mapsis" placeholder="Banco de dados" />
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="servidor" id="ms_servidor_mapsis" placeholder="Servidor hospedado"></textarea>
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="setor" id="ms_setor_mapsis" placeholder="Setor responsável"></textarea>
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="ocorrencia" id="ms_ocorrencia_mapsis" placeholder="Recorrência de utilização"></textarea>
                    </div>
                    <select class="mb-3 form-select" id="ms_ativo_mapsis">
                        <option value="" selected disabled>Ativo?</option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                    <div class="mb-3">
                        <input type="file" class="form-control" name="anexo" id="ms_anexo_mapsis" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="ms_cadastra">Cadastrar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para update de dados sistema ou processo-->
    <div class="modal fade" id="ms_modal_update_mapsistemas" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Atualizar registro do item atual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="ms_id_update" value="" />
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nome" id="ms_nome_mapsis_update" placeholder="Nome do registro" />
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="descricao" id="ms_descricao_mapsis_update" placeholder="Descricao do registro"></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="database" id="ms_database_mapsis_update" placeholder="Banco de dados" />
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="servidor" id="ms_servidor_mapsis_update" placeholder="Servidor hospedado"></textarea>
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="setor" id="ms_setor_mapsis_update" placeholder="Setor responsável"></textarea>
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" name="ocorrencia" id="ms_ocorrencia_mapsis_update" placeholder="Recorrência de utilização"></textarea>
                    </div>
                    <select class="mb-3 form-select" id="ms_ativo_mapsis_update">
                        <option value="" selected disabled>Ativo?</option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                    <div class="mb-3">
                        <input type="file" class="form-control" id="ms_anexo_mapsis_update" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="ms_update">Atualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <!-- Jquery 3.6.0 -->
    <script src="./public/jquery/jquery-3.6.0.min.js"></script>
    <!-- Scripts utilizados nos paineis -->
    <script src="./public/js/scripts_paineis.js"></script>
    <!-- Scripts para a tela de arquitetura de servidores -->
    <script src="./public/js/arq_servers/el_arq_servers.js"></script>
    <script src="./public/js/arq_servers/funcoes_arq_servers.js"></script>
    <!-- Scripts para a tela de arquitetura de banco de dados -->
    <script src="./public/js/arq_database/funcoes_arq_database.js"></script>
    <script src="./public/js/arq_database/el_arq_database.js"></script>
    <!-- Scripts para a tela de mapeamento de jobs e triggers -->
    <script src="./public/js/job_trigger/el_job_trigger.js"></script>
    <script src="./public/js/job_trigger/funcoes_job_trigger.js"></script>
    <!-- Scripts para a tela de mapeamento sistemas ou processos -->
    <script src="./public/js/map_sistemas/el_map_sistemas.js"></script>
    <script src="./public/js/map_sistemas/funcoes_map_sistemas.js"></script>
    <!-- SweetAlert2 -->
    <script src="./public/sweetalert2/package/dist/sweetalert2.all.min.js"></script>
    <!-- Bundle Bootstrap 5 -->
    <script src="./public/bootstrap5/js/bootstrap.bundle.min.js"></script>

</body>

</html>