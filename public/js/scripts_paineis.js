let urlServidor = window.location.href;

// Aguarda o carregamento do document para iniciar os event listeners
$(document).ready(() => {
  $("#arquitetura-servidores").on("click", () => {
    // Esconde todos os painéis
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

        // Montando html dos cards
        let as_cards_html = "";

        dados.map((linha) => {
          as_cards_html += retornaCardHtml(
            linha.id,
            linha.nome,
            linha.objetivo,
            linha.linguagem
          );
        });

        $(".as-content").html(as_cards_html);
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

function retornaCardHtml(id, nome, objetivo, linguagem) {
  let html = "";

  // Gerando cards com dados
  html += '<div class="as-content-card">';
  html += '<div class="as-card-id">';
  html += `${id}`;
  html += "</div>";
  html += '<div class="as-nome">';
  html += `${nome}`;
  html += "</div>";
  html += '<div class="as-objetivo">';
  html += `${objetivo}`;
  html += "</div>";
  html += '<div class="as-tipo-linguagem">';
  html += `${linguagem}`;
  html += "</div>";
  html += "</div>";

  return html;
}
