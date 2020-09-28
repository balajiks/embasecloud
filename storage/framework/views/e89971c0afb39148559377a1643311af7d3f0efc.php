
<input type="hidden" name="selecteddrugid" id="selecteddrugid" value="<?php echo e($data['selecteddrugid']); ?>"/>
<input type="hidden" name="field" value="<?php echo e($data['field']); ?>"/>
<div class="col-lg-121">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading"><?php echo trans('app.'.'drugdosage'); ?></div>
      <div class="panel-body card">
        <div class="col-sm-121">
          <div class="row" id="druglink_drugdosescheduleterm">
            <div class="col-lg-12">
              <select class="select2-option form-control" id="drugdosescheduleterm" name="drugdosescheduleterm[]">
                <!--multiple="multiple"-->
                 
	 <?php $__currentLoopData = $data['dosescheduleterms']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dosescheduleterm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     
                <option value="<?php echo e($dosescheduleterm->name); ?>"><?php echo e($dosescheduleterm->name); ?></option>
                
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
	$("#drugdosescheduleterm").select2({
		placeholder: "Select ..",
		allowClear: true,
    });
	$('#drugdosescheduleterm').val([ <?php echo $data['tblindex_drug']; ?> ]).trigger('change');
});
</script>
