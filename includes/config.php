<?php
$servername = "localhost";
$username = "root";       // padrão do XAMPP
$password = "";           // geralmente vazio
$dbname = "portal_condutor";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Erro de conexão: " . $conn->connect_error);
}
?>
