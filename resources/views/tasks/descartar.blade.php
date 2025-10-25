<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mapa de Descarte</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
   @vite(['resources/css/DescartarBtn.css', 'resources/js/Descartar.js'])
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <h2>Menu de Descarte</h2>
      <label for="start">Endereço de origem:</label>
      <input type="text" id="start" placeholder="Ex: Rua A, Belo Horizonte" />
      <label for="end">Endereço de destino:</label>
      <input type="text" id="end" placeholder="Ex: Av. Paulista, São Paulo" />
      <button onclick="calcularRota()">Calcular Rota</button>
      <button  onclick="irParaDescarte()">Ir para Descarte</button>

      <h3>Pontos de Coleta:</h3>
      <ul class="coleta-lista">
        <li><a href="#" onclick="setDestino('R. Santa Cruz, 546, barroca')">--- Cotemig, Sou Tech</a></li>
        <li><a href="#" onclick="setDestino('Av. Barão Homem de Melo, 1619 - BH')">--- Galpão, Barão Homem de Melo, 1619</a></li>
        <li><a href="#" onclick="setDestino('Av. Barão Homem de Melo, 1579 - BH')">--- Galpão, Barão Homem de Melo, 1579</a></li>
        <li><a href="#" onclick="setDestino('BR-356, 3049 - BH Shopping')">--- Shopping, BH Shopping, 3049</a></li>
      </ul>
      <img id="logoEle" src="{{ asset('logo.png') }}" alt="Logo Eletro Descarte" />
    </aside>

    <section class="map-area">
      <div id="distancia"></div>
      <div id="map"></div>
    </section>
  </div>

  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script>
    const map = L.map('map').setView([-19.9191, -43.9386], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap'
    }).addTo(map);

    let routeLayer;
    let geojsonRoute;
    let distanciaKm;
    let origemEndereco;
    let destinoEndereco;

    function setDestino(endereco) {
      document.getElementById("end").value = endereco;
    }

    async function geocode(endereco) {
      const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(endereco)}`;
      const response = await fetch(url, {
        headers: {
          'Accept-Language': 'pt-BR',
          'User-Agent': 'eletrodescarte/1.0'
        }
      });
      const data = await response.json();
      if (data.length === 0) throw new Error("Endereço não encontrado: " + endereco);
      return [parseFloat(data[0].lat), parseFloat(data[0].lon)];
    }

    async function calcularRota() {
      origemEndereco = document.getElementById("start").value;
      destinoEndereco = document.getElementById("end").value;

      if (!origemEndereco || !destinoEndereco) {
        alert("Preencha os dois endereços.");
        return;
      }

      try {
        const start = await geocode(origemEndereco);
        const end = await geocode(destinoEndereco);

        const response = await fetch(`https://router.project-osrm.org/route/v1/driving/${start[1]},${start[0]};${end[1]},${end[0]}?overview=full&geometries=geojson`);
        const data = await response.json();

        const route = data.routes[0];
        distanciaKm = (route.distance / 1000).toFixed(2);
        geojsonRoute = route.geometry;

        if (routeLayer) map.removeLayer(routeLayer);
        routeLayer = L.geoJSON(geojsonRoute, {
          style: { color: "blue", weight: 5 }
        }).addTo(map);

        map.fitBounds(routeLayer.getBounds());

        document.getElementById("distancia").innerText = `🛣️ Distância: ${distanciaKm} km`;

      } catch (e) {
        alert("Erro ao calcular rota: " + e.message);
      }
    }

    function irParaDescarte() {
      if (!origemEndereco || !destinoEndereco || !geojsonRoute) {
        alert("Por favor, preencha os dois endereços e calcule a rota antes de prosseguir.");
        return;
      }

      sessionStorage.setItem('origem', origemEndereco);
      sessionStorage.setItem('endereco', destinoEndereco);
      sessionStorage.setItem('rota', JSON.stringify(geojsonRoute));
      sessionStorage.setItem('distancia', distanciaKm);

      window.location.href = 'OndeDescarte';
    }
  </script>
</body>
</html>
