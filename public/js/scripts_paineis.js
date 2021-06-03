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
    // Esconde todos os painéis
    $(".painel").addClass("hide");
    $(".painel").removeClass("show");

    $(".hover-span-menu-generico").removeClass("hover-span-menu-generico");
    $("#arquitetura-servidores").addClass("hover-span-menu-generico");

    retornaDadosServidor();

    // Exibe painél selecionado
    $("#tela-arq-serv").addClass("show");
    $("#tela-arq-serv").removeClass("hide");
  });
  $("#arquitetura-banco").on("click", () => {
    // Esconde todos os painéis
    $(".painel").addClass("hide");
    $(".painel").removeClass("show");

    $(".hover-span-menu-generico").removeClass("hover-span-menu-generico");
    $("#arquitetura-banco").addClass("hover-span-menu-generico");

    retornaDadosDatabase();

    // Exibe painél selecionado
    $("#tela-arq-db").addClass("show");
    $("#tela-arq-db").removeClass("hide");
  });
  $("#mapeamento-jobs").on("click", () => {
    $(".painel").hide();
    $("#tela-map-job").show();
  });
  $("#mapeamento-sistemas").on("click", () => {
    $(".painel").hide();
    $("#tela-map-sis").show();
  });
});
