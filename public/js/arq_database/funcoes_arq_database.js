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
  $("#db_nome_servidor_update").val(novo_nome);
  $("#db_descricao_update").val(nova_descricao);
  $("#db_ambiente_update").val(novo_ambiente);
  $("#db_ativo_database_update").val(novo_status);
}
