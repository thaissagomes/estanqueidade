<!DOCTYPE html>
<html lang="pt-br">
<?php include 'includes/head.php'; ?>
<body>

  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>

  <div class="container my-5">
    <!-- Título do Portal -->
    <h1 class="text-center mb-4" style="color:#000;">Portal da Máquina de Estanqueidade</h1>

    <!-- GRÁFICO -->
    <div class="card shadow-lg mb-4 p-4" style="background-color:#0A0F24;">
      <h4 class="text-center mb-3 text-white">Monitoramento de Pressão dos Circuitos</h4>
      <div id="graficoPressao" style="width: 100%; height: 400px;"></div>
      <div style="color:#bbb; text-align:center; margin-top:8px; font-size:14px;">
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

  <!-- ECharts -->
  <script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>

  <script>
    var chartDom = document.getElementById('graficoPressao');
    var myChart = echarts.init(chartDom);

    var option = {
      backgroundColor: '#0A0F24',
      tooltip: {
        trigger: 'axis',
        backgroundColor: 'rgba(30,30,30,0.9)',
        textStyle: { color: '#fff' }
      },
      legend: {
        data: ['Água', 'Vela', 'Óleo'],
        top: 10,
        textStyle: { color: '#E8F1FF' }
      },
      grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
      xAxis: {
        type: 'category',
        boundaryGap: false,
        data: ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00'],
        axisLine: { lineStyle: { color: '#777' } },
        axisLabel: { color: '#E8F1FF' }
      },
      yAxis: {
        type: 'value',
        name: 'Pressão (bar)',
        axisLine: { lineStyle: { color: '#777' } },
        axisLabel: { color: '#E8F1FF' },
        splitLine: { lineStyle: { color: '#222' } }
      },
      series: [
        {
          name: 'Água',
          type: 'line',
          smooth: true,
          data: [2.1, 2.3, 2.2, 2.5, 2.4, 2.7, 2.6],
          lineStyle: { color: '#00B4FF', width: 3 },
          itemStyle: { color: '#00B4FF' },
          areaStyle: { color: 'rgba(0,180,255,0.08)' }
        },
        {
          name: 'Vela',
          type: 'line',
          smooth: true,
          data: [1.8, 1.9, 2.0, 2.1, 1.9, 1.8, 1.7],
          lineStyle: { color: '#FF7300', width: 3 },
          itemStyle: { color: '#FF7300' },
          areaStyle: { color: 'rgba(255,115,0,0.08)' }
        },
        {
          name: 'Óleo',
          type: 'line',
          smooth: true,
          data: [3.0, 2.9, 3.1, 3.2, 3.3, 3.2, 3.1],
          lineStyle: { color: '#00FF85', width: 3 },
          itemStyle: { color: '#00FF85' },
          areaStyle: { color: 'rgba(0,255,133,0.08)' }
        }
      ],
      visualMap: {
        show: false,
        pieces: [
          { gt: 0, lte: 2, color: 'rgba(255,0,0,0.25)' },
          { gt: 2, lte: 5, color: 'rgba(0,255,0,0.15)' },
          { gt: 5, lte: 7, color: 'rgba(255,0,0,0.25)' }
        ]
      }
    };

    myChart.setOption(option);
  </script>

</body>
</html>
