document.addEventListener('DOMContentLoaded', () => {

    // Inicialização do mapa só acontece depois que o DOM está pronto
    const map = L.map('map').setView([-19.9191, -43.9386], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap'
    }).addTo(map);

    let routeLayer;
    let geojsonRoute;
    let distanciaKm;
    let origemEndereco;
    let destinoEndereco;

    // As funções são definidas no escopo do listener
    window.setDestino = function(endereco) {
      document.getElementById("end").value = endereco;
    };

    window.geocode = async function(endereco) {
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
    };

    window.calcularRota = async function() {
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
    };

    window.irParaDescarte = function() {
      if (!origemEndereco || !destinoEndereco || !geojsonRoute) {
        alert("Por favor, preencha os dois endereços e calcule a rota antes de prosseguir.");
        return;
      }

      sessionStorage.setItem('origem', origemEndereco);
      sessionStorage.setItem('endereco', destinoEndereco);
      sessionStorage.setItem('rota', JSON.stringify(geojsonRoute));
      sessionStorage.setItem('distancia', distanciaKm);

      window.location.href = 'OndeDescarte';
    };
});