<!DOCTYPE html>
<html lang="pt-br">
<?php include 'includes/head.php'; ?>
<?php include 'includes/config.php'; ?>

<body>

<?php include 'includes/navbar.php'; ?>

<main class="container my-5">
  <h2 class="text-center mb-4">Histórico da Máquina</h2>

  <!-- Abas -->
  <ul class="nav nav-tabs" id="historicoTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="completo-tab" data-bs-toggle="tab" data-bs-target="#completo" type="button" role="tab">Histórico Completo</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="erros-tab" data-bs-toggle="tab" data-bs-target="#erros" type="button" role="tab">Erros Registrados</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="vedacoes-tab" data-bs-toggle="tab" data-bs-target="#vedacoes" type="button" role="tab">Trocas de Vedação</button>
    </li>
  </ul>

  <!-- Conteúdo das Abas -->
  <div class="tab-content mt-3">

    <!-- 🧾 Histórico Completo -->
    <div class="tab-pane fade show active" id="completo" role="tabpanel">
      <h5>Histórico Completo</h5>
      <table class="table table-striped">
        <thead class="table-dark">
          <tr>
            <th>Data</th>
            <th>Tipo</th>
            <th>Descrição</th>
            <th>Circuito</th>
            <th>Operador</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM registros ORDER BY data_registro DESC";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>" . date('d/m/Y H:i', strtotime($row['data_registro'])) . "</td>
                      <td>{$row['tipo']}</td>
                      <td>{$row['descricao']}</td>
                      <td>{$row['circuito']}</td>
                      <td>{$row['operador']}</td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='5' class='text-center text-muted'>Nenhum registro encontrado.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- ❌ Erros Registrados -->
    <div class="tab-pane fade" id="erros" role="tabpanel">
      <h5>Erros Registrados</h5>
      <table class="table table-striped">
        <thead class="table-danger">
          <tr>
            <th>Data</th>
            <th>Descrição</th>
            <th>Circuito</th>
            <th>Operador</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM registros WHERE tipo = 'Erro' ORDER BY data_registro DESC";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>" . date('d/m/Y H:i', strtotime($row['data_registro'])) . "</td>
                      <td>{$row['descricao']}</td>
                      <td>{$row['circuito']}</td>
                      <td>{$row['operador']}</td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='4' class='text-center text-muted'>Nenhum erro registrado.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- 🔧 Trocas de Vedação -->
    <div class="tab-pane fade" id="vedacoes" role="tabpanel">
      <h5>Trocas de Vedação</h5>
      <table class="table table-striped">
        <thead class="table-warning">
          <tr>
            <th>Data</th>
            <th>Circuito</th>
            <th>Descrição</th>
            <th>Responsável</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM registros WHERE tipo = 'Vedação' ORDER BY data_registro DESC";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>" . date('d/m/Y H:i', strtotime($row['data_registro'])) . "</td>
                      <td>{$row['circuito']}</td>
                      <td>{$row['descricao']}</td>
                      <td>{$row['operador']}</td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='4' class='text-center text-muted'>Nenhuma troca registrada.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
