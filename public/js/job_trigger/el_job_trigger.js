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

    $.ajax({
      type: "POST",
      url: `${urlServidor}src/routes/routes.php`,
      data: { updateIdJobTrigger },
      success: () => {
        // Atualiza as informações na tela
        $("#mapeamento-jobs").click();
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
