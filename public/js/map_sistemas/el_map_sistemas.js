$(document).ready(() => {
  $("#ms-form_busca_dinamica").on("submit", (event) => {
    event.preventDefault();

    let palavraBuscada = $("#ms_input_busca_dinamica")[0].value;

    $.ajax({
      type: "GET",
      url: `${urlServidor}src/routes/routes.php`,
      data: { retornaDataFiltradaMapSistemas: palavraBuscada },
      success: (response) => {
        let data = JSON.parse(response);

        $(".ms-content").html("");

        if (data.dados.length != 0) {
          // Montando html dos cards
          let ms_cards_html = "";

          ms_cards_html += "<table class='table'>";
          ms_cards_html += "<thead>";
          ms_cards_html += "<tr>";
          ms_cards_html += "<th>ID</th>";
          ms_cards_html += "<th>STATUS</th>";
          ms_cards_html += "<th>NOME</th>";
          ms_cards_html += "<th>DESCRICAO</th>";
          ms_cards_html += "<th>ANEXO</th>";
          ms_cards_html += "<th>DATABASE</th>";
          ms_cards_html += "<th>SERVIDOR</th>";
          ms_cards_html += "<th>SETOR</th>";
          ms_cards_html += "<th>OCORRÊNCIA</th>";
          ms_cards_html += "<th>DELETAR</th>";
          ms_cards_html += "<th>AJUSTAR</th>";
          ms_cards_html += "</tr>";
          ms_cards_html += "</thead>";

          data.dados.map((linha) => {
            ms_cards_html += retornaCardMapSistemas(
              linha.ID,
              linha.ATIVO,
              linha.NOME,
              linha.DESCRICAO,
              linha.ANEXO,
              linha.DATABASE,
              linha.SERVIDOR,
              linha.SETOR,
              linha.OCORRENCIA
            );
          });

          ms_cards_html += "</table>";

          $(".ms-content").html(ms_cards_html);
        } else {
          $(".ms-content").append(
            "<h2 class='d-flex justify-content-center'>Não foram encontrados registros de documentação!</h2>"
          );
        }

        $(".ms-content").append(
          '<span><button type="button" class="btn btn-primary mt-2 ms-2" data-bs-toggle="modal" data-bs-target="#ms_modal_cria_mapsis">Adicionar sistema ou processo</button></span>'
        );
      },
      error: (data) => {
        console.log("Error --> ", data);
      },
    });
  });

  // Listener que escuta o botão para cadastrar e envia um post para o servidor efetuar o cadastro
  $("#ms_cadastra").on("click", () => {
    let nome_mapsistemas = $("#ms_nome_mapsis").val();
    let descricao_mapsistemas = $("#ms_descricao_mapsis").val();
    let anexo_mapsistemas = $("#ms_anexo_mapsis").val();
    let database_mapsistemas = $("#ms_database_mapsis").val();
    let servidor_mapsistemas = $("#ms_servidor_mapsis").val();
    let setor_mapsistemas = $("#ms_setor_mapsis").val();
    let ocorrencia_mapsistemas = $("#ms_ocorrencia_mapsis").val();
    let ativo_mapsistemas = $("#ms_ativo_mapsis option:selected").val();

    if (!nome_mapsistemas) {
      Swal.fire({
        heightAuto: false,
        icon: "error",
        title: "Digite um nome do registro!",
      });
      return;
    }

    if (!ativo_mapsistemas) {
      Swal.fire({
        heightAuto: false,
        icon: "error",
        title: "Selecione o status do registro!",
      });
      return;
    }

    let cadastraDadosMapSistemas = {
      nome: nome_mapsistemas,
      descricao: descricao_mapsistemas,
      anexo: anexo_mapsistemas,
      database: database_mapsistemas,
      servidor: servidor_mapsistemas,
      setor: setor_mapsistemas,
      ocorrencia: ocorrencia_mapsistemas,
      ativo: ativo_mapsistemas,
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { cadastraDadosMapSistemas },
      success: () => {
        // Atualiza as informações na tela
        $("#mapeamento-sistemas").click();

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
  $("#ms_update").on("click", (event) => {
    let updateMapSistemas = {
      id_map_sistemas: $("#ms_id_update").val(),
      nome: $("#ms_nome_mapsis_update").val(),
      descricao: $("#ms_descricao_mapsis_update").val(),
      anexo: $("#ms_anexo_mapsis_update").val(),
      database: $("#ms_database_mapsis_update").val(),
      servidor: $("#ms_servidor_mapsis_update").val(),
      setor: $("#ms_setor_mapsis_update").val(),
      ocorrencia: $("#ms_ocorrencia_mapsis_update").val(),
      ativo: $("#ms_ativo_mapsis_update option:selected").val(),
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { updateMapSistemas },
      success: () => {
        // Atualiza as informações na tela
        $("#mapeamento-sistemas").click();
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