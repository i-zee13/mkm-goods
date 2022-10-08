<?php if(session('success')): ?>
    <div class="alert alert-success" style="margin: 0px">
        <strong>Success</strong> <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('failed')): ?>
    <div class="alert alert-danger" style="margin: 0px">
        <strong>Failed</strong> <?php echo e(session('failed')); ?>

    </div>
<?php endif; ?><?php /**PATH F:\Sourcecode-Academia-BE\resources\views/includes/alerts.blade.php ENDPATH**/ ?>