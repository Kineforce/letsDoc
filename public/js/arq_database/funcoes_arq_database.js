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
  html += `<div class="db-descricao" name="objetivo">`;
  html += `${objetivo}`;
  html += "</div>";
  html += `<div class="db-ambiente" name="linguagem">`;
  html += `${linguagem}`;
  html += "</div>";
  html += '<div class="db-exclusao">';
  html +=
    '<i class="fa fa-trash db-excluir" aria-hidden="true" onclick="deletaDadosDatabase(event)"></i>';
  html += "</div>";
  html += '<div class="db-update">';
  html +=
    '<a href="#db_modal_update_server" id="update_database" rel="modal:open" onclick="openModalUpdateDatabase (event)"><i class="fa fa-wrench db-update"></i></a>';
  html += "</div>";
  html += "</div>";
  html += '<div class="db-content-server-card">';
  html += "</div>";
  html += "</div>";

  return html;
}
