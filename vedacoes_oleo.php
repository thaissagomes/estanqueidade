<!DOCTYPE html>
<html lang="pt-br">
<?php include 'includes/head.php'; ?>

<body>
  <?php include 'includes/navbar.php';?>

  <main class="container my-5">
    <h2 class="text-center mb-4">Circuito de Óleo - Cabeçote HR16</h2>

    <p>O circuito de óleo é responsável por testar as galerias de alta pressão e as esferas internas do cabeçote HR16. 
      Vazamentos durante o teste HP indicam desgaste das vedações F300 e F600 (A–D).</p>

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
            <td>Enchimento lento / pressão instável (~4–5 bar). Vazamento constante durante o teste HP/Esferas.</td>
            <td>Vedação F300 danificada.<br>Vazamento interno em F600 (A–D).<br>Tampões ou esferas ausentes.<br>Filtro hidráulico ou linha de retorno obstruída.</td>
            <td>F300, F600-A, F600-B, F600-C, F600-D</td>
            <td>E833842191 / E833842189 / R100753201 / R100751038 / R100751030</td>
            <td>PU ou Silicone — 60 shore</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="text-center mt-4">
      <img src="img/vedacao_oleo.jpg" alt="Pontos de vedação do circuito de óleo - HR16" class="img-fluid rounded shadow" style="max-height:400px;">
      <small class="d-block text-muted mt-2">Borrachas do Circuito de Óleo Alta Pressão</small>
    </div>

    <div class="text-center mt-5">
      <a href="vedacoes.php" class="btn btn-dark">← Voltar</a>
    </div>
  </main>
</body>
</html>
