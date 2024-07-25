<?php
// Incluir o arquivo de conexão
include '../../db/connection.php';

// Inicializa variáveis
$id = "";
$nome = "";
$cnpj = "";
$alertMessage = "";
$alertType = "success";

// Se há um ID na URL, carrega os dados do produto
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepara a consulta SQL
    $sql = "SELECT nome, cnpj FROM fornecedores WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nome, $cnpj);
    
    if (!$stmt->fetch()) {
        $alertMessage = "Fornecedor não encontrado!";
        $alertType = "error";
        $id = "";
        $nome = "";
        $cnpj = "";
    }
    
    $stmt->close();
} else {
    $alertMessage = "ID do produto não fornecido!";
    $alertType = "error";
}

// Processar o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $nome = $_POST['nome'];
    $cnpj = $_POST['cnpj'];

    // Atualiza o produto existente
    $sql = "UPDATE fornecedores SET nome=?, cnpj=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nome, $cnpj, $id);
    
    if ($stmt->execute()) {
        $alertMessage = "Fornecedor atualizado com sucesso!";
        $alertType = "success"; // Corrige o tipo do alerta para sucesso
    } else {
        $alertMessage = "Erro: " . $stmt->error;
        $alertType = "error";
    }
    
    // Fechar a declaração
    $stmt->close();
    
    // A mensagem de alerta será exibida e a página será redirecionada após o fechamento do alerta
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Editar Fornecedor</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function showAlert(message, type) {
            Swal.fire({
                icon: type,
                title: type === 'success' ? 'Sucesso' : 'Erro',
                text: message,
                confirmButtonText: 'OK',
                willClose: () => {
                    if (type === 'success') {
                        window.location.href = '/gerencimini/modules/compras/listar_fornecedor.php';
                    }
                }
            });
        }
    </script>
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . htmlspecialchars($id); ?>" method="post">
        <h1>Editar Fornecedor</h1>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
        <br><br>
        <label for="cnpj">CNPJ:</label>
        <input type="text" id="cnpj" name="cnpj" value="<?php echo htmlspecialchars($cnpj); ?>" required>
        <br><br>
        <br><br>
        <input type="submit" value="Atualizar">
    </form>
    <?php include '../../includes/footer.php'; ?>
    <?php if (!empty($alertMessage)) : ?>
        <script type="text/javascript">
            showAlert("<?php echo $alertMessage; ?>", "<?php echo $alertType; ?>");
        </script>
    <?php endif; ?>
</body>
</html>
