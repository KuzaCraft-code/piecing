<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="bi bi-database-fill-add me-2"></i>Gestor de Estrutura SQL</h5>
        </div>
        <div class="card-body">
            <form action="/dashboard/sql-upload" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label fw-bold">Selecionar Ficheiro .sql</label>
                    <input type="file" name="sql_file" class="form-control" accept=".sql" required>
                    <div class="form-text">O ficheiro será executado e registado no histórico de migrações.</div>
                </div>
                <button type="submit" class="btn btn-primary" style="background-color: #0097b2; border: none;">
                    Executar Migração
                </button>
            </form>
        </div>
    </div>
</div>