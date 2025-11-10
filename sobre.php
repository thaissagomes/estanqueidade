<!DOCTYPE html>
<html lang="pt-br">
<?php include 'includes/head.php'; ?>

<body>
  <!-- Navbar -->
  <?php include 'includes/navbar.php';?>

  <main class="container my-5">
    <h2 class="text-center mb-4">Sobre a Máquina de Estanqueidade</h2>

    <!-- 🔧 BLOCO 1: PARÂMETROS OPERACIONAIS -->
    <div class="mb-5 p-4 bg-light border rounded shadow-sm">
      <h4 class="mb-3 text-danger fw-bold">⚙️ Parâmetros Operacionais da Máquina</h4>
      <p>Antes de iniciar o ciclo, confira se os valores abaixo estão dentro dos padrões especificados pelo fabricante:</p>

      <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th>Sistema</th>
              <th>Parâmetro</th>
              <th>Valor Padrão</th>
              <th>Observação</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Pneumático</td>
              <td>Pressão de alimentação</td>
              <td><strong>5–6 bar</strong></td>
              <td>Vazão mínima de 80 m³/h</td>
            </tr>
            <tr>
              <td>Hidráulico</td>
              <td>Pressão nominal</td>
              <td><strong>60 bar</strong></td>
              <td>Reservatório de 100 L (óleo Tellus 68)</td>
            </tr>
            <tr>
              <td>Elétrico</td>
              <td>Tensão de alimentação</td>
              <td><strong>380 VCA</strong></td>
              <td>Consumo de 3 KVA</td>
            </tr>
            <tr>
              <td>Circuito de Água</td>
              <td>Pressão de teste</td>
              <td><strong>1,5 bar</strong></td>
              <td>Galeria de circuito de água</td>
            </tr>
            <tr>
              <td>Circuito de Óleo (Alta Pressão)</td>
              <td>Pressão de teste</td>
              <td><strong>9 ccm – 1100 cm³</strong></td>
              <td>Esferas do circuito de óleo</td>
            </tr>
            <tr>
              <td>Circuito de Vela</td>
              <td>Pressão de teste</td>
              <td><strong>3,6 ccm – 200 cm³</strong></td>
              <td>Verificar integridade das vedações</td>
            </tr>
          </tbody>
        </table>
      </div>

      <p class="text-muted mt-3">
        🔍 Caso algum valor esteja fora do padrão, interromper o ciclo e acionar a manutenção para inspeção.
      </p>
    </div>

    <!-- 🔩 BLOCO 2: CONDIÇÕES DE BOM FUNCIONAMENTO -->
    <div class="mb-5 p-4 bg-light border rounded shadow-sm">
      <h4 class="mb-3 text-danger fw-bold">✅ Condições para Bom Funcionamento</h4>
      <ul>
        <li>Verificar sistema <strong>hidráulico</strong> dentro do padrão de pressão e nível adequado.</li>
        <li>Conferir pressão e nível do <strong>sistema pneumático</strong> (ar comprimido).</li>
        <li>Checar possíveis <strong>vazamentos</strong> nas conexões de água, óleo e vela.</li>
        <li>Certificar calibração dos <strong>sensores de pressão</strong>.</li>
        <li>Manter o cabeçote limpo e livre de resíduos nas áreas de vedação.</li>
        <li>Confirmar comunicação com o <strong>CLP</strong> e sistemas de medição.</li>
      </ul>
    </div>

    <!-- BLOCO 3: DESCRIÇÃO E FUNCIONAMENTO -->
    <div class="row align-items-center mb-5">
      <div class="col-md-6">
        <p>
         A máquina de estanqueidade é responsável por testar a vedação do cabeçote do motor, 
         verificando possíveis vazamentos nos circuitos de ar, água, óleo e vela. 
         Esse processo garante que cada peça siga para a próxima etapa dentro dos padrões de 
         qualidade e segurança exigidos pela produção.
        </p>
        <p>
          Durante o ciclo, o robô posiciona o cabeçote no alimentador e a peça é encaminhada para a área de
           estanqueidade, onde é pressurizada com ar comprimido. Os sensores da máquina monitoram a variação 
           de pressão para detectar qualquer perda ou falha de vedação.
        </p>
        <p>
          Se o teste for aprovado, a peça segue automaticamente para a próxima etapa do processo.
           Caso contrário, ela retorna à esteira para uma nova tentativa. A máquina realiza até três tentativas consecutivas.
          Se a falha persistir após essas três repetições, o cabeçote é direcionado para uma esteira
           de peças não conformes, onde o operador realiza a verificação manual para identificar a 
           causa da reprovação.

        </p>
      </div>

      <div class="col-md-6 text-center">
        <img src="img/foto_maquina.jpg" alt="Máquina de Estanqueidade" class="img-fluid rounded shadow" style="max-height: 300px;">
        <small class="text-muted d-block mt-2">Imagem ilustrativa da máquina de estanqueidade</small>
      </div>
    </div>

    <!-- BLOCO 4: MANUTENÇÃO -->
    <div class="mb-5">
      <h4 class="mb-3">Manutenção e Observações</h4>
      <ul>
        <li>Verificar condições das borrachas de vedação e engates rápidos.</li>
        <li>Limpar os canais de ar e sensores de pressão.</li>
        <li>Manter o alinhamento e fechamento correto do cabeçote.</li>
        <li>Registrar ocorrências no <a href="historico.html">portal de histórico</a>.</li>
      </ul>
      <p class="text-muted mt-3">
        ⚙️ Página atualizável conforme novos parâmetros técnicos forem adicionados.
      </p>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
