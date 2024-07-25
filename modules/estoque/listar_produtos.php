<?php
// Incluir o arquivo de conexão
include '../../db/connection.php';

// Preparar a consulta SQL
$sql = "SELECT id, nome, codigo_barras, quantidade FROM produtos";

// Preparar e executar a consulta
$result = $conn->query($sql);

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Opcional: Inclua um arquivo CSS para estilizar -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function confirmDeletion(event, id) {
            event.preventDefault(); // Previne o comportamento padrão do link

            Swal.fire({
                title: 'Tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Se confirmado, redireciona para a página de exclusão
                    window.location.href = 'excluir_produto.php?id=' + id;
                }
            });
        }
    </script>
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <h1>Lista de Produtos</h1>
    <?php if ($result->num_rows > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Código de Barras</th>
                    <th>Quantidade</th>
                    <th>Ações</th> <!-- Nova coluna para ações -->
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td><?php echo htmlspecialchars($row['codigo_barras']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantidade']); ?></td>
                        <td>
                            <a href="editar_produto.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn-edit">Editar</a>
                            <a href="#" class="btn-delete" onclick="confirmDeletion(event, <?php echo htmlspecialchars($row['id']); ?>)">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Não há produtos cadastrados.</p>
    <?php endif; ?>
    <?php include '../../includes/footer.php'; ?>
</body>
</html>
