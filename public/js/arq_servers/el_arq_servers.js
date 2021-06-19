$(document).ready(() => {
  // Listener que escuta o botão para cadastrar e envia um post para o servidor efetuar o cadastro
  $("#as_cadastra").on("click", () => {
    let nome_servidor = $("#as_nome_servidor").val();
    let objetivo_servidor = $("#as_objetivo_servidor").val();
    let linguagem_servidor = $("#as_linguagem_servidor").val();
    let ativo_servidor = $("#as_ativo_servidor option:selected").val();

    if (!ativo_servidor) {
      Swal.fire({
        heightAuto: false,
        icon: "error",
        title: "Selecione o status do servidor!",
      });
      return;
    }

    let cadastraDadosServidor = {
      nome: nome_servidor,
      objetivo: objetivo_servidor,
      linguagem: linguagem_servidor,
      ativo: ativo_servidor,
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { cadastraDadosServidor },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-servidores").click();
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
  $("#as_update").on("click", (event) => {
    let updateIdServidor = {
      id_servidor: $("#as_id_update").val(),
      nome: $("#as_nome_servidor_update").val(),
      objetivo: $("#as_objetivo_servidor_update").val(),
      linguagem: $("#as_linguagem_servidor_update").val(),
      ativo: $("#as_ativo_servidor_update option:selected").val(),
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { updateIdServidor },
      success: () => {
        // Atualiza as informações na tela
        $("#arquitetura-servidores").click();

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

  // Listener que escuta o botão para fazer update do item e envia um post para o servidor efetuar o update
  $("#as_update_subitem").on("click", (event) => {
    let updateIdServidorSubItem = {
      id_item: $("#as_id_update_subitem").val(),
      nome: $("#as_nome_update_subitem").val(),
      descricao: $("#as_descricao_update_subitem").val(),
      ativo: $("#as_ativo_update_subitem option:selected").val(),
    };

    let linha_selecionada = $("#selecionado");
    let ativo_sel = linha_selecionada.find(".as-ativo-subitem");
    let nome_sel = linha_selecionada.find(".as-subcard-nome-item");
    let desc_sel = linha_selecionada.find(".as-subcard-descricao-item");

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { updateIdServidorSubItem },
      success: () => {
        // Atualiza as informações da linha
        ativo_sel.attr("valor", updateIdServidorSubItem.ativo);

        ico_ativo = ativo_sel.children();

        if (updateIdServidorSubItem.ativo == "S") {
          ico_ativo.removeClass("fa-times-circle");
          ico_ativo.addClass("fa-check-circle");
          ico_ativo.css("color", "green");
        } else {
          ico_ativo.removeClass("fa-check-circle");
          ico_ativo.addClass("fa-times-circle");
          ico_ativo.css("color", "red");
        }

        nome_sel.text(updateIdServidorSubItem.nome);
        desc_sel.text(updateIdServidorSubItem.descricao);

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
  $("#as_cadastra_subitem").on("click", () => {
    let cadastraDadosItemServidor = {
      id_servidor: $("#id_servidor_subitem").val(),
      nome: $("#as_nome_servidor_subitem").val(),
      descricao: $("#as_descricao_servidor_subitem").val(),
      ativo: $("#as_ativo_servidor_subitem option:selected").val(),
    };

    let linha_selecionada = $("#selecionado");

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { cadastraDadosItemServidor },
      success: (resp) => {
        // Atualiza as informações na tela
        let inserted_id = resp.replaceAll('"', "");

        tr_inserted_html = "";
        tr_inserted_html += "<tr class='as-subcard-item'>";
        tr_inserted_html += `<td class='as-subcard-id-item'>${inserted_id}</td>`;
        tr_inserted_html += `<td class='as-ativo-subitem' name='ativo' valor='${cadastraDadosItemServidor.ativo}'>`;
        tr_inserted_html += `${
          cadastraDadosItemServidor.ativo == "S"
            ? '<i class="fa fa-check-circle" style="color: green" aria-hidden="true"></i>'
            : '<i class="fa fa-times-circle" style="color: red" aria-hidden="true"></i>'
        }`;
        tr_inserted_html += "</td>";
        tr_inserted_html += `<td class='as-subcard-nome-item text-break'>${cadastraDadosItemServidor.nome}</td>`;
        tr_inserted_html += `<td class='as-subcard-descricao-item text-break'>${cadastraDadosItemServidor.descricao}</td>`;
        tr_inserted_html += '<td class="as-subcard-exclusao">';
        tr_inserted_html +=
          '<i class="fa fa-trash as-excluir_subitem" aria-hidden="true" onclick="deletaDadosSubItemServidor(event)"></i>';
        tr_inserted_html += "</td>";
        tr_inserted_html += '<td class="as-subcard-update">';
        tr_inserted_html +=
          '<a data-bs-toggle="modal" data-bs-target="#as_modal_update_server_subitem" id="update_server" onclick="openModalUpdateSubItem(event)"><i class="fa fa-wrench as-update"></i></a>';
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

  $("#load_options_as").on("change", (event) => {
    let value_load_demand = event.target.value;

    retornaDadosServidor(null, value_load_demand);
  });
});
