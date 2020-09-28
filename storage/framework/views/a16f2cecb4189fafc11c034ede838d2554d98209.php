<input type="hidden" name="selecteddrugid" id="selecteddrugid" value="<?php echo e($data['selecteddrugid']); ?>"/>
<input type="hidden" name="field" value="<?php echo e($data['field']); ?>"/>
<div class="col-lg-121">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading"><?php echo trans('app.'.'drugtherapy'); ?></div>
      <div class="panel-body card">
        <div class="col-sm-121">
          <div class="row" id="druglink_drugtherapy">
            <div class="col-lg-10">
              <label class="control-label" for="fname"><?php echo trans('app.'.'drugtherapy'); ?>:</label>
              <input type="text" class="form-control" id="txtdrugtherapy" placeholder="<?php echo trans('app.'.'drugtherapy'); ?>" name="txtdrugtherapy" value="<?php echo e(@$data['txtdrugtherapy']); ?>" >
            </div>
            <div class="col-lg-10">
              <label class="control-label" for="fname">Indexed Medical Terms:</label>
              <select class="select2-option form-control" id="drugtherapy" name="drugtherapy[]" multiple="multiple">
                
	 <?php $__currentLoopData = $data['indexed_medical_term']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medical_term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     
                <option value="<?php echo e($medical_term->medicalterm); ?>"><?php echo e($medical_term->medicalterm); ?></option>
                
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
	$("#drugtherapy").select2({
		placeholder: "Select ..",
		allowClear: true,
    });
	$('#drugtherapy').val([ <?php echo $data['tblindex_drug']; ?> ]).trigger('change');
});
</script>