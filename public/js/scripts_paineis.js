// Define url base para ser utilizada nos requests
let urlServidor = window.location.href;
urlServidor = urlServidor.replace("index.php", "");

// Aguarda o carregamento do document para iniciar os event listeners
$(document).ready(() => {
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
});

function exibePainel(id_menu) {
  // Exibe painel selecionado
  $(`#${id_menu}`).addClass("show_pannel");
  $(`#${id_menu}`).removeClass("hide_pannel");
}

function escondeTodosPaineis() {
  // Esconde todos os painéis
  $(".painel").addClass("hide_pannel");
  $(".painel").removeClass("show_pannel");
}

function indicaMenuSelecionado(id_menu) {
  $(".hover-span-menu-generico").removeClass("hover-span-menu-generico");
  $(`#${id_menu}`).addClass("hover-span-menu-generico");
}
