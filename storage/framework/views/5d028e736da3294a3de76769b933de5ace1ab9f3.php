

<!-- [ Main Content ] start -->
<div class="dash-container">
    <div class="dash-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3 mb-sm-0">
                            <div class="">
                                <h4 class="m-b-10"> <?php echo $__env->yieldContent('page-title'); ?></h4>
                            </div>
                            
                                <?php echo $__env->yieldContent('action-button'); ?>
                            
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"> </li>
                                <a href="<?php echo e(route('dashboard')); ?>"></a>
                                     <?php echo $__env->yieldContent('breadcrumb'); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- [ Main Content ] end -->
<?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/partials/content.blade.php ENDPATH**/ ?>