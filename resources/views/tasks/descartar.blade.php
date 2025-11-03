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
      
      <label for="start">🔍 Endereço de origem:</label>
      <div class="input-container">
        <input type="text" id="start" placeholder="Digite seu endereço..." autocomplete="off" />
        <div id="autocomplete-start" class="autocomplete-list"></div>
      </div>
      
      <label for="end">📍 Endereço de destino:</label>
      <div class="input-container">
        <input type="text" id="end" placeholder="Selecione um ponto de coleta abaixo" readonly />
      </div>
      
      <button onclick="calcularRota()">Calcular Rota</button>
      <button onclick="irParaDescarte()">Ir para Descarte</button>

      <h3>Pontos de Coleta:</h3>
      <ul class="coleta-lista">
        <li><a href="#" onclick="setDestino('R. Santa Cruz, 546, barroca')">--- Cotemig, Sou Tech</a></li>
        <li><a href="#" onclick="setDestino('Av. Barão Homem de Melo, 1619 - BH')">--- Galpão, Barão Homem de Melo, 1619</a></li>
        <li><a href="#" onclick="setDestino('Av. Barão Homem de Melo, 1579 - BH')">--- Galpão, Barão Homem de Melo, 1579</a></li>
        <li><a href="#" onclick="setDestino('BR-356, 3049 - BH Shopping')">--- Shopping, BH Shopping, 3049</a></li>
      </ul>
      
      <img id="logoEle" src="{{ asset('img/logo.png') }}" alt="Logo Eletro Descarte" />
    </aside>

    <section class="map-area">
      <div id="distancia"></div>
      <div id="map"></div>
    </section>
  </div>

  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script>
    // ==================== INICIALIZAÇÃO DO MAPA ====================
    const map = L.map('map').setView([-19.9191, -43.9386], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap'
    }).addTo(map);

    // ==================== VARIÁVEIS GLOBAIS ====================
    let routeLayer;
    let geojsonRoute;
    let distanciaKm;
    let origemEndereco;
    let destinoEndereco;
    let searchTimeout;
    
    const startInput = document.getElementById('start');
    const autocompleteDiv = document.getElementById('autocomplete-start');

    // ==================== FUNÇÕES DE DESTINO ====================
    function setDestino(endereco) {
      document.getElementById("end").value = endereco;
    }

    // ==================== GEOCODING ====================
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

    // ==================== AUTOCOMPLETE INTELIGENTE ====================
    startInput.addEventListener('input', function() {
      const query = this.value.trim();
      
      clearTimeout(searchTimeout);
      
      if (query.length < 3) {
        autocompleteDiv.classList.remove('show');
        return;
      }

      autocompleteDiv.innerHTML = '<div class="autocomplete-loading">🔎 Buscando...</div>';
      autocompleteDiv.classList.add('show');

      searchTimeout = setTimeout(async () => {
        try {
          const suggestions = await buscarEnderecos(query);
          mostrarSugestoes(suggestions);
        } catch (error) {
          autocompleteDiv.innerHTML = '<div class="autocomplete-loading">❌ Erro na busca</div>';
        }
      }, 500);
    });

    // Fechar autocomplete ao clicar fora
    document.addEventListener('click', function(e) {
      if (!startInput.contains(e.target) && !autocompleteDiv.contains(e.target)) {
        autocompleteDiv.classList.remove('show');
      }
    });

    async function buscarEnderecos(query) {
      const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}, Belo Horizonte, Minas Gerais, Brasil&limit=10&addressdetails=1`;
      const response = await fetch(url, {
        headers: {
          'Accept-Language': 'pt-BR',
          'User-Agent': 'eletrodescarte/1.0'
        }
      });
      const data = await response.json();
      return filtrarEOrdenarResultados(data, query);
    }

    function filtrarEOrdenarResultados(results, query) {
      const queryLower = query.toLowerCase().trim();
      
      const resultadosComScore = results.map(item => {
        const address = item.address || {};
        let score = 0;
        const textoCompleto = item.display_name.toLowerCase();
        
        if (address.road && address.road.toLowerCase().startsWith(queryLower)) {
          score += 100;
        }
        
        if (textoCompleto.includes(queryLower)) {
          score += 50;
        }
        
        if (address.house_number) {
          score += 30;
        }
        
        if (address.road) {
          score += 20;
        }
        
        if (!address.road && !address.suburb) {
          score -= 50;
        }
        
        if (address.city === 'Belo Horizonte') {
          score += 15;
        }
        
        const palavrasQuery = queryLower.split(' ');
        palavrasQuery.forEach(palavra => {
          if (palavra.length > 2 && textoCompleto.includes(palavra)) {
            score += 10;
          }
        });
        
        return { ...item, score };
      });
      
      const filtrados = resultadosComScore.filter(item => item.score > 0);
      filtrados.sort((a, b) => b.score - a.score);
      return filtrados.slice(0, 5);
    }

    function mostrarSugestoes(suggestions) {
      if (suggestions.length === 0) {
        autocompleteDiv.innerHTML = '<div class="autocomplete-loading">❌ Nenhum endereço encontrado</div>';
        return;
      }

      autocompleteDiv.innerHTML = '';
      
      suggestions.forEach(item => {
        const div = document.createElement('div');
        div.className = 'autocomplete-item';
        
        const address = item.address || {};
        let textoParaMostrar = '';
        let textoParaInput = '';
        
        if (address.house_number) {
          textoParaInput += address.road + ', ' + address.house_number;
        } else if (address.road) {
          textoParaInput += address.road;
        }
        
        if (address.suburb || address.neighbourhood) {
          const bairro = address.suburb || address.neighbourhood;
          textoParaInput += (textoParaInput ? ', ' : '') + bairro;
        }
        
        if (address.city || address.town) {
          const cidade = address.city || address.town;
          textoParaInput += (textoParaInput ? ' - ' : '') + cidade;
        }
        
        textoParaMostrar = textoParaInput;
        
        if (address.postcode) {
          textoParaMostrar += ' | CEP: ' + address.postcode;
        }
        
        if (!textoParaInput) {
          const partes = item.display_name.split(',');
          textoParaInput = partes.slice(0, 3).join(',');
          textoParaMostrar = textoParaInput;
        }
        
        div.textContent = textoParaMostrar;
        div.dataset.inputText = textoParaInput;
        div.dataset.lat = item.lat;
        div.dataset.lon = item.lon;
        
        div.addEventListener('click', function() {
          startInput.value = this.dataset.inputText;
          startInput.dataset.lat = this.dataset.lat;
          startInput.dataset.lon = this.dataset.lon;
          autocompleteDiv.classList.remove('show');
        });
        
        autocompleteDiv.appendChild(div);
      });
    }

    // ==================== CALCULAR ROTA ====================
    async function calcularRota() {
      origemEndereco = document.getElementById("start").value;
      destinoEndereco = document.getElementById("end").value;

      if (!origemEndereco || !destinoEndereco) {
        alert("Preencha o endereço de origem e selecione um ponto de coleta.");
        return;
      }

      try {
        let start;
        
        if (startInput.dataset.lat && startInput.dataset.lon) {
          start = [parseFloat(startInput.dataset.lat), parseFloat(startInput.dataset.lon)];
        } else {
          start = await geocode(origemEndereco);
        }
        
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

    // ==================== IR PARA DESCARTE ====================
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