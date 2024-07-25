<?php
// Obtém o nome do arquivo atual
$currentFile = basename($_SERVER['PHP_SELF']);

// Define um array com os nomes dos módulos e seus caminhos
$modules = array(
    'Home' => array('/gerencimini/index.php' => 'Pagina Inicial'),'Estoque' => array('/gerencimini/modules/estoque/cadastro_produto.php' => 'Cadastrar Produto','/gerencimini/modules/estoque/contagem_estoque.php' => 'Contagem de Estoque', '/gerencimini/modules/estoque/listar_produtos.php' => 'Listar Estoque'),
    'Compras' => array('/gerencimini/modules/compras/orcamento.php' => 'Orçamento','/gerencimini/modules/compras/cadastro_fornecedor.php'=> 'Cadastrar Fornecedor','/gerencimini/modules/compras/listar_fornecedor.php'=> 'Listar Fornecedores', '/gerencimini/modules/compras/compras_lista.php' => 'Lista de Compras'),
    'Caixa' => array('registro_saida.php' => 'Registro de Saída', 'caixa_resumo.php' => 'Resumo do Caixa')
);
?>

<!-- Código HTML para o header -->
<header class="header">
    <nav>
        <ul class="nav-list">
            <?php foreach ($modules as $moduleName => $moduleFiles) { ?>
                <li class="nav-item <?php if (array_key_exists($currentFile, $moduleFiles)) { echo 'active'; } ?>">
                    <a href="#"><?php echo $moduleName; ?></a>
                    <ul class="submenu">
                        <?php foreach ($moduleFiles as $file => $label) { ?>
                            <li class="<?php if ($currentFile === $file) { echo 'active'; } ?>">
                                <a href="<?php echo $file; ?>"><?php echo $label; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </nav>
</header>
