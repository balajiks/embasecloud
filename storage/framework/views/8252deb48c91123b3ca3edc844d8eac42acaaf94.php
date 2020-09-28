<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo trans('app.'.'status'); ?>  </h4>
        </div>
        <?php echo Form::open(['route' => 'settings.statuses.save', 'class' => 'bs-example form-horizontal', 'id' => 'saveStatus']); ?>

        

        <div class="modal-body">
            <div class="form-group">
                <label class="col-lg-4 control-label"><?php echo trans('app.'.'status'); ?> <span class="text-danger">*</span></label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" placeholder="e.g Pending" name="status">
                </div>
            </div>
            <ul class="list-group gutter list-group-lg list-group-sp sortable" id="statusList">

                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item" draggable="true" id="status-<?php echo e($status->id); ?>">
                    <span class="pull-right">
                    <a href="<?php echo e(route('settings.statuses.edit', $status->id)); ?>" data-toggle="ajaxModal" data-dismiss="modal">
                            <?php echo e(svg_image('solid/pencil-alt', 'icon-muted fa-fw m-r-xs')); ?>
                    </a>
                        <a href="#" class="deleteStatus" data-status-id="<?php echo e($status->id); ?>">
                            <?php echo e(svg_image('solid/times', 'icon-muted fa-fw')); ?>
                        </a>
                    </span>


                        <div class="clear"><?php echo e($status->status); ?></div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


            </ul>
        </div>
        <div class="modal-footer">
            <?php echo closeModalButton(); ?>

            <?php echo renderAjaxButton(); ?>

        </div>
        <?php echo Form::close(); ?>

    </div>

</div>

<?php $__env->startPush('pagescript'); ?>
<script>
        $('#saveStatus').on('submit', function(e) {
            $(".formSaving").html('Processing..<i class="fas fa-spin fa-spinner"></i>');

            e.preventDefault();
            var tag, data;
            tag = $(this);
            data = tag.serialize();

            axios.post('<?php echo e(route('settings.statuses.save')); ?>', data)
            .then(function (response) {
                $('#statusList').append(response.data.html);
                toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
                $(".formSaving").html('<i class="fas fa-paper-plane"></i> <?php echo trans('app.'.'save'); ?> </span>');
                tag[0].reset();
          })
          .catch(function (error) {
            var errors = error.response.data.errors;
            var errorsHtml= '';
            $.each( errors, function( key, value ) {
                errorsHtml += '<li>' + value[0] + '</li>'; 
            });
            toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
            $(".formSaving").html('<i class="fas fa-sync"></i> Try Again</span>');
        });

        });


        $('body').on('click', '.deleteStatus', function (e) {
            e.preventDefault();
            var tag, id;

            tag = $(this);
            id = tag.data('status-id');

            if(!confirm('Do you want to delete this message?')) {
                return false;
            }
            axios.post('<?php echo e(route('settings.statuses.delete')); ?>', {
                "id":id
            })
            .then(function (response) {
                toastr.warning( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
                $('#status-' + id).hide(500, function () {
                    $(this).remove();
                });
              })
              .catch(function (error) {
                    toastr.error('Oops! Request failed to complete.', '<?php echo trans('app.'.'response_status'); ?> ');
            });
        });

</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->yieldPushContent('pagescript'); ?>