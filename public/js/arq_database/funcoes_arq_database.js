function retornaDadosDatabase() {
  // Carregar dados existentes no banco
  $.ajax({
    type: "GET",
    url: `${urlServidor}src/routes/routes.php`,
    data: { retornaInfoDatabase: 1 },
    success: (response) => {
      let data = JSON.parse(response);

      $(".db-content").html("");

      if (data.dados.length != 0) {
        // Montando html dos cards
        let db_cards_html = "";

        db_cards_html += "<table class='table'>";
        db_cards_html += "<thead>";
        db_cards_html += "<tr>";
        db_cards_html += "<th>ID</th>";
        db_cards_html += "<th>ITEMS</th>";
        db_cards_html += "<th>STATUS</th>";
        db_cards_html += "<th>NOME</th>";
        db_cards_html += "<th>DESCRICAO</th>";
        db_cards_html += "<th>AMBIENTE</th>";
        db_cards_html += "<th>DELETAR</th>";
        db_cards_html += "<th>AJUSTAR</th>";
        db_cards_html += "</tr>";
        db_cards_html += "</thead>";

        data.dados.map((linha) => {
          db_cards_html += retornaCardDatabaseHtml(
            linha.ID,
            linha.ATIVO,
            linha.NOME,
            linha.DESCRICAO,
            linha.AMBIENTE
          );
        });

        db_cards_html += "</table>";

        $(".db-content").html(db_cards_html);
      } else {
        $(".db-content").append(
          "<h2 class='d-flex justify-content-center'>Não foram encontrados registros de documentação!</h2>"
        );
      }

      $(".db-content").append(
        '<span><button type="button" class="btn btn-primary mt-2 ms-2" data-bs-toggle="modal" data-bs-target="#db_modal_cria_database">Adicionar servidor de database</button></span>'
      );
    },
    error: (data) => {
      console.log("Error --> ", data);
    },
  });
}

function retornaCardDatabaseHtml(id, ativo, nome, descricao, ambiente) {
  let html = "";

  //Gerando cards com dados

  let ambiente_desc = "";

  if (ambiente == "Prod") {
    ambiente_desc = "Produção";
  }

  if (ambiente == "Homolog") {
    ambiente_desc = "Homologação";
  }

  if (ambiente == "Desenv") {
    ambiente_desc = "Desenvolvimento";
  }

  html += "<tbody class='db-container-card'>";
  html += "<tr class='db-card'>";
  html += `<td class="db-card-id">${id}</td>`;
  html += '<td class="db-dropdown">';
  html +=
    '<i class="fas fa-caret-square-down" onclick="mostraSubItemsDatabase(event)"></i>';
  html += "</td>";
  html += `<td class="db-ativo" name="ativo" valor="${ativo}">`;
  html += `${
    ativo == "S"
      ? '<i class="fa fa-check-circle" style="color: green" aria-hidden="true"></i>'
      : '<i class="fa fa-times-circle" style="color: red" aria-hidden="true"></i>'
  }`;
  html += "</td>";
  html += `<td class="db-nome text-break" name="nome">`;
  html += `${nome}`;
  html += "</td>";
  html += `<td class="db-descricao text-break" name="descricao">`;
  html += `${descricao}`;
  html += "</td>";
  html += `<td class="db-ambiente text-break" name="ambiente" valor="${ambiente}">`;
  html += `${ambiente_desc}`;
  html += "</td>";
  html += '<td class="db-exclusao">';
  html +=
    '<i class="fa fa-trash" aria-hidden="true" onclick="deletaDadosDatabase(event)"></i>';
  html += "</td>";
  html += '<td class="db-update">';
  html +=
    '<a data-bs-toggle="modal" data-bs-target="#db_modal_update_database" onclick="openModalUpdateDatabase(event)"><i class="fa fa-wrench db-update"></i></a>';
  html += "</td>";
  html += "</tr>";
  html += "<tr class='db-content-database-card' style='display: none'>";
  html += "<td colspan='8'>";
  html += "<div class='db-inside-td-subtable'>";
  html += "<table class='table table-dark'>";
  html += "<thead>";
  html += "<tr>";
  html += "<th>ID</th>";
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

function deletaDadosDatabase(event) {
  event.preventDefault();

  let current_card = event.target.closest(".db-card");
  current_card = $(current_card);

  // Seleciona o id da linha clicada
  let id = current_card.find(".db-card-id").text();

  let deletaIdDatabase = {
    id_database: id,
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
        data: { deletaIdDatabase },
        success: () => {
          // Atualiza as informações na tela
          $("#arquitetura-banco").click();
          Swal.fire({
            heightAuto: false,
            icon: "success",
            title: "Informações do database e items foram deletadas",
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

function openModalUpdateDatabase(event) {
  event.preventDefault();

  // console.log(event.target.parentElement.parentElement.parentElement);
  let current_card = event.target.closest(".db-card");
  current_card = $(current_card);

  //Seleciona os dados da linha clicada
  let id = current_card.find(".db-card-id").text();
  let novo_status = current_card.find(".db-ativo").attr("valor");
  let novo_nome = current_card.find(".db-nome").text();
  let nova_descricao = current_card.find(".db-descricao").text();
  let novo_ambiente = current_card.find(".db-ambiente").attr("valor");

  $("#db_id_update").val(id);
  $("#db_nome_database_update").val(novo_nome);
  $("#db_descricao_update").val(nova_descricao);
  $("#db_ambiente_update").val(novo_ambiente);
  $("#db_ativo_database_update").val(novo_status);
}

function mostraSubItemsDatabase(event) {
  event.preventDefault();

  let dropdown_el = $(event.target);
  let current_dropdown_btn = $(event.target);
  let curr_sub_card = current_dropdown_btn
    .closest("tbody")
    .find(".db-content-database-card");

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

  let current_card = event.target.closest(".db-card");
  current_card = $(current_card);

  // Seleciona o id da linha clicada
  let id = current_card.find(".db-card-id").text();

  let buscaSubItemsDatabase = {
    id_database: id,
  };

  $.ajax({
    type: "GET",
    url: `${urlServidor}src/routes/routes.php`,
    data: { buscaSubItemsDatabase },
    success: (resp) => {
      let parsed_response = JSON.parse(resp);

      // Montando html dos sub cards
      let sub_card_html = "";

      parsed_response.dados.map((linha) => {
        sub_card_html += retornaSubCardHtmlDatabase(
          linha.ID,
          linha.NOME,
          linha.DESCRICAO
        );
      });

      if (sub_card_html.length > 0) {
        inner_tbody.html(sub_card_html);
      }

      $(inner_tbody).append(
        '<tr><td colspan="6"><span><button type="button" data-bs-toggle="modal" data-bs-target="#db_modal_cria_database_subitem" class="btn btn-primary mt-2 ms-2" onclick="openModalCreateSubItemDatabase(event)">Adicionar servidor de database</button></span></td></tr>'
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

function retornaSubCardHtmlDatabase(id, nome, descricao) {
  let html = "";

  // Gerando sub cards com dados

  html += '<tr class="db-subcard-item">';
  html += '<td class="db-subcard-id-item">';
  html += id;
  html += "</td>";
  html += '<td class="db-subcard-nome-item text-break">';
  html += nome;
  html += "</td>";
  html += '<td class="db-subcard-descricao-item text-break">';
  html += descricao;
  html += "</td>";
  html += '<td class="db-subcard-exclusao">';
  html +=
    '<i class="fa fa-trash db-excluir_subitem" aria-hidden="true" onclick="deletaDadosSubItemDatabase(event)"></i>';
  html += "</td>";
  html += '<td class="db-subcard-update">';
  html +=
    '<a data-bs-toggle="modal" data-bs-target="#db_modal_update_database_subitem" id="update_subitem_database" onclick="openModalUpdateSubItemDatabase(event)"><i class="fa fa-wrench db-update"></i></a>';
  html += "</td>";
  html += "</tr>";

  return html;
}

function openModalCreateSubItemDatabase(event) {
  event.preventDefault();

  let current_card = event.target.closest(".db-container-card");
  current_card = $(current_card).find(".db-card").find(".db-card-id");

  let closest_tr_parent = event.target.closest("tr");
  $(closest_tr_parent).attr("id", "selecionado");

  let id_servidor = current_card.text();

  $("#db_database_subitem").val(id_servidor);
}

function deletaDadosSubItemDatabase(event) {
  event.preventDefault();

  let current_sub_card = event.target.closest(".db-subcard-item");
  current_sub_card = $(current_sub_card);

  // Seleciona o id da linha clicada
  let sub_id = current_sub_card.find(".db-subcard-id-item").text();

  let deletaInfoItemDatabase = {
    id_item_database: sub_id,
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
        data: { deletaInfoItemDatabase },
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

function openModalUpdateSubItemDatabase(event) {
  event.preventDefault();

  let current_card = event.target.closest(".db-subcard-item");
  current_card = $(current_card);

  //Linha selecionada
  current_card.attr("id", "selecionado");

  //Seleciona os dados da linha clicada
  let id = current_card.find(".db-subcard-id-item").text();
  let novo_nome = current_card.find(".db-subcard-nome-item").text();
  let nova_descricao = current_card.find(".db-subcard-descricao-item").text();

  $("#db_id_update_subitem").val(id);
  $("#db_nome_update_subitem").val(novo_nome);
  $("#db_descricao_update_subitem").val(nova_descricao);
}
