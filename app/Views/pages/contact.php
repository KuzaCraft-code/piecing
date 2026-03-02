<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-4 bg-dark text-white p-5 d-flex flex-column justify-content-center" style="background: linear-gradient(135deg, #181A1C 0%, #046362 100%) !important;">
                        <h3 class="fw-bold mb-4">Fala Connosco</h3>
                        <p class="small opacity-75">Tens um projeto em mente? A nossa equipa na Beira está pronta para ajudar.</p>

                        <div class="mt-4">
                            <div class="d-flex mb-3">
                                <i class="bi bi-geo-alt me-3" style="color: #0097b2;"></i>
                                <span>Beira, Sofala, MZ</span>
                            </div>
                            <div class="d-flex mb-3">
                                <i class="bi bi-envelope me-3" style="color: #0097b2;"></i>
                                <span>info@kuzacraft.com</span>
                            </div>
                            <div class="d-flex mb-3">
                                <i class="bi bi-telephone me-3" style="color: #0097b2;"></i>
                                <span>+258 8X XXX XXXX</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 p-5 bg-white">
                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div>Mensagem enviada! Em breve entraremos em contacto.</div>
                            </div>
                        <?php endif; ?>

                        <form action="/contact/send" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">NOME</label>
                                    <input type="text" name="nome" class="form-control" placeholder="Teu nome" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">E-MAIL</label>
                                    <input type="email" name="email" class="form-control" placeholder="exemplo@mail.com" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">TELEMÓVEL</label>
                                    <div class="input-group">
                                        <select name="ddi" class="form-select" style="max-width: 140px; background-color: #f8f9fa;">
                                            <?php if (!empty($countries)): ?>
                                                <?php foreach ($countries as $country): ?>
                                                    <option value="<?= $country['code']; ?>" <?= $country['code'] === '+258' ? 'selected' : ''; ?>>
                                                        <?= $country['flag']; ?> <?= $country['code']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="+258">🇲🇿 +258</option>
                                            <?php endif; ?>
                                        </select>
                                        <input type="tel" name="telemovel" class="form-control" placeholder="8X XXX XXXX" required>
                                    </div>
                                    <small class="text-muted" style="font-size: 0.75rem;">Selecione o código do seu país.</small>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">ASSUNTO</label>
                                    <select name="assunto" class="form-select">
                                        <option value="Software">Desenvolvimento de Software</option>
                                        <option value="Redes">Infraestrutura de Redes</option>
                                        <option value="CCTV">Segurança Eletrónica (CCTV)</option>
                                        <option value="Outro">Outros Assuntos</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">MENSAGEM</label>
                                    <textarea name="mensagem" class="form-control" rows="4" required></textarea>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm" style="background-color: #0097b2; border: none;">
                                        Enviar Mensagem <i class="bi bi-send ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>