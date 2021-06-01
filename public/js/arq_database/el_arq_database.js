$(document).ready(() => {
  // Listener que escuta o botão para cadastrar e envia um post para o servidor efetuar o cadastro
  $("#db_cadastra").on("click", () => {
    let nome_database = $("#db_nome_database").val();
    let descricao_database = $("#db_descricao_database").val();
    let ambiente_database = $("#db_ambiente option:selected").val();
    let ativo_database = $("#db_ativo_database option:selected").val();

    if (!ambiente_database) {
      Swal.fire("Selecione o ambiente do banco de dados!", "", "error");
      return;
    }

    if (!ativo_database) {
      Swal.fire("Selecione o status do servidor!", "", "error");
      return;
    }

    let cadastraDadosDatabase = {
      nome: nome_database,
      descricao: descricao_database,
      ambiente: ambiente_database,
      ativo: ativo_database,
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { cadastraDadosDatabase },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-banco").click();

        Swal.fire("Cadastrado com sucesso!", "", "success");
      },
      error: () => {
        Swal.fire("Algo de errado ocorreu no cadastro!", "", "error");
      },
    });
  });
});
