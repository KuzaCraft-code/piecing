<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/" style="color: #0097b2;">Kuzacraft</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav me-auto">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="/about">About</a>
                <a class="nav-link" href="/contact">Contact</a>
            </div>
            <div class="navbar-nav">
                <?php if(isset($_SESSION['user'])): ?>
                    <a class="nav-link text-info" href="/dashboard">Painel Admin</a>
                    <a class="nav-link text-warning" href="/logout">Logout</a>
                <?php else: ?>
                    <a class="nav-link btn btn-primary btn-sm px-3 text-white" style="background-color: #0097b2; border: none;" href="/login">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<main class="container mt-4 flex-grow-1"> 