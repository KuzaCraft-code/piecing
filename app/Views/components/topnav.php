<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm" style="border-bottom: 2px solid #0097b2;">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="/assets/img/logo-kuzacraft.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
            <span class="fw-bold" style="letter-spacing: 1px;">Piecing</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navKuzacraft">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navKuzacraft">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link px-3" href="/">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="/about">Sobre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="/contact">Contacto</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <a href="mailto:suporte@kuzacraft.com" class="text-white text-decoration-none small d-none d-xl-block">
                    <i class="bi bi-envelope me-1"></i> mail-us
                </a>

                <a href="tel:+258XXXXXXXXX" class="btn btn-sm btn-outline-light px-3">
                    <i class="bi bi-telephone me-1"></i> Ligar
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/dashboard" class="btn btn-sm btn-outline-info me-2">Painel</a>
                    <a href="/logout" class="btn btn-sm btn-danger">Sair</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-sm btn-primary" style="background-color: #0097b2;">Iniciar Sessão</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>