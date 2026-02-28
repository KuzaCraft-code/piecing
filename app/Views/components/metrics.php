<section class="bg-dark text-white py-5 my-5">
    <div class="container">
        <div class="row text-center">
            <?php 
            // Assume que as métricas são passadas como um array de objetos ou do CMS
            foreach($metrics as $metric): ?>
            <div class="col-6 col-md-3">
                <h2 class="fw-bold" style="color: #0097b2;"><?= $metric['value'] ?></h2>
                <p class="text-uppercase small"><?= $metric['label'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>