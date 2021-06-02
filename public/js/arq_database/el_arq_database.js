$(document).ready(() => {
  $("#db_pesquisa_filtrada").on("click", (event) => {
    event.preventDefault();

    let palavraBuscada = $("#db_input_busca_dinamica")[0].value;

    $.ajax({
      type: "GET",
      url: `${urlServidor}src/routes/routes.php`,
      data: { retornaDataFiltradaDatabase: palavraBuscada },
      success: (response) => {
        let data = JSON.parse(response);

        // Montando html dos cards
        let as_cards_html = "";

        data.dados.map((linha) => {
          as_cards_html += retornaCardDatabaseHtml(
            linha.ID,
            linha.ATIVO,
            linha.NOME,
            linha.DESCRICAO,
            linha.AMBIENTE
          );
        });

        $(".db-content").html(as_cards_html);
        $(".db-content").append(
          '<span class="as_modal_open"><a href="#db_modal_cria_database" rel="modal:open">Adicionar database</a></span>'
        );
      },
    });
  });

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

  // Listener que escuta o botão para fazer update e envia um post para o servidor efetuar o update
  $("#db_update").on("click", (event) => {
    let updateIdDatabase = {
      id_database: $("#db_id_update").val(),
      nome: $("#db_nome_database_update").val(),
      descricao: $("#db_descricao_update").val(),
      ambiente: $("#db_ambiente_update option:selected").val(),
      ativo: $("#db_ativo_database_update option:selected").val(),
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { updateIdDatabase },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-banco").click();

        Swal.fire("Atualizado com sucesso!", "", "success");
      },
      error: () => {
        Swal.fire(
          "Algo de errado ocorreu na atualização do registro!",
          "",
          "error"
        );
      },
    });
  });

  // Listener que escuta o botão para criar um item de um servidor
  $("#db_cadastra_subitem").on("click", () => {
    let cadastraDadosItemDatabase = {
      id_database: $("#db_database_subitem").val(),
      nome: $("#db_nome_database_subitem").val(),
      descricao: $("#db_descricao_database_subitem").val(),
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { cadastraDadosItemDatabase },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-banco").click();

        Swal.fire("Inserido com sucesso!", "", "success");
      },
      error: () => {
        Swal.fire(
          "Algo de errado ocorreu na inserção do registro!",
          "",
          "error"
        );
      },
    });
  });

  // Listener que escuta o botão para fazer update do item e envia um post para o servidor efetuar o update
  $("#db_update_subitem_database").on("click", (event) => {
    let updateIdDatabaseSubItem = {
      id_item_database: $("#db_id_update_subitem").val(),
      nome: $("#db_nome_update_subitem").val(),
      descricao: $("#db_descricao_update_subitem").val(),
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { updateIdDatabaseSubItem },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-banco").click();

        Swal.fire("Atualizado com sucesso!", "", "success");
      },
      error: () => {
        Swal.fire(
          "Algo de errado ocorreu na atualização do registro!",
          "",
          "error"
        );
      },
    });
  });
});
