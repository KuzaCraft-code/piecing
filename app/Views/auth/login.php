<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body p-5">

                    <div class="text-center mb-4">
                        <img src="/assets/img/logo-kuzacraft.png" alt="Logo" width="60" class="mb-3">
                        <h3 class="fw-bold text-dark">Acesso Restrito</h3>
                        <p class="text-muted small">Piecing Framework &middot; Kuzacraft Agency</p>
                    </div>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger py-2 small text-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= $_GET['error'] == 'invalido' ? 'Credenciais incorretas.' : 'Erro ao aceder ao sistema.' ?>
                        </div>
                    <?php endif; ?>

                    <form action="/login" method="POST">
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="nome@kuzacraft.com" required>
                            <label for="floatingEmail"><i class="bi bi-envelope me-2"></i>E-mail Corporativo</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Senha" required>
                            <label for="floatingPassword"><i class="bi bi-shield-lock me-2"></i>Palavra-passe</label>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember">
                                <label class="form-check-label small" for="remember text-muted">Lembrar-me</label>
                            </div>
                            <a href="/forgot-password" class="small text-decoration-none" style="color: #0097b2;">Esqueceu a senha?</a>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-2 fw-bold shadow-sm" style="background-color: #181A1C;">
                            Entrar no Sistema <i class="bi bi-arrow-right-short ms-1"></i>
                        </button>
                    </form>

                    <div class="position-relative my-4">
                        <hr class="text-muted">
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">OU</span>
                    </div>

                    <div class="position-relative mb-4">
                        <hr class="text-muted opacity-25">
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted" style="font-size: 0.7rem; font-weight: 600;">OU CONTINUAR COM</span>
                    </div>

                    <div class="d-flex justify-content-center gap-3 mb-4">
                        <a href="#" class="btn btn-outline-light border shadow-sm d-flex align-items-center justify-content-center" style="width: 60px; height: 50px; border-radius: 12px;" title="Google">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google__G__Logo.svg" alt="Google" width="22">
                        </a>
                        <a href="#" class="btn btn-outline-light border shadow-sm d-flex align-items-center justify-content-center" style="width: 60px; height: 50px; border-radius: 12px;" title="GitHub">
                            <i class="bi bi-github text-dark" style="font-size: 1.5rem;"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light border shadow-sm d-flex align-items-center justify-content-center" style="width: 60px; height: 50px; border-radius: 12px;" title="LinkedIn">
                            <i class="bi bi-linkedin" style="font-size: 1.4rem; color: #0077b5;"></i>
                        </a>
                    </div>

                   
                        <p class="mb-0 text-muted text-center " style="font-size: 0.7rem;">
                            <i class="bi bi-shield-check text-success me-1"></i>
                            Segurança <strong>AES-256-GCM</strong> &middot; Kuzacraft Beira
                        </p>
                  
                 

                </div>
            </div>
        </div>
    </div>
</div>