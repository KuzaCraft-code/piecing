<section class="container py-5">
    <div class="row g-4">
        <?php foreach($features as $f): ?>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <img src="<?= $f['img'] ?>" class="card-img-top" alt="<?= $f['title'] ?>">
                <div class="card-body">
                    <h5 class="card-title fw-bold" style="color: #046362;"><?= $f['title'] ?></h5>
                    <p class="card-text text-muted"><?= substr($f['content'], 0, 100) ?>...</p>
                    <a href="/service/view/<?= $f['slug'] ?>" class="btn btn-link p-0 text-decoration-none" style="color: #0097b2;">Ver mais &rarr;</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>