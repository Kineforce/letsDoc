function retornaDadosDatabase() {
  // Carregar dados existentes no banco
  $.ajax({
    type: "GET",
    url: `${urlServidor}src/routes/routes.php`,
    data: { retornaInfoDatabase: 1 },
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
    error: (data) => {
      console.log("Error --> ", data);
    },
  });
}

function retornaCardDatabaseHtml(id, ativo, nome, objetivo, linguagem) {
  let html = "";

  // Gerando cards com dados
  html += '<div class="db-card">';
  html += '<div class="db-content-card">';
  html += `<div class="db-card-id" name="id">`;
  html += `${id}`;
  html += "</div>";
  html += '<div class="db-dropdown">';
  html +=
    '<i class="fas fa-caret-square-down" onclick="mostraSubItemsDatabase(event)"></i>';
  html += "</div>";
  html += `<div class="db-ativo" name="ativo" valor="${ativo}">`;
  html += `${
    ativo == "S"
      ? '<i class="fa fa-check-circle" style="color: green" aria-hidden="true"></i>'
      : '<i class="fa fa-times-circle" style="color: red" aria-hidden="true"></i>'
  }`;
  html += "</div>";
  html += `<div class="db-nome" name="nome">`;
  html += `${nome}`;
  html += "</div>";
  html += `<div class="db-descricao" name="descricao">`;
  html += `${objetivo}`;
  html += "</div>";
  html += `<div class="db-ambiente" name="ambiente">`;
  html += `${linguagem}`;
  html += "</div>";
  html += '<div class="db-exclusao">';
  html +=
    '<i class="fa fa-trash db-excluir" aria-hidden="true" onclick="deletaDadosDatabase(event)"></i>';
  html += "</div>";
  html += '<div class="db-update">';
  html +=
    '<a href="#db_modal_update_database" id="update_database" rel="modal:open" onclick="openModalUpdateDatabase (event)"><i class="fa fa-wrench db-update"></i></a>';
  html += "</div>";
  html += "</div>";
  html += '<div class="db-content-database-card">';
  html += "</div>";
  html += "</div>";

  return html;
}

function deletaDadosDatabase(event) {
  event.preventDefault();

  let current_card = event.target.closest(".db-content-card");
  current_card = $(current_card);

  // Seleciona o id da linha clicada
  let id = current_card.find(".db-card-id").text();

  let deletaIdDatabase = {
    id_database: id,
  };

  Swal.fire({
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

          Swal.fire("Deletado com sucesso!", "", "success");
        },
        error: () => {
          Swal.fire(
            "Algo de errado ocorreu na exclusão do registro!",
            "",
            "error"
          );
        },
      });
      Swal.fire(
        "Deletado!",
        "Informações do sevidor e items foram deletadas",
        "success"
      );
    } else {
      return;
    }
  });
}

function openModalUpdateDatabase(event) {
  event.preventDefault();

  // console.log(event.target.parentElement.parentElement.parentElement);
  let current_card = event.target.closest(".db-content-card");
  current_card = $(current_card);

  //Seleciona os dados da linha clicada
  let id = current_card.find(".db-card-id").text();
  let novo_status = current_card.find(".db-ativo").attr("valor");
  let novo_nome = current_card.find(".db-nome").text();
  let nova_descricao = current_card.find(".db-descricao").text();
  let novo_ambiente = current_card.find(".db-ambiente").text();

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
    .closest(".db-card")
    .find(".db-content-database-card");

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
    curr_sub_card.html("");
    curr_sub_card.hide();
    return;
  }

  let current_card = event.target.closest(".db-content-card");
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

      curr_sub_card.html(sub_card_html);
      curr_sub_card.css("display", "flex");

      $(curr_sub_card).append(
        '<span class="as_modal_open"><a href="#db_modal_cria_server_subitem" rel="modal:open" id="db_subitem_servidor_create_btn" onclick="openModalCreateSubItemDatabase(event)">Adicionar item</a></span>'
      );
    },
    error: () => {
      Swal.fire("Algo de errado ocorreu na busca do registro!", "", "error");
    },
  });
}

function retornaSubCardHtmlDatabase(id, nome, descricao) {
  let html = "";

  // Gerando sub cards com dados
  html += '<div class="db-subcard-item">';
  html += '<div class="db-subcard-id-item">';
  html += id;
  html += "</div>";
  html += '<div class="db-subcard-nome-item">';
  html += nome;
  html += "</div>";
  html += '<div class="db-subcard-descricao-item">';
  html += descricao;
  html += "</div>";
  html += '<div class="db-subcard-exclusao">';
  html +=
    '<i class="fa fa-trash db-excluir_subitem" aria-hidden="true" onclick="deletaDadosSubItemDatabase(event)"></i>';
  html += "</div>";
  html += '<div class="db-subcard-update">';
  html +=
    '<a href="#db_modal_update_database_subitem" id="update_subitem_database" rel="modal:open" onclick="openModalUpdateSubItemDatabase(event)"><i class="fa fa-wrench db-update"></i></a>';
  html += "</div>";
  html += "</div>";

  return html;
}

function openModalCreateSubItemDatabase(event) {
  event.preventDefault();

  let current_card = event.target.closest(".db-card");
  current_card = $(current_card).find(".db-content-card").find(".db-card-id");

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
          $("#arquitetura-banco").click();

          Swal.fire("Deletado com sucesso!", "", "success");
        },
        error: () => {
          Swal.fire(
            "Algo de errado ocorreu na exclusão do registro!",
            "",
            "error"
          );
        },
      });
      Swal.fire("Deletado!", "Informações do item foram deletadas", "success");
    } else {
      return;
    }
  });
}

function openModalUpdateSubItemDatabase(event) {
  event.preventDefault();

  let current_card = event.target.closest(".db-subcard-item");
  current_card = $(current_card);

  //Seleciona os dados da linha clicada
  let id = current_card.find(".db-subcard-id-item").text();
  let novo_nome = current_card.find(".db-subcard-nome-item").text();
  let nova_descricao = current_card.find(".db-subcard-descricao-item").text();

  $("#db_id_update_subitem").val(id);
  $("#db_nome_update_subitem").val(novo_nome);
  $("#db_descricao_update_subitem").val(nova_descricao);
}
