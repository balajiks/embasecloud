<?php $__env->startSection('content'); ?>
<section id="content" class="bg">
    <section class="vbox">
        <header class="header panel-heading bg-white b-b b-light">
            <div class="btn-group">
                <button class="btn btn-<?php echo e(get_option('theme_color')); ?> btn-sm dropdown-toggle"
                data-toggle="dropdown"> <?php echo trans('app.'.'filter'); ?>
                <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo e(route('projects.index', ['filter' => 'active'])); ?>"><?php echo trans('app.'.'active'); ?> </a></li>
                    <li><a href="<?php echo e(route('projects.index', ['filter' => 'on_hold'])); ?>"><?php echo trans('app.'.'on_hold'); ?> </a></li>
                    <li><a href="<?php echo e(route('projects.index', ['filter' => 'done'])); ?>"><?php echo trans('app.'.'done'); ?></a></li>
                    <li><a href="<?php echo e(route('projects.index', ['filter' => 'archived'])); ?>"><?php echo trans('app.'.'archived'); ?></a></li>
                    <li><a href="<?php echo e(route('projects.index')); ?>"><?php echo trans('app.'.'all'); ?></a></li>
                </ul>
            </div>

            <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
            <a href="<?php echo e(route('projects.index', ['filter' => 'templates'])); ?>"
                class="btn btn-sm btn-<?php echo e(get_option('theme_color')); ?>">
            <?php echo e(svg_image('solid/recycle')); ?> <?php echo trans('app.'.'templates'); ?></a>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('projects_create')): ?>
            <a href="<?php echo e(route('projects.create')); ?>"
                class="btn btn-sm btn-<?php echo e(get_option('theme_color')); ?> pull-right">
            <?php echo e(svg_image('solid/plus')); ?> <?php echo trans('app.'.'create'); ?>  </a>
            <?php endif; ?>
            
        </header>
        <section class="scrollable wrapper">
            <section class="panel panel-default">

                <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
                <?php echo app('arrilot.widget')->run('Projects.StatusChart'); ?>
                <?php endif; ?>


                <form id="frm-project" method="POST">
                    <input type="hidden" name="module" value="projects">
                    <div class="table-responsive">
                        <table class="table table-striped m-b-none" id="projects-table">
                            <thead>
                                <tr>
                                    <th class="hide"></th>
                                    <th class="no-sort">
                                        <label>
                                            <input name="select_all" value="1" id="select-all" type="checkbox" />
                                            <span class="label-text"></span>
                                        </label>
                                    </th>
                                    <th class=""><?php echo trans('app.'.'name'); ?></th>
									<th class="">CAR ID</th>
									<th class="">PUI</th>
									<th class="">Order ID</th>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('projects_view_clients')): ?>
                                    <th class="no-sort"><?php echo trans('app.'.'company_name'); ?></th>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('projects_view_team')): ?>
                                    <th class="no-sort"><?php echo trans('app.'.'team_members'); ?></th>
                                    <?php endif; ?>
                                    
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('projects_view_hours')): ?>
                                    <th class=""><?php echo trans('app.'.'total_time'); ?>  </th>
                                    <?php endif; ?>
                                    
                                   
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('invoices_create')): ?>
                    <button type="submit" id="button" class="btn btn-sm btn-<?php echo e(get_option('theme_color')); ?> m-xs" value="bulk-invoice">
                    <span class=""><?php echo e(svg_image('solid/file-invoice-dollar')); ?> <?php echo trans('app.'.'invoice'); ?></span>
                    </button>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('projects_delete')): ?>
                    <button type="submit" id="button" class="btn btn-sm btn-<?php echo e(get_option('theme_color')); ?> m-xs" value="bulk-archive">
                    <span class=""><?php echo e(svg_image('solid/archive')); ?> <?php echo trans('app.'.'archive'); ?></span>
                    </button>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('projects_delete')): ?>
                    <button type="submit" id="button" class="btn btn-sm btn-<?php echo e(get_option('theme_color')); ?> m-xs" value="bulk-delete">
                    <span class=""><?php echo e(svg_image('solid/trash-alt')); ?> <?php echo trans('app.'.'delete'); ?></span>
                    </button>
                    <?php endif; ?>
                    
                </form>
            </section>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
<?php $__env->startPush('pagestyle'); ?>
<?php echo $__env->make('stacks.css.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('pagescript'); ?>
<?php echo $__env->make('stacks.js.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script>
$(function() {
var table = $('#projects-table').DataTable({
processing: true,
serverSide: true,
ajax: {
    url: '<?php echo route('projects.data'); ?>',
    type: 'POST',
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
        "filter": '<?php echo e($filter); ?>',
    }
},
order: [[ 0, "desc" ]],
columns: [
{ data: 'id', name: 'id' },
{ data: 'chk', name: 'chk', orderable: false, searchable: false, sortable: false },
{ data: 'name', name: 'name' },
{ data: 'carid', name: 'carid' },
{ data: 'pui', name: 'pui' },
{ data: 'orderid', name: 'orderid' },
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('projects_view_clients')): ?>
{ data: 'client_id', name: 'company.name' },
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('projects_view_team')): ?>
{ data: 'team', name: 'team' },
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('projects_view_hours')): ?>
{ data: 'billable_time', name: 'billable_time' },
<?php endif; ?>


]
});
$("#frm-project button").click(function(ev){
ev.preventDefault();
if($(this).attr("value") == "bulk-delete"){
var form = $("#frm-project").serialize();
axios.post('<?php echo e(route('projects.bulk.delete')); ?>', form)
.then(function (response) {
    toastr.warning(response.data.message, '<?php echo trans('app.'.'response_status'); ?> ');
    window.location.href = response.data.redirect;
})
.catch(function (error) {
    showErrors(error);
});
}
if($(this).attr("value") == "bulk-archive"){
var form = $("#frm-project").serialize();
axios.post('<?php echo e(route('archive.process')); ?>', form)
.then(function (response) {
    toastr.warning(response.data.message, '<?php echo trans('app.'.'response_status'); ?> ');
    window.location.href = response.data.redirect;
})
.catch(function (error) {
    showErrors(error);
});
}
if($(this).attr("value") == "bulk-invoice"){
    var form = $("#frm-project").serialize();
    axios.post('<?php echo e(route('projects.bulk.invoice')); ?>', form)
    .then(function (response) {
        toastr.success(response.data.message, '<?php echo trans('app.'.'response_status'); ?> ');
        window.location.href = response.data.redirect;
})
.catch(function (error) {
    showErrors(error);
});
}

});
function showErrors(error){
    console.log();
    var errors = error.response.data.errors;
    var errorsHtml= '';
$.each( errors, function( key, value ) {
    errorsHtml += '<li>' + value[0] + '</li>';
});
toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
}
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>