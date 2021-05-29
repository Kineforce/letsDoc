$(document).ready(() => {
  $("#as_pesquisa_filtrada").on("click", (event) => {
    event.preventDefault();

    let palavraBuscada = $("#as_input_busca_dinamica")[0].value;

    $.ajax({
      type: "GET",
      url: `${urlServidor}src/controller/arqservers.php`,
      data: { retornaDataFiltrada: palavraBuscada },
      success: (response) => {
        let data = JSON.parse(response);

        // Montando html dos cards
        let as_cards_html = "";

        data.dados.map((linha) => {
          as_cards_html += retornaCardHtml(
            linha.ID,
            linha.ATIVO,
            linha.NOME,
            linha.OBJETIVO,
            linha.LINGUAGEM
          );
        });

        $(".as-content").html(as_cards_html);
        $(".as-content").append(
          '<span class="as_modal_open"><a href="#as_modal" rel="modal:open">Adicionar servidor</a></span>'
        );
      },
    });
  });

  // Listener que escuta o botão para cadastrar e envia um post para o servidor efetuar o cadastro
  $("#as_cadastra").on("click", () => {
    let nome_servidor = $("#as_nome_servidor").val();
    let objetivo_servidor = $("#as_objetivo_servidor").val();
    let linguagem_servidor = $("#as_linguagem_servidor").val();
    let ativo_servidor = $("#as_ativo_servidor option:selected").val();

    if (!ativo_servidor) {
      Swal.fire("Selecione o status do servidor!", "", "error");
      return;
    }

    let cadastraDadosServidor = {
      nome: nome_servidor,
      objetivo: objetivo_servidor,
      linguagem: linguagem_servidor,
      ativo: ativo_servidor,
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/controller/arqservers.php`,
      data: { cadastraDadosServidor },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-servidores").click();

        Swal.fire("Cadastrado com sucesso!", "", "success");
      },
      error: () => {
        Swal.fire("Algo de errado ocorreu no cadastro!", "", "error");
      },
    });
  });

  // Listener que escuta o botão para fazer update e envia um post para o servidor efetuar o update
  $("#as_update").on("click", (event) => {
    let updateIdServidor = {
      id_servidor: $("#as_id_update").val(),
      nome: $("#as_nome_servidor_update").val(),
      objetivo: $("#as_objetivo_servidor_update").val(),
      linguagem: $("#as_linguagem_servidor_update").val(),
      ativo: $("#as_ativo_servidor_update option:selected").val(),
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/controller/arqservers.php`,
      data: { updateIdServidor },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-servidores").click();

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

  // Listener que escuta o botão para fazer update do item e envia um post para o servidor efetuar o update
  $("#as_update_subitem").on("click", (event) => {
    let updateIdServidorSubItem = {
      id_item: $("#as_id_update_subitem").val(),
      nome: $("#as_nome_update_subitem").val(),
      descricao: $("#as_descricao_update_subitem").val(),
      ativo: $("#as_ativo_update_subitem option:selected").val(),
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/controller/arqservers.php`,
      data: { updateIdServidorSubItem },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-servidores").click();

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
  $("#as_cadastra_subitem").on("click", () => {
    let cadastraDadosItemServidor = {
      id_servidor: $("#id_servidor_subitem").val(),
      nome: $("#as_nome_servidor_subitem").val(),
      descricao: $("#as_descricao_servidor_subitem").val(),
      ativo: $("#as_ativo_servidor_subitem option:selected").val(),
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/controller/arqservers.php`,
      data: { cadastraDadosItemServidor },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-servidores").click();

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
});
