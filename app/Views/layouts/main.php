<?php 
// 1. Carrega o <head> (SEO, CSS, etc)
require __DIR__ . '/head.php'; 

// 2. Carrega o Teu Topnav (Menu)
require __DIR__ . '/../components/topnav.php'; 

// 3. Injeta o conteúdo dinâmico (Home, Contacto, Dashboard)
// NOTA: Não precisas de abrir a tag <main> aqui, porque o teu footer.php já a fecha!
?>

<?= $content ?> 

<?php 
// 4. Carrega o teu footer.php (que fecha o </main>, </body> e </html>)
require __DIR__ . '/footer.php'; 
?>