function retornaDadosMapSistemas(event, value_load_demand) {
  if (event) {
    event.preventDefault();
  }

  let val_opt = $("#load_options_ms").val();

  if (val_opt) {
    value_load_demand = val_opt;
  }

  let qtd = value_load_demand ? value_load_demand : 10;
  let palavraBuscada = $("#ms_input_busca_dinamica")[0].value;

  // Carregar dados existentes no banco
  $.ajax({
    type: "GET",
    url: `${urlServidor}src/routes/routes.php`,
    data: { retornaDadosMapSistemas: { palavraBuscada, qtd } },
    success: (response) => {
      let data = JSON.parse(response);
      let count_searched = 0;

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
            linha.id,
            linha.ativo,
            linha.nome,
            linha.descricao,
            linha.anexo,
            linha.database,
            linha.servidor,
            linha.setor,
            linha.ocorrencia
          );
          count_searched += 1;
        });

        ms_cards_html += "</table>";

        $(".ms-content").html(ms_cards_html);
      } else {
        $(".ms-content").append(
          "<h2 class='d-flex justify-content-center'>Não foram encontrados registros de documentação!</h2>"
        );
      }

      let count_search_ms_html = `Mostrando <span class="text-primary">${count_searched}</span> de <span class="text-primary">${data.count[0].total}</span> resultados`;
      $("#info_count_ms").html(count_search_ms_html);
    },
    error: (data) => {
      console.log("Error --> ", data);
    },
  });
}

function retornaCardMapSistemas(
  id,
  ativo,
  nome,
  descricao,
  anexo,
  database,
  servidor,
  setor,
  ocorrencia
) {
  let html = "";

  //Gerando cards com dados

  html += "<tbody class='ms-container-card'>";
  html += "<tr class='ms-card'>";
  html += `<td class="ms-card-id">${id}</td>`;
  html += `<td class="ms-ativo" name="ativo" valor="${ativo}">`;
  html += `${
    ativo == "S"
      ? '<i class="fa fa-check-circle" style="color: green" aria-hidden="true"></i>'
      : '<i class="fa fa-times-circle" style="color: red" aria-hidden="true"></i>'
  }`;
  html += "</td>";
  html += `<td class="ms-nome text-break" name="nome">`;
  html += `${nome}`;
  html += "</td>";
  html += `<td class="ms-descricao text-break" name="descricao">`;
  html += `${descricao}`;
  html += "</td>";
  html += `<td class="ms-anexo text-break" name="anexo" ${
    anexo.length > 1
      ? 'data-bs-toggle="modal" data-bs-target="#ms_abre_anexo_modal" onclick="carregaAnexoModal(event)"'
      : ""
  }>`;
  html += `${anexo}`;
  html += "</td>";
  html += `<td class="ms-database text-break" name="database">`;
  html += `${database}`;
  html += "</td>";
  html += `<td class="ms-servidor text-break" name="servidor">`;
  html += `${servidor}`;
  html += "</td>";
  html += `<td class="ms-setor text-break" name="setor">`;
  html += `${setor}`;
  html += "</td>";
  html += `<td class="ms-ocorrencia text-break" name="ocorrencia">`;
  html += `${ocorrencia}`;
  html += "</td>";
  html += '<td class="ms-exclusao">';
  html +=
    '<i class="fa fa-trash" aria-hidden="true" onclick="deletaDadosMapSistemas(event)"></i>';
  html += "</td>";
  html += '<td class="ms-update">';
  html +=
    '<a data-bs-toggle="modal" data-bs-target="#ms_modal_update_mapsistemas" onclick="openModalUpdateMapSistemas(event)"><i class="fa fa-wrench ms-update"></i></a>';
  html += "</td>";
  html += "</tr>";
  html += "</tbody>";

  return html;
}

function deletaDadosMapSistemas(event) {
  event.preventDefault();

  let current_card = event.target.closest(".ms-card");
  current_card = $(current_card);

  // Seleciona o id da linha clicada
  let id = current_card.find(".ms-card-id").text();

  // Seleciona o nome do anexo da linha clicada
  let anexo = current_card.find(".ms-anexo").text();

  let deletaMapSistemas = {
    id_map_sistemas: id,
    anexo: anexo,
  };

  Swal.fire({
    heightAuto: false,
    title: "Você tem certeza que deseja deletar?",
    text: "Essa ação não poderá ser revertida!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sim, deletar!",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: `${urlServidor}src/routes/routes.php`,
        data: { deletaMapSistemas },
        success: () => {
          // Atualiza as informações na tela
          current_card.remove();

          Swal.fire({
            heightAuto: false,
            icon: "success",
            title: "O registro foi deletado",
          });
        },
        error: () => {
          Swal.fire({
            heightAuto: false,
            icon: "error",
            title: "Algo de errado ocorreu na exclusão do registro!",
          });
        },
      });
    } else {
      return;
    }
  });
}

function openModalUpdateMapSistemas(event) {
  event.preventDefault();

  let current_card = event.target.closest(".ms-card");
  current_card = $(current_card);

  //Linha selecionada
  current_card.attr("id", "selecionado");

  //Reseta o arquivo anexado na modal
  $("#ms_anexo_mapsis_update").val("");

  //Seleciona os dados da linha clicada
  let id = current_card.find(".ms-card-id").text();
  let novo_status = current_card.find(".ms-ativo").attr("valor");
  let novo_nome = current_card.find(".ms-nome").text();
  let nova_descricao = current_card.find(".ms-descricao").text();
  let novo_database = current_card.find(".ms-database").text();
  let novo_servidor = current_card.find(".ms-servidor").text();
  let novo_setor = current_card.find(".ms-setor").text();
  let nova_ocorrencia = current_card.find(".ms-ocorrencia").text();

  $("#ms_id_update").val(id);
  $("#ms_ativo_mapsis_update").val(novo_status);
  $("#ms_nome_mapsis_update").val(novo_nome);
  $("#ms_descricao_mapsis_update").val(nova_descricao);
  $("#ms_database_mapsis_update").val(novo_database);
  $("#ms_servidor_mapsis_update").val(novo_servidor);
  $("#ms_setor_mapsis_update").val(novo_setor);
  $("#ms_ocorrencia_mapsis_update").val(nova_ocorrencia);
}

function carregaAnexoModal(event) {
  event.preventDefault();

  let nome_arquivo = event.target.innerText;

  if (nome_arquivo) {
    // Caso já exista um embed, remover do DOM
    if ($("#ms_display_anexo")) {
      $("#ms_display_anexo").remove();
    }

    // Cria o embed com o nome do arquivo para ser mostrado
    let embed_html = `<embed id="ms_display_anexo" src="${urlServidor}src/uploads_anexos/${nome_arquivo}" alt="ms_anexo_selecionado" width="100%" height="750px">`;

    // Insere o embed na modal popup
    $("#insert_embed").html(embed_html);
  }
}
