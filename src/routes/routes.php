<?php

require_once('../session_auth/session.php');
header('Content-Type: text/html; charset=utf-8');

// Importa o controlador para ter o método chamado de acordo com o parâmetro vindo no request
require('../controller/arqservers.php');
require('../controller/arqdatabase.php');
require('../controller/jobtrigger.php');
require('../controller/mapsistemas.php');

$call_arq_database = new ArqDatabase_controller();
$call_arq_servers = new ArqServers_controller();
$call_job_trigger = new JobTrigger_controller();
$call_map_sistemas = new MapSistemas_controller();

// Magic quotes está ligado no servidor, função para remover as barras adicionais
if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}

/******** ARQUITETURA DE SERVIDORES ********/

if (isset($_GET['retornaInfoServidores'])) {

    $call_arq_servers->retornaInfoServidores();
    return;
}

if (isset($_POST['cadastraDadosServidor'])) {

    $call_arq_servers->cadastraDadosServidor();
    return;
}

if (isset($_POST['cadastraDadosItemServidor'])) {

    $call_arq_servers->cadastraDadosItemServidor();
    return;
}

if (isset($_POST['deletaIdServidor'])) {

    $call_arq_servers->deletaIdServidor();
    return;
}


if (isset($_POST['deletaInfoItemArqServer'])) {

    $call_arq_servers->deletaInfoItemArqServer();
    return;
}

if (isset($_POST['updateIdServidor'])) {

    $call_arq_servers->updateIdServidor();
    return;
}


if (isset($_POST['updateIdServidorSubItem'])) {

    $call_arq_servers->updateIdServidorSubItem();
    return;
}


if (isset($_GET['buscaSubItemsServer'])) {

    $call_arq_servers->buscaSubItemsServidor();
    return;
}


/******** ARQUITETURA DE BANCO DE DADOS ********/

if (isset($_GET['retornaInfoDatabase'])) {

    $call_arq_database->retornaInfoDatabase();
    return;
}

if (isset($_POST['cadastraDadosDatabase'])) {

    $call_arq_database->cadastraInfoDatabase();
    return;
}

if (isset($_POST['deletaIdDatabase'])) {

    $call_arq_database->deletaIdDatabase();
    return;
}

if (isset($_POST['updateIdDatabase'])) {

    $call_arq_database->updateInfoDatabase();
    return;
}

if (isset($_GET['buscaSubItemsDatabase'])) {

    $call_arq_database->buscaSubItemsDatabase();
    return;
}

if (isset($_POST['cadastraDadosItemDatabase'])) {

    $call_arq_database->cadastraItemDatabase();
    return;
}

if (isset($_POST['deletaInfoItemDatabase'])) {

    $call_arq_database->deletaSubItemDatabase();
    return;
}

if (isset($_POST['updateIdDatabaseSubItem'])) {

    $call_arq_database->updateDatabaseSubitem();
    return;
}


/******** MAPEAMENTO DE JOBS E TRIGGERS NO BANCO ********/

if (isset($_GET['retornaDadosJobTrigger'])) {

    $call_job_trigger->retornaDadosJobTrigger();
    return;
}

if (isset($_POST['cadastraDadosJobTrigger'])) {

    $call_job_trigger->cadastraDadosJobTrigger();
    return;
}

if (isset($_POST['deletaIdJobTrigger'])) {

    $call_job_trigger->deletaRegistroJobTrigger();
    return;
}

if (isset($_POST['updateIdJobTrigger'])) {

    $call_job_trigger->updateJobTrigger();
    return;
}

/******** MAPEAMENTO DE SISTEMAS OU PROCESSOS ********/

if (isset($_GET['retornaDadosMapSistemas'])) {

    $call_map_sistemas->retornaDadosMapSistemas();
    return;
}

if (isset($_POST['cadastraDadosMapSistemas'])) {


    $call_map_sistemas->cadastraDadosMapSistemas();
    return;
}

if (isset($_POST['deletaMapSistemas'])) {

    $call_map_sistemas->deletaRegistroMapSistemas();
    return;
}

if (isset($_POST['updateMapSistemas'])) {

    $call_map_sistemas->updateMapSistemas();
    return;
}

/******** EXPORTAÇÃO DE EXCEL ********/

if (isset($_GET['exportaServersExcel'])) {

    $call_arq_servers->retornaExcelServidor();
    return;
}

if (isset($_GET['exportaDatabaseExcel'])) {

    $call_arq_database->retornaExcelDatabase();
    return;
}

if (isset($_GET['exportaJobTriggerExcel'])) {

    $call_job_trigger->retornaExcelJobTrigger();
    return;
}

if (isset($_GET['exportaMapSistemasExcel'])) {

    $call_map_sistemas->retornaExcelMapSistemas();
    return;
}
