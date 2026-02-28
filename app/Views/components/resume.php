<section class="container py-5">
    <div class="row align-items-center <?= ($resume['invert_layout'] ?? false) ? 'flex-row-reverse' : '' ?>">
        <div class="col-md-6 px-4">
            <span class="text-uppercase text-muted small fw-bold">Nossa Visão</span>
            <h2 class="mt-2"><?= $resume['title'] ?? 'Sobre Nós' ?></h2>
            <p class="text-muted"><?= $resume['content'] ?? 'Texto sobre a agência...' ?></p>
            <a href="/sobre" class="text-decoration-none fw-bold" style="color: #0097b2;">Ver mais &rarr;</a>
        </div>
        <div class="col-md-6">
            <div class="bg-secondary rounded shadow" style="height: 350px; background: url('<?= $resume['image_path'] ?>') center/cover;"></div>
        </div>
    </div>
</section>