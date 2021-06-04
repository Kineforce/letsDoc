$(document).ready(() => {
  $("#as-form_busca_dinamica").on("submit", (event) => {
    event.preventDefault();

    let palavraBuscada = $("#as_input_busca_dinamica")[0].value;

    $.ajax({
      type: "GET",
      url: `${urlServidor}src/routes/routes.php`,
      data: { retornaDataFiltrada: palavraBuscada },
      success: (response) => {
        let data = JSON.parse(response);

        $(".as-content").html("");

        if (data.dados.length !== 0) {
          // Montando html dos cards
          let as_cards_html = "";

          as_cards_html += "<table class='table'>";
          as_cards_html += "<thead>";
          as_cards_html += "<tr>";
          as_cards_html += "<th>ID</th>";
          as_cards_html += "<th>SUBITEMS</th>";
          as_cards_html += "<th>STATUS</th>";
          as_cards_html += "<th>NOME</th>";
          as_cards_html += "<th>OBJETIVO</th>";
          as_cards_html += "<th>LINGUAGEM</th>";
          as_cards_html += "<th>DELETAR</th>";
          as_cards_html += "<th>AJUSTAR</th>";
          as_cards_html += "</tr>";
          as_cards_html += "</thead>";

          data.dados.map((linha) => {
            as_cards_html += retornaCardHtml(
              linha.ID,
              linha.ATIVO,
              linha.NOME,
              linha.OBJETIVO,
              linha.LINGUAGEM
            );
          });

          as_cards_html += "</table";

          $(".as-content").html(as_cards_html);
        } else {
          $(".as-content").append(
            "<h2 class='d-flex justify-content-center'>Não foram encontrados registros de documentação!</h2>"
          );
        }

        $(".as-content").append(
          '<span><button type="button" class="btn btn-primary mt-2 ms-2" data-bs-toggle="modal" data-bs-target="#as_modal_cria_server">Adicionar servidor</button></span>'
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
      Swal.fire({
        heightAuto: false,
        icon: "error",
        title: "Selecione o status do servidor!",
      });
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
      url: `${urlServidor}src/routes/routes.php`,
      data: { cadastraDadosServidor },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-servidores").click();
        Swal.fire({
          heightAuto: false,
          icon: "success",
          title: "Cadastrado com sucesso!",
        });
      },
      error: () => {
        Swal.fire({
          heightAuto: false,
          icon: "error",
          title: "Algo de errado ocorreu no cadastro!",
        });
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
      url: `${urlServidor}src/routes/routes.php`,
      data: { updateIdServidor },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-servidores").click();

        Swal.fire({
          heightAuto: false,
          icon: "success",
          title: "Atualizado com sucesso!",
        });
      },
      error: () => {
        Swal.fire({
          heightAuto: false,
          icon: "error",
          title: "Algo de errado ocorreu na atualização do registro!",
        });
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
      url: `${urlServidor}src/routes/routes.php`,
      data: { updateIdServidorSubItem },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-servidores").click();
        Swal.fire({
          heightAuto: false,
          icon: "success",
          title: "Atualizado com sucesso!",
        });
      },
      error: () => {
        Swal.fire({
          heightAuto: false,
          icon: "error",
          title: "Algo de errado ocorreu na atualização do registro!",
        });
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
      url: `${urlServidor}src/routes/routes.php`,
      data: { cadastraDadosItemServidor },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-servidores").click();
        Swal.fire({
          heightAuto: false,
          icon: "success",
          title: "Inserido com sucesso!",
        });
      },
      error: () => {
        Swal.fire({
          heightAuto: false,
          icon: "error",
          title: "Algo de errado ocorreu na inserção do registro!",
        });
      },
    });
  });
});
