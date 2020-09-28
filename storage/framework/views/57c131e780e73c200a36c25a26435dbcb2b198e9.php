<div class="row">

    <div class="col-lg-12">

        <div class="alert alert-warning small">
           <?php echo e(svg_image('solid/exclamation-circle')); ?> Always make a backup before updating
           <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
           <a href="#" class="btn btn-<?php echo e(get_option('theme_color')); ?> btn-xs pull-right" id="backupBtn"><?php echo e(svg_image('solid/database')); ?> Backup</a>
           <?php endif; ?>
        </div>

        <div class="alert alert-info small">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p><strong>CRON: </strong> <code>* * * * * php /path-to-your-project/artisan schedule:run >/dev/null</code></p>
            <p><strong>Via URL</strong> <code><?php echo e(route('artisan.schedule', ['token' => get_option('cron_key')])); ?></code></p>
        </div>

        <div class="m-xs">
            <span class="text-dark">Laravel Version</span>: <span class="text-muted"><?php echo e(app()->version()); ?></span>
        </div>
        <div class="line"></div>
        <?php
            $latest = getLastVersion();
        ?>
        <div class="m-xs">
            <span class="text-dark">Embase Work Flow Version</span>: <span class="text-muted"><?php echo e(getCurrentVersion()['version']); ?></span>
            <?php if(isset($latest['id'])): ?>
                <span class="label label-success"><?php echo e($latest['attributes']['build'] <= getCurrentVersion()['build'] ? 'Latest Version' : 'Update v.'.$latest['attributes']['version'].' Available'); ?></span>
            <?php endif; ?>
            
        </div>
        <div class="line"></div>
        <div class="m-xs">
            <span class="text-dark">Build</span>: <span class="text-muted"><?php echo e(getCurrentVersion()['build']); ?></span>
        </div>
        <div class="line"></div>
        <div class="m-xs">
            <span class="text-dark">OS Version</span>: <span class="text-muted"><?php echo e(php_uname('s')); ?></span>
        </div>
        <div class="line"></div>
        <div class="m-xs">
            <span class="text-dark">PHP Version</span>: <span class="text-muted"><?php echo e(phpversion()); ?></span>
        </div>
        <div class="line"></div>
        <div class="m-xs">
            <span class="text-dark">Your App Name</span>: <span class="text-muted"><?php echo e(config('app.name')); ?></span>
        </div>
        <div class="line"></div>
        <div class="m-xs">
            <span class="text-dark">Timezone</span>: <span class="text-muted"><?php echo e(date_default_timezone_get()); ?></span>
        </div>
        <div class="line"></div>
        <div class="m-xs">
            <span class="text-dark">Server Time</span>: <span class="text-muted"><?php echo e(dateTimeFormatted(now())); ?></span>
        </div>
        
        
    
    </div>
</div>
 <?php echo trans('app.'.'save'); ?> 
<?php $__env->startPush('pagescript'); ?>
    <script>
        $("#backupBtn").click(function() {
        axios.get('<?php echo e(route('updates.backup')); ?>')
        .then(function (response) {
            toastr.success(response.data.message, '<?php echo trans('app.'.'response_status'); ?> ');
        })
        .catch(function (error) {
            toastr.error('Oops! Request failed to complete.', '<?php echo trans('app.'.'response_status'); ?> ');
        });

        
    });
        $("#updatesBtn").click(function() {
        axios.get('<?php echo e(route('updates.check')); ?>')
        .then(function (response) {
            toastr.success(response.data.message, '<?php echo trans('app.'.'response_status'); ?> ');
        })
        .catch(function (error) {
            toastr.error('Oops! Request failed to complete.', '<?php echo trans('app.'.'response_status'); ?> ');
        });
    });
    </script>
<?php $__env->stopPush(); ?>
