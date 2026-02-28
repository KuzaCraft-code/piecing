<?php
use Core\Database;

// 1. O servidor testa a base de dados. Esta parte NUNCA vai para o navegador do cliente.
$dbOnline = false;
try {
    Database::getConnection();
    $dbOnline = true;
} catch (\Exception $e) {
    // O erro morre aqui no servidor. Ninguém no front-end fica a saber.
    $dbOnline = false;
}
?>

<section class="py-5" style="background-color: #f1f1f1;">
    <div class="container text-center">
        <h3>Mantenha-se Atualizado</h3>
        <p>Receba as novidades da Kuzacraft diretamente na Beira.</p>
        
        <?php if ($dbOnline): ?>
            <form action="/newsletter/subscribe" method="POST" class="row g-2 justify-content-center mt-3">
                <div class="col-auto">
                    <input type="email" name="email" class="form-control border-0 shadow-sm" placeholder="Seu e-mail profissional" required style="border-radius: 10px;">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary px-4 fw-bold" style="background-color: #0097b2; border: none; border-radius: 10px;">Subscrever</button>
                </div>
            </form>
        <?php else: ?>
            <div class="mt-4">
                <span class="text-muted fst-italic py-2 px-3 rounded" style="background-color: #e9ecef; border: 1px dashed #ccc;">
                    <i class="bi bi-envelope-x me-1"></i> As subscrições para novidades estarão disponíveis em breve.
                </span>
            </div>
        <?php endif; ?>
    </div>
</section>