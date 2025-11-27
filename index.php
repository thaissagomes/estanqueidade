<!DOCTYPE html>
<html lang="pt-br">
<?php include 'includes/head.php'; ?>
<body>

  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>

  <div class="container-fluid my-5">

    <!-- Título -->
    <h1 class="text-center mb-4" style="color:#000;">Portal da Máquina de Estanqueidade</h1>

    <!--  GRÁFICO  -->
    <div class="card shadow-lg mb-4 p-4 grafico-container">
      <h4 class="text-center mb-3 text-white">Monitoramento de Pressão dos Circuitos</h4>

      <div class="card shadow-lg mb-4 p-4 grafico-container">
  <h4 class="text-center mb-3 text-white">Monitoramento de Pressão</h4>

  <div class="row">
    <div class="col-12 col-md-4 mb-3">
      <h6 class="text-center text-white">Água</h6>
      <div id="graficoAgua" style="height:180px;"></div>
    </div>

    <div class="col-12 col-md-4 mb-3">
      <h6 class="text-center text-white">Vela</h6>
      <div id="graficoVela" style="height:180px;"></div>
    </div>

    <div class="col-12 col-md-4 mb-3">
      <h6 class="text-center text-white">Óleo</h6>
      <div id="graficoOleo" style="height:180px;"></div>
    </div>
  </div>
</div>


    <!-- CARDS -->
    <div class="row g-4 justify-content-center">

      <!-- Card 1 -->
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card text-center shadow-lg card-hover h-100">
          <div class="card-body d-flex flex-column">
            <h4 class="card-title">Trocar Vedação</h4>
            <p class="card-text flex-grow-1">Anote e categorize falhas detectadas pela máquina.</p>
            <a href="registrar-erro.php" class="btn btn-dark mt-auto">Acessar</a>
          </div>
        </div>
      </div>

    

      <!-- Card 2 -->
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

 <script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>

<script>
function criarGrafico(id, nome, cor, dados) {
  var chart = echarts.init(document.getElementById(id));
  var option = {
    backgroundColor: "transparent",
    tooltip: { trigger: "axis" },

    xAxis: {
      type: "category",
      data: ['08:00','08:30','09:00','09:30','10:00','10:30','11:00'],
      axisLabel: { color: "#E8F1FF", fontSize: 10 },
      axisLine: { lineStyle: { color: "#666" } }
    },

    yAxis: {
      type: "value",
      axisLabel: { color: "#E8F1FF", fontSize: 10 },
      axisLine: { lineStyle: { color: "#666" } },
      splitLine: { lineStyle: { color: "rgba(255,255,255,0.05)" } }
    },

    series: [
      {
        name: nome,
        data: dados,
        type: "line",
        smooth: true,
        lineStyle: { color: cor, width: 3 },
        itemStyle: { color: cor },
        areaStyle: { color: cor + "33" } // 33 = 20% de opacidade
      }
    ]
  };

  chart.setOption(option);
  window.addEventListener("resize", () => chart.resize());
}

/* Criando cada gráfico */
criarGrafico("graficoAgua", "Água", "#00B4FF", [2.1, 2.3, 2.2, 2.5, 2.4, 2.7, 2.6]);
criarGrafico("graficoVela", "Vela", "#FF7300", [1.8, 1.9, 2.0, 2.1, 1.9, 1.8, 1.7]);
criarGrafico("graficoOleo", "Óleo", "#00FF85", [3.0, 2.9, 3.1, 3.2, 3.3, 3.2, 3.1]);
</script>

</body>
</html>
