$(document).ready(() => {
  // Listener que escuta o botão para cadastrar e envia um post para o servidor efetuar o cadastro
  $("#db_cadastra").on("click", () => {
    let nome_database = $("#db_nome_database").val();
    let descricao_database = $("#db_descricao_database").val();
    let ambiente_database = $("#db_ambiente option:selected").val();
    let ativo_database = $("#db_ativo_database option:selected").val();

    if (!ambiente_database) {
      Swal.fire({
        heightAuto: false,
        icon: "error",
        title: "Selecione o ambiente do banco de dados!",
      });
      return;
    }

    if (!ativo_database) {
      Swal.fire({
        heightAuto: false,
        icon: "error",
        title: "Selecione o status do servidor!",
      });
      return;
    }

    let cadastraDadosDatabase = {
      nome: nome_database,
      descricao: descricao_database,
      ambiente: ambiente_database,
      ativo: ativo_database,
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { cadastraDadosDatabase },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-banco").click();

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
  $("#db_update").on("click", (event) => {
    let updateIdDatabase = {
      id_database: $("#db_id_update").val(),
      nome: $("#db_nome_database_update").val(),
      descricao: $("#db_descricao_update").val(),
      ambiente: $("#db_ambiente_update option:selected").val(),
      ativo: $("#db_ativo_database_update option:selected").val(),
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { updateIdDatabase },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-banco").click();
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

  // Listener que escuta o botão para criar um item de um servidor
  $("#db_cadastra_subitem").on("click", () => {
    let cadastraDadosItemDatabase = {
      id_database: $("#db_database_subitem").val(),
      nome: $("#db_nome_database_subitem").val(),
      descricao: $("#db_descricao_database_subitem").val(),
    };

    let linha_selecionada = $("#selecionado");

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { cadastraDadosItemDatabase },
      success: (resp) => {
        // Atualiza as informações na tela
        let inserted_id = resp.replaceAll('"', "");

        tr_inserted_html = "";
        tr_inserted_html += "<tr class='db-subcard-item'>";
        tr_inserted_html += `<td class='db-subcard-id-item'>${inserted_id}</td>`;
        tr_inserted_html += `<td class='db-subcard-nome-item text-break'>${cadastraDadosItemDatabase.nome}</td>`;
        tr_inserted_html += `<td class='db-subcard-descricao-item text-break'>${cadastraDadosItemDatabase.descricao}</td>`;
        tr_inserted_html += '<td class="db-subcard-exclusao">';
        tr_inserted_html +=
          '<i class="fa fa-trash db-excluir_subitem" aria-hidden="true" onclick="deletaDadosSubItemDatabase(event)"></i>';
        tr_inserted_html += "</td>";
        tr_inserted_html += '<td class="db-subcard-update">';
        tr_inserted_html +=
          '<a data-bs-toggle="modal" data-bs-target="#db_modal_update_database_subitem" id="update_subitem_database" onclick="openModalUpdateSubItemDatabase(event)"><i class="fa fa-wrench db-update"></i></a>';
        tr_inserted_html += "</td>";
        tr_inserted_html += "</tr>";

        linha_selecionada.before(tr_inserted_html);

        Swal.fire({
          heightAuto: false,
          icon: "success",
          title: "Inserido com sucesso!",
        });
      },
      error: () => {
        Swal.fire({
          heightAuto: false,
          icon: "error",
          title: "Algo de errado ocorreu na inserção do registro!",
        });
      },
    });
  });

  // Listener que escuta o botão para fazer update do item e envia um post para o servidor efetuar o update
  $("#db_update_subitem_database").on("click", (event) => {
    let updateIdDatabaseSubItem = {
      id_item_database: $("#db_id_update_subitem").val(),
      nome: $("#db_nome_update_subitem").val(),
      descricao: $("#db_descricao_update_subitem").val(),
    };

    let linha_selecionada = $("#selecionado");
    let nome_sel = linha_selecionada.find(".db-subcard-nome-item");
    let desc_sel = linha_selecionada.find(".db-subcard-descricao-item");

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { updateIdDatabaseSubItem },
      success: () => {
        // Atualiza as informações da linha

        nome_sel.text(updateIdDatabaseSubItem.nome);
        desc_sel.text(updateIdDatabaseSubItem.descricao);

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

  $("#load_options_db").on("change", (event) => {
    let value_load_demand = event.target.value;

    retornaDadosDatabase(null, value_load_demand);
  });
});
