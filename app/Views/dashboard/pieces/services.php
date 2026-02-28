<div class="card border-0 shadow-sm p-4 rounded-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="bi bi-wallet2 me-2 text-primary"></i>Gateways de Pagamento</h5>
        <span class="badge bg-dark rounded-pill small">AES-256 Protected</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle border-top">
            <thead class="table-light small text-uppercase">
                <tr>
                    <th>Gateway</th>
                    <th>Estado</th>
                    <th>Ping/API</th>
                    <th class="text-center">Ações (Edit/Test/Res/Save)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $gateways = [
                    ['id' => 'mpesa', 'name' => 'M-Pesa', 'icon' => 'bi-phone', 'color' => '#dc3545'],
                    ['id' => 'emola', 'name' => 'e-Mola', 'icon' => 'bi-phone-fill', 'color' => '#ff6b00'],
                    ['id' => 'mkesh', 'name' => 'mKesh', 'icon' => 'bi-cash-stack', 'color' => '#ffcc00'],
                    ['id' => 'paypal', 'name' => 'PayPal', 'icon' => 'bi-paypal', 'color' => '#003087'],
                    ['id' => 'stripe', 'name' => 'Stripe', 'icon' => 'bi-credit-card', 'color' => '#6772e5']
                ];
                foreach ($gateways as $gate): 
                ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <i class="bi <?= $gate['icon'] ?> me-3 fs-5" style="color: <?= $gate['color'] ?>;"></i>
                            <span class="fw-bold"><?= $gate['name'] ?></span>
                        </div>
                    </td>
                    <td><span class="badge bg-success-soft text-success px-3">Ativo</span></td>
                    <td class="small text-muted">200 OK (0.4s)</td>
                    <td class="text-center">
                        <div class="btn-group shadow-sm rounded-pill bg-white">
                            <button class="btn btn-sm btn-light py-2 px-3 border-end" title="Edit" data-bs-toggle="modal" data-bs-target="#modal-<?= $gate['id'] ?>"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light py-2 px-3 border-end" title="Test" onclick="testConnection('<?= $gate['id'] ?>')"><i class="bi bi-lightning-charge"></i></button>
                            <button class="btn btn-sm btn-light py-2 px-3 border-end" title="Result"><i class="bi bi-graph-up"></i></button>
                            <button class="btn btn-sm btn-light py-2 px-3" title="Save"><i class="bi bi-save"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>