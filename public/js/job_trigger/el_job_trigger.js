$(document).ready(() => {
  $("#mj-form_busca_dinamica").on("submit", (event) => {
    event.preventDefault();

    let palavraBuscada = $("#mj_input_busca_dinamica")[0].value;

    $.ajax({
      type: "GET",
      url: `${urlServidor}src/routes/routes.php`,
      data: { retornaDataFiltradaJobTrigger: palavraBuscada },
      success: (response) => {
        let data = JSON.parse(response);

        $(".mj-content").html("");

        if (data.dados.length != 0) {
          // Montando html dos cards
          let mj_cards_html = "";

          mj_cards_html += "<table class='table'>";
          mj_cards_html += "<thead>";
          mj_cards_html += "<tr>";
          mj_cards_html += "<th>ID</th>";
          mj_cards_html += "<th>STATUS</th>";
          mj_cards_html += "<th>NOME</th>";
          mj_cards_html += "<th>DESCRICAO</th>";
          mj_cards_html += "<th>ORIGEM</th>";
          mj_cards_html += "<th>DELETAR</th>";
          mj_cards_html += "<th>AJUSTAR</th>";
          mj_cards_html += "</tr>";
          mj_cards_html += "</thead>";

          data.dados.map((linha) => {
            mj_cards_html += retornaCardJobTrigger(
              linha.ID,
              linha.ATIVO,
              linha.NOME,
              linha.DESCRICAO,
              linha.ORIGEM
            );
          });

          mj_cards_html += "</table>";

          $(".mj-content").html(mj_cards_html);
        } else {
          $(".mj-content").append(
            "<h2 class='d-flex justify-content-center'>Não foram encontrados registros de documentação!</h2>"
          );
        }
      },
    });
  });

  // Listener que escuta o botão para cadastrar e envia um post para o servidor efetuar o cadastro
  $("#mj_cadastra").on("click", () => {
    let nome_jobtrigger = $("#mj_nome_jobtrigger").val();
    let descricao_jobtrigger = $("#mj_descricao_jobtrigger").val();
    let tabela_jobtrigger = $("#mj_tabela").val();
    let database_jobtrigger = $("#mj_database").val();
    let ativo_jobtrigger = $("#mj_ativo_jobtrigger option:selected").val();

    if (!nome_jobtrigger) {
      Swal.fire({
        heightAuto: false,
        icon: "error",
        title: "Digite um nome do registro!",
      });
      return;
    }

    if (!ativo_jobtrigger) {
      Swal.fire({
        heightAuto: false,
        icon: "error",
        title: "Selecione o status do registro!",
      });
      return;
    }

    let cadastraDadosJobTrigger = {
      nome: nome_jobtrigger,
      descricao: descricao_jobtrigger,
      tabela: tabela_jobtrigger,
      database: database_jobtrigger,
      ativo: ativo_jobtrigger,
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { cadastraDadosJobTrigger },
      success: () => {
        // Atualiza as informações na tela
        $("#mapeamento-jobs").click();

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
  $("#mj_update").on("click", (event) => {
    let updateIdJobTrigger = {
      id_job_trigger: $("#mj_id_update").val(),
      nome: $("#mj_nome_jobtrigger_update").val(),
      descricao: $("#mj_descricao_update").val(),
      tabela: $("#mj_tabela_update").val(),
      database: $("#mj_database_update").val(),
      ativo: $("#mj_ativo_jobtrigger_update option:selected").val(),
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { updateIdJobTrigger },
      success: () => {
        // Atualiza as informações na tela
        $("#mapeamento-jobs").click();
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
});
