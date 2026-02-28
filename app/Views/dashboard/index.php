<div class="container mt-5 mb-5">
    <?php include 'pieces/header.php'; ?>

    <ul class="nav nav-pills mb-4 bg-white p-2 shadow-sm rounded-pill justify-content-center" id="dashboardTabs" role="tablist">
        <li class="nav-item"><button class="nav-link active rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#tab-admin" type="button"><i class="bi bi-cpu me-2"></i>SuperPainel</button></li>
        <li class="nav-item"><button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#tab-services" type="button"><i class="bi bi-plugin me-2"></i>Services & API</button></li>
        <li class="nav-item"><button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#tab-cms" type="button"><i class="bi bi-pencil-square me-2"></i>Editor CMS</button></li>
    </ul>

    <div class="tab-content" id="dashboardTabsContent">
        <div class="tab-pane fade show active" id="tab-admin" role="tabpanel">
            <?php include 'pieces/superpainel.php'; ?>
        </div>

        <div class="tab-pane fade" id="tab-services" role="tabpanel">
            <?php include 'pieces/services.php'; ?>
        </div>

        <div class="tab-pane fade" id="tab-cms" role="tabpanel">
            <?php include 'pieces/cms.php'; ?>
        </div>
    </div>
</div>

<?php include 'pieces/toasts.php'; ?>