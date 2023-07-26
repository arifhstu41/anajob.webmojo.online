<?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>    <?php
        
        $mode_setting = \App\Models\Utility::settings();
       
        $setting = \App\Models\Utility::colorset();
        if ($mode_setting == []) {
            // dd('hey');
            $color = 'theme-3';
            if (!empty($setting['color'])) {
                $color = $setting['color'];
            }
        } else {
            $color = 'theme-3';
            if (!empty($mode_setting['color'])) {
                $color = $mode_setting['color'];
            }
        }

        $SITE_RTL = 'off';
        if (!empty($setting['SITE_RTL'])) {
            $SITE_RTL = $setting['SITE_RTL'];
        }
         $utility=\App\Models\Utility::getValByName('header_text');

      
    ?>

    <!DOCTYPE html>
    <html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e($SITE_RTL == 'on' ? 'rtl' : ''); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <title>
        <?= $utility ? $utility : config('app.name', 'Google Analytics') ?>
        - <?php echo $__env->yieldContent('page-title'); ?></title>
        <?php echo $__env->make('partials.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="loader-bg"></div>
    <body class="<?php echo e($color); ?>">
 <!-- [ Pre-loader ] start -->
 <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->
        <input type="hidden" id="path_admin" value="<?php echo e((url('/'))); ?>">

        <?php
            $users = \Auth::user();
            $currantLang = $users->currentLanguage();
            $languages = \App\Models\Utility::languages();
            $footer_text = isset(\App\Models\Utility::settings()['footer_text']) ? \App\Models\Utility::settings()['footer_text'] : '';
            $setting_data = App\Models\Settings::pluck('value', 'name')->toArray();
        ?>



        <?php echo $__env->make('partials.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <style>
            [dir="rtl"] .dash-sidebar {
                left: auto !important;
            }
    
            [dir="rtl"] .dash-header {
                left: 0;
                right: 280px;
            }
    
            [dir="rtl"] .dash-header:not(.transprent-bg) .header-wrapper {
                padding: 0 0 0 30px;
            }
    
            [dir="rtl"] .dash-header:not(.transprent-bg):not(.dash-mob-header)~.dash-container {
                margin-left: 0px;
            }
    
            [dir="rtl"] .me-auto.dash-mob-drp {
                margin-right: 10px !important;
            }
    
            [dir="rtl"] .me-auto {
                margin-left: 10px !important;
            }
    
            [dir="rtl"] .header-wrapper .ms-auto {
                margin-left: 0 !important;
            }
    
            [dir="rtl"] .dash-header {
                left: 0 !important;
                right: 280px !important;
            }
    
            [dir="rtl"] .list-group-flush>.list-group-item .float-end {
                float: left !important;
            }
        </style>
        <div class="main-content position-relative">
            <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
                <?php echo $__env->make('partials.content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleoverModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleoverModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleoverModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>


        <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <!-- Demo JS - remove it when starting your project -->

        <script>
            var toster_pos = "<?php echo e($SITE_RTL == 'on' ? 'left' : 'right'); ?>";
        </script>

        <?php if($SITE_RTL == 'on'): ?>
            <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>">
        <?php endif; ?>
        <?php if(isset($mode_setting['cust_darklayout']) && $mode_setting['cust_darklayout'] == 'on'): ?>
            <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>" id="main-style-link">
        <?php else: ?>
            <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>"id="main-style-link">
        <?php endif; ?>
        <!-- custom JS -->

        <?php echo $__env->yieldPushContent('script-page'); ?>

        <?php if(Session::has('success')): ?>
            <script>
                toastrs('<?php echo e(__('Success')); ?>', "<?php echo session('success'); ?>", 'success');
            </script>
            <?php echo e(Session::forget('success')); ?>

        <?php endif; ?>
        <?php if(Session::has('error')): ?>
            <script>
                toastrs('<?php echo e(__('Error')); ?>', "<?php echo session('error'); ?>", 'error');
            </script>
            <?php echo e(Session::forget('error')); ?>

        <?php endif; ?>
        <script>
            var date_picker_locale = {
                format: 'YYYY-MM-DD',
                daysOfWeek: [
                    "<?php echo e(__('Sun')); ?>",
                    "<?php echo e(__('Mon')); ?>",
                    "<?php echo e(__('Tue')); ?>",
                    "<?php echo e(__('Wed')); ?>",
                    "<?php echo e(__('Thu')); ?>",
                    "<?php echo e(__('Fri')); ?>",
                    "<?php echo e(__('Sat')); ?>"
                ],
                monthNames: [
                    "<?php echo e(__('January')); ?>",
                    "<?php echo e(__('February')); ?>",
                    "<?php echo e(__('March')); ?>",
                    "<?php echo e(__('April')); ?>",
                    "<?php echo e(__('May')); ?>",
                    "<?php echo e(__('June')); ?>",
                    "<?php echo e(__('July')); ?>",
                    "<?php echo e(__('August')); ?>",
                    "<?php echo e(__('September')); ?>",
                    "<?php echo e(__('October')); ?>",
                    "<?php echo e(__('November')); ?>",
                    "<?php echo e(__('December')); ?>"
                ],
            };
            var calender_header = {
                today: "<?php echo e(__('today')); ?>",
                month: '<?php echo e(__('month')); ?>',
                week: '<?php echo e(__('week')); ?>',
                day: '<?php echo e(__('day')); ?>',
                list: '<?php echo e(__('list')); ?>'
            };
        </script>
        <script>
            function copyToClipboard(element) {

                var copyText = element.id;
                document.addEventListener('copy', function (e) {
                    e.clipboardData.setData('text/plain', copyText);
                    e.preventDefault();
                }, true);

                document.execCommand('copy');
                toastrs('success', 'Url copied to clipboard', 'success');
            }
        </script>
     
        <script>
            var exampleModal = document.getElementById('exampleModal')

            exampleModal.addEventListener('show.bs.modal', function(event) {

                // Button that triggered the modal
                var button = event.relatedTarget
                // Extract info from data-bs-* attributes
                var recipient = button.getAttribute('data-bs-whatever')
                var url = button.getAttribute('data-url')
                var size = button.getAttribute('data-size');
                var modalTitle = exampleModal.querySelector('.modal-title')

                var modalBodyInput = exampleModal.querySelector('.modal-body input')
                // modalTitle.textContent = recipient
                $("#exampleModal .modal-title").html(recipient);
                $("#exampleModal .modal-dialog").addClass('modal-' + size);
                $.ajax({
                    url: url,
                    success: function(data) {
                        $('#exampleModal .modal-body').html(data);
                        $("#exampleModal").modal('show');
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        toastrs('Error', data.error, 'error')
                    }
                });
            })


            var exampleModal = document.getElementById('exampleoverModal')

            exampleModal.addEventListener('show.bs.modal', function(event) {
                // Button that triggered the modal
                var button = event.relatedTarget
                // Extract info from data-bs-* attributes
                var recipient = button.getAttribute('data-bs-whatever')
                var url = button.getAttribute('data-url')
                var size = button.getAttribute('data-size');
                var modalTitle = exampleModal.querySelector('.modal-title')
                var modalBodyInput = exampleModal.querySelector('.modal-body input')
                //   modalTitle.textContent = recipient
                $("#exampleoverModal .modal-title").html(recipient);
                $("#exampleoverModal .modal-dialog").addClass('modal-' + size);
                $.ajax({
                    url: url,
                    success: function(data) {
                        $('#exampleoverModal .modal-body').html(data);
                        $("#exampleoverModal").modal('show');
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        toastrs('Error', data.error, 'error')
                    }
                });
            })

            function arrayToJson(form) {
                var data = $(form).serializeArray();
                var indexed_array = {};

                $.map(data, function(n, i) {
                    indexed_array[n['name']] = n['value'];
                });

                return indexed_array;
            }
        </script>

        

        <script>
            $(document).ready(function() {

                var highestBox = 0;
                $('.main .card').each(function() {
                    if ($(this).height() > highestBox) {
                        highestBox = $(this).height();
                    }
                });
                $('.main .card').height(highestBox);

            });
        </script>

    </body>
<?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </html>
<?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/layouts/admin.blade.php ENDPATH**/ ?>