<input type="hidden" name="selecteddrugid" id="selecteddrugid" value="{{ $data['selecteddrugid'] }}"/>
<input type="hidden" name="field" value="{{ $data['field'] }}"/>
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
            <input type="checkbox" name="drugotherfield[]" {{ @$data['tblindex_drug'][0] == 'endogenous compound' ? '  checked' : '' }} value="endogenous compound" class="endogenouscompound">
            <span class="label-text">Endogenous compound</span></label>
          </div>
          @foreach($data['tbldrugotherfields'] as $key=>$drugotherfield)
          <div class="checkbox" id="{{str_replace(' ','',$drugotherfield->name)}}">
            <label style="padding-left:0px !important">
            <input type="checkbox" class="drugotherfieldcls" @if(is_array(@$data['tblindex_drug'])) @if(in_array($drugotherfield->
            name, @$data['tblindex_drug'])) checked @endif @endif name="drugotherfield[]" value="{{$drugotherfield->name}}"> <span class="label-text">{{$drugotherfield->name}}</span> </label>
          </div>
          @if($key == 5) </div>
        <div class="col-sm-6"> @endif
          @endforeach </div>
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
