$(document).ready(() => {
  // Listener que escuta o botão para cadastrar e envia um post para o servidor efetuar o cadastro
  $("#mj_cadastra").on("click", () => {
    let nome_jobtrigger = $("#mj_nome_jobtrigger").val();
    let descricao_jobtrigger = $("#mj_descricao_jobtrigger").val();
    let tabela_jobtrigger = $("#mj_tabela").val();
    let database_jobtrigger = $("#mj_database").val();
    let ativo_jobtrigger = $("#mj_ativo_jobtrigger option:selected").val();

    if (!nome_jobtrigger) {
      Swal.fire({
        heightAuto: false,
        icon: "error",
        title: "Digite um nome do registro!",
      });
      return;
    }

    if (!ativo_jobtrigger) {
      Swal.fire({
        heightAuto: false,
        icon: "error",
        title: "Selecione o status do registro!",
      });
      return;
    }

    let cadastraDadosJobTrigger = {
      nome: nome_jobtrigger,
      descricao: descricao_jobtrigger,
      tabela: tabela_jobtrigger,
      database: database_jobtrigger,
      ativo: ativo_jobtrigger,
    };

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { cadastraDadosJobTrigger },
      success: () => {
        // Atualiza as informações na tela
        $("#mapeamento-jobs").click();

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
  $("#mj_update").on("click", (event) => {
    let updateIdJobTrigger = {
      id_job_trigger: $("#mj_id_update").val(),
      nome: $("#mj_nome_jobtrigger_update").val(),
      descricao: $("#mj_descricao_update").val(),
      tabela: $("#mj_tabela_update").val(),
      database: $("#mj_database_update").val(),
      ativo: $("#mj_ativo_jobtrigger_update option:selected").val(),
    };

    let linha_selecionada = $("#selecionado");
    let ativo_sel = linha_selecionada.find(".mj-ativo");
    let nome_sel = linha_selecionada.find(".mj-nome");
    let descricao_sel = linha_selecionada.find(".mj-descricao");
    let tabela_sel = linha_selecionada.find(".mj-tabela");
    let database_sel = linha_selecionada.find(".mj-database");

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { updateIdJobTrigger },
      success: () => {
        // Atualiza as informações da linha
        ativo_sel.attr("valor", updateIdJobTrigger.ativo);

        ico_ativo = ativo_sel.children();

        if (updateIdJobTrigger.ativo == "S") {
          ico_ativo.removeClass("fa-times-circle");
          ico_ativo.addClass("fa-check-circle");
          ico_ativo.css("color", "green");
        } else {
          ico_ativo.removeClass("fa-check-circle");
          ico_ativo.addClass("fa-times-circle");
          ico_ativo.css("color", "red");
        }

        nome_sel.text(updateIdJobTrigger.nome);
        descricao_sel.text(updateIdJobTrigger.descricao);
        tabela_sel.text(updateIdJobTrigger.tabela);
        database_sel.text(updateIdJobTrigger.database);

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

  $("#load_options_mt").on("change", (event) => {
    let value_load_demand = event.target.value;

    retornaDadosJobTrigger(null, value_load_demand);
  });
});
