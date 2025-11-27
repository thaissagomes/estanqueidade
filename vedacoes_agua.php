<!DOCTYPE html>
<html lang="pt-br">
<?php include 'includes/head.php'; ?>

<body>
 <?php include 'includes/navbar.php';?>

  <main class="container my-5">
    <h2 class="text-center mb-4">Circuito de Água - Cabeçote HR16</h2>

    <p>O circuito de água realiza o teste de estanqueidade nas galerias de refrigeração do cabeçote HR16. 
      Pressões fora do padrão (1 bar ±0,1) ou fuga alta indicam desgaste ou má vedação das borrachas.
    </p>

    <div class="table-responsive">
      <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>Sintoma no ATEQ/IHM</th>
            <th>Causas Prováveis</th>
            <th>Vedações a Trocar</th>
            <th>MABEC</th>
            <th>Material</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Pressão não atinge 1 bar ou cai logo após estabilização. Fuga alta na leitura de vazamento.</td>
            <td>Vedação ressecada, rachada ou fora do canal.<br>Mangueira solta ou válvula Y travada.<br>Sujeira no canal da placa.</td>
            <td>F100, F500-B, F500-C</td>
            <td>R100751036 / E833842193 / E833842192</td>
            <td>Borracha Nitrílica / PU (60–70 shore)</td>
          </tr>
        </tbody>
      </table>
    </div>


    
    <div class="text-center mt-4">
      <img src="img/vedacao_agua.jpg" alt="Pontos de vedação do circuito de água - HR16" class="img-fluid rounded shadow" style="max-height:400px;">
      <small class="d-block text-muted mt-2">Borrachas do Circuito de Água</small>
    </div>

    <div class="text-center mt-5">
      <a href="vedacoes.php" class="btn btn-dark">← Voltar</a>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
