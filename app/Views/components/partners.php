<section class="container py-5 overflow-hidden">
    <h4 class="text-center mb-4 text-muted small fw-bold text-uppercase">Nossos Parceiros</h4>
    <div class="d-flex justify-content-center align-items-center opacity-75 gap-5" 
         style="overflow-x: auto; white-space: nowrap; scrollbar-width: none;">
        
        <?php if (!empty($partners)): ?>
            <?php foreach($partners as $partner): ?>
                <img src="<?= $partner['image_path'] ?>" 
                     alt="<?= htmlspecialchars($partner['name']) ?>" 
                     title="<?= htmlspecialchars($partner['name']) ?>"
                     style="height: 45px; filter: grayscale(100%); transition: 0.3s;" 
                     onmouseover="this.style.filter='none'" 
                     onmouseout="this.style.filter='grayscale(100%)'">
            <?php endforeach; ?>
        <?php else: ?>
            <img src="/assets/img/logos/client-placeholder.png" style="height: 40px; filter: grayscale(100%); opacity: 0.3;">
        <?php endif; ?>
        
    </div>
</section>