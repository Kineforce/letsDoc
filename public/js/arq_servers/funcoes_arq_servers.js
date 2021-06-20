function retornaDadosServidor(event, value_load_demand) {
  if (event) {
    event.preventDefault();
  }

  let val_opt = $("#load_options_as").val();

  if (val_opt) {
    value_load_demand = val_opt;
  }

  let qtd = value_load_demand ? value_load_demand : 10;
  let palavraBuscada = $("#as_input_busca_dinamica")[0].value;

  // Carregar dados existentes no banco
  $.ajax({
    type: "GET",
    url: `${urlServidor}src/routes/routes.php`,
    data: { retornaInfoServidores: { palavraBuscada, qtd } },
    success: (response) => {
      let data = JSON.parse(response);
      let count_searched = 0;
      let total = 0;

      $(".as-content").html("");

      if (data.dados.length !== 0) {
        // Montando html dos cards
        let as_cards_html = "";

        as_cards_html += "<table class='table'>";
        as_cards_html += "<thead>";
        as_cards_html += "<tr>";
        as_cards_html += "<th>ID</th>";
        as_cards_html += "<th>ITEMS</th>";
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

          count_searched += 1;
        });

        as_cards_html += "</table";

        $(".as-content").html(as_cards_html);
      } else {
        $(".as-content").append(
          "<h2 class='d-flex justify-content-center'>Não foram encontrados registros de documentação!</h2>"
        );
      }

      count_search_as_html = `Mostrando <span class="text-primary">${count_searched}</span> de <span class="text-primary">${data.count[0].TOTAL}</span> resultados`;
      $("#info_count_as").html(count_search_as_html);
    },
    error: (data) => {
      console.log("Error --> ", data);
    },
  });
}

function retornaCardHtml(id, ativo, nome, objetivo, linguagem) {
  let html = "";

  // // Gerando cards com dados

  html += "<tbody class='as-container-card'>";
  html += "<tr class='as-card'>";
  html += `<td class="as-card-id">${id}</td>`;
  html += '<td class="as-dropdown">';
  html +=
    '<i class="fas fa-caret-square-down" onclick="mostraSubItemsServidor(event)"></i>';
  html += "</td>";
  html += `<td class="as-ativo" name="ativo" valor="${ativo}">`;
  html += `${
    ativo == "S"
      ? '<i class="fa fa-check-circle" style="color: green" aria-hidden="true"></i>'
      : '<i class="fa fa-times-circle" style="color: red" aria-hidden="true"></i>'
  }`;
  html += "</td>";
  html += `<td class="as-nome text-break" name="nome" >`;
  html += `${nome}`;
  html += "</td>";
  html += `<td class="as-objetivo text-break" name="objetivo">`;
  html += `${objetivo}`;
  html += "</td>";
  html += `<td class="as-tipo-linguagem text-break" name="linguagem" >`;
  html += `${linguagem}`;
  html += "</td>";
  html += '<td class="as-exclusao">';
  html +=
    '<i class="fa fa-trash as-excluir" aria-hidden="true" onclick="deletaDadosServidor(event)"></i>';
  html += "</td>";
  html += '<td class="as-update">';
  html +=
    '<a data-bs-toggle="modal" data-bs-target="#as_modal_update_server" onclick="openModalUpdate(event)"><i class="fa fa-wrench as-update"></i></a>';
  html += "</td>";
  html += "</tr>";
  html += "<tr class='as-content-server-card' style='display: none'>";
  html += "<td colspan='8'>";
  html += "<div class='as-inside-td-subtable'>";
  html += "<table class='table table-dark'>";
  html += "<thead>";
  html += "<tr>";
  html += "<th>ID</th>";
  html += "<th>ATIVO</th>";
  html += "<th>NOME</th>";
  html += "<th>DESCRICAO</th>";
  html += "<th>DELETAR</th>";
  html += "<th>AJUSTAR</th>";
  html += "</tr>";
  html += "</thead>";
  html += "<tbody>";
  html += "</tbody>";
  html += "</table>";
  html += "</div>";
  html += "</div>";
  html += "</td>";
  html += "</tr>";
  html += "</tbody>";

  return html;
}

function retornaSubCardHtml(id_item, status_item, nome_item, descricao) {
  let html = "";

  // Gerando sub cards com dados

  html += '<tr class="as-subcard-item">';
  html += '<td class="as-subcard-id-item">';
  html += id_item;
  html += "</td>";
  html += `<td class="as-ativo-subitem" name="ativo" valor="${status_item}">`;
  html += `${
    status_item == "S"
      ? '<i class="fa fa-check-circle" style="color: green" aria-hidden="true"></i>'
      : '<i class="fa fa-times-circle" style="color: red" aria-hidden="true"></i>'
  }`;
  html += "</td>";
  html += '<td class="as-subcard-nome-item text-break">';
  html += nome_item;
  html += "</td>";
  html += '<td class="as-subcard-descricao-item text-break">';
  html += descricao;
  html += "</td>";
  html += '<td class="as-subcard-exclusao">';
  html +=
    '<i class="fa fa-trash as-excluir_subitem" aria-hidden="true" onclick="deletaDadosSubItemServidor(event)"></i>';
  html += "</td>";
  html += '<td class="as-subcard-update">';
  html +=
    '<a data-bs-toggle="modal" data-bs-target="#as_modal_update_server_subitem" id="update_server" onclick="openModalUpdateSubItem(event)"><i class="fa fa-wrench as-update"></i></a>';
  html += "</td>";
  html += "</tr>";

  return html;
}

function deletaDadosServidor(event) {
  event.preventDefault();

  let current_card = event.target.closest(".as-card");
  current_card = $(current_card);

  // Seleciona o id da linha clicada
  let id = current_card.find(".as-card-id").text();

  let deletaIdServidor = {
    id_servidor: id,
  };

  Swal.fire({
    heightAuto: false,
    title: "Você tem certeza que deseja deletar?",
    text: "Isso deletará todos os sub-itens!",
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
        data: { deletaIdServidor },
        success: () => {
          // Atualiza as informações na tela
          $("#arquitetura-servidores").click();

          Swal.fire({
            heightAuto: false,
            icon: "success",
            title: "Informações do sevidor e items foram deletadas",
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

function openModalUpdate(event) {
  event.preventDefault();

  let current_card = event.target.closest(".as-card");
  current_card = $(current_card);

  //Seleciona os dados da linha clicada
  let id = current_card.find(".as-card-id").text();
  let novo_status = current_card.find(".as-ativo").attr("valor");
  let novo_nome = current_card.find(".as-nome").text();
  let novo_objetivo = current_card.find(".as-objetivo").text();
  let nova_linguagem = current_card.find(".as-tipo-linguagem").text();

  $("#as_id_update").val(id);
  $("#as_ativo_servidor_update").val(novo_status);
  $("#as_nome_servidor_update").val(novo_nome);
  $("#as_objetivo_servidor_update").val(novo_objetivo);
  $("#as_linguagem_servidor_update").val(nova_linguagem);
}

function openModalUpdateSubItem(event) {
  event.preventDefault();

  let current_card = event.target.closest(".as-subcard-item");
  current_card = $(current_card);

  //Linha selecionada
  current_card.attr("id", "selecionado");

  //Seleciona os dados da linha clicada
  let id = current_card.find(".as-subcard-id-item").text();
  let novo_status = current_card.find(".as-ativo-subitem").attr("valor");
  let novo_nome = current_card.find(".as-subcard-nome-item").text();
  let nova_descricao = current_card.find(".as-subcard-descricao-item").text();

  $("#as_id_update_subitem").val(id);
  $("#as_ativo_update_subitem").val(novo_status);
  $("#as_nome_update_subitem").val(novo_nome);
  $("#as_descricao_update_subitem").val(nova_descricao);
}

function openModalCreateSubItem(event) {
  event.preventDefault();

  let current_card = event.target.closest(".as-container-card");
  current_card = $(current_card).find(".as-card").find(".as-card-id");

  let closest_tr_parent = event.target.closest("tr");
  $(closest_tr_parent).attr("id", "selecionado");

  let id_servidor = current_card.text();

  $("#id_servidor_subitem").val(id_servidor);
}

function mostraSubItemsServidor(event) {
  event.preventDefault();

  let dropdown_el = $(event.target);
  let current_dropdown_btn = $(event.target);
  let curr_sub_card = current_dropdown_btn
    .closest("tbody")
    .find(".as-content-server-card");

  let inner_tbody = curr_sub_card.find("tbody");

  let status = "";

  if (dropdown_el.hasClass("fas")) {
    dropdown_el.removeClass("fas");
    dropdown_el.addClass("far");
    curr_sub_card.show();
    status = "show";
  } else {
    dropdown_el.removeClass("far");
    dropdown_el.addClass("fas");
    status = "hide";
  }

  if (status == "hide") {
    inner_tbody.html("");
    curr_sub_card.hide();
    return;
  }

  let current_card = event.target.closest(".as-card");
  current_card = $(current_card);

  // Seleciona o id da linha clicada
  let id = current_card.find(".as-card-id").text();

  let buscaSubItemsServer = {
    id_servidor: id,
  };

  $.ajax({
    type: "GET",
    url: `${urlServidor}src/routes/routes.php`,
    data: { buscaSubItemsServer },
    success: (resp) => {
      let parsed_response = JSON.parse(resp);

      // Montando html dos sub cards
      let sub_card_html = "";

      parsed_response.dados.map((linha) => {
        sub_card_html += retornaSubCardHtml(
          linha.ID,
          linha.ATIVO,
          linha.ITEM,
          linha.DESCRICAO
        );
      });

      if (sub_card_html.length > 0) {
        inner_tbody.html(sub_card_html);
      }
      $(inner_tbody).append(
        '<tr><td colspan="6"><span><button type="button" data-bs-toggle="modal" data-bs-target="#as_modal_cria_server_subitem"  class="btn btn-primary mt-2 ms-2" onclick="openModalCreateSubItem(event)">Adicionar item</button></span></td></tr>'
      );
    },
    error: () => {
      Swal.fire({
        heightAuto: false,
        icon: "error",
        title: "Algo de errado ocorreu na busca do registro!",
      });
    },
  });
}

function deletaDadosSubItemServidor(event) {
  event.preventDefault();

  let current_sub_card = event.target.closest(".as-subcard-item");
  current_sub_card = $(current_sub_card);

  // Seleciona o id da linha clicada
  let sub_id = current_sub_card.find(".as-subcard-id-item").text();

  let deletaInfoItemArqServer = {
    id_item_servidor: sub_id,
  };

  Swal.fire({
    heightAuto: false,
    title: "Você tem certeza que deseja deletar?",
    text: "Isso deletará este item!",
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
        data: { deletaInfoItemArqServer },
        success: () => {
          // Atualiza as informações na tela
          current_sub_card.remove();
          Swal.fire({
            heightAuto: false,
            icon: "success",
            title: "Deletado com sucesso!",
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
