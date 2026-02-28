<section class="hero-slider-container">
    <div class="hero-slider">
        <?php foreach ($slides as $slide): ?>
            <div class="hero-slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('<?= $slide['image_path'] ?>');">
                <div class="container h-100 d-flex align-items-center">
                    <div class="col-md-8 text-white">
                        <span class="badge mb-2" style="background-color: #0097b2;"><?= $slide['tag'] ?? 'Destaque' ?></span>
                        <h2 class="display-3 fw-bold"><?= $slide['title'] ?></h2>
                        <p class="lead mb-4"><?= $slide['content'] ?></p>
                        <a href="<?= $slide['button_link'] ?>" class="btn btn-lg px-4" style="background-color: #046362; color: white; border: none;">
                            <?= $slide['button_text'] ?? 'Ver Mais' ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>