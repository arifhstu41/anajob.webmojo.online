<?php $__env->startPush('scripts'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Report History')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Report History')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Report History')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-button'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php if(count($data)>0): ?>
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class=" col-xxl-4">
    <div class="card">
        <div class="card-header border-0 pb-0">
            <div class="d-flex  align-items-center">
                <div class="bg-primary theme-avtar me-2 " ><h3 class="mb-0 badge" style="font-family: cursive;font-size: xx-large;"> <?=substr($val->site->site_name,0,1);?></h3></div>
                <div class="gap-4">
                     <h5 class="mb-0 "><a class="text-dark" href="https://demo.rajodiya.com/erpgo-saas/projects/7"><?php echo e($val->site->site_name); ?></a></h5>
                </div>
                   
            </div>

            <div class="card-header-right">
                <div class="btn-group card-option">
                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#!" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#show_report" data-size="lg"  onclick="show_report(<?=$val->id?>)">
                            <i class="ti ti-eye"></i><span> Show</span>
                        </a>
                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['delete-report-history', [$val->id]]]); ?>

                            <a href="#!" class="dropdown-item bs-pass-para show_confirm">
                                <i class="ti ti-archive"></i><span> Delete</span>
                            </a>
                        <?php echo Form::close(); ?>

                        
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h4><?=ucfirst($val->report_type)?> </h4>
            
            <h6 class="text-center text-muted mt-3"><?php echo e($val->title); ?></h6>
          
           
        </div>
    </div>
</div>


<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<div class="modal fade " id="show_report" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="report_type"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    
                    <p id="report_title"></p>
                    <div  style="padding: 20px 40px">
                        <table class="table datatable"style="width: 100%;">
                            <thead style="text-align:left;" >
                                <tr>
                                    <th scope="col" class="text-muted" data-sort="name"><?php echo e(__('Metrics')); ?></th>
                                    <th scope="col" class="text-muted"><?php echo e(__('Current')); ?> <br> <?php echo e(__('Period')); ?>   </th>
                                    <th scope="col" class="text-muted"><?php echo e(__('Previous')); ?> <br> <?php echo e(__('Period')); ?></th>
                                    <th scope="col" class="text-muted" data-sort="completion"><?php echo e(__('Change')); ?></th>
                                   
                                </tr>
                            </thead>
                            <tbody id="report_data">

                            </tbody>
                        </table>
                    </div>
                </div>
              
            </div>
        </div>
        </div>
<script type="text/javascript">
    function show_report(id) {
    var token= $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: $("#path_admin").val()+"/show/report/"+id ,
        method:"POST",
        data: {"_token": token},
        success: function(data) {
           
            $('#report_type').html(data.report_type);
            $('#report_title').html(data.title);
            var parsed = JSON.parse(data.data);  
            var html = '';
            $.each(parsed, function (i, item) {
                
                html += '<tr>';
                html += '<td scope="row" >' + (i + 1) + '</td>';
                html += '<td>' + item.current + '</td>';
                html += '<td>' + item.previous + '</td>';
                if(item.previous<item.current || item.previous==0)
                {
                    html += '<td style="color:green"><i class="ti ti-arrow-narrow-up"></i>' + Math.abs(item.change) + '%</td>';
                }
                else
                {
                    html += '<td style="color:red"><i class="ti ti-arrow-narrow-down"></i>' + Math.abs(item.change) + '%</td>';
                }
                
                html += '</tr>';
            });
           $("#report_data").html(html);
        }
    });
  }
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/report/history.blade.php ENDPATH**/ ?>