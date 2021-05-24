const retornaDadosFiltrados = (event) => {
  event.preventDefault();

  let palavraBuscada = event.target.as_input_busca_dinamica.value;

  $.ajax({
    type: "GET",
    url: `${urlServidor}src/controller/api.php`,
    data: { retornaDataFiltrada: palavraBuscada },
    success: (response) => {
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
  });
};
