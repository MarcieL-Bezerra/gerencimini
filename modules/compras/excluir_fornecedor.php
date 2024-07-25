<?php
// Incluir o arquivo de conexão
include '../../db/connection.php';

// Inicializa variáveis
$id = "";
$alertMessage = "";
$alertType = "success";

// Verificar se o ID foi fornecido
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar a consulta SQL para excluir o fornecedor
    $sql = "DELETE FROM fornecedores WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $alertMessage = "Fornecedor excluído com sucesso!";
        $alertType = "success";
    } else {
        $alertMessage = "Erro: " . $stmt->error;
        $alertType = "error";
    }

    // Fechar a declaração
    $stmt->close();
} else {
    $alertMessage = "ID do fornecedor não fornecido!";
    $alertType = "error";
}

// Fechar a conexão
$conn->close();

// Redirecionar após a exclusão
header("Location: listar_fornecedor.php?alertMessage=" . urlencode($alertMessage) . "&alertType=" . urlencode($alertType));
exit;
?>
