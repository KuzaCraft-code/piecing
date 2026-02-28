<section class="container py-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="display-4 fw-bold"><?= $hero['title'] ?? 'Inovação na Beira' ?></h1>
            <p class="lead"><?= $hero['content'] ?? 'Soluções de TI sob medida.' ?></p>
            <a href="<?= $hero['button_link'] ?? '#' ?>" class="btn btn-primary px-4 py-2" style="background-color: #0097b2; border:none;">
                <?= $hero['button_text'] ?? 'Saber Mais' ?>
            </a>
        </div>
        <div class="col-md-6 mt-4 mt-md-0">
            <img src="<?= $hero['image_path'] ?? '/assets/img/hero-placeholder.jpg' ?>" class="img-fluid rounded shadow-lg" alt="Hero Kuzacraft">
        </div>
    </div>
</section>