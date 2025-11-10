<!DOCTYPE html>
<html lang="pt-br">
<?php include 'includes/head.php'; ?>

  <!-- Navbar -->
 <?php include 'includes/navbar.php';?>

  <!-- Conteúdo principal -->
  <div class="container my-5">
    <h1 class="text-center mb-4">Portal das Borrachas de Vedações</h1>

    <div class="row g-4 justify-content-center">

      <!-- Card 1 -->
      <div class="col-md-4">
        <div class="card text-center shadow-lg card-hover">
          <div class="card-body">
            <h4 class="card-title">Circuito Água</h4>
            <p class="card-text">Problemas na galeria de circuito de água.</p>
            <a href="vedacoes_agua.php" class="btn btn-dark">Acessar</a>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-md-4">
        <div class="card text-center shadow-lg card-hover">
          <div class="card-body">
            <h4 class="card-title">Circuito Vela</h4>
            <p class="card-text">Problemas na galeria de circuito de vela.</p>
            <a href="vedacoes_vela.php" class="btn btn-dark">Acessar</a>
          </div>
        </div>
      </div>

      <!-- Card 3 (Histórico substituindo a Árvore de Falhas) -->
      <div class="col-md-4">
        <div class="card text-center shadow-lg card-hover">
          <div class="card-body">
            <h4 class="card-title">Circuito Óleo Alta Pressão</h4>
            <p class="card-text">Problemas na galeria de circuito de óleo.</p>
            <a href="vedacoes_oleo.php" class="btn btn-dark">Acessar</a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
