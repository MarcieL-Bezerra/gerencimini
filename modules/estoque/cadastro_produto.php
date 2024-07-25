<?php
// Incluir o arquivo de conexão
include '../../db/connection.php';
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$baseUrl = $protocol . $_SERVER['HTTP_HOST'] ;

// Processar o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $nome = $_POST['nome'];
    $codigo_barras = $_POST['codigo_barras'];
    $quantidade = $_POST['quantidade'];

    // Preparar a consulta SQL
    $sql = "INSERT INTO produtos (nome, codigo_barras, quantidade) VALUES (?, ?, ?)";

    // Preparar e vincular
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nome, $codigo_barras, $quantidade);

    // Executar e verificar se a inserção foi bem-sucedida
    if ($stmt->execute()) {
        $alertMessage = "Produto cadastrado com sucesso!";
        $alertType = "success";
    } else {
        $alertMessage = "Erro: " . $stmt->error;
        $alertType = "error";
    }

    // Fechar a declaração
    $stmt->close();
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cadastro de Produto</title>
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h1>Cadastro de Produto</h1>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <br><br>
        <label for="codigo_barras">Código de Barras:</label>
        <input type="text" id="codigo_barras" name="codigo_barras" required>
        <br><br>
        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade" required>
        <br><br>
        <input type="submit" value="Cadastrar">
    </form>
    <?php include '../../includes/footer.php'; ?>
    <?php if (!empty($alertMessage)) : ?>
        <script type="text/javascript">
            showAlert("<?php echo $alertMessage; ?>", "<?php echo $alertType; ?>");
        </script>
    <?php endif; ?>
</body>
</html>
