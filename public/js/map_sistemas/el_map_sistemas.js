$(document).ready(() => {
  // Listener que escuta o botão para cadastrar e envia um post para o servidor efetuar o cadastro
  $("#ms_cadastra").on("click", () => {
    let nome_mapsistemas = $("#ms_nome_mapsis").val();
    let descricao_mapsistemas = $("#ms_descricao_mapsis").val();
    let database_mapsistemas = $("#ms_database_mapsis").val();
    let servidor_mapsistemas = $("#ms_servidor_mapsis").val();
    let setor_mapsistemas = $("#ms_setor_mapsis").val();
    let ocorrencia_mapsistemas = $("#ms_ocorrencia_mapsis").val();
    let ativo_mapsistemas = $("#ms_ativo_mapsis option:selected").val();
    let anexo_mapsistemas = $("#ms_anexo_mapsis")[0].files[0];

    let ms_data = new FormData();

    ms_data.append("cadastraDadosMapSistemas", 1);
    ms_data.append("nome", nome_mapsistemas);
    ms_data.append("descricao", descricao_mapsistemas);
    ms_data.append("database", database_mapsistemas);
    ms_data.append("servidor", servidor_mapsistemas);
    ms_data.append("setor", setor_mapsistemas);
    ms_data.append("ocorrencia", ocorrencia_mapsistemas);
    ms_data.append("ativo", ativo_mapsistemas);
    ms_data.append("anexo", anexo_mapsistemas);

    if (!nome_mapsistemas) {
      Swal.fire({
        heightAuto: false,
        icon: "error",
        title: "Digite um nome do registro!",
      });
      return;
    }

    if (!ativo_mapsistemas) {
      Swal.fire({
        heightAuto: false,
        icon: "error",
        title: "Selecione o status do registro!",
      });
      return;
    }

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: ms_data,
      cache: false,
      processData: false,
      contentType: false,
      success: () => {
        // Atualiza as informações na tela
        $("#mapeamento-sistemas").click();

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
  $("#ms_update").on("click", (event) => {
    let id_mapsistemas = $("#ms_id_update").val();
    let nome_mapsistemas = $("#ms_nome_mapsis_update").val();
    let descricao_mapsistemas = $("#ms_descricao_mapsis_update").val();
    let database_mapsistemas = $("#ms_database_mapsis_update").val();
    let servidor_mapsistemas = $("#ms_servidor_mapsis_update").val();
    let setor_mapsistemas = $("#ms_setor_mapsis_update").val();
    let ocorrencia_mapsistemas = $("#ms_ocorrencia_mapsis_update").val();
    let ativo_mapsistemas = $("#ms_ativo_mapsis_update option:selected").val();
    let anexo_mapsistemas = $("#ms_anexo_mapsis_update")[0].files[0];

    let ms_data_update = new FormData();

    ms_data_update.append("updateMapSistemas", 1);
    ms_data_update.append("id_map_sistemas", id_mapsistemas);
    ms_data_update.append("nome", nome_mapsistemas);
    ms_data_update.append("descricao", descricao_mapsistemas);
    ms_data_update.append("database", database_mapsistemas);
    ms_data_update.append("servidor", servidor_mapsistemas);
    ms_data_update.append("setor", setor_mapsistemas);
    ms_data_update.append("ocorrencia", ocorrencia_mapsistemas);
    ms_data_update.append("ativo", ativo_mapsistemas);
    ms_data_update.append("anexo", anexo_mapsistemas);

    let linha_selecionada = $("#selecionado");
    let ativo_sel = linha_selecionada.find(".ms-ativo");
    let nome_sel = linha_selecionada.find(".ms-nome");
    let descricao_sel = linha_selecionada.find(".ms-descricao");
    let anexo_sel = linha_selecionada.find(".ms-anexo");
    let database_sel = linha_selecionada.find(".ms-database");
    let servidor_sel = linha_selecionada.find(".ms-servidor");
    let setor_sel = linha_selecionada.find(".ms-setor");
    let ocorrencia_sel = linha_selecionada.find(".ms-ocorrencia");

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: ms_data_update,
      cache: false,
      processData: false,
      contentType: false,
      success: (resp) => {
        // Atualiza as informações da linha
        ativo_sel.attr("valor", ativo_mapsistemas);

        ico_ativo = ativo_sel.children();

        if (ativo_mapsistemas == "S") {
          ico_ativo.removeClass("fa-times-circle");
          ico_ativo.addClass("fa-check-circle");
          ico_ativo.css("color", "green");
        } else {
          ico_ativo.removeClass("fa-check-circle");
          ico_ativo.addClass("fa-times-circle");
          ico_ativo.css("color", "red");
        }

        nome_sel.text(nome_mapsistemas);
        descricao_sel.text(descricao_mapsistemas);
        database_sel.text(database_mapsistemas);
        servidor_sel.text(servidor_mapsistemas);
        setor_sel.text(setor_mapsistemas);
        ocorrencia_sel.text(ocorrencia_mapsistemas);

        if (anexo_mapsistemas) {
          anexo_sel.text(JSON.parse(resp).data);
        }

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
  $("#load_options_ms").on("change", (event) => {
    let value_load_demand = event.target.value;

    retornaDadosMapSistemas(null, value_load_demand);
  });
});
