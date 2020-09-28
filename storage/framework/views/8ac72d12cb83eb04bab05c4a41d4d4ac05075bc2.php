
<input type="hidden" name="selecteddrugid" id="selecteddrugid" value="<?php echo e($data['selecteddrugid']); ?>"/>
<input type="hidden" name="field" value="<?php echo e($data['field']); ?>"/>

<div class="col-lg-121">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading"><?php echo trans('app.'.'drugpharma'); ?></div>
      <div class="panel-body card">
        <div class="col-sm-121">
  <div class="row" id="druglink_druginteraction">
	<div class="col-lg-12">
	  <label class="control-label" for="fname"><?php echo trans('app.'.'specialsitutation'); ?>:</label>
	  
	  <select class="select2-option form-control" id="specialsitutation" name="specialsitutation[]" multiple="multiple">
	 <?php $__currentLoopData = $data['specialpharma']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialpharma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     <option value="<?php echo e($specialpharma->name); ?>"><?php echo e($specialpharma->name); ?></option>
	 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
     </select>
	  
	</div>
	<div class="col-lg-12">
	<label class="control-label" for="fname"><?php echo trans('app.'.'unexpectedoutcome'); ?>:</label>
 	<select class="select2-option form-control" id="unexpectedoutcome" name="unexpectedoutcome[]" multiple="multiple">
	 <?php $__currentLoopData = $data['drugtreatment']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $drugtreatment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     <option value="<?php echo e($drugtreatment->name); ?>"><?php echo e($drugtreatment->name); ?></option>
	 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
     </select>
	</div>							  
  </div>
</div>
        <div class="form-group"><br />
          <div class="col-sm-10">
            <button type="submit" id="savebtn" class="btn btn-info"><i class="fas fa-paper-plane"></i>&nbsp;Add</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




<script>
$(document).ready(function () {
	$("#specialsitutation").select2({
		placeholder: "Select ..",
		allowClear: true,
    });
	$('#specialsitutation').val([ <?php echo $data['tblindex_drugspecialpharma']; ?> ]).trigger('change');
	
	
	$("#unexpectedoutcome").select2({
		placeholder: "Select ..",
		allowClear: true,
    });
	$('#unexpectedoutcome').val([ <?php echo $data['tblindex_drugunexpecteddrugtreatment']; ?> ]).trigger('change');
	
	
});

</script>
