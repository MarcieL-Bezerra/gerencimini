<?php
// Incluir o arquivo de conexão
include '../../db/connection.php';

// Inicializa variáveis
$id = "";
$nome = "";
$codigo_barras = "";
$quantidade = "";
$alertMessage = "";
$alertType = "success";

// Se há um ID na URL, carrega os dados do produto
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepara a consulta SQL
    $sql = "SELECT nome, codigo_barras, quantidade FROM produtos WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nome, $codigo_barras, $quantidade);
    
    if (!$stmt->fetch()) {
        $alertMessage = "Produto não encontrado!";
        $alertType = "error";
        $id = "";
        $nome = "";
        $codigo_barras = "";
        $quantidade = "";
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
    $codigo_barras = $_POST['codigo_barras'];
    $quantidade = $_POST['quantidade'];

    // Atualiza o produto existente
    $sql = "UPDATE produtos SET nome=?, codigo_barras=?, quantidade=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $nome, $codigo_barras, $quantidade, $id);
    
    if ($stmt->execute()) {
        $alertMessage = "Produto atualizado com sucesso!";
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
    <title>Editar Produto</title>
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
                        window.location.href = '/gerencimini/modules/estoque/listar_produtos.php';
                    }
                }
            });
        }
    </script>
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . htmlspecialchars($id); ?>" method="post">
        <h1>Editar Produto</h1>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
        <br><br>
        <label for="codigo_barras">Código de Barras:</label>
        <input type="text" id="codigo_barras" name="codigo_barras" value="<?php echo htmlspecialchars($codigo_barras); ?>" required>
        <br><br>
        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade" value="<?php echo htmlspecialchars($quantidade); ?>" required>
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
