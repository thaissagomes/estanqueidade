<!DOCTYPE html>
<html lang="pt-br">
<?php include 'includes/head.php'; ?>
<body>
  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>

  <div class="container my-5">
    <h1 class="text-center mb-4">🌳 Árvore de Falhas - Teste de Estanqueidade</h1>

    <!-- Etapa 1 -->
    <div class="card p-4 text-center" id="etapa1">
      <h3 class="mb-3">A peça falhou no teste?</h3>
      <button class="btn btn-horse btn-lg mx-2" onclick="mostrarEtapa('etapa2')">Sim</button>
      <button class="btn btn-dark btn-lg mx-2" onclick="finalizar()">Não</button>
    </div>

    <!-- Etapa 2 -->
    <div class="card p-4 text-center d-none" id="etapa2">
      <h4 class="mb-3">Realizar as seguintes limpezas:</h4>
      <ul class="list-unstyled">
        <li>✅ Mesa</li>
        <li>✅ Vedações do circuito reprovador</li>
        <li>✅ Peça</li>
      </ul>
      <p class="mt-3">Após a limpeza, refazer o teste.</p>
      <h4 class="mt-4">A peça reprovou novamente?</h4>
      <button class="btn btn-horse btn-lg mx-2" onclick="mostrarEtapa('etapa3')">Sim</button>
      <button class="btn btn-dark btn-lg mx-2" onclick="finalizar()">Não</button>
    </div>

    <!-- Etapa 3 -->
    <div class="card p-4 text-center d-none" id="etapa3">
      <h4>Realizar teste com a peça padrão.

      inserir valores da peça padrao aqui .........
      </h4>
      <h4 class="mt-4">A peça padrão também reprovou?</h4>
      <button class="btn btn-horse btn-lg mx-2" onclick="mostrarEtapa('etapa4')">Sim</button>
      <button class="btn btn-dark btn-lg mx-2" onclick="finalizar()">Não</button>
    </div>

    <!-- Etapa 4 -->
    <div class="card p-4 text-center d-none" id="etapa4">
      <h4>Realizar medição da temperatura da peça.</h4>
      <h4 class="mt-4">Temperatura maior que 30°C?</h4>
      <button class="btn btn-horse btn-lg mx-2" onclick="mostrarEtapa('etapa5')">Sim</button>
      <button class="btn btn-dark btn-lg mx-2" onclick="mostrarEtapa('etapa6')">Não</button>
    </div>

    <!-- Etapa 5 -->
    <div class="card p-4 text-center d-none" id="etapa5">
      <h4>Verificar o Chiller da máquina.</h4>
      <h4 class="mt-4">Chiller com temperatura alta?</h4>
      <button class="btn btn-horse btn-lg mx-2" onclick="finalizarManutencao()">Sim</button>
      <button class="btn btn-dark btn-lg mx-2" onclick="mostrarEtapa('etapa6')">Não</button>
    </div>

    <!-- Etapa 6 -->
    <div class="card p-4 text-center d-none" id="etapa6">
      <h4>Verificar acabamento da face usinada no circuito reprovado.</h4>
      <h4 class="mt-4">A reprovação ainda continua?</h4>
      <button class="btn btn-horse btn-lg mx-2" onclick="mostrarEtapa('etapa7')">Sim</button>
      <button class="btn btn-dark btn-lg mx-2" onclick="finalizar()">Não</button>
    </div>

    <!-- Etapa 7 -->
    <div class="card p-4 text-center d-none" id="etapa7">
      <h4>Iniciar troca das vedações do circuito.</h4>
      <p class="mt-3">Após a troca, realizar novo teste com a peça padrão.</p>
      <p class="text-info mt-3">Se ainda reprovar, contatar o responsável técnico.</p>
      <button class="btn btn-dark btn-lg mt-3" onclick="reiniciar()">Reiniciar Diagnóstico</button>
    </div>
  </div>

  <script>
    function mostrarEtapa(id) {
      document.querySelectorAll('.card').forEach(c => c.classList.add('d-none'));
      document.getElementById(id).classList.remove('d-none');
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function finalizar() {
      alert("✅ Teste concluído com sucesso!");
      reiniciar();
    }

    function finalizarManutencao() {
      alert("⚠️ Chamar equipe de manutenção!");
      reiniciar();
    }

    function reiniciar() {
      document.querySelectorAll('.card').forEach(c => c.classList.add('d-none'));
      document.getElementById('etapa1').classList.remove('d-none');
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  </script>

  <?php include 'includes/footer.php'; ?>
</body>
</html>

