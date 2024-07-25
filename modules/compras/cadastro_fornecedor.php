<?php
// Incluir o arquivo de conexão
include '../../db/connection.php';
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$baseUrl = $protocol . $_SERVER['HTTP_HOST'] ;

// Processar o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $nome = $_POST['nome'];
    $cnpj = $_POST['cnpj'];

    // Preparar a consulta SQL
    $sql = "INSERT INTO fornecedores (nome, cnpj) VALUES (?, ?)";

    // Preparar e vincular
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nome, $cnpj);

    // Executar e verificar se a inserção foi bem-sucedida
    if ($stmt->execute()) {
        $alertMessage = "Fornecedor cadastrado com sucesso!";
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
    <title>Cadastro de Fornecedor</title>
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
                onClose: () => {
                    window.location.href = "/gerencimini/index.php";
                }
            });
        }
    </script>
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1>Cadastro de Fornecedor</h1>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            <br><br>
            <label for="cnpj">CNPJ:</label>
            <input type="text" id="cnpj" name="cnpj" required>
            <br><br>
            <input type="submit" value="Cadastrar">
        </form>
    </form>
    <?php include '../../includes/footer.php'; ?>
    <?php if (!empty($alertMessage)) : ?>
        <script type="text/javascript">
            showAlert("<?php echo $alertMessage; ?>");
        </script>
    <?php endif; ?>
</body>
</html>
