<?php
    $items = collect($lowStockItems ?? []);
    $count = $lowStockCount ?? $items->count();
    $previewItems = $items->take(3);
    $inventoryUrl = $inventoryUrl ?? null;
    $inventoryPage = $inventoryPage ?? null;
?>

<?php if($count > 0): ?>
    <div class="alert alert-warning border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex flex-column flex-lg-row gap-3 align-items-lg-center justify-content-between">
            <div class="d-flex gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-warning bg-opacity-25 text-warning-emphasis flex-shrink-0" style="width:44px;height:44px;">
                    <i class="fas fa-triangle-exclamation"></i>
                </div>
                <div>
                    <div class="fw-semibold">Notifikasi stok minimum</div>
                    <div class="small">
                        <?php echo e($count); ?> bahan telah mencecah atau berada di bawah stok minimum.
                        <?php $__currentLoopData = $previewItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge text-bg-light border ms-1">
                                <?php echo e(data_get($item, 'name')); ?>:
                                <?php echo e(number_format((float) data_get($item, 'stock', 0), 2)); ?>

                                <?php echo e(data_get($item, 'unit', 'Unit')); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <?php if($inventoryUrl): ?>
                <a href="<?php echo e($inventoryUrl); ?>" class="btn btn-sm btn-warning fw-semibold">
                    <i class="fas fa-boxes-stacked me-1"></i>Lihat Inventori
                </a>
            <?php elseif($inventoryPage): ?>
                <button type="button" class="btn btn-sm btn-warning fw-semibold" data-page="<?php echo e($inventoryPage); ?>">
                    <i class="fas fa-boxes-stacked me-1"></i>Lihat Inventori
                </button>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\MySIPMa\resources\views/partials/low_stock_notification.blade.php ENDPATH**/ ?>