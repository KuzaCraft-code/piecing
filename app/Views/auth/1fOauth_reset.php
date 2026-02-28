<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="col-md-5 col-lg-4">
        <div class="card border-0 shadow-lg" style="border-radius: 20px;">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="bi bi-shield-lock-fill text-warning" style="font-size: 3rem;"></i>
                    <h4 class="fw-bold mt-3">Segurança Primeiro</h4>
                    <p class="text-muted small">Define a tua nova senha pessoal para ativar a conta.</p>
                </div>

                <form action="/password-update" method="POST">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Nova Senha</label>
                        <div class="input-group">
                            <input type="password" name="new_password" class="form-control bg-light border-0 py-3" id="newPass" required style="border-radius: 12px 0 0 12px;" autocomplete="new-password">
                            <button class="btn btn-light border-0 px-3" type="button" id="togglePassword" style="border-radius: 0 12px 12px 0;">
                                <i class="bi bi-eye-fill text-muted" id="eyeIcon"></i>
                            </button>
                        </div>
                        <div class="form-text small mt-2">Usa pelo menos 8 caracteres com letras e números.</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm" style="background-color: #0097b2; border: none; border-radius: 12px;">
                        ATUALIZAR E ENTRAR
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#newPass');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', function (e) {
        // Alterna o tipo de input
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Alterna o ícone
        eyeIcon.classList.toggle('bi-eye-fill');
        eyeIcon.classList.toggle('bi-eye-slash-fill');
    });
</script>