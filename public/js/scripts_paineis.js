// Define url base para ser utilizada nos requests
let urlServidor = window.location.href;
urlServidor = urlServidor.replace("index.php", "");

// Aguarda o carregamento do document para iniciar os event listeners
$(document).ready(() => {
  // Quando qualquer modal fechar, remover o ID selecionado da linha selecionada
  $(".modal").on("hide.bs.modal", () => {
    $("#selecionado").removeAttr("id");
  });

  // Oculta o menu ao clicar no botão
  $("#btn-oculta-menu").on("click", () => {
    $("header").hide();
  });

  // Mostra o menu caso o ponteiro do mouse chegue perto da extremidade esquerda da tela
  $(document).on("mousemove", function (event) {
    if (event.pageX <= 30) {
      $("header").show();
    }
  });

  $("#arquitetura-servidores").on("click", () => {
    escondeTodosPaineis();
    indicaMenuSelecionado("arquitetura-servidores");
    retornaDadosServidor();
    exibePainel("tela-arq-serv");
  });
  $("#arquitetura-banco").on("click", () => {
    escondeTodosPaineis();
    indicaMenuSelecionado("arquitetura-banco");
    retornaDadosDatabase();
    exibePainel("tela-arq-db");
  });
  $("#mapeamento-jobs").on("click", () => {
    escondeTodosPaineis();
    indicaMenuSelecionado("mapeamento-jobs");
    retornaDadosJobTrigger();
    exibePainel("tela-map-job");
  });
  $("#mapeamento-sistemas").on("click", () => {
    escondeTodosPaineis();
    indicaMenuSelecionado("mapeamento-sistemas");
    retornaDadosMapSistemas();
    exibePainel("tela-map-sis");
  });

  $(".export_excel").on("click", (event) => {
    let which_table = event.target.getAttribute("table");
    let table = "";

    if (which_table == "as") {
      table = "?exportaServersExcel=1";
    }

    if (which_table == "db") {
      table = "?exportaDatabaseExcel=1";
    }

    if (which_table == "mt") {
      table = "?exportaJobTriggerExcel=1";
    }

    if (which_table == "ms") {
      table = "?exportaMapSistemasExcel=1";
    }

    window.location = `${urlServidor}src/routes/routes.php/${table}`;
  });
});

function exibePainel(id_menu) {
  // Exibe painel selecionado
  $(`#${id_menu}`).addClass("show_pannel");
  $(`#${id_menu}`).removeClass("hide_pannel");
}

function escondeTodosPaineis() {
  // Reseta dados de todos os painéis
  $(".content-geral").html("");

  // Reseta contadores de todos os painéis
  $(".load_options_geral").val(10);

  // Esconde todos os painéis
  $(".painel").addClass("hide_pannel");
  $(".painel").removeClass("show_pannel");
}

function indicaMenuSelecionado(id_menu) {
  $(".hover-span-menu-generico").removeClass("hover-span-menu-generico");
  $(`#${id_menu}`).addClass("hover-span-menu-generico");
}
