// O código deve ser executado apenas após o DOM ser carregado.
document.addEventListener('DOMContentLoaded', () => {

    // Armazena o conteúdo HTML original do modal para restaurar depois
    const originalModalContent = document.getElementById("modalContent").innerHTML;

    // Configuração do mapa
    const map = L.map('mapa').setView([-19.9191, -43.9386], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap'
    }).addTo(map);

    // Obter dados do sessionStorage
    const origem = sessionStorage.getItem('origem');
    const endereco = sessionStorage.getItem('endereco');
    const rotaJson = sessionStorage.getItem('rota');
    const distancia = sessionStorage.getItem('distancia');

    // Exibir a rota no mapa, se houver
    if (rotaJson) {
      try {
        const rota = JSON.parse(rotaJson);
        const routeLayer = L.geoJSON(rota, {
          style: { color: "blue", weight: 5 }
        }).addTo(map);

        map.fitBounds(routeLayer.getBounds());
        
        // Obtém as coordenadas exatas do início e do fim da rota
        const startPoint = rota.coordinates[0];
        const endPoint = rota.coordinates[rota.coordinates.length - 1];

        // Cria os marcadores usando as coordenadas reais (latitude, longitude)
        L.marker([startPoint[1], startPoint[0]]).addTo(map).bindPopup("Origem").openPopup();
        L.marker([endPoint[1], endPoint[0]]).addTo(map).bindPopup("Destino").openPopup();
        
        document.getElementById("distancia-destino").innerText = `🛣️ Distância: ${distancia} km`;

      } catch (e) {
        console.error("Erro ao carregar a rota:", e);
        // Se houver erro na rota, exibe apenas o destino
        exibirApenasDestino(endereco);
      }
    } else {
      exibirApenasDestino(endereco);
    }

    // Função para exibir apenas o destino no mapa
    window.exibirApenasDestino = function(endereco) {
      if (endereco) {
        async function geocodeAndSetView(endereco) {
          const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(endereco)}`;
          try {
            const response = await fetch(url, {
              headers: {
                'Accept-Language': 'pt-BR',
                'User-Agent': 'eletrodescarte/1.0'
              }
            });
            const data = await response.json();
            if (data.length > 0) {
              const lat = parseFloat(data[0].lat);
              const lon = parseFloat(data[0].lon);
              map.setView([lat, lon], 15);
              L.marker([lat, lon]).addTo(map).bindPopup(endereco).openPopup();
            }
          } catch (e) {
            console.error("Erro na geocodificação:", e);
          }
        }
        geocodeAndSetView(endereco);
      }
    };

    // Função para abrir a rota no Google Maps
    window.abrirRota = function() {
      if (origem && endereco) {
        // Formato da URL do Google Maps
        const rotaGoogleMaps = `http://maps.google.com/maps?saddr=${encodeURIComponent(origem)}&daddr=${encodeURIComponent(endereco)}&dirflg=d`;
        window.open(rotaGoogleMaps, "_blank");
      } else {
        alert("Endereços de origem e destino não encontrados.");
      }
    };

    // Funções do Modal
    window.abrirModal = function() {
      document.getElementById("modal").style.display = "flex";
    };

    window.fecharModal = function() {
      document.getElementById("modal").style.display = "none";
      document.getElementById("modalContent").innerHTML = originalModalContent;
    };

    window.mostrarMensagem = function(item) {
      let imagens = [];
      switch (item) {
        case 'Hardware':
          imagens = [
            '{{ asset("img/Terra.gif") }}',
            '{{ asset("img/Terra.gif") }}'
          ];
          break;
        case 'Eletrodomésticos':
          imagens = [
            '{{ asset("img/Terra.gif") }}',
            '{{ asset("img/Terra.gif") }}',
            '{{ asset("img/Terra.gif") }}'
          ];
          break;
        case 'Monitores':
          imagens = [
            '{{ asset("img/Terra.gif") }}',
            '{{ asset("img/Terra.gif") }}',
            '{{ asset("img/Terra.gif") }}'
          ];
          break;
        case 'Computador':
          imagens = [
            '{{ asset("img/Terra.gif") }}'
          ];
          break;
        case 'Pilhas':
          imagens = [
            '{{ asset("img/Terra.gif") }}',
            '{{ asset("img/Terra.gif") }}'
          ];
          break;
        default:
          imagens = ['{{ asset("img/Terra.gif") }}'];
      }

      const imagemTags = imagens.map(url => `<img src="${url}" alt="${item}" style="max-width: 150px; margin: 10px;">`).join('');
      const content = `
        <button class="close-btn" onclick="fecharModal()">×</button>
        <h2>Parabéns pelo descarte de ${item}!</h2>
        <p style="margin-top: 20px;">Você está contribuindo para um planeta mais limpo 🌱<br>
        Ao descartar corretamente, você protege o meio ambiente e inspira outros a fazer o mesmo.</br> Essa é a quantidade de terras que seriam gastas em um mundo sem você:</p>
        <div style="display: flex; flex-wrap: wrap; justify-content: center;">${imagemTags}</div>
      `;
      document.getElementById("modalContent").innerHTML = content;
    };
});