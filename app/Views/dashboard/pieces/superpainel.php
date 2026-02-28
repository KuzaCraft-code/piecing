<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 15px;">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-primary bg-opacity-10 rounded-circle text-primary me-3">
                    <i class="bi bi-people fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0 small fw-bold">Total Leads</h6>
                    <h3 class="fw-bold mb-0"><?= $totalLeads ?? 0 ?></h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 15px;">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-success bg-opacity-10 rounded-circle text-success me-3">
                    <i class="bi bi-person-check fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0 small fw-bold">Clientes Ativos</h6>
                    <h3 class="fw-bold mb-0"><?= $totalCustomers ?? 0 ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 15px;">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-warning bg-opacity-10 rounded-circle text-warning me-3">
                    <i class="bi bi-database-check fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0 small fw-bold">Uptime DB</h6>
                    <h3 class="fw-bold mb-0">99.9%</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 15px;">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-dark bg-opacity-10 rounded-circle text-dark me-3">
                    <i class="bi bi-hdd-stack fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0 small fw-bold">Server Load</h6>
                    <h3 class="fw-bold mb-0">1.2%</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-list-stars me-2 text-primary"></i>Monitor de Leads</h5>
                <a href="/leads/export" class="btn btn-sm btn-outline-secondary border-0 small"><i class="bi bi-download me-1"></i>Exportar CSV</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small text-uppercase">
                        <tr>
                            <th class="px-4">Lead</th>
                            <th>Origem</th>
                            <th>Estado</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($ultimasLeads as $lead): ?>
                        <tr>
                            <td class="px-4">
                                <div class="fw-bold"><?= htmlspecialchars($lead['nome'] ?? 'Anónimo') ?></div>
                                <div class="text-muted" style="font-size: 0.75rem;"><?= $lead['email'] ?></div>
                            </td>
                            <td><span class="badge bg-light text-dark border"><?= $lead['origem'] ?></span></td>
                            <td>
                                <span class="badge rounded-pill px-3 <?= $lead['status'] == 'visitante' ? 'bg-danger' : 'bg-info' ?>">
                                    <?= ucfirst($lead['status']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if ($lead['status'] !== 'convertido'): ?>
                                    <form action="/dashboard/promote-lead" method="POST">
                                        <input type="hidden" name="lead_id" value="<?= $lead['id'] ?>">
                                        <button class="btn btn-sm btn-success rounded-pill px-3 shadow-sm border-0">Converter</button>
                                    </form>
                                <?php else: ?>
                                    <i class="bi bi-patch-check-fill text-success"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-shield-check me-2 text-info"></i>Auditoria do Sistema</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item py-3">
                        <span class="text-muted d-block" style="font-size: 0.65rem;">HOJE, 02:45</span>
                        <strong>Admin (JLB-101)</strong> alterou a <span class="badge bg-light text-dark">Hero Section</span>
                    </li>
                    <li class="list-group-item py-3">
                        <span class="text-muted d-block" style="font-size: 0.65rem;">ONTEM, 23:10</span>
                        <strong>Chance-dev-max</strong> atualizou API Key do <span class="badge bg-light text-dark">M-Pesa</span>
                    </li>
                    <li class="list-group-item py-3">
                        <span class="text-muted d-block" style="font-size: 0.65rem;">ONTEM, 18:00</span>
                        <strong>Sistema:</strong> Backup automático da base de dados concluído.
                    </li>
                </ul>
            </div>
            <div class="card-footer bg-light border-0 text-center">
                <a href="#" class="text-decoration-none small fw-bold">Ver log completo &rarr;</a>
            </div>
        </div>
    </div>
</div>