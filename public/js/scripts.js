// Aguarda o carregamento do document para iniciar os event listeners
$(document).ready(() => {
  let urlServidor = window.location.href;

  $("#arquitetura-servidores").on("click", () => {
    $(".painel").hide();
    // Carregar dados existentes no banco

    $.ajax({
      type: "GET",
      url: `${urlServidor}src/controller/api.php`,
      data: { retornaInfoServidores: 1 },
      success: (response) => {
        if (!response) {
          $(".as-content-card").html(
            "Não há dados disponíveis, por favor cadastre-os clicando no botão para inserir!"
          );
          return;
        }

        let dados = JSON.parse(response);

        // Gerando cards com dados
        let as_cards_html = "";

        dados.map((linha) => {
          as_cards_html += '<div class="as-content-card">';
          as_cards_html += '<div class="as-card-id">';
          as_cards_html += `${linha.id}`;
          as_cards_html += "</div>";
          as_cards_html += '<div class="as-nome">';
          as_cards_html += `${linha.nome}`;
          as_cards_html += "</div>";
          as_cards_html += '<div class="as-objetivo">';
          as_cards_html += `${linha.objetivo}`;
          as_cards_html += "</div>";
          as_cards_html += '<div class="as-tipo-linguagem">';
          as_cards_html += `${linha.linguagem}`;
          as_cards_html += "</div>";
          as_cards_html += "</div>";
        });

        $(".as-content").html(as_cards_html);
      },
      error: (data) => {
        console.log("Error --> ", data);
      },
    });

    $("#tela-arq-serv").show();
  });
  $("#arquitetura-banco").on("click", () => {
    $(".painel").hide();
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
