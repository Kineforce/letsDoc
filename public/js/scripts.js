// Aguarda o carregamento do document para iniciar os event listeners
$(document).ready(() => {
  $("#arquitetura-servidores").on("click", () => {
    $(".painel").hide();
    $("#tela-arq-serv").show();
  });
  $("#arquitetura-banco").on("click", () => {
    $(".painel").hide();
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
