// Aguarda o carregamento do document para iniciar os event listeners
$(document).ready(() => {
  $("#arquitetura-servidores").on("click", () => {
    console.log(
      "Abrir painel para visualização e cadastro de dados a respeito da arquitetura de servidores!"
    );
  });
  $("#arquitetura-banco").on("click", () => {
    console.log(
      "Abrir painel para visualização e cadastro de dados a respeito da arquitetura do banco de dados!"
    );
  });
  $("#mapeamento-jobs").on("click", () => {
    console.log(
      "Abrir painel para visualização e cadastro de dados a respeito do mapeamento de jobs e triggers!"
    );
  });
  $("#mapeamento-sistemas").on("click", () => {
    console.log(
      "Abrir painel para visualização e cadastro de dados a respeito do mapeamento dos sistemas!"
    );
  });
});
