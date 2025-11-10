<!DOCTYPE html>
<html lang="pt-br">
<?php include 'includes/head.php'; ?>
<body>

  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>

  <div class="container my-5">
    <h1 class="text-center mb-4">Portal da Máquina de Estanqueidade</h1>

    <!-- GRÁFICO -->
    <div class="card shadow-lg mb-4 p-4">
      <h4 class="text-center mb-3">Monitoramento de Pressão em Tempo Real</h4>
      <canvas id="graficoPressao" height="120"></canvas>
      <div style="color:#333; text-align:center; margin-top:8px; font-size:14px;">
        <em>Faixas: verde = pressão ideal | vermelho = risco de falha</em>
      </div>
    </div>

    <!-- CARDS -->
    <div class="row g-4 justify-content-center">

      <!-- Card 1 -->
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card text-center shadow-lg card-hover h-100">
          <div class="card-body d-flex flex-column">
            <h4 class="card-title">Registrar Erro</h4>
            <p class="card-text flex-grow-1">Anote e categorize falhas detectadas pela máquina.</p>
            <a href="registrar-erro.php" class="btn btn-dark mt-auto">Acessar</a>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card text-center shadow-lg card-hover h-100">
          <div class="card-body d-flex flex-column">
            <h4 class="card-title">Vedações</h4>
            <p class="card-text flex-grow-1">Consulte os tipos de vedações e seus locais de aplicação.</p>
            <a href="vedacoes.php" class="btn btn-dark mt-auto">Acessar</a>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card text-center shadow-lg card-hover h-100">
          <div class="card-body d-flex flex-column">
            <h4 class="card-title">Árvore de Falhas</h4>
            <p class="card-text flex-grow-1">Visualize os tipos de falhas e o próximo passo a seguir.</p>
            <a href="arvore_falhas.php" class="btn btn-dark mt-auto">Acessar</a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <?php include 'includes/footer.php'; ?>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.4.0/dist/chartjs-plugin-annotation.min.js"></script>

  <script>
    const ctx = document.getElementById('graficoPressao').getContext('2d');

    // Fundo preto dentro do gráfico
    ctx.canvas.style.backgroundColor = "#000";

    // Linha azul em gradiente
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 200, 255, 0.7)');
    gradient.addColorStop(1, 'rgba(0, 200, 255, 0.1)');

    const graficoPressao = new Chart(ctx, {
      type: 'line',
      data: {
        labels: [],
        datasets: [{
          label: 'Pressão (bar)',
          data: [],
          borderColor: '#00eaff',
          backgroundColor: gradient,
          borderWidth: 2.5,
          fill: true,
          pointRadius: 0,
          tension: 0.25
        }]
      },
      options: {
        responsive: true,
        animation: { duration: 0 },
        scales: {
          x: {
            ticks: { color: '#aaa' },
            grid: { color: 'rgba(255,255,255,0.05)' }
          },
          y: {
            min: 0,
            max: 7,
            ticks: { color: '#aaa' },
            grid: { color: 'rgba(255,255,255,0.08)' }
          }
        },
        plugins: {
          legend: { labels: { color: '#fff' } },
          annotation: {
            annotations: {
              faixaBaixa: {
                type: 'box',
                yMin: 0,
                yMax: 2,
                backgroundColor: 'rgba(255, 0, 0, 0.25)' // vermelho embaixo
              },
              faixaSegura: {
                type: 'box',
                yMin: 2,
                yMax: 5,
                backgroundColor: 'rgba(0, 255, 0, 0.25)' // verde no meio
              },
              faixaAlta: {
                type: 'box',
                yMin: 5,
                yMax: 7,
                backgroundColor: 'rgba(255, 0, 0, 0.25)' // vermelho em cima
              }
            }
          }
        }
      },
      plugins: [window['chartjs-plugin-annotation']]
    });

    // Simulação de pressão
    let pressaoAtual = 3;

    function simularPressao() {
      const variacao = (Math.random() - 0.5) * 0.3;
      pressaoAtual += variacao;
      if (pressaoAtual < 1.5) pressaoAtual = 1.5;
      if (pressaoAtual > 6.2) pressaoAtual = 6.2;

      const agora = new Date().toLocaleTimeString('pt-BR', { hour12: false });
      graficoPressao.data.labels.push(agora);
      graficoPressao.data.datasets[0].data.push(pressaoAtual);

      if (graficoPressao.data.labels.length > 25) {
        graficoPressao.data.labels.shift();
        graficoPressao.data.datasets[0].data.shift();
      }

      graficoPressao.update();
    }

    setInterval(simularPressao, 2000);
  </script>

</body>
</html>
