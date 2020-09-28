<input type="hidden" name="selecteddrugid" id="selecteddrugid" value="<?php echo e($data['selecteddrugid']); ?>"/>
<input type="hidden" name="field" value="<?php echo e($data['field']); ?>"/>
<div class="col-lg-121">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">Other Fields</div>
     <div class="panel-body card">
    <div class="col-sm-121">
      <div class="row" id="druglink_otherfields">
        <div class="col-sm-6">
          <div class="compoundselect" id="endogenouscompound">
            <label style="padding-left:0px !important">
            <input type="checkbox" name="drugotherfield[]" <?php echo e(@$data['tblindex_drug'][0] == 'endogenous compound' ? '  checked' : ''); ?> value="endogenous compound" class="endogenouscompound">
            <span class="label-text">Endogenous compound</span></label>
          </div>
          <?php $__currentLoopData = $data['tbldrugotherfields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$drugotherfield): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="checkbox" id="<?php echo e(str_replace(' ','',$drugotherfield->name)); ?>">
            <label style="padding-left:0px !important">
            <input type="checkbox" class="drugotherfieldcls" <?php if(is_array(@$data['tblindex_drug'])): ?> <?php if(in_array($drugotherfield->
            name, @$data['tblindex_drug'])): ?> checked <?php endif; ?> <?php endif; ?> name="drugotherfield[]" value="<?php echo e($drugotherfield->name); ?>"> <span class="label-text"><?php echo e($drugotherfield->name); ?></span> </label>
          </div>
          <?php if($key == 5): ?> </div>
        <div class="col-sm-6"> <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-10">
        <button type="submit" id="savebtn" class="btn btn-info"><i class="fas fa-paper-plane"></i>&nbsp;Add</button>
      </div>
    </div>
  </div>
    </div>
  </div>
</div>

<script>
<?php if(@$data['tblindex_drug'][0] == 'endogenous compound') {?>
	$(".checkbox").addClass("disabledbutton");
	$(".drugmenu").addClass("disabledbutton");
<?php } ?>

$(".compoundselect").click(function () {
	if($(".endogenouscompound").prop("checked") == true){
		$(".checkbox").addClass("disabledbutton");
		$(".drugmenu").addClass("disabledbutton");
	} else if($(".endogenouscompound").prop("checked") == false){
		$(".checkbox").removeClass("disabledbutton");
		$(".drugmenu").removeClass("disabledbutton");
	}
});
</script>
