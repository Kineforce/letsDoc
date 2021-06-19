function retornaDadosJobTrigger(event, value_load_demand) {
  if (event) {
    event.preventDefault();
  }

  let val_opt = $("#load_options_mt").val();

  if (val_opt) {
    value_load_demand = val_opt;
  }

  let qtd = value_load_demand ? value_load_demand : 10;
  let palavraBuscada = $("#mj_input_busca_dinamica")[0].value;

  // Carregar dados existentes no banco
  $.ajax({
    type: "GET",
    url: `${urlServidor}src/routes/routes.php`,
    data: { retornaDadosJobTrigger: { palavraBuscada, qtd } },
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
        mj_cards_html += "<th>TABELA</th>";
        mj_cards_html += "<th>DATABASE</th>";
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
            linha.TABELA,
            linha.DATABASE
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
    error: (data) => {
      console.log("Error --> ", data);
    },
  });
}

function retornaCardJobTrigger(id, ativo, nome, descricao, tabela, database) {
  let html = "";

  //Gerando cards com dados

  html += "<tbody class='mj-container-card'>";
  html += "<tr class='mj-card'>";
  html += `<td class="mj-card-id">${id}</td>`;
  html += `<td class="mj-ativo" name="ativo" valor="${ativo}">`;
  html += `${
    ativo == "S"
      ? '<i class="fa fa-check-circle" style="color: green" aria-hidden="true"></i>'
      : '<i class="fa fa-times-circle" style="color: red" aria-hidden="true"></i>'
  }`;
  html += "</td>";
  html += `<td class="mj-nome text-break" name="nome">`;
  html += `${nome}`;
  html += "</td>";
  html += `<td class="mj-descricao text-break" name="descricao">`;
  html += `${descricao}`;
  html += "</td>";
  html += `<td class="mj-tabela text-break" name="tabela">`;
  html += `${tabela}`;
  html += "</td>";
  html += `<td class="mj-database text-break" name="database">`;
  html += `${database}`;
  html += "</td>";
  html += '<td class="mj-exclusao">';
  html +=
    '<i class="fa fa-trash" aria-hidden="true" onclick="deletaDadosJobTrigger(event)"></i>';
  html += "</td>";
  html += '<td class="mj-update">';
  html +=
    '<a data-bs-toggle="modal" data-bs-target="#mj_modal_update_jobtrigger" onclick="openModalUpdateJobTrigger(event)"><i class="fa fa-wrench mj-update"></i></a>';
  html += "</td>";
  html += "</tr>";
  html += "</tbody>";

  return html;
}

function deletaDadosJobTrigger(event) {
  event.preventDefault();

  let current_card = event.target.closest(".mj-card");
  current_card = $(current_card);

  // Seleciona o id da linha clicada
  let id = current_card.find(".mj-card-id").text();

  let deletaIdJobTrigger = {
    id_jobtrigger: id,
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
        data: { deletaIdJobTrigger },
        success: () => {
          // Atualiza as informações na tela
          $("#mapeamento-jobs").click();
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

function openModalUpdateJobTrigger(event) {
  event.preventDefault();

  // console.log(event.target.parentElement.parentElement.parentElement);
  let current_card = event.target.closest(".mj-card");
  current_card = $(current_card);

  //Seleciona os dados da linha clicada
  let id = current_card.find(".mj-card-id").text();
  let novo_status = current_card.find(".mj-ativo").attr("valor");
  let novo_nome = current_card.find(".mj-nome").text();
  let nova_descricao = current_card.find(".mj-descricao").text();
  let nova_tabela = current_card.find(".mj-tabela").text();
  let novo_database = current_card.find(".mj-database").text();

  $("#mj_id_update").val(id);
  $("#mj_nome_jobtrigger_update").val(novo_nome);
  $("#mj_descricao_update").val(nova_descricao);
  $("#mj_tabela_update").val(nova_tabela);
  $("#mj_database_update").val(novo_database);
  $("#mj_ativo_jobtrigger_update").val(novo_status);
}
