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
    $(".painel").hide();
    $(".hover-span-menu-generico").removeClass("hover-span-menu-generico");
    $("#arquitetura-servidores").addClass("hover-span-menu-generico");

    retornaDadosServidor();

    // Exibe painél selecionado
    $("#tela-arq-serv").show();
  });
  $("#arquitetura-banco").on("click", () => {
    $(".painel").hide();
    $(".hover-span-menu-generico").removeClass("hover-span-menu-generico");

    retornaDadosDatabase();

    // Exibe painél selecionado
    $("#arquitetura-banco").addClass("hover-span-menu-generico");
    $("#tela-arq-db").show();
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
