let urlServidor = window.location.href;
urlServidor = urlServidor.replace("index.php", "");

// Aguarda o carregamento do document para iniciar os event listeners
$(document).ready(() => {
  $("#arquitetura-servidores").on("click", () => {
    // Esconde todos os painéis
    $(".painel").hide();
    $(".hover-span-menu-generico").removeClass("hover-span-menu-generico");
    $("#arquitetura-servidores").addClass("hover-span-menu-generico");

    // Carregar dados existentes no banco
    $.ajax({
      type: "GET",
      url: `${urlServidor}src/routes/routes.php`,
      data: { retornaInfoServidores: 1 },
      success: (response) => {
        if (response.count == 0) {
          $(".as-content").html(
            "<h2 style='text-align: center; margin-top: 10px'>Não há dados disponíveis, por favor cadastre-os clicando no botão para inserir!</h2>"
          );
          $(".as-content").append(
            '<span class="as_modal_open"><a href="#as_modal" rel="modal:open">Adicionar servidor</a></span>'
          );

          return;
        }
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
          '<span class="as_modal_open"><a href="#as_modal_cria_server" rel="modal:open">Adicionar servidor</a></span>'
        );
      },
      error: (data) => {
        console.log("Error --> ", data);
      },
    });

    // Exibe painél selecionado
    $("#tela-arq-serv").show();
  });
  $("#arquitetura-banco").on("click", () => {
    $(".painel").hide();
    $(".hover-span-menu-generico").removeClass("hover-span-menu-generico");
    $("#arquitetura-banco").addClass("hover-span-menu-generico");
    $("#tela-arq-db").show();
  });
  $("#mapeamento-jobs").on("click", () => {
    $(".painel").hide();
    $("#tela-map-job").show();
  });
  $("#mapeamento-sistemas").on("click", () => {
    $(".painel").hide();
    $("#tela-map-sis").show();
  });
});

function retornaCardHtml(id, ativo, nome, objetivo, linguagem) {
  let html = "";

  // Gerando cards com dados
  html += '<div class="as-card">';
  html += '<div class="as-content-card">';
  html += `<div class="as-card-id" name="id">`;
  html += `${id}`;
  html += "</div>";
  html += '<div class="as-dropdown">';
  html +=
    '<i class="fas fa-caret-square-down" onclick="mostraSubItemsServidor(event)"></i>';
  html += "</div>";
  html += `<div class="as-ativo" name="ativo" valor="${ativo}">`;
  html += `${
    ativo == "S"
      ? '<i class="fa fa-check-circle" style="color: green" aria-hidden="true"></i>'
      : '<i class="fa fa-times-circle" style="color: red" aria-hidden="true"></i>'
  }`;
  html += "</div>";
  html += `<div class="as-nome" name="nome">`;
  html += `${nome}`;
  html += "</div>";
  html += `<div class="as-objetivo" name="objetivo">`;
  html += `${objetivo}`;
  html += "</div>";
  html += `<div class="as-tipo-linguagem" name="linguagem">`;
  html += `${linguagem}`;
  html += "</div>";
  html += '<div class="as-exclusao">';
  html +=
    '<i class="fa fa-trash as-excluir" aria-hidden="true" onclick="deletaDadosServidor(event)"></i>';
  html += "</div>";
  html += '<div class="as-update">';
  html +=
    '<a href="#as_modal_update_server" id="update_server" rel="modal:open" onclick="openModalUpdate(event)"><i class="fa fa-wrench as-update"></i></a>';
  html += "</div>";
  html += "</div>";
  html += '<div class="as-content-server-card">';
  html += "</div>";
  html += "</div>";

  return html;
}

function retornaSubCardHtml(id_item, status_item, nome_item, descricao) {
  let html = "";

  // Gerando sub cards com dados
  html += '<div class="as-subcard-item">';
  html += '<div class="as-subcard-id-item">';
  html += id_item;
  html += "</div>";
  html += `<div class="as-ativo-subitem" name="ativo" valor="${status_item}">`;
  html += `${
    status_item == "S"
      ? '<i class="fa fa-check-circle" style="color: green" aria-hidden="true"></i>'
      : '<i class="fa fa-times-circle" style="color: red" aria-hidden="true"></i>'
  }`;
  html += "</div>";
  html += '<div class="as-subcard-nome-item">';
  html += nome_item;
  html += "</div>";
  html += '<div class="as-subcard-descricao-item">';
  html += descricao;
  html += "</div>";
  html += '<div class="as-subcard-exclusao">';
  html +=
    '<i class="fa fa-trash as-excluir_subitem" aria-hidden="true" onclick="deletaDadosSubItemServidor(event)"></i>';
  html += "</div>";
  html += '<div class="as-subcard-update">';
  html +=
    '<a href="#as_modal_update_server_subitem" id="update_server" rel="modal:open" onclick="openModalUpdateSubItem(event)"><i class="fa fa-wrench as-update"></i></a>';
  html += "</div>";
  html += "</div>";

  return html;
}

function isEmpty(obj) {
  return Object.keys(obj).length === 0;
}

function deletaDadosServidor(event) {
  event.preventDefault();

  let current_card = event.target.closest(".as-content-card");
  current_card = $(current_card);

  // Seleciona o id da linha clicada
  let id = current_card.find(".as-card-id").text();

  let deletaIdServidor = {
    id_servidor: id,
  };

  $.ajax({
    type: "POST",
    url: `${urlServidor}src/routes/routes.php`,
    data: { deletaIdServidor },
    success: () => {
      // Atualiza as informações na tela
      $("#arquitetura-servidores").click();

      Swal.fire("Deletado com sucesso!", "", "success");
    },
    error: () => {
      Swal.fire("Algo de errado ocorreu na exclusão do registro!", "", "error");
    },
  });
}

function openModalUpdate(event) {
  event.preventDefault();

  // console.log(event.target.parentElement.parentElement.parentElement);
  let current_card = event.target.closest(".as-content-card");
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

  let current_card = event.target.closest(".as-card");
  current_card = $(current_card).find(".as-content-card").find(".as-card-id");

  let id_servidor = current_card.text();

  $("#id_servidor_subitem").val(id_servidor);
}

function mostraSubItemsServidor(event) {
  event.preventDefault();

  let dropdown_el = $(event.target);
  let current_dropdown_btn = $(event.target);
  let curr_sub_card = current_dropdown_btn
    .closest(".as-card")
    .find(".as-content-server-card");

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

  let current_card = event.target.closest(".as-content-card");
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

      curr_sub_card.html(sub_card_html);
      curr_sub_card.css("display", "flex");

      $(curr_sub_card).append(
        '<span class="as_modal_open"><a href="#as_modal_cria_server_subitem" rel="modal:open" id="as_subitem_servidor_create_btn" onclick="openModalCreateSubItem(event)">Adicionar item</a></span>'
      );
    },
    error: () => {
      Swal.fire("Algo de errado ocorreu na busca do registro!", "", "error");
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

  $.ajax({
    type: "POST",
    url: `${urlServidor}src/routes/routes.php`,
    data: { deletaInfoItemArqServer },
    success: () => {
      // Atualiza as informações na tela
      $("#arquitetura-servidores").click();

      Swal.fire("Deletado com sucesso!", "", "success");
    },
    error: () => {
      Swal.fire("Algo de errado ocorreu na exclusão do registro!", "", "error");
    },
  });
}
