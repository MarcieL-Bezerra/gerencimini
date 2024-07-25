<?php
// Configurações do banco de dados
$servername = "localhost"; // ou o endereço do servidor MySQL
$username = "root"; // usuário root do MySQL
$password = ""; // senha vazia
$database = "gerencimin"; // substitua pelo nome do seu banco de dados

// Criar uma conexão
$conn = new mysqli($servername, $username, $password, $database);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
// echo "Conectado com sucesso";

// Fechar a conexão
// $conn->close();
?>
