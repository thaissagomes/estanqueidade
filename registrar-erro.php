<!DOCTYPE html>
<html lang="pt-br">
<?php include 'includes/head.php'; ?>
<body>
<?php
include 'includes/config.php';

// Se clicou num botão de troca automática
if (isset($_GET['circuito'])) {
    $circuito = $_GET['circuito'];
    $tipo = "Vedação";
    $descricao = "Troca de borracha no circuito de $circuito";
    $sql = "INSERT INTO registros (tipo, circuito, descricao) VALUES ('$tipo', '$circuito', '$descricao')";
    $conn->query($sql);
    header("Location: registrar-erro.php?sucesso=1");
exit;
}

// Se enviou o formulário de erro manual
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = "Erro";
    $circuito = "Outro";
    $descricao = $_POST['descricaoErro'];
    $sql = "INSERT INTO registros (tipo, circuito, descricao) VALUES ('$tipo', '$circuito', '$descricao')";
    $conn->query($sql);
    header("Location: registrar-erro.php?sucesso=1");
    exit;
}

?>
<?php include 'includes/navbar.php'; ?>

<?php
if (isset($_GET['sucesso'])) {
  echo '<div id="msgSucesso" class="alert alert-success alert-dismissible fade show text-center mt-3" role="alert">
          Registro salvo com sucesso!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
?>



<div class="container my-5">
  <h2 class="text-center mb-4">Registro de Trocas da Máquina</h2>
  <p class="text-center text-muted mb-5">Selecione o tipo de falha observada ou registre manualmente outro tipo de erro.</p>

  <div class="row g-4 justify-content-center align-items-stretch">
    <!-- Card Água -->
    <div class="col-md-3 d-flex">
      <div class="card text-center shadow card-hover d-flex flex-column">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">Água</h5>
          <p class="card-text">Troca de vedação no circuito de água.</p>
          <a href="registrar-erro.php?circuito=Água" class="btn btn-dark">Registrar troca</a>
        </div>
      </div>
    </div>

    <!-- Card Vela -->
    <div class="col-md-3 d-flex">
      <div class="card text-center shadow card-hover d-flex flex-column">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">Vela</h5>
          <p class="card-text">Troca de vedação no circuito de vela.</p>
          <a href="registrar-erro.php?circuito=Vela" class="btn btn-dark">Registrar troca</a>
        </div>
      </div>
    </div>

    <!-- Card Óleo -->
    <div class="col-md-3 d-flex">
      <div class="card text-center shadow card-hover d-flex flex-column">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">Óleo</h5>
          <p class="card-text">Troca de vedação no circuito de óleo.</p>
          <a href="registrar-erro.php?circuito=Óleo" class="btn btn-dark">Registrar troca</a>
        </div>
      </div>
    </div>

    <!-- Card Outro Erro -->
    <div class="col-md-3 d-flex ">
      <div class="card text-center shadow card-hover d-flex flex-column">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">Outro Erro</h5>
          <p class="card-text">Registrar manualmente um erro diferente dos listados.</p>
          <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalOutroErro">Registrar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de registro manual -->
<div class="modal fade" id="modalOutroErro" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registrar Outro Erro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="">
          <div class="mb-3">
            <label for="descricaoErro" class="form-label">Descrição</label>
            <textarea id="descricaoErro" name="descricaoErro" class="form-control" rows="4" placeholder="Descreva o problema observado..." required></textarea>
          </div>
          <button type="submit" class="btn btn-dark w-100">Salvar Registro</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const msg = document.getElementById("msgSucesso");
  if (msg) {
    // some sozinho após 3s
    setTimeout(() => {
      // fade manual
      msg.classList.add("fade");
      msg.style.transition = "opacity .5s";
      msg.style.opacity = "0";
      setTimeout(() => msg.remove(), 500);
    }, 3000);

    // remove o ?sucesso=1 da URL (evita reaparecer ao atualizar)
    const url = new URL(window.location);
    url.searchParams.delete("sucesso");
    window.history.replaceState({}, "", url);
  }
});
</script>

</body>
</html>
