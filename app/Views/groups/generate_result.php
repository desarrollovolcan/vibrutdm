<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Generación de grupos</h3>
    <p><?php echo e($message); ?></p>
    <a href="/groups?category_id=<?php echo (int)$categoryId; ?>" class="btn">Volver</a>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
