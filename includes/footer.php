<?php
    // Obter a URL base
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $baseUrl = $protocol . $_SERVER['HTTP_HOST'] ;

    // Caminho da imagem
    $imagePath = $baseUrl . '/gerencimini/img/logo.webp';
    ?>

<footer class="footer">
    <img src="<?php echo $imagePath; ?>" alt="Imagem" class="footer-image">
    <h2>GerenciMini</h2>
    <p>&copy; 2024 GerenciMini. Todos os direitos reservados.</p>
    <p>Simplificando a gestão do seu mercadinho!</p>
    <p class="signature">Criado por Marciel Bezerra</p>
</footer>