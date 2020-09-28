<div class="row">
    <div class="col-lg-12">
        <?php echo Form::open(['route' => ['settings.edit', $section], 'class' => 'bs-example form-horizontal ajaxifyForm', 'files' => true]); ?>

        <section class="panel panel-default">
        <header class="panel-heading"><?php echo e(svg_image('solid/cogs')); ?> <?php echo trans('app.'.'settings'); ?>  </header>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-lg-3 control-label"><?php echo trans('app.'.'ticket'); ?> Prefix</label>
                <div class="col-lg-5">
                    <input type="text" name="ticket_prefix" class="form-control"
                    value="<?php echo e(get_option('ticket_prefix')); ?>">
                </div>
            </div>

            <div class="form-group">
                    <label class="col-lg-3 control-label"><?php echo trans('app.'.'ticket_number_format'); ?></label>
                    <div class="col-lg-5">
                        <input type="text" name="ticket_number_format" class="form-control"
                               value="<?php echo e(get_option('ticket_number_format')); ?>">
                    </div>
                </div>

            <div class="form-group">
                <label class="col-lg-3 control-label"><?php echo trans('app.'.'ticket_start_number'); ?>  </label>
                <div class="col-lg-5">
                    <input type="text" name="ticket_start_no" class="form-control"
                    value="<?php echo e(get_option('ticket_start_no')); ?>">
                </div>
            </div>

            <div class="form-group">
                    <label class="col-lg-3 control-label"><?php echo trans('app.'.'support_email'); ?></label>
                    <div class="col-lg-5">
                        <input type="text" class="form-control" value="<?php echo e(get_option('support_email')); ?>" placeholder="support@example.com" data-toggle="tooltip"
                        data-placement="top" data-original-title="Email used for support emails" name="support_email">
                    </div>
            </div>
            <div class="form-group">
                    <label class="col-lg-3 control-label"><?php echo trans('app.'.'support_email_name'); ?></label>
                    <div class="col-lg-5">
                        <input type="text" class="form-control" value="<?php echo e(get_option('support_email_name')); ?>" placeholder="Acme Desk" data-toggle="tooltip"
                        data-placement="top" data-original-title="Support Name that appears on tickets" name="support_email_name">
                    </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label"><?php echo trans('app.'.'default_department'); ?>  </label>
                <div class="col-lg-5">
                    <select name="ticket_default_department" class="form-control">
                        <?php $__currentLoopData = App\Entities\Department::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($d->deptid); ?>"<?php echo e(get_option('ticket_default_department') == $d->deptid ? ' selected="selected"' : ''); ?>><?php echo e($d->deptname); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <span class="help-block m-b-none small text-danger"><?php echo trans('app.'.'default_ticket_department'); ?></span>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label"><?php echo trans('app.'.'auto_close_ticket'); ?> 
                <span class="" data-rel="tooltip" title="<?php echo trans('app.'.'auto_close_ticket_after'); ?>"><?php echo e(svg_image('solid/question-circle')); ?></span>
            </label>
                
                <div class="col-lg-5">
                    <input type="text" class="form-control" value="<?php echo e(get_option('auto_close_ticket')); ?>"
                    name="auto_close_ticket">
                </div>
            </div>
            <div class="form-group">
                    <label class="col-lg-3 control-label"><?php echo trans('app.'.'ticket_due_after'); ?> <span class="text-danger">*</span></label>
                    <div class="col-lg-5">
                        <input type="text" name="ticket_due_after" class="form-control" data-toggle="tooltip"
                               data-placement="top" data-original-title="Maximum number of days a ticket can remain open"
                               value="<?php echo e(get_option('ticket_due_after')); ?>" required>
                    </div>
                </div>

            <div class="form-group">
                <label class="col-lg-3 control-label"><?php echo trans('app.'.'feedback_request'); ?> 
                <span class="" data-rel="tooltip" title="<?php echo trans('app.'.'feedback_request_help'); ?>"><?php echo e(svg_image('solid/question-circle')); ?></span>
            </label>
                
                <div class="col-lg-5">
                    <input type="text" class="form-control" value="<?php echo e(get_option('ticket_feedback_after')); ?>"
                    name="ticket_feedback_after">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Enable Answer Bot</label>
                <div class="col-lg-5">
                    <label class="switch">
                        <input type="hidden" value="FALSE" name="answerbot_active"/>
                        <input type="checkbox"
                        <?php echo e(settingEnabled('answerbot_active') ? 'checked="checked"' : ''); ?> name="answerbot_active" value="TRUE">
                        <span></span>
                    </label>
                </div>
            </div>


        <div class="form-group">
                <label class="col-lg-3 control-label"> IMAP</label>
                <div class="col-lg-3">
                    <label class="switch">
                        <input type="hidden" value="FALSE" name="ticket_mail_imap" />
                        <input type="checkbox" <?php echo e(settingEnabled('ticket_mail_imap') ? 'checked' : ''); ?> name="ticket_mail_imap" value="TRUE">
                        <span ></span>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label"> IMAP Host </label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" value="<?php echo e(get_option('ticket_mail_host')); ?>" name="ticket_mail_host">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label"> IMAP Username </label>
                <div class="col-lg-5">
                    <input type="text" autocomplete="off" class="form-control" value="<?php echo e(get_option('ticket_mail_username')); ?>" name="ticket_mail_username">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label"> IMAP Password </label>
                <div class="col-lg-5">
                    <input type="password" autocomplete="off" class="form-control"
                    value="<?php echo e(get_option('ticket_mail_password')); ?>"
                    name="ticket_mail_password">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label"> Mail Port </label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" value="<?php echo e(get_option('ticket_mail_port')); ?>" name="ticket_mail_port">
                </div>
                <span class="help-block m-b-none small text-danger"> Port(143 or 110) (Gmail: 993)</span>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label"> Mail Flags </label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" value="<?php echo e(get_option('ticket_mail_flags')); ?>"
                    name="ticket_mail_flags">
                </div>
                <span class="help-block m-b-none small text-danger">/imap/ssl/validate-cert or /imap/ssl/novalidate-cert</span>
            </div>
            
            <div class="form-group">
                <label class="col-lg-3 control-label"> Mailbox</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" value="<?php echo e(get_option('ticket_mailbox')); ?>" name="ticket_mailbox">
                </div>
            </div>
            

            
            
        </div>
        <div class="panel-footer">
            <?php echo renderAjaxButton(); ?>

        </div>
    </section>
    <?php echo Form::close(); ?>

    
</div>
</div>
<?php $__env->startPush('pagestyle'); ?>
<link rel="stylesheet" href="<?php echo e(getAsset('plugins/iconpicker/fontawesome-iconpicker.min.css')); ?>" type="text/css"/>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('pagescript'); ?>
<?php echo $__env->make('stacks.js.iconpicker', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopPush(); ?>