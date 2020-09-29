<div class="modal-dialog" style="width:1100px!important">
<div class="modal-content">
  <div class="modal-header btn-<?php echo e(get_option('theme_color')); ?>">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo trans('app.'.'opsbankxmlview'); ?></h4>
  </div>
  <div class="modal-body">
    <section id="content">
      <section class="hbox stretch">
        <section class="vbox">
          <section class="scrollable wrapper bg">
            <section class="panel panel-default">
              <div class="panel-body">
                <div class="row">
                  <div class="form-group">
                    <div class="col-lg-12">
                      <div id="dynamicXML-output"></div>
                    </div>
                    <div class="col-lg-12">
                      <section id="content">
                        <section class="hbox stretch">
                          <section class="vbox">
                            <section class="scrollable wrapper bg">
                              <section class="panel panel-default">
                                <header class="panel-heading text-danger" style=" color: #ea2e49;"> <?php echo e(svg_image('solid/cogs')); ?>Errorlist : &nbsp;&nbsp;&nbsp; </header>
                                <div class="row">
                                  <div class="form-group">
                                    <div class="col-lg-12"> <span class="pull-left" style="margin-left:20px;">&nbsp;&nbsp;</span> <span class="btn btn-sm btn-primary pull-left" id="savebtn"> <i class="fa fa-check" aria-hidden="true"></i> Complete & Get Job</span> <span class="btn btn-sm btn-warning pull-right"> <i class="fa fa-check" aria-hidden="true"></i> <?php echo $WarningCount?> Warnings</span> <span class="btn btn-sm btn-danger pull-right"> <i class="fa fa-check" aria-hidden="true"></i> <?php echo $ErrorCount?> Errors</span> </div>
                                  </div
                                ></div>
                                <div class="panel-body">
                                  <div class="table-responsive" style="height:350px; overflow-y:scroll;">
                                    <table class="table table-striped" id="errorlist-table">
                                      <thead>
                                        <tr>
                                          <th class=""><button type="button" id="selectAll" class="main btn btn-sm btn-success"> <span class="sub"></span> Select All</button></th>
                                          <th class="">Type</th>
                                          <th class=" ">ID</th>
                                          <th class="">Description</th>
                                          <th class=" ">Position</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php foreach($errorlist as $key => $list){ ?>
                                        <tr role="row" class="<?php  echo ($key%2 ? "odd" : "even"); ?>">
                                          <td><?php if($list['ErrorType'] == 2) { ?>
                                            <label>
                                            <input type="checkbox" class="chkbok" value="1" name="checked[]">
                                            <span class="label-text"></span></label>
                                            <?php } ?>
                                          </td>
                                          <td><?php if($list['ErrorType'] == 2) { ?>
                                            <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: #fdab29;"></i>
                                            <?php } else {  ?>
                                            <i class="fa fa-window-close" aria-hidden="true" style="color: #ea2e49;"></i>
                                            <?php } ?></td>
                                          <td><?php echo $list['ConditionID']; ?></td>
                                          <td><?php echo $list['Description']; ?></td>
                                          <td><?php echo $list['Position']; ?></td>
                                        </tr>
                                        <?php } ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </section>
                            </section>
                          </section>
                        </section>
                      </section>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </section>
        </section>
      </section>
    </section>
  </div>
</div>
<?php $__env->startPush('pagestyle'); ?>
<link rel=stylesheet href="<?php echo e(getAsset('css/jquerysctipttop.css')); ?>">
<link rel=stylesheet href="<?php echo e(getAsset('css/simpleXML.css')); ?>">
<style>
.app .vbox > footer, .app .vbox > section {
    position: relative !important;
}
#dynamicXML-output{
	height:350px;
	overflow-y:scroll;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('pagescript'); ?>
<script src="<?php echo e(getAsset('js/simpleXML.js')); ?>"></script>
<script language="javascript">
$('#savebtn').hide();
$(document).ready(function () {
	var xml = '<?php echo base64_decode($output);?>';
	$("#dynamicXML-output").simpleXML({ xmlString: xml });
});
		
$(document).ready(function () {
  $('#errorlist-table').on('click', '#selectAll', function () {
    if ($(this).hasClass('allChecked')) {
        $('input[type="checkbox"]', '#errorlist-table').prop('checked', false);
		$('#savebtn').hide();
    } else {
        $('input[type="checkbox"]', '#errorlist-table').prop('checked', true);
		$('#savebtn').show();
    }
    $(this).toggleClass('allChecked');
  })
});	


$("input[type='checkbox'].chkbok").change(function(){
    var a = $("input[type='checkbox'].chkbok");
    if(a.length == a.filter(":checked").length){
        $('#savebtn').show();
    } else {
		$('#savebtn').hide();
	}
});

$("#savebtn").click(function(e) {
	var jobid = '<?php echo e($jobid); ?>';
	var data = {};
		data['jobid'] 	= '<?php echo e($jobid); ?>';
		data['pui'] 	= '<?php echo e($pui); ?>';
		data['orderid']	= '<?php echo e($orderid); ?>';
	
	axios.post('<?php echo e(route('indexing.api.apicompletejob')); ?>', data)
		.then(function (response) {
				console.log(response);
				toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
				window.location.href = response.data.redirect;
				
		})
		.catch(function (error) {
			var errors = error.response.data.errors;
			var errorsHtml= '';
			$.each( errors, function( key, value ) {
			errorsHtml += '<li>' + value[0] + '</li>';
			});
			toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
			$(".formSaving").html('<i class="fas fa-sync"></i> Try Again');
	});
	
	
});

		
		
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->yieldPushContent('pagestyle'); ?>
<?php echo $__env->yieldPushContent('pagescript'); ?> 