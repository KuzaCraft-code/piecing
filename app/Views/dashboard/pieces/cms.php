<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="list-group list-group-flush" id="cms-menu" role="tablist">
                <button class="list-group-item list-group-item-action active py-3 px-4 border-0" data-bs-toggle="list" data-bs-target="#edit-hero">
                    <i class="bi bi-layout-text-window-reverse me-2 text-primary"></i> Hero Section
                </button>
                <button class="list-group-item list-group-item-action py-3 px-4 border-0" data-bs-toggle="list" data-bs-target="#edit-metrics">
                    <i class="bi bi-bar-chart me-2 text-success"></i> Métricas da Home
                </button>
                <button class="list-group-item list-group-item-action py-3 px-4 border-0" data-bs-toggle="list" data-bs-target="#edit-about">
                    <i class="bi bi-info-circle me-2 text-warning"></i> Secção Sobre
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mt-4 bg-dark text-white p-4">
            <h6 class="fw-bold text-info small"><i class="bi bi-lightbulb me-2"></i>Dica do Piecing</h6>
            <p class="small mb-0 opacity-75">As alterações feitas aqui refletem-se instantaneamente na Landing Page da agência.</p>
        </div>
    </div>

    <div class="col-md-8">
        <div class="tab-content border-0">

            <div class="tab-pane fade show active" id="edit-hero">
                <div class="card border-0 shadow-sm p-4 rounded-4">
                    <h5 class="fw-bold mb-4">Editar Hero Section</h5>
                    <form action="/dashboard/cms/update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="section_slug" value="hero">

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Título Principal (H1)</label>
                            <input type="text" name="title" class="form-control" value="Transformamos ideias em Software">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Subtítulo / Descrição</label>
                            <textarea name="content" class="form-control" rows="3">A Kuzacraft é a sua agência de TI sediada na Beira, MZ, focada em soluções robustas.</textarea>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Texto do Botão (CTA)</label>
                                <input type="text" name="button_text" class="form-control" value="Saber Mais">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Link do Botão</label>
                                <input type="text" name="button_link" class="form-control" value="#servicos">
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3 mb-4">
                            <label class="form-label small fw-bold">Imagem de Fundo / Lado</label>
                            <input type="file" name="image" class="form-control form-control-sm">
                        </div>

                        <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold">
                            <i class="bi bi-cloud-upload me-2"></i>Publicar Alterações
                        </button>
                    </form>
                </div>
            </div>

            <div class="tab-pane fade" id="edit-metrics">
                <div class="card border-0 shadow-sm p-4 rounded-4 text-center py-5">
                    <i class="bi bi-tools fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">Módulo de Métricas em Desenvolvimento</h5>
                    <p class="small px-5">Aqui poderás editar os números de "Clientes Satisfeitos", "Projectos Concluídos", etc.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm p-4 rounded-4 mt-4">
                <h5 class="fw-bold mb-3">Adicionar Parceiro / Logo</h5>
                <form action="/dashboard/partners/add" method="POST" enctype="multipart/form-data" class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="partner_name" class="form-control" placeholder="Nome do Parceiro" required>
                    </div>
                    <div class="col-md-4">
                        <input type="file" name="logo" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-dark w-100">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>