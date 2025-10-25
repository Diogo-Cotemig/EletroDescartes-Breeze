<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Destino de Descarte</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
   @vite(['resources/css/Ondedescarte.css'])
</head>
<body>

  <div class="mapa" id="mapa">
    <div id="distancia-destino"></div>
  </div>

  <div class="conteudo">
    <h2>Como deseja realizar o descarte?</h2>
    <div class="opcoes">
      <div class="opcao" onclick="abrirModal('buscar')">🚚 Buscar no Local</div>
      <div class="opcao" onclick="abrirModal('ponto')">🗑️ Ponto de coleta mais próximo</div>
      <div class="opcao" onclick="abrirRota()">🏢 Levar na empresa</div>
    </div>
  </div>

  <div class="modal" id="modal">
    <div class="modal-content" id="modalContent">
      <button class="close-btn" onclick="fecharModal()">×</button>
      <h3>Qual item será descartado?</h3>
      <div class="botoes-itens">
        <button onclick="mostrarMensagem('Hardware')">Hardware</button>
        <button onclick="mostrarMensagem('Eletrodomésticos')">Eletrodomésticos</button>
        <button onclick="mostrarMensagem('Monitores')">Monitores</button>
        <button onclick="mostrarMensagem('Computador')">Computador</button>
        <button onclick="mostrarMensagem('Pilhas')">Pilhas</button>
      </div>
    </div>
  </div>

  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script>
    const originalModalContent = document.getElementById("modalContent").innerHTML;
    let tipoFluxo = null;

    const map = L.map('mapa').setView([-19.9191, -43.9386], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap'
    }).addTo(map);

    const origem = sessionStorage.getItem('origem');
    const endereco = sessionStorage.getItem('endereco');
    const rotaJson = sessionStorage.getItem('rota');
    const distancia = sessionStorage.getItem('distancia');

    if (rotaJson) {
      try {
        const rota = JSON.parse(rotaJson);
        const routeLayer = L.geoJSON(rota, { style: { color: "blue", weight: 5 } }).addTo(map);
        map.fitBounds(routeLayer.getBounds());

        const startPoint = rota.coordinates[0];
        const endPoint = rota.coordinates[rota.coordinates.length - 1];

        L.marker([startPoint[1], startPoint[0]]).addTo(map).bindPopup("Origem").openPopup();
        L.marker([endPoint[1], endPoint[0]]).addTo(map).bindPopup("Destino").openPopup();

        document.getElementById("distancia-destino").innerText = `🛣️ Distância: ${distancia} km`;
      } catch (e) {
        console.error("Erro ao carregar a rota:", e);
        exibirApenasDestino();
      }
    } else {
      exibirApenasDestino();
    }

    function exibirApenasDestino() {
      if (endereco) {
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(endereco)}`)
          .then(r => r.json())
          .then(data => {
            if (data.length > 0) {
              const lat = parseFloat(data[0].lat);
              const lon = parseFloat(data[0].lon);
              map.setView([lat, lon], 15);
              L.marker([lat, lon]).addTo(map).bindPopup(endereco).openPopup();
            }
          });
      }
    }

    function abrirRota() {
      if (origem && endereco) {
        const rota = `https://www.google.com/maps/dir/${encodeURIComponent(origem)}/${encodeURIComponent(endereco)}`;
        window.open(rota, "_blank");
      } else {
        alert("Endereços de origem e destino não encontrados.");
      }
    }

    function abrirModal(tipo) {
      tipoFluxo = tipo;
      document.getElementById("modal").style.display = "flex";
    }

    function fecharModal() {
      document.getElementById("modal").style.display = "none";
      document.getElementById("modalContent").innerHTML = originalModalContent;
    }

    function mostrarMensagem(item) {
      if (tipoFluxo === 'buscar') {
        sessionStorage.setItem('itemDescartado', item);
        sessionStorage.setItem('distancia', distancia);
        window.location.href = "pagamento";
        return;
      }

      const content = `
        <button class="close-btn" onclick="fecharModal()">×</button>
        <h2>Descarte de ${item} realizado!</h2>
        <p>Você contribuiu para um planeta mais limpo 🌎<br>Obrigado pela sua atitude sustentável!</p>
        <button class="close-btn" style="position:relative;margin-top:20px;" onclick="fecharModal()">Fechar</button>
      `;
      document.getElementById("modalContent").innerHTML = content;
    }
  </script>
   @vite(['resources/js/OndeDescarteJava.js'])
</body>
</html>


